<?php
use Illuminate\Support\Facades\Route;
use Fieroo\Bootstrapper\Controllers\ProfileController;
use Fieroo\Bootstrapper\Controllers\SettingsController;
use Fieroo\Bootstrapper\Controllers\AccountController;

Route::group(['middleware' => ['web']], function() {
    Route::get('/', function(){
        return redirect()->route('login');
    });
    Route::get('/switch-lang/{langCode}', [AccountController::class, 'switchLang']);
    Route::post('/reset-password', [AccountController::class, 'resetPassword'])->name('password.reset.update');
    Route::post('register-exhibitor', [AccountController::class, 'registerExhibitor'])->name('registerExhibitor');
    Route::post('register-admin', [AccountController::class, 'registerAdmin'])->name('registerAdmin');
    
    Route::group(['prefix' => 'admin'], function() {
        Route::get('/', function () {
            return redirect()->route('login');
        });
    
        Route::group(['middleware' => ['auth']], function() {
    
            Route::group(['prefix' => 'settings'], function(){
                Route::get('/', [SettingsController::class, 'index'])->name('settings');
                Route::post('/save-settings-generals', [SettingsController::class, 'saveSettingsGenerals'])->name('save-settings-generals');
                Route::post('/save-settings-emails', [SettingsController::class, 'saveSettingsEmails'])->name('save-settings-emails');
                
            });
    
            Route::group(['prefix' => 'profile'], function(){
                Route::get('/', [ProfileController::class, 'index'])->name('profile');
                Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change-password'); // only for admin
                Route::post('/change-personal-data', [ProfileController::class, 'changePersonalData'])->name('change-personal-data');
                Route::post('/save-data', [ProfileController::class, 'saveData'])->name('save-data');
            });
        });
    
        Route::group(['prefix' => 'account'], function(){
            Route::get('/confirm/{id}', [AccountController::class, 'confirmAccount']);
            Route::post('/confirm/set-password', [AccountController::class, 'setPassword'])->name('set-password');
        });
        
    });
});