<?php

use Illuminate\Http\Request;
use App\Mail\MessageTestMail;
use App\Events\WebsocketDemoEvent;
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

Route::get('/', function () {
    // broadcast(new WebsocketDemoEvent('some data'));
    return view('welcome');
});


Auth::routes(['verify' => true]);

Route::middleware('verified')->group(function () {
       Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index']);
    Route::get('/brands', function(){ return view('app.brands'); })->name('brands')->middleware('auth');

    Route::get('/admin/config', [App\Http\Controllers\ConfigController::class, 'mainView'])->middleware('auth');

    // Route::get('/admin/config', function(){ 
    //    return view('app.admin.config');
    // })->name('admin/config')->middleware('auth');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //Chats route
    Route::get('/chats', [App\Http\Controllers\ChatsController::class, 'index'])->name('chats');
    Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
    Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);
});

Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'es', 'fr'])) {
        abort(400);
    }
 
    App::setLocale($locale);

    $lol = App::currentLocale();

    dd($lol);
});



Route::get('email-test', function () {
    dd(Lang::get('passwords.user'));
    // Mail::to('g.fonseca.barros@gmail.com')->send(new MessageTestMail());
    return 'Succ sess';
    // return new MessageTestMail();
})->middleware('throttle:30000');
