<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/', App\Livewire\Welcome::class);

// Auth::routes();
Route::group(['middleware' => 'guest'], function(){
    Route::get('/login', 'App\Livewire\Auth\Login'::class)->name('login');
    Route::get('/register', 'App\Livewire\Auth\Register'::class)->name('register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'App\Livewire\Dashboard'::class);
    Route::get('/dashboard', 'App\Livewire\Dashboard'::class);
    Route::get('/system', 'App\Livewire\System\Permission'::class);
    Route::get('/system/user', 'App\Livewire\System\User'::class);
    Route::get('/system/role', 'App\Livewire\System\Role'::class);
    Route::get('/system/permission', 'App\Livewire\System\Permission'::class);
    Route::get('/system/menu', 'App\Livewire\System\Menu'::class);
    Route::get('/system/country', 'App\Livewire\System\Country'::class);
    Route::get('/system/translate', 'App\Livewire\System\Translate'::class);
    Route::get('/account', 'App\Livewire\Account\Profile'::class);
    Route::get('/account/profile', 'App\Livewire\Account\Profile'::class);
    // Route::post('/logout', 'App\Livewire\Auth\Logout'::class)->name('logout');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    session()->flash('message', __('message.translated'));
    // return redirect()->to('/');
    if(auth()->check()){
        return redirect('/dashboard');
    }else{
        return redirect('/login');
    }
});


Livewire::setScriptRoute(function ($handle) {
    return Route::get('/example-app/public/vendor/livewire/livewire.js', $handle);
    // return Route::get('/example-app/public/build/assets/app-0f67a93f.js', $handle);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/example-app/public/livewire/update', $handle);
});