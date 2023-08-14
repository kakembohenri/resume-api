<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** AUTH CONTROLLER
 * 
 */

Route::controller(AuthController::class)->group(function () {
    // Login
    Route::post("/login", "Login");
    // Logout
    Route::post("/logout", "Logout");
});

/** USER CONTROLLER
 * 
 */

Route::controller(UserController::class)->group(function () {
    // Create account
    Route::post("/users", "Create");
    // Verify Users
    Route::put("/users/verify-account/{email}/{token}", "VerifyAccount");
});

/** RESUME CONTROLLER
 * 
 */
Route::controller(ResumeController::class)->group(function () {
    Route::middleware(['jwt.verify'])->group(function () {
        // Create Resume
        Route::post("/resumes", "Create");
        // Get Resume
        Route::get("/resumes", "GetMyResume");
        // Update Resume
        Route::put("/resumes", "Update");

        // Delete
        Route::delete("/resumes", "Delete");
    });
    // Get by access code / referer code
    Route::get("/resumes/access-code/{access_code}", "GetByAccessCode");
    // Verify access code
    Route::post("/resumes/access-code/{access_code}", "VerifyAccessCode");
});
