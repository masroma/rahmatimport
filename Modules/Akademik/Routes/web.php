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

Route::prefix('akademik')->group(function() {
    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('kampus')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KampusController@data',
                        'as' => 'kampus.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'KampusController@index',
                        'as' => 'kampus.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'KampusController@create',
                        'as' => 'kampus.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'KampusController@store',
                        'as' => 'kampus.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'KampusController@edit',
                        'as' => 'kampus.edit'
                    ]
                );

                Route::get(
                    '/{id}/show',
                    [
                        'uses' => 'KampusController@show',
                        'as' => 'kampus.show'
                    ]
                );


                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'KampusController@update',
                        'as' => 'kampus.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KampusController@destroy',
                        'as' => 'kampus.destroy'
                    ]
                );
            }
        );

        // fakultas
        Route::prefix('fakultas')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'FakultasController@data',
                        'as' => 'fakultas.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'FakultasController@index',
                        'as' => 'fakultas.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'FakultasController@create',
                        'as' => 'fakultas.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'FakultasController@store',
                        'as' => 'fakultas.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'FakultasController@edit',
                        'as' => 'fakultas.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'FakultasController@update',
                        'as' => 'fakultas.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'FakultasController@destroy',
                        'as' => 'fakultas.destroy'
                    ]
                );
            }
        );

        // jurusan
        Route::prefix('jurusan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JurusanController@data',
                        'as' => 'jurusan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JurusanController@index',
                        'as' => 'jurusan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JurusanController@create',
                        'as' => 'jurusan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JurusanController@store',
                        'as' => 'jurusan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JurusanController@edit',
                        'as' => 'jurusan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JurusanController@update',
                        'as' => 'jurusan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JurusanController@destroy',
                        'as' => 'jurusan.destroy'
                    ]
                );
            }
        );

                // Jenjangpendidikan
        Route::prefix('jenjangpendidikan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JenjangPendidikanController@data',
                        'as' => 'jenjangpendidikan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JenjangPendidikanController@index',
                        'as' => 'jenjangpendidikan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JenjangPendidikanController@create',
                        'as' => 'jenjangpendidikan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JenjangPendidikanController@store',
                        'as' => 'jenjangpendidikan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JenjangPendidikanController@edit',
                        'as' => 'jenjangpendidikan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JenjangPendidikanController@update',
                        'as' => 'jenjangpendidikan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JenjangPendidikanController@destroy',
                        'as' => 'jenjangpendidikan.destroy'
                    ]
                );
            }
        );

        // program study
        Route::prefix('programstudy')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'ProgramStudyController@data',
                        'as' => 'programstudy.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'ProgramStudyController@index',
                        'as' => 'programstudy.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'ProgramStudyController@create',
                        'as' => 'programstudy.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'ProgramStudyController@store',
                        'as' => 'programstudy.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'ProgramStudyController@edit',
                        'as' => 'programstudy.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'ProgramStudyController@update',
                        'as' => 'programstudy.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'ProgramStudyController@destroy',
                        'as' => 'programstudy.destroy'
                    ]
                );
            }
        );

        // mahasiswa
        Route::prefix('mahasiswa')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'MahasiswaController@data',
                        'as' => 'mahasiswa.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'MahasiswaController@index',
                        'as' => 'mahasiswa.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'MahasiswaController@create',
                        'as' => 'mahasiswa.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'MahasiswaController@store',
                        'as' => 'mahasiswa.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'MahasiswaController@edit',
                        'as' => 'mahasiswa.edit'
                    ]
                );

                Route::get(
                    '/{id}/show',
                    [
                        'uses' => 'MahasiswaController@show',
                        'as' => 'mahasiswa.show'
                    ]
                );


                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'MahasiswaController@update',
                        'as' => 'mahasiswa.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'MahasiswaController@destroy',
                        'as' => 'mahasiswa.destroy'
                    ]
                );
                Route::get(
                    '/datatrash',
                    [
                        'uses' => 'MahasiswaController@dataTrash',
                        'as' => 'mahasiswa.datatrash'
                    ]
                );
                Route::get(
                    '/trash',
                    [
                        'uses' => 'MahasiswaController@trash',
                        'as' => 'mahasiswa.trash'
                    ]
                );

                Route::get(
                    '/{id}/restore',
                    [
                        'uses' => 'MahasiswaController@restore',
                        'as' => 'mahasiswa.restore'
                    ]
                );
            }
        );
    });
});
