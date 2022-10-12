<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CmsPagesController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\ErrorController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['revalidate']], function () {
    Route::get('/home', function () {
        return redirect(route('admin.dashboard.index'));
    })->name('home');

    Route::controller(PagesController::class)->group(function () {
        // Profile
        Route::get('profile/', 'profile')->name('profile-view');
        Route::post('profile/update',  'updateProfile')->name('profile.update');
        Route::put('change/password',  'updatePassword')->name('update-password');

        // Quick Link
        Route::get('quickLink', 'quickLink')->name('quickLink');
        Route::post('link/update', 'updateQuickLink')->name('update-quickLink');
    });
});

Route::group(['namespace' => 'Admin', 'middleware' => ['check_permit', 'revalidate']], function () {

    Route::controller(PagesController::class)->group(function () {
        /* Dashboard */
        Route::get('/',  'dashboard')->name('dashboard.index');
        Route::get('/dashboard',  'dashboard')->name('dashboard.index');

        /* Site Configuration */
        Route::get('settings',   "showSetting")->name('settings.index');
        Route::post('change-setting',  "changeSetting")->name('settings.change-setting');
    });

    /* User */
    Route::get('users/listing',  [UsersController::class, 'listing'])->name('users.listing');
    Route::resource('users', UsersController::class);


    /* Role Management */
    Route::get('roles/listing', [AdminController::class, 'listing'])->name('roles.listing');
    Route::resource('roles', AdminController::class);

    /* Country Management*/
    Route::get('countries/listing',  [CountryController::class, 'listing'])->name('countries.listing');
    Route::resource('countries', CountryController::class);

    /* State Management*/
    Route::get('states/listing',   [StateController::class, 'listing'])->name('states.listing');
    Route::resource('states', StateController::class);

    /* City Management*/
    Route::get('cities/listing', [CityController::class, 'listing'])->name('cities.listing');
    Route::resource('cities', CityController::class);

    /* CMS Management*/
    Route::get('pages/listing',  [CmsPagesController::class, 'listing'])->name('pages.listing');
    Route::resource('pages', CmsPagesController::class);
});

//User Exception
Route::get('users-error-listing',  [ErrorController::class, "listing"])->name('error.listing');

//Chart routes
Route::controller(ChartController::class)->group(function () {
    Route::get('register-users-chart',  'getRegisterUser')->name('users.registerchart');
    Route::get('active-deactive-users-chart',  'getActiveDeactiveUser')->name('users.activeDeactiveChart');
});

Route::controller(UtilityController::class)->group(function () {
    Route::post('check-email',  'checkEmail')->name('check.email');
    Route::post('check-contact',  'checkContact')->name('check.contact');

    Route::post('check-title',  'checkTitle')->name('check.title');
    Route::post('profile/check-password',  'profilecheckpassword')->name('profile.check-password');
});

Route::post('summernote-image-upload', [SummernoteController::class, 'imageUpload'])->name('summernote.imageUpload');
Route::post('summernote-media-image', [SummernoteController::class, 'mediaDelete'])->name('summernote.mediaDelete');
