<?php

use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // $threads = Thread::getAllLatest()->get();

    $thread = Thread::forUserWithNewMessages(83)->latest('updated_at')->first();

    dd($thread, $thread->messages, $thread->getLatestMessageAttribute(), $thread->users);
});
