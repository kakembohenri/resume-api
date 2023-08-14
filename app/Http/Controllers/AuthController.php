<?php

namespace App\Http\Controllers;

use App\CustomHelpers\ReturnBase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                ],
                [
                    'Email' => 'Email field is required!',
                    'Password' => 'Password field is required!'
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
}
