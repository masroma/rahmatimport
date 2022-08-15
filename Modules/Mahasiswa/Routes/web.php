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

Route::prefix('mahasiswa')->group(function() {
  
    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('dashboard')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'DashboardController@index',
                        'as' => 'dashboard'
                    ]
                );
            }
        );

        Route::prefix('info')->group(
            function () {
                Route::get(
                    '/{id}',
                    [
                        'uses' => 'DashboardController@detailinfo',
                        'as' => 'info'
                    ]
                );
            }
        );
       
        Route::prefix('informasi-matakuliah')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'InformasiMatakuliahController@index',
                        'as' => 'informasimatakuliah'
                    ]
                );
            }
        );
    });
});
