<?php

use App\Http\Controllers\RouteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminRouteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AdminRouteController::class)->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/composer/{current?}', 'composer')->name('composer');
    Route::post('/composer/info', 'updateInfo');
    Route::post('/upload/photo', 'uploadImage');

    Route::post('/composer/teams/remove', 'removeTeamMember');
    Route::post('/composer/teams/add', 'addTeamMember');
    Route::post('/composer/teams/update', 'updateTeamMember');

    Route::post('/composer/events/remove', 'removeEvent');
    Route::post('/composer/events/add', 'addEvent');
    Route::post('/composer/events/update', 'updateEvent');

    Route::post('/composer/awards/remove', 'removeAward');
    Route::post('/composer/awards/add', 'addAward');
    Route::post('/composer/awards/update', 'updateAward');

    Route::post('/composer/managers/remove', 'removeManager');
    Route::post('/composer/managers/add', 'addManager');
    Route::post('/composer/managers/update', 'updateManager');

    Route::post('/composer/media/remove', 'removeMedia');
    Route::post('/composer/media/add', 'addMedia');
    Route::post('/composer/media/update', 'updateMedia');

    Route::post('/composer/messages/remove', 'removeMessage');

    Route::post('/composer/about/update', 'updateAbout');
});

Route::get('/', [RouteController::class, 'index'])->name('home');

Route::post('/send', [AdminRouteController::class, 'sendMessage']);
