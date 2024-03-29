<?php

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

Route::get('/dashboard', function () {
    return view('app.dashboard');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/brands', function(){
    return view('app.brands');
})->name('brands')->middleware('auth');


Route::get('/greeting/{locale}', function (string $locale) {
    if (! in_array($locale, ['en', 'es', 'fr'])) {
        abort(400);
    }
 
    App::setLocale($locale);

    $lol = App::currentLocale();

    dd($lol);
});

//Chats route
Route::get('/chats', [App\Http\Controllers\ChatsController::class, 'index'])->name('chats');
Route::get('/messages', [App\Http\Controllers\ChatsController::class, 'fetchMessages']);
Route::post('/messages', [App\Http\Controllers\ChatsController::class, 'sendMessage']);
Auth::routes();


Route::get('email-test', function () {
    // return 'Succ sess';
    return new MessageTestMail();
});
Auth::routes();
