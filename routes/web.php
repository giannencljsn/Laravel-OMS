<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\WebhookController;

use App\Http\Controllers\MailController;

Route::get('/', function () {

    return redirect('/home/login');
})->name('admin.login');



Route::get('phpmyinfo', function () {
    phpinfo();
})->name('phpmyinfo');

Auth::routes();


