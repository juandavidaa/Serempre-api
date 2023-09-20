 <?php

use App\Http\Controllers\admin\{UserController};
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;

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
    Route::get('createPassword/{user}', [AuthController::class, 'createPassword'])->name('api.createPassword');
    Route::patch('savePassword', [AuthController::class, 'savePassword'])->name('api.savePassword');

    Route::post('auth/login', [AuthController::class, 'login'])->name('login');

    Route::middleware(['auth:api'])->group(function (){
        Route::patch('admin/clients/updateName/{name}', [UserController::class, 'updateName'])->name('admin.updateName');
        Route::prefix('auth')->group(function(){
            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
        });



    });


