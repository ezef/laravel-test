<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Lightit\Authentication\App\Controllers\EnableTwoFactorAuthenticationController;
use Lightit\Authentication\App\Controllers\LoginController;
use Lightit\Authentication\App\Controllers\LogoutController;
use Lightit\Authentication\App\Controllers\RefreshController;
use Lightit\Authentication\App\Controllers\VerifyTwoFactorAuthenticationController;
use Lightit\Backoffice\Users\App\Controllers\DeleteUserController;
use Lightit\Backoffice\Users\App\Controllers\GetUserController;
use Lightit\Backoffice\Users\App\Controllers\ListUserController;
use Lightit\Backoffice\Users\App\Controllers\StoreUserController;
use Lightit\Backoffice\Users\Domain\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('create-user', function() {
    $user = \Database\Factories\UserFactory::new()->create([
        'email' => 'eze@test.com',
    ]);

    return $user;
});

Route::prefix('auth')->group(static function () {
    Route::post('login', LoginController::class);
    Route::post('logout', LogoutController::class);
    Route::post('refresh', RefreshController::class);
    Route::get('/logged-in-user', function (Request $request) {
        return $request->user();
    });

    Route::middleware(['auth', '2fa_inactive'])->group(function() {
        Route::post('2fa/enable', EnableTwoFactorAuthenticationController::class);
        Route::put('2fa/verify', VerifyTwoFactorAuthenticationController::class);
        Route::get('2fa-inactive/user', function(Request $request){
            return $request->user();
        });
    });

    Route::middleware(['auth', '2fa_active'])->group(function() {
        Route::get('2fa-active/user', function (Request $request) {
            return $request->user();
        });
    });
});


/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
//Route::prefix('users')
//    ->middleware([])
//    ->group(static function () {
//        Route::get('/', ListUserController::class);
//        Route::get('/{user}', GetUserController::class)->withTrashed();
//        Route::post('/', StoreUserController::class);
//        Route::delete('/{user}', DeleteUserController::class);
//    });
