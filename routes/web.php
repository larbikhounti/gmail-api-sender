<?php

use App\Http\Controllers\EmailTokenController;
use App\Http\Controllers\SendEmailController;
use App\Models\EmailToken;
use App\Models\SendJobs;
use Illuminate\Support\Facades\Route;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
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
    return view('welcome');
});


Route::get('/token-list', function () {
    $email_token = EmailToken::all();    
    return view('tokenList',compact('email_token'));
});



Route::get('/drop-list', function () {
   // return list and paginate
    $drop_list = SendJobs::paginate(10);
    return view('drops',compact('drop_list'));

});

Route::get('/login', function (){
    return LaravelGmail::redirect();
});

Route::post('/send', function (){
    return LaravelGmail::redirect();
});


// add token
Route::post('/add-alias',[EmailTokenController::class,'add_alias'])->name('add-alias');
Route::get('welcome',[EmailTokenController::class,'store'] );
Route::post('send-test',[SendEmailController::class,'send_test'])->name('send_test');
Route::get('test-page',[SendEmailController::class,'send_page'])->name('test-page');




Route::get('/oauth/gmail/logout', function (){
LaravelGmail::logout(); //It returns exception if fails
    return redirect()->to('/');
});

