<?php

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

// Site
Route::get('/', 'HomeController@index')->name('home');

Route::get('campanha/{slug}', 'CampaignController@show')->name('campaign.show');

Route::get('entity-register', 'Auth\RegisterController@showRegistrationFormEntity')->name('entity-register');
Route::post('entity-register', 'Auth\RegisterController@entityRegister')->name('entity-register');

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes();

Route::get('/ufs/', function($uf = null){
    return response()->json(\App\Models\State::select('abbr')->orderBy('abbr')->get());
});

Route::get('/cities/{uf}', function($uf = null){
    $state = \App\Models\State::where('abbr', $uf)->first();
    return response()->json(\App\Models\City::where('state_id', $state->id)->orderBy('name')->get());
});

// Panel
Route::group(['middleware' => 'auth'], function () {
    // Home
    Route::get('/home', 'Panel\HomeController@index')->name('home');

    // Profile
    Route::get('/profile', 'Panel\ProfileController@index')->name('profile');
    Route::post('/profile', 'Panel\ProfileController@update')->name('profile');

    Route::group(['middleware' => 'check.entity'], function () {
        // Campaigns
        Route::resource('campaigns', 'Panel\CampaignController', ['except' => 'destroy']);
        Route::get('campaigns/confirm-donation/{id}', 'Panel\CampaignController@confirmDonation')->name('campaigns.confirm-donation');
        Route::get('campaigns/cancel-donation/{id}', 'Panel\CampaignController@cancelDonation')->name('campaigns.cancel-donation');
    });

    Route::group(['middleware' => 'check.user'], function () {
        // Donations
        Route::get('donations', 'Panel\DonationController@index')->name('donations.index');
        Route::get('campanha/{slug}/doar', 'Panel\DonationController@donateView')->name('donations.donate');
        Route::post('campanha/{slug}/doar', 'Panel\DonationController@donate')->name('donations.donate');
    });
});

Route::prefix('admin')->group(function() {
    Route::get('/login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\Admin\LoginController@login')->name('admin.login.submit');
    Route::post('logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'], function () {
        // Home
        Route::get('/', 'Admin\HomeController@index')->name('admin.home');

        // Users
        Route::resource('users', 'Admin\UserController', ['except' => 'destroy', 'store', 'create']);
        Route::get('users/destroy/{id}', 'Admin\UserController@destroy')->name('users.destroy');

        // Entities
        Route::resource('entities', 'Admin\EntityController', ['except' => 'destroy', 'store', 'create']);
        Route::get('entities/destroy/{id}', 'Admin\EntityController@destroy')->name('entities.destroy');

        // Campaigns
        Route::resource('campaigns', 'Admin\CampaignController', ['except' => 'destroy', 'store', 'create', 'names' =>[
            'index' => 'admin.campaigns.index',
            'show' => 'admin.campaigns.show',
            'edit' => 'admin.campaigns.edit',
            'update' => 'admin.campaigns.update',
            'create' => 'admin.campaigns.create',
            'store' => 'admin.campaigns.store',
            'destroy' => 'admin.campaigns.destroy'
        ]]);
        Route::get('campaigns/confirm-donation/{id}', 'Admin\CampaignController@confirmDonation')->name('admin.campaigns.confirm-donation');
        Route::get('campaigns/cancel-donation/{id}', 'Admin\CampaignController@cancelDonation')->name('admin.campaigns.cancel-donation');
    });
});
