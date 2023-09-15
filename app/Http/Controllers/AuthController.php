<?php

namespace App\Http\Controllers;

use App\CustomHelpers\ReturnBase;
use App\Mail\PasswordResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /** LOGIN USER
     * DESCRIPTION: Handle login users
     * ENDPOINT: /login
     * METHOD: POST
     * TODO
     * - check users login credentials
     * - deliver jwt token
     */

    public function Login(Request $request)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'Email' => 'required|email',
                    'Password' => 'required|string'
                ]
            );

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }

            // Check if email exists in user table
            $user = User::where('Email', $request->Email)->first();

            if ($user == null) {
                return ReturnBase::Error('Invalid Credentials', Response::HTTP_BAD_REQUEST);
            }

            // check if users account is verified
            if ($user->Status_Id == 2) {
                return ReturnBase::Error('Your Account is not Verified!', Response::HTTP_BAD_REQUEST);
            }

            // If email exists, compare request password with email password
            if (!Hash::check($request->Password, $user->Password)) {
                return ReturnBase::Error('Invalid Credentials', Response::HTTP_BAD_REQUEST);
            }

            // Generate jwt token
            $token = auth()->claims(['isGuest' => false])->login($user);

            unset($user['Password']);

            return ReturnBase::Object("Login Successfull", (object)[
                'token' => $token,
            ], Response::HTTP_OK);
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** LOGOUT USER
     * DESCRIPTION: Handle logging out user
     * ENDPOINT: /logout
     * METHOD: POST
     * TODO
     * - logout user
     * 
     */
    public function Logout()
    {
        try {
            auth()->logout(true);
            return ReturnBase::JustMessage("Logged out", Response::HTTP_OK);
        } catch (\Exception $exp) {
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** PASSWORD FORGOT
     * DESCRIPTION: Handle a user who has forgotten their password for their account
     * ENDPOINT: /password/forgot
     * METHOD: POST
     * TODO
     * - check if email address belongs to you
     * - send email to address with a password reset token
     * 
     */
    public function ForgotPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'Email' => 'required|email|exists:users,Email'
            ], [
                'exists' => 'Email Address does not exist!'
            ]);

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }

            // send email

            DB::beginTransaction();

            $token = Str::random(64);

            $mailData = [
                'email' => $request->Email,
                'token' => $token,
            ];

            // Create record in password reset table
            PasswordReset::create([
                'Email' => $request->Email,
                'Token' => $token,
                'ExpiresIn' => date('Y:m:d H:i:s', strtotime("+1 days"))
            ]);

            try {
                Mail::to($request->Email)->send(new PasswordResetMail($mailData));
            } catch (\Exception $exp) {
                DB::rollBack();
                Log::error($exp->getMessage());
                return ReturnBase::Error('Unable to send email', Response::HTTP_BAD_REQUEST);
            }

            DB::commit();

            return ReturnBase::JustMessage('Password Reset Token Has Been Sent To Your Email Address', Response::HTTP_CREATED);
        } catch (\Exception $exp) {
            return ReturnBase::InternalServerError($exp);
        }
    }

    /** RESET PASSWORD
     * DESCRIPTION: Handle reseting a password given the email, token, password and confirmed password
     * ENDPOINT: /passwords/reset/{email}/{token}
     * METHOD: POST
     * TODO
     * - check if password reset credentials are valid
     * - change users password
     * - delete the reset token record from the password resets table
     * 
     */

    public function ResetPassword(Request $request)
    {
        Log::info($request);
        try {

            $validator = Validator::make($request->all(), [
                'password' => 'required|string|confirmed|min:6',
                'token' => 'required|string',
                'email' => 'required|email|string|exists:users,Email',
            ]);

            if ($validator->fails()) {
                return ReturnBase::HandleValidationErrors($validator);
            }

            DB::beginTransaction();

            // Check if password reset credentials are valid
            $passwordReset = PasswordReset::where([
                'Email' => $request->email,
                'Token' => $request->token
            ])->first();

            if ($passwordReset == null) {
                DB::rollback();
                return ReturnBase::Error('Password reset credentials are invalid!', Response::HTTP_BAD_REQUEST);
            }

            $ExpiresIn = strtotime($passwordReset->ExpiresIn);
            $Now = strtotime(date('Y:m:d H:i:s', time()));

            // Check if token is expired
            if ($ExpiresIn < $Now) {
                DB::rollback();
                return ReturnBase::Error('Token is expired!', Response::HTTP_BAD_REQUEST);
            }

            $user = User::where('Email', $request->email)->first();

            // change users password
            $user->update([
                'Password' => Hash::make($request->password),
                'ModifiedAt' => date('Y:m:d H:i:s', time()),
                'Modified_By' => $user->Id,
            ]);

            // delete reset password record from table
            $passwordReset->delete();

            DB::commit();

            return ReturnBase::JustMessage('You have successfully reset your password', Response::HTTP_OK);
        } catch (\Exception $exp) {
            DB::rollBack();
            return ReturnBase::InternalServerError($exp);
        }
    }
}
