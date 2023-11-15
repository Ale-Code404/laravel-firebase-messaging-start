<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'notification')->name('notifications.campaings.form');
Route::post('/notifications/campaigns', [NotificationController::class, 'createCampaign'])
    ->name('notifications.campaings.create');
