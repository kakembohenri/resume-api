<?php

namespace App\Http\Controllers;

use App\CustomHelpers\ReturnBase;
use App\Mail\AccountVerificationEmail;
use App\Models\EmailVerificationToken;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /** CREATE USER
     * DESCRIPTION: Handle the creation a user account
     * ENDPOINT: /users
     * METHOD: POST
     * TODO
     * - check for a unique email
     * - send verfication token to inbox
     * - create user
     * 
     */

    public function Create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Email' => 'required|email|unique:users',
                'Password' => 'required|string|min:6|confirmed'
            ]);

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }

            $token = Str::random(64);

            $mailData = [
                'token' => $token,
                'email' =>  $request->Email
            ];

            DB::beginTransaction();

            // Create tenant
            $request['CreatedAt'] = date('Y:m:d H:i:s', time());
            $request['Role_Id'] = 2;
            $request['Status_Id'] = 2;
            $request['Password'] = Hash::make($request->Password);

            User::create($request->all());

            // Insert token, email and tenant id into verification table
            EmailVerificationToken::create([
                'Email' => $request->Email,
                'Token' => $token,
            ]);

            try {
                Mail::to($request->Email)->send(new AccountVerificationEmail($mailData));
            } catch (\Exception $exp) {
                DB::rollBack();
                Log::error($exp->getMessage());
                return ReturnBase::Error('Failed to send email to ' . $request->Email, Response::HTTP_BAD_REQUEST);
            }

            DB::commit();
            return ReturnBase::JustMessage('A email verification token has been sent to your address', Response::HTTP_OK);
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** VERIFY USERS ACCOUNT
     * DESCRIPTION: Handle the verification of a users account
     * ENDPOINT: /users/verify-account/{email}/{token}
     * METHOD: PUT
     * TODO
     * - first check if user exists
     * - check if the email and token combination exists as one record in email verification table
     * - update users status to verified
     * - remove token and email from verification token
     * - login user
     * 
     */

    public function VerifyAccount(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'Email' => 'required|email|exists:users,Email',
                'Token' => 'required|string'
            ]);

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }

            $user = User::where('Email', $request->Email)->first();

            if ($user == null) {
                return ReturnBase::Error('User Does Not Exist!', 400);
            }

            DB::beginTransaction();

            // Check if email and token combo exist
            $verificationRecord = EmailVerificationToken::where([
                ['Email', $request->Email],
                ['Token', $request->Token]
            ])->first();

            if ($verificationRecord == null) {
                DB::rollBack();
                return ReturnBase::Error('Invalid Credentials for Verifying Email Account', 400);
            }

            // Update clients status
            $user->update([
                'Status_Id' => 1,
                'ModifiedAt' => date('Y:m:d H:i:s', time())
            ]);

            // Remove record from verification token table
            EmailVerificationToken::where([
                ['Email', $request->Email],
                ['Token', $request->Token]
            ])->delete();

            DB::commit();

            return ReturnBase::JustMessage('Email Account Has Been Verified', 200);
        } catch (\Exception $exp) {
            // Log::error($exp->getMessage());
            return ReturnBase::InternalServerError($exp);
        }
    }
}
