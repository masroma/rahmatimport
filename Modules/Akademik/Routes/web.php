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

                // pendidikan mahasiswa
                Route::get(
                    '/creatependidikan/{id}',
                    [
                        'uses' => 'MahasiswaHistoryPendidikanController@creatependidikan',
                        'as' => 'mahasiswa.creatependidikan'
                    ]
                );

                Route::get(
                    '/datapendidikan/{id}',
                    [
                        'uses' => 'MahasiswaHistoryPendidikanController@datapendidikan',
                        'as' => 'mahasiswa.datapendidikan'
                    ]
                );

                Route::post(
                    '/storependidikan',
                    [
                        'uses' => 'MahasiswaHistoryPendidikanController@storeRiwayatPendidikan',
                        'as' => 'mahasiswa.storeriwayatpendidikan'
                    ]
                );

                Route::get(
                    '/{id}/editpendidikan',
                    [
                        'uses' => 'MahasiswaHistoryPendidikanController@editPendidikan',
                        'as' => 'mahasiswa.editpendidikan'
                    ]
                );

                Route::post(
                    '/updatependidikan/{id}',
                    [
                        'uses' => 'MahasiswaHistoryPendidikanController@updatePendidikan',
                        'as' => 'mahasiswa.updatependidikan'
                    ]
                );

                Route::get(
                    '/{id}/deletependidikan',
                    [
                        'uses' => 'MahasiswaHistoryPendidikanController@destroyPendidikan',
                        'as' => 'mahasiswa.destroypendidikan'
                    ]
                );

                // prestasi
                Route::get(
                    '/createprestasi/{id}',
                    [
                        'uses' => 'PrestasiMahasiswaController@create',
                        'as' => 'mahasiswa.createprestasi'
                    ]
                );

                Route::get(
                    '/dataprestasi/{id}',
                    [
                        'uses' => 'PrestasiMahasiswaController@data',
                        'as' => 'mahasiswa.dataprestasi'
                    ]
                );

                Route::post(
                    '/storeprestasi',
                    [
                        'uses' => 'PrestasiMahasiswaController@store',
                        'as' => 'mahasiswa.storeprestasi'
                    ]
                );

                Route::get(
                    '/{id}/editprestasi',
                    [
                        'uses' => 'PrestasiMahasiswaController@edit',
                        'as' => 'mahasiswa.editprestasi'
                    ]
                );

                Route::post(
                    '/updateprestasi/{id}',
                    [
                        'uses' => 'PrestasiMahasiswaController@update',
                        'as' => 'mahasiswa.updateprestasi'
                    ]
                );

                Route::get(
                    '/{id}/deleteprestasi',
                    [
                        'uses' => 'PrestasiMahasiswaController@destroy',
                        'as' => 'mahasiswa.destroyprestasi'
                    ]
                );

                // krs mahasiswa
                Route::get(
                    '/createkrs/{id}',
                    [
                        'uses' => 'MahasiswaKrsController@createKrs',
                        'as' => 'mahasiswa.createkrs'
                    ]
                );

                Route::get(
                    '/datakrs/{id}',
                    [
                        'uses' => 'MahasiswaKrsController@dataKrs',
                        'as' => 'mahasiswa.datakrs'
                    ]
                );

                Route::get(
                    '/totalsks/{id}',
                    [
                        'uses' => 'MahasiswaKrsController@TotalSks',
                        'as' => 'mahasiswa.totalsks'
                    ]
                );

                Route::post(
                    '/storekrs',
                    [
                        'uses' => 'MahasiswaKrsController@storeRiwayatKrs',
                        'as' => 'mahasiswa.storeriwayatkrs'
                    ]
                );


                Route::get(
                    '/{id}/deletekrs',
                    [
                        'uses' => 'MahasiswaKrsController@destroyKrs',
                        'as' => 'mahasiswa.destroykrs'
                    ]
                );
                Route::get(
                    '/{id}/getakm',
                    [
                        'uses' => 'MahasiswaController@getAkm',
                        'as' => 'mahasiswa.getakm'
                    ]
                );
                Route::get(
                    '/{id}/gettranskrip',
                    [
                        'uses' => 'MahasiswaController@getTransrip',
                        'as' => 'mahasiswa.gettranskrip'
                    ]
                );
                Route::get(
                    '/{id}/gettransfer',
                    [
                        'uses' => 'MahasiswaController@getTransfer',
                        'as' => 'mahasiswa.gettransfer'
                    ]
                );
                Route::post(
                    '/storetransfer',
                    [
                        'uses' => 'MahasiswaController@nilaiTransferStore',
                        'as' => 'nilaitransfer.store'
                    ]
                );
                Route::get(
                    '/nilaitransfer/delete/{id}',
                    [
                        'uses' => 'MahasiswaController@deleteNilaiTranfer',
                        'as' => 'nilaitransfer.delete'
                    ]
                );
                Route::get(
                    '/nilaitransfer/print/{id}',
                    [
                        'uses' => 'MahasiswaController@printNilaiTransfer',
                        'as' => 'nilaitransfer.print'
                    ]
                );
            }
        );

        Route::prefix('import')->group(
            function () {

                Route::post(
                    '/import',
                    [
                        'uses' => 'ImportController@importProcess',
                        'as' => 'import.process'
                    ]
                );
                Route::get(
                    '/mahasiswa',
                    [
                        'uses' => 'ImportController@mahasiswa',
                        'as' => 'index.mahasiswa'
                    ]
                );

                Route::get(
                    '/dosen',
                    [
                        'uses' => 'ImportController@dosen',
                        'as' => 'index.dosen'
                    ]
                );

                Route::get(
                    '/matakuliah',
                    [
                        'uses' => 'ImportController@matakuliah',
                        'as' => 'index.matakuliah'
                    ]
                );

                Route::get(
                    '/semester',
                    [
                        'uses' => 'ImportController@semester',
                        'as' => 'index.semester'
                    ]
                );
        });

        // dosen
        Route::prefix('dosen')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'DosenController@data',
                        'as' => 'dosen.data'
                    ]
                );

                Route::get(
                    '/',
                    [
                        'uses' => 'DosenController@index',
                        'as' => 'dosen.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'DosenController@create',
                        'as' => 'dosen.create'
                    ]
                );

                Route::post(
                    '/store',
                    [
                        'uses' => 'DosenController@store',
                        'as' => 'dosen.store'
                    ]
                );

                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'DosenController@edit',
                        'as' => 'dosen.edit'
                    ]
                );

                Route::get(
                    '/{id}/show',
                    [
                        'uses' => 'DosenController@show',
                        'as' => 'dosen.show'
                    ]
                );


                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'DosenController@update',
                        'as' => 'dosen.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'DosenController@destroy',
                        'as' => 'dosen.destroy'
                    ]
                );
                Route::get(
                    '/datatrash',
                    [
                        'uses' => 'DosenController@dataTrash',
                        'as' => 'dosen.datatrash'
                    ]
                );
                Route::get(
                    '/trash',
                    [
                        'uses' => 'DosenController@trash',
                        'as' => 'dosen.trash'
                    ]
                );

                Route::get(
                    '/{id}/restore',
                    [
                        'uses' => 'DosenController@restore',
                        'as' => 'dosen.restore'
                    ]
                );

                // riwayat fungsional
                Route::get(
                    '/createfungsional/{id}',
                    [
                        'uses' => 'DosenController@createFungsional',
                        'as' => 'dosen.createfungsional'
                    ]
                );

                Route::get(
                    '/datafungsional/{id}',
                    [
                        'uses' => 'DosenController@dataFungsional',
                        'as' => 'dosen.datafungsional'
                    ]
                );

                Route::post(
                    '/storefungsional',
                    [
                        'uses' => 'DosenController@storeRiwayatFungsional',
                        'as' => 'dosen.storeriwayatfungsional'
                    ]
                );

                Route::get(
                    '/{id}/editfungsional',
                    [
                        'uses' => 'DosenController@editFungsional',
                        'as' => 'dosen.editfungsional'
                    ]
                );

                Route::post(
                    '/updatefungsional/{id}',
                    [
                        'uses' => 'DosenController@updateFungsional',
                        'as' => 'dosen.updatefungsional'
                    ]
                );

                Route::get(
                    '/{id}/deletefungsional',
                    [
                        'uses' => 'DosenController@destroyFungsional',
                        'as' => 'dosen.destroyfungsional'
                    ]
                );

                // pangkat
                Route::get(
                    '/createpangkat/{id}',
                    [
                        'uses' => 'DosenController@createPangkat',
                        'as' => 'dosen.createpangkat'
                    ]
                );

                Route::get(
                    '/datapangkat/{id}',
                    [
                        'uses' => 'DosenController@dataPangkat',
                        'as' => 'dosen.datapangkat'
                    ]
                );

                Route::post(
                    '/storepangkat',
                    [
                        'uses' => 'DosenController@storeRiwayatPangkat',
                        'as' => 'dosen.storeriwayatpangkat'
                    ]
                );

                Route::get(
                    '/{id}/editpangkat',
                    [
                        'uses' => 'DosenController@editPangkat',
                        'as' => 'dosen.editpangkat'
                    ]
                );

                Route::post(
                    '/updatepangkat/{id}',
                    [
                        'uses' => 'DosenController@updatePangkat',
                        'as' => 'dosen.updatepangkat'
                    ]
                );

                Route::get(
                    '/{id}/deletepangkat',
                    [
                        'uses' => 'DosenController@destroyPangkat',
                        'as' => 'dosen.destroypangkat'
                    ]
                );

                // PENDIDIKAN
                Route::get(
                    '/creatependidikan/{id}',
                    [
                        'uses' => 'DosenController@creatependidikan',
                        'as' => 'dosen.creatependidikan'
                    ]
                );

                Route::get(
                    '/datapendidikan/{id}',
                    [
                        'uses' => 'DosenController@datapendidikan',
                        'as' => 'dosen.datapendidikan'
                    ]
                );

                Route::post(
                    '/storependidikan',
                    [
                        'uses' => 'DosenController@storeRiwayatPendidikan',
                        'as' => 'dosen.storeriwayatpendidikan'
                    ]
                );

                Route::get(
                    '/{id}/editpendidikan',
                    [
                        'uses' => 'DosenController@editPendidikan',
                        'as' => 'dosen.editpendidikan'
                    ]
                );

                Route::post(
                    '/updatependidikan/{id}',
                    [
                        'uses' => 'DosenController@updatePendidikan',
                        'as' => 'dosen.updatependidikan'
                    ]
                );

                Route::get(
                    '/{id}/deletependidikan',
                    [
                        'uses' => 'DosenController@destroyPendidikan',
                        'as' => 'dosen.destroypendidikan'
                    ]
                );

                // penelitian
                Route::get(
                    '/createpenelitian/{id}',
                    [
                        'uses' => 'DosenController@createPenelitian',
                        'as' => 'dosen.createpenelitian'
                    ]
                );

                Route::get(
                    '/datapenelitian/{id}',
                    [
                        'uses' => 'DosenController@dataPenelitian',
                        'as' => 'dosen.datapenelitian'
                    ]
                );

                Route::post(
                    '/storepenelitian',
                    [
                        'uses' => 'DosenController@storeRiwayatPenelitian',
                        'as' => 'dosen.storeriwayatpenelitian'
                    ]
                );

                Route::get(
                    '/{id}/editpenelitian',
                    [
                        'uses' => 'DosenController@editPenelitian',
                        'as' => 'dosen.editpenelitian'
                    ]
                );

                Route::post(
                    '/updatepenelitian/{id}',
                    [
                        'uses' => 'DosenController@updatePenelitian',
                        'as' => 'dosen.updatepenelitian'
                    ]
                );

                Route::get(
                    '/{id}/deletepenelitian',
                    [
                        'uses' => 'DosenController@destroyPenelitian',
                        'as' => 'dosen.destroypenelitian'
                    ]
                );

                // sertifikasi
                Route::get(
                    '/createsertifikasi/{id}',
                    [
                        'uses' => 'DosenController@createSertifikasi',
                        'as' => 'dosen.createsertifikasi'
                    ]
                );

                Route::get(
                    '/datasertifikasi/{id}',
                    [
                        'uses' => 'DosenController@dataSertifikasi',
                        'as' => 'dosen.datasertifikasi'
                    ]
                );

                Route::post(
                    '/storesertifikasi',
                    [
                        'uses' => 'DosenController@storeRiwayatSertifikasi',
                        'as' => 'dosen.storeriwayatsertifikasi'
                    ]
                );

                Route::get(
                    '/{id}/editsertifikasi',
                    [
                        'uses' => 'DosenController@editSertifikasi',
                        'as' => 'dosen.editsertifikasi'
                    ]
                );

                Route::post(
                    '/updatesertifikasi/{id}',
                    [
                        'uses' => 'DosenController@updateSertifikasi',
                        'as' => 'dosen.updatesertifikasi'
                    ]
                );

                Route::get(
                    '/{id}/deletesertifikasi',
                    [
                        'uses' => 'DosenController@destroySertifikasi',
                        'as' => 'dosen.destroysertifikasi'
                    ]
                );


            }
        );

         // tahun ajaran
         Route::prefix('tahunajaran')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'TahunAjaranController@data',
                        'as' => 'tahunajaran.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'TahunAjaranController@index',
                        'as' => 'tahunajaran.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'TahunAjaranController@create',
                        'as' => 'tahunajaran.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'TahunAjaranController@store',
                        'as' => 'tahunajaran.store'
                    ]
                );
                Route::post(
                    '/updatestatus',
                    [
                        'uses' => 'TahunAjaranController@updateStatus',
                        'as' => 'tahunajaran.updatestatus'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'TahunAjaranController@edit',
                        'as' => 'tahunajaran.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'TahunAjaranController@update',
                        'as' => 'tahunajaran.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'TahunAjaranController@destroy',
                        'as' => 'tahunajaran.destroy'
                    ]
                );
            }
        );

        // cutlock time
        // tahun ajaran
            Route::prefix('cutlocktime')->group(
                function () {
                    Route::get(
                        '/data',
                        [
                            'uses' => 'CutLockTimeController@data',
                            'as' => 'cutlocktime.data'
                        ]
                    );
                    Route::get(
                        '/',
                        [
                            'uses' => 'CutLockTimeController@index',
                            'as' => 'cutlocktime.index'
                        ]
                    );
                    Route::get(
                        '/create',
                        [
                            'uses' => 'CutLockTimeController@create',
                            'as' => 'cutlocktime.create'
                        ]
                    );
                    Route::post(
                        '/store',
                        [
                            'uses' => 'CutLockTimeController@store',
                            'as' => 'cutlocktime.store'
                        ]
                    );
                    Route::post(
                        '/updatestatus',
                        [
                            'uses' => 'CutLockTimeController@updateStatus',
                            'as' => 'cutlocktime.updatestatus'
                        ]
                    );
                    Route::get(
                        '/{id}/edit',
                        [
                            'uses' => 'CutLockTimeController@edit',
                            'as' => 'cutlocktime.edit'
                        ]
                    );
                    Route::post(
                        '/update/{id}',
                        [
                            'uses' => 'CutLockTimeController@update',
                            'as' => 'cutlocktime.update'
                        ]
                    );


                    Route::get(
                        '/{id}/delete',
                        [
                            'uses' => 'CutLockTimeController@destroy',
                            'as' => 'cutlocktime.destroy'
                        ]
                    );
                }
            );

        // pept grade
        Route::prefix('peptgrade')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'PeptGradeController@data',
                        'as' => 'peptgrade.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PeptGradeController@index',
                        'as' => 'peptgrade.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PeptGradeController@create',
                        'as' => 'peptgrade.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PeptGradeController@store',
                        'as' => 'peptgrade.store'
                    ]
                );
                Route::post(
                    '/updatestatus',
                    [
                        'uses' => 'PeptGradeController@updateStatus',
                        'as' => 'peptgrade.updatestatus'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PeptGradeController@edit',
                        'as' => 'peptgrade.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PeptGradeController@update',
                        'as' => 'peptgrade.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PeptGradeController@destroy',
                        'as' => 'peptgrade.destroy'
                    ]
                );
            }
        );

        // pept batch
        Route::prefix('peptbatch')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'PeptBatchController@data',
                        'as' => 'peptbatch.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PeptBatchController@index',
                        'as' => 'peptbatch.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PeptBatchController@create',
                        'as' => 'peptbatch.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PeptBatchController@store',
                        'as' => 'peptbatch.store'
                    ]
                );
                Route::post(
                    '/updatestatus',
                    [
                        'uses' => 'PeptBatchController@updateStatus',
                        'as' => 'peptbatch.updatestatus'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PeptBatchController@edit',
                        'as' => 'peptbatch.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PeptBatchController@update',
                        'as' => 'peptbatch.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PeptBatchController@destroy',
                        'as' => 'peptbatch.destroy'
                    ]
                );
            }
        );

        Route::prefix('peptkelas')->group(
            function () {
                Route::get(
                    '/dataruangan',
                    [
                        'uses' => 'PeptKelasController@dataRuang',
                        'as' => 'peptkelas.dataruang'
                    ]
                );
                Route::get(
                    '/data',
                    [
                        'uses' => 'PeptKelasController@data',
                        'as' => 'peptkelas.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PeptKelasController@index',
                        'as' => 'peptkelas.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PeptKelasController@create',
                        'as' => 'peptkelas.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PeptKelasController@store',
                        'as' => 'peptkelas.store'
                    ]
                );
                Route::post(
                    '/updatestatus',
                    [
                        'uses' => 'PeptKelasController@updateStatus',
                        'as' => 'peptkelas.updatestatus'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PeptKelasController@edit',
                        'as' => 'peptkelas.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PeptKelasController@update',
                        'as' => 'peptkelas.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PeptKelasController@destroy',
                        'as' => 'peptkelas.destroy'
                    ]
                );
            }
        );

        // unclokkrs
        Route::prefix('unlockkrs')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'UnlockKrsController@data',
                        'as' => 'unlockkrs.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'UnlockKrsController@index',
                        'as' => 'unlockkrs.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'UnlockKrsController@create',
                        'as' => 'unlockkrs.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'UnlockKrsController@store',
                        'as' => 'unlockkrs.store'
                    ]
                );
                Route::post(
                    '/updatestatus',
                    [
                        'uses' => 'UnlockKrsController@updateStatus',
                        'as' => 'unlockkrs.updatestatus'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'UnlockKrsController@edit',
                        'as' => 'unlockkrs.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'UnlockKrsController@update',
                        'as' => 'unlockkrs.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'UnlockKrsController@destroy',
                        'as' => 'unlockkrs.destroy'
                    ]
                );
            }
        );




        // penugasan dosen
        Route::prefix('penugasandosen')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'PenugasanDosenController@data',
                        'as' => 'penugasandosen.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PenugasanDosenController@index',
                        'as' => 'penugasandosen.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PenugasanDosenController@create',
                        'as' => 'penugasandosen.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PenugasanDosenController@store',
                        'as' => 'penugasandosen.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PenugasanDosenController@edit',
                        'as' => 'penugasandosen.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PenugasanDosenController@update',
                        'as' => 'penugasandosen.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PenugasanDosenController@destroy',
                        'as' => 'penugasandosen.destroy'
                    ]
                );
            }
        );

        // penugasan matakuliah
        Route::prefix('matakuliah')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'MataKuliahController@data',
                        'as' => 'matakuliah.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'MataKuliahController@index',
                        'as' => 'matakuliah.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'MataKuliahController@create',
                        'as' => 'matakuliah.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'MataKuliahController@store',
                        'as' => 'matakuliah.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'MataKuliahController@edit',
                        'as' => 'matakuliah.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'MataKuliahController@update',
                        'as' => 'matakuliah.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'MataKuliahController@destroy',
                        'as' => 'matakuliah.destroy'
                    ]
                );
            }
        );

        // substansi
        Route::prefix('substansikuliah')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'SubstansiKuliahController@data',
                        'as' => 'substansikuliah.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'SubstansiKuliahController@index',
                        'as' => 'substansikuliah.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'SubstansiKuliahController@create',
                        'as' => 'substansikuliah.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'SubstansiKuliahController@store',
                        'as' => 'substansikuliah.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'SubstansiKuliahController@edit',
                        'as' => 'substansikuliah.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'SubstansiKuliahController@update',
                        'as' => 'substansikuliah.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'SubstansiKuliahController@destroy',
                        'as' => 'substansikuliah.destroy'
                    ]
                );
            }
        );

        //kurikulum
        Route::prefix('kurikulum')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KurikulumController@data',
                        'as' => 'kurikulum.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'KurikulumController@index',
                        'as' => 'kurikulum.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'KurikulumController@create',
                        'as' => 'kurikulum.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'KurikulumController@store',
                        'as' => 'kurikulum.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'KurikulumController@edit',
                        'as' => 'kurikulum.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'KurikulumController@update',
                        'as' => 'kurikulum.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KurikulumController@destroy',
                        'as' => 'kurikulum.destroy'
                    ]
                );

                // matakuliah kurikulum
                Route::get(
                    '/datakurikulummatakuliah/{id}',
                    [
                        'uses' => 'KurikulumController@dataKurikulumMatakuliah',
                        'as' => 'kurikulummatakuliah.data'
                    ]
                );

                Route::get(
                    '/datakurikulummatakuliahbelumterdaftar/{id}',
                    [
                        'uses' => 'KurikulumController@dataKurikulumMatakuliahBelumTerdaftar',
                        'as' => 'kurikulummatakuliahbelumterdaftar.data'
                    ]
                );

                Route::get(
                    '/updatekurikulumsemester',
                    [
                        'uses' => 'KurikulumController@updateSemester',
                        'as' => 'kurikulum.updatekurikulumsemester'
                    ]
                );

                Route::get(
                    '/tambahsemester',
                    [
                        'uses' => 'KurikulumController@tambahSemester',
                        'as' => 'kurikulum.tambahSemester'
                    ]
                );

                Route::get(
                    '/updatekurikulumwajib',
                    [
                        'uses' => 'KurikulumController@updateWajib',
                        'as' => 'kurikulum.updatekurikulumwajib'
                    ]
                );

                Route::get(
                    '/{id}/deletematakuliah',
                    [
                        'uses' => 'KurikulumController@deleteMatakuliahKurikulum',
                        'as' => 'kurikulum.destroymatakuliah'
                    ]
                );
            }
        );

        // penugasan kelasperkuliahan
        Route::prefix('kelasperkuliahan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KelasKuliahController@data',
                        'as' => 'kelasperkuliahan.data'
                    ]
                );

                Route::get(
                    '/datakelasbelumkrs/{id}',
                    [
                        'uses' => 'KelasKuliahController@dataKelasBelumKrs',
                        'as' => 'kelasperkuliahan.datakelasbelumkrs'
                    ]
                );

                Route::get(
                    '/',
                    [
                        'uses' => 'KelasKuliahController@index',
                        'as' => 'kelasperkuliahan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'KelasKuliahController@create',
                        'as' => 'kelasperkuliahan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'KelasKuliahController@store',
                        'as' => 'kelasperkuliahan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'KelasKuliahController@edit',
                        'as' => 'kelasperkuliahan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'KelasKuliahController@update',
                        'as' => 'kelasperkuliahan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KelasKuliahController@destroy',
                        'as' => 'kelasperkuliahan.destroy'
                    ]
                );

                Route::get(
                    '/datadosen/{id}',
                    [
                        'uses' => 'KelasKuliahController@dataDosenPerkuliahan',
                        'as' => 'kelasperkuliahan.datadosenperkuliahan'
                    ]
                );

                Route::get(
                    '/createdosenpengajar/{id}',
                    [
                        'uses' => 'KelasKuliahController@createDosenPerkuliahan',
                        'as' => 'kelasperkuliahan.createdosenperkuliahan'
                    ]
                );

                Route::post(
                    '/storedosenperngajar',
                    [
                        'uses' => 'KelasKuliahController@storeDosenPerkuliahan',
                        'as' => 'kelasperkuliahan.storeDosenPerkuliahan'
                    ]
                );

                Route::get(
                    '/{id}/editdosenpengajar',
                    [
                        'uses' => 'KelasKuliahController@editDosenPerkuliahan',
                        'as' => 'kelasperkuliahan.editdosenperkuliahan'
                    ]
                );

                Route::post(
                    '/updatedosenpengajar/{id}',
                    [
                        'uses' => 'KelasKuliahController@updateDosenPerkuliahan',
                        'as' => 'kelasperkuliahan.updatedosenpengajar'
                    ]
                );

                Route::get(
                    '/{id}/deletedosenpengajar',
                    [
                        'uses' => 'KelasKuliahController@destroyDosenPerkuliahan',
                        'as' => 'kelasperkuliahan.destroydosenpengajar'
                    ]
                );
            }
        );

        // jalur masuk
        Route::prefix('jalurmasuk')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JalurMasukInternalController@data',
                        'as' => 'jalurmasuk.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JalurMasukInternalController@index',
                        'as' => 'jalurmasuk.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JalurMasukInternalController@create',
                        'as' => 'jalurmasuk.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JalurMasukInternalController@store',
                        'as' => 'jalurmasuk.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JalurMasukInternalController@edit',
                        'as' => 'jalurmasuk.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JalurMasukInternalController@update',
                        'as' => 'jalurmasuk.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JalurMasukInternalController@destroy',
                        'as' => 'jalurmasuk.destroy'
                    ]
                );
            }
        );

        Route::prefix('typemahasiswa')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'TypeMahasiswaController@data',
                        'as' => 'typemahasiswa.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'TypeMahasiswaController@index',
                        'as' => 'typemahasiswa.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'TypeMahasiswaController@create',
                        'as' => 'typemahasiswa.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'TypeMahasiswaController@store',
                        'as' => 'typemahasiswa.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'TypeMahasiswaController@edit',
                        'as' => 'typemahasiswa.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'TypeMahasiswaController@update',
                        'as' => 'typemahasiswa.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'TypeMahasiswaController@destroy',
                        'as' => 'typemahasiswa.destroy'
                    ]
                );
            }
        );

        Route::prefix('kategoriinformasi')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KategoriInformasiController@data',
                        'as' => 'kategoriinformasi.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'KategoriInformasiController@index',
                        'as' => 'kategoriinformasi.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'KategoriInformasiController@create',
                        'as' => 'kategoriinformasi.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'KategoriInformasiController@store',
                        'as' => 'kategoriinformasi.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'KategoriInformasiController@edit',
                        'as' => 'kategoriinformasi.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'KategoriInformasiController@update',
                        'as' => 'kategoriinformasi.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KategoriInformasiController@destroy',
                        'as' => 'kategoriinformasi.destroy'
                    ]
                );
            }
        );

        Route::prefix('informasi')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'InformasiController@data',
                        'as' => 'informasi.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'InformasiController@index',
                        'as' => 'informasi.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'InformasiController@create',
                        'as' => 'informasi.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'InformasiController@store',
                        'as' => 'informasi.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'InformasiController@edit',
                        'as' => 'informasi.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'InformasiController@update',
                        'as' => 'informasi.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'InformasiController@destroy',
                        'as' => 'informasi.destroy'
                    ]
                );
            }
        );

        // jenisprestasi
        Route::prefix('jenisprestasi')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JenisPrestasiController@data',
                        'as' => 'jenisprestasi.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JenisPrestasiController@index',
                        'as' => 'jenisprestasi.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JenisPrestasiController@create',
                        'as' => 'jenisprestasi.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JenisPrestasiController@store',
                        'as' => 'jenisprestasi.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JenisPrestasiController@edit',
                        'as' => 'jenisprestasi.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JenisPrestasiController@update',
                        'as' => 'jenisprestasi.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JenisPrestasiController@destroy',
                        'as' => 'jenisprestasi.destroy'
                    ]
                );
            }
        );

        // tingkatprestasi
        Route::prefix('tingkatprestasi')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'TingkatPrestasiController@data',
                        'as' => 'tingkatprestasi.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'TingkatPrestasiController@index',
                        'as' => 'tingkatprestasi.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'TingkatPrestasiController@create',
                        'as' => 'tingkatprestasi.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'TingkatPrestasiController@store',
                        'as' => 'tingkatprestasi.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'TingkatPrestasiController@edit',
                        'as' => 'tingkatprestasi.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'TingkatPrestasiController@update',
                        'as' => 'tingkatprestasi.update'
                    ]
                );

                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'TingkatPrestasiController@destroy',
                        'as' => 'tingkatprestasi.destroy'
                    ]
                );
            }
        );


        // jenis pendaftaran
        Route::prefix('jenispendaftaran')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JenisPendaftaranController@data',
                        'as' => 'jenispendaftaran.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JenisPendaftaranController@index',
                        'as' => 'jenispendaftaran.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JenisPendaftaranController@create',
                        'as' => 'jenispendaftaran.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JenisPendaftaranController@store',
                        'as' => 'jenispendaftaran.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JenisPendaftaranController@edit',
                        'as' => 'jenispendaftaran.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JenisPendaftaranController@update',
                        'as' => 'jenispendaftaran.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JenisPendaftaranController@destroy',
                        'as' => 'jenispendaftaran.destroy'
                    ]
                );
            }
        );

        // jalur
        // jalur pendaftaran
        Route::prefix('jalurpendaftaran')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JalurPendaftaranController@data',
                        'as' => 'jalurpendaftaran.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JalurPendaftaranController@index',
                        'as' => 'jalurpendaftaran.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JalurPendaftaranController@create',
                        'as' => 'jalurpendaftaran.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JalurPendaftaranController@store',
                        'as' => 'jalurpendaftaran.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JalurPendaftaranController@edit',
                        'as' => 'jalurpendaftaran.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JalurPendaftaranController@update',
                        'as' => 'jalurpendaftaran.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JalurPendaftaranController@destroy',
                        'as' => 'jalurpendaftaran.destroy'
                    ]
                );
            }
        );

                // jalur pendaftaran
        Route::prefix('jatahkrs')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JatahKrsController@data',
                        'as' => 'jatahkrs.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JatahKrsController@index',
                        'as' => 'jatahkrs.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JatahKrsController@create',
                        'as' => 'jatahkrs.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JatahKrsController@store',
                        'as' => 'jatahkrs.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JatahKrsController@edit',
                        'as' => 'jatahkrs.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JatahKrsController@update',
                        'as' => 'jatahkrs.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JatahKrsController@destroy',
                        'as' => 'jatahkrs.destroy'
                    ]
                );
            }
        );

        // jalur peminatan
        // jalur pendaftaran
        Route::prefix('peminatan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'PeminatanController@data',
                        'as' => 'peminatan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PeminatanController@index',
                        'as' => 'peminatan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PeminatanController@create',
                        'as' => 'peminatan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PeminatanController@store',
                        'as' => 'peminatan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PeminatanController@edit',
                        'as' => 'peminatan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PeminatanController@update',
                        'as' => 'peminatan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PeminatanController@destroy',
                        'as' => 'peminatan.destroy'
                    ]
                );
            }
        );

        Route::prefix('ruangan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'RuanganController@data',
                        'as' => 'ruangan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'RuanganController@index',
                        'as' => 'ruangan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'RuanganController@create',
                        'as' => 'ruangan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'RuanganController@store',
                        'as' => 'ruangan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'RuanganController@edit',
                        'as' => 'ruangan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'RuanganController@update',
                        'as' => 'ruangan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'RuanganController@destroy',
                        'as' => 'ruangan.destroy'
                    ]
                );
            }
        );

         //status mahasiswa
         Route::prefix('statusmahasiswa')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'StatusMahasiswaController@data',
                        'as' => 'statusmahasiswa.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'StatusMahasiswaController@index',
                        'as' => 'statusmahasiswa.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'StatusMahasiswaController@create',
                        'as' => 'statusmahasiswa.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'StatusMahasiswaController@store',
                        'as' => 'statusmahasiswa.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'StatusMahasiswaController@edit',
                        'as' => 'statusmahasiswa.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'StatusMahasiswaController@update',
                        'as' => 'statusmahasiswa.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'StatusMahasiswaController@destroy',
                        'as' => 'statusmahasiswa.destroy'
                    ]
                );
            }
        );

        Route::prefix('ruangperkuliahan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'RuangPerkuliahanController@data',
                        'as' => 'ruangperkuliahan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'RuangPerkuliahanController@index',
                        'as' => 'ruangperkuliahan.index'
                    ]
                );
                Route::get(
                    '/calendar/{id}',
                    [
                        'uses' => 'RuangPerkuliahanController@calendar',
                        'as' => 'ruangperkuliahan.calendar'
                    ]
                );
                Route::post(
                    '/savecalendar',
                    [
                        'uses' => 'RuangPerkuliahanController@insertCalendar',
                        'as' => 'ruangperkuliahan.savecalendar'
                    ]
                );
                Route::get(
                    '/create/{id}',
                    [
                        'uses' => 'RuangPerkuliahanController@createKelasByRuangan',
                        'as' => 'ruangperkuliahan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'RuangPerkuliahanController@store',
                        'as' => 'ruangperkuliahan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'RuangPerkuliahanController@editkelasByRuangan',
                        'as' => 'ruangperkuliahan.edit'
                    ]
                );
                Route::get(
                    '/{id}/show',
                    [
                        // 'uses' => 'RuangPerkuliahanController@show',
                        'uses' => 'RuangPerkuliahanController@calendar',
                        'as' => 'ruangperkuliahan.show'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'RuangPerkuliahanController@update',
                        'as' => 'ruangperkuliahan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'RuangPerkuliahanController@destroy',
                        'as' => 'ruangperkuliahan.destroy'
                    ]
                );

                Route::get(
                    '/{id}/deletekelas',
                    [
                        'uses' => 'RuangPerkuliahanController@deleteKelas',
                        'as' => 'ruangperkuliahan.deletekelas'
                    ]
                );

                Route::get(
                    '/datakelas/{id}',
                    [
                        'uses' => 'RuangPerkuliahanController@dataKelas',
                        'as' => 'ruangperkuliahan.datakelas'
                    ]
                );
                Route::get(
                    '/getkelas/{id}',
                    [
                        'uses' => 'RuangPerkuliahanController@getJadwalById',
                        'as' => 'ruangperkuliahan.getjadwalbyid'
                    ]
                );
                Route::get(
                    '/jadwalkelas/{id}',
                    [
                        'uses' => 'RuangPerkuliahanController@jadwalKelas',
                        'as' => 'ruangperkuliahan.jadwalkelas'
                    ]
                );
                Route::get(
                    '/generate',
                    [
                        'uses' => 'RuangPerkuliahanController@generateTanggal',
                        'as' => 'ruangperkuliahan.generate'
                    ]
                );
            }
        );

        // hitung aktivitas mahasiswa
        Route::prefix('hitungaktivitaskuliahmahasiswa')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'HitungAktivitasMahasiswaController@data',
                        'as' => 'hitungaktivitaskuliahmahasiswa.data'
                    ]
                );
                Route::get(
                    '/datakrs/{id}',
                    [
                        'uses' => 'HitungAktivitasMahasiswaController@dataKrs',
                        'as' => 'hitungaktivitaskuliahmahasiswa.datakrs'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'HitungAktivitasMahasiswaController@index',
                        'as' => 'hitungaktivitaskuliahmahasiswa.index'
                    ]
                );
                // Route::get(
                //     '/create',
                //     [
                //         'uses' => 'HitungAktivitasMahasiswaController@create',
                //         'as' => 'hitungaktivitaskmahasiswa.create'
                //     ]
                // );
                Route::post(
                    '/store',
                    [
                        'uses' => 'HitungAktivitasMahasiswaController@store',
                        'as' => 'hitungaktivitaskmahasiswa.store'
                    ]
                );
                // Route::get(
                //     '/{id}/edit',
                //     [
                //         'uses' => 'HitungAktivitasMahasiswaController@edit',
                //         'as' => 'hitungaktivitaskmahasiswa.edit'
                //     ]
                // );
                // Route::post(
                //     '/update/{id}',
                //     [
                //         'uses' => 'HitungAktivitasMahasiswaController@update',
                //         'as' => 'hitungaktivitaskmahasiswa.update'
                //     ]
                // );


                // Route::get(
                //     '/{id}/delete',
                //     [
                //         'uses' => 'HitungAktivitasMahasiswaController@destroy',
                //         'as' => 'hitungaktivitaskmahasiswa.destroy'
                //     ]
                // );
            }
        );
          //status mahasiswa
          Route::prefix('aktivitaskuliahmahasiswa')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'AktivitasKuliahMahasiswaController@data',
                        'as' => 'aktivitaskuliahmahasiswa.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'AktivitasKuliahMahasiswaController@index',
                        'as' => 'aktivitaskuliahmahasiswa.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'AktivitasKuliahMahasiswaController@create',
                        'as' => 'aktivitaskuliahmahasiswa.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'AktivitasKuliahMahasiswaController@store',
                        'as' => 'aktivitaskuliahmahasiswa.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'AktivitasKuliahMahasiswaController@edit',
                        'as' => 'aktivitaskuliahmahasiswa.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'AktivitasKuliahMahasiswaController@update',
                        'as' => 'aktivitaskuliahmahasiswa.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'AktivitasKuliahMahasiswaController@destroy',
                        'as' => 'aktivitaskuliahmahasiswa.destroy'
                    ]
                );
            }
        );

          //Aktivitas Mahasiswa
          Route::prefix('aktivitasmahasiswa')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'AktivitasMahasiswaController@data',
                        'as' => 'aktivitasmahasiswa.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'AktivitasMahasiswaController@index',
                        'as' => 'aktivitasmahasiswa.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'AktivitasMahasiswaController@create',
                        'as' => 'aktivitasmahasiswa.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'AktivitasMahasiswaController@store',
                        'as' => 'aktivitasmahasiswa.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'AktivitasMahasiswaController@edit',
                        'as' => 'aktivitasmahasiswa.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'AktivitasMahasiswaController@update',
                        'as' => 'aktivitasmahasiswa.update'
                    ]
                );
                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'AktivitasMahasiswaController@destroy',
                        'as' => 'aktivitasmahasiswa.destroy'
                    ]
                );

                Route::get(
                    '/datapesertaaktif/{id}',
                    [
                        'uses' => 'AktivitasMahasiswaController@dataPesertaAktif',
                        'as' => 'aktivitasmahasiswa.datapesertaaktif'
                    ]
                );

                Route::post(
                    '/storeperanpeserta',
                    [
                        'uses' => 'AktivitasMahasiswaController@addPesertaAktif',
                        'as' => 'aktivitasmahasiswa.storeperanpeserta'
                    ]
                );

                Route::get(
                    '/{id}/deletepeserta',
                    [
                        'uses' => 'AktivitasMahasiswaController@destroyPeserta',
                        'as' => 'aktivitasmahasiswa.destroypeserta'
                    ]
                );

                // dosen pembimbing aktivitas mahasiswa
                Route::get(
                    '/datapembimbing/{id}',
                    [
                        'uses' => 'AktivitasMahasiswaController@dataPembimbingAktivitasMahasiswa',
                        'as' => 'aktivitasmahasiswa.datapembimbingaktivitasmahasiswa'
                    ]
                );

                Route::post(
                    '/storepembimbing',
                    [
                        'uses' => 'AktivitasMahasiswaController@addPembimbingAktivitasMahasiswa',
                        'as' => 'aktivitasmahasiswa.storepembimbingaktivitasmahasiswa'
                    ]
                );

                Route::get(
                    '/{id}/deletepembimbing',
                    [
                        'uses' => 'AktivitasMahasiswaController@destroyPembimbingAktivitasMahasiswa',
                        'as' => 'aktivitasmahasiswa.destroypembimbingaktivitasmahasiswa'
                    ]
                );

                // penguji
                Route::get(
                    '/datapenguji/{id}',
                    [
                        'uses' => 'AktivitasMahasiswaController@dataPengujiAktivitasMahasiswa',
                        'as' => 'aktivitasmahasiswa.datapengujiaktivitasmahasiswa'
                    ]
                );

                Route::post(
                    '/storepenguji',
                    [
                        'uses' => 'AktivitasMahasiswaController@addPengujiAktivitasMahasiswa',
                        'as' => 'aktivitasmahasiswa.storepengujiaktivitasmahasiswa'
                    ]
                );

                Route::get(
                    '/{id}/deletepenguji',
                    [
                        'uses' => 'AktivitasMahasiswaController@destroyPengujiAktivitasMahasiswa',
                        'as' => 'aktivitasmahasiswa.destroypengujiaktivitasmahasiswa'
                    ]
                );

                Route::post(
                    '/cek',
                    [
                        'uses' => 'AktivitasMahasiswaController@cekSubmit',
                        'as' => 'aktivitasmahasiswa.cek'
                    ]
                );
            }
        );



         //jenis Aktivitas
         Route::prefix('jenisaktivitas')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'JenisAktivitasController@data',
                        'as' => 'jenisaktivitas.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'JenisAktivitasController@index',
                        'as' => 'jenisaktivitas.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'JenisAktivitasController@create',
                        'as' => 'jenisaktivitas.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'JenisAktivitasController@store',
                        'as' => 'jenisaktivitas.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'JenisAktivitasController@edit',
                        'as' => 'jenisaktivitas.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'JenisAktivitasController@update',
                        'as' => 'jenisaktivitas.update'
                    ]
                );
                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'JenisAktivitasController@destroy',
                        'as' => 'jenisaktivitas.destroy'
                    ]
                );
        });

        // penggunaan ruang
        Route::prefix('penggunaanruang')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'PenggunaanRuangController@data',
                        'as' => 'penggunaanruang.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PenggunaanRuangController@index',
                        'as' => 'penggunaanruang.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PenggunaanRuangController@create',
                        'as' => 'penggunaanruang.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PenggunaanRuangController@store',
                        'as' => 'penggunaanruang.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PenggunaanRuangController@edit',
                        'as' => 'penggunaanruang.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PenggunaanRuangController@update',
                        'as' => 'penggunaanruang.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PenggunaanRuangController@destroy',
                        'as' => 'penggunaanruang.destroy'
                    ]
                );
        });

          // skala nilai
        Route::prefix('skalanilai')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'SkalaNilaiController@data',
                        'as' => 'skalanilai.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'SkalaNilaiController@index',
                        'as' => 'skalanilai.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'SkalaNilaiController@create',
                        'as' => 'skalanilai.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'SkalaNilaiController@store',
                        'as' => 'skalanilai.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'SkalaNilaiController@edit',
                        'as' => 'skalanilai.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'SkalaNilaiController@update',
                        'as' => 'skalanilai.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'SkalaNilaiController@destroy',
                        'as' => 'skalanilai.destroy'
                    ]
                );
            });

         // Mahasiswa Lulus DO
         Route::prefix('mahasiswalulusdo')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'MahasiswaLulusDOController@data',
                        'as' => 'mahasiswalulusdo.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'MahasiswaLulusDOController@index',
                        'as' => 'mahasiswalulusdo.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'MahasiswaLulusDOController@create',
                        'as' => 'mahasiswalulusdo.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'MahasiswaLulusDOController@store',
                        'as' => 'mahasiswalulusdo.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'MahasiswaLulusDOController@edit',
                        'as' => 'mahasiswalulusdo.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'MahasiswaLulusDOController@update',
                        'as' => 'mahasiswalulusdo.update'
                    ]
                );
                Route::get('/getipk/{id}',[
                    'uses' => 'MahasiswaLulusDOController@getIpk',
                        'as' => 'mahasiswalulusdo.getipk'
                ]);
                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'MahasiswaLulusDOController@destroy',
                        'as' => 'mahasiswalulusdo.destroy'
                    ]
                );
            });

         //Pengaturan Periode Perkuliahan
        Route::prefix('periodeperkuliahan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'PengaturanPeriodePerkuliahanController@data',
                        'as' => 'periodeperkuliahan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'PengaturanPeriodePerkuliahanController@index',
                        'as' => 'periodeperkuliahan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'PengaturanPeriodePerkuliahanController@create',
                        'as' => 'periodeperkuliahan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'PengaturanPeriodePerkuliahanController@store',
                        'as' => 'periodeperkuliahan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'PengaturanPeriodePerkuliahanController@edit',
                        'as' => 'periodeperkuliahan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'PengaturanPeriodePerkuliahanController@update',
                        'as' => 'periodeperkuliahan.update'
                    ]
                );
                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'PengaturanPeriodePerkuliahanController@destroy',
                        'as' => 'periodeperkuliahan.destroy'
                    ]
                );
        });


        Route::prefix('krs')->group(
            function () {
                Route::get(
                    '/add',
                    [
                        'uses' => 'MahasiswaController@addKrsMahasiswa',
                        'as' => 'krs.add'
                    ]
                );
        });

        Route::prefix('nilaiperkuliahan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'NilaiPerkuliahanController@data',
                        'as' => 'nilaiperkuliahan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'NilaiPerkuliahanController@index',
                        'as' => 'nilaiperkuliahan.index'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'NilaiPerkuliahanController@edit',
                        'as' => 'nilaiperkuliahan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'NilaiPerkuliahanController@update',
                        'as' => 'nilaiperkuliahan.update'
                    ]
                );
        });

         //Export Data
         Route::prefix('exportdata')->group(
            function () {
                Route::get(
                    '/mahasiswa',
                    [
                        'uses' => 'ExportDataController@mahasiswa',
                        'as' => 'exportdata.mahasiswa'
                    ]
                );
                Route::post(
                    '/mahasiswastore',
                    [
                        'uses' => 'ExportDataController@mahasiswastore',
                        'as' => 'exportdata.mahasiswa.store'
                    ]
                );

                Route::get(
                    '/nilaitransfer',
                    [
                        'uses' => 'ExportDataController@nilaitransfer',
                        'as' => 'exportdata.nilaitransfer'
                    ]
                );
                Route::post(
                    '/nilaitransferstore',
                    [
                        'uses' => 'ExportDataController@nilaitransferstore',
                        'as' => 'exportdata.nilaitransfer.store'
                    ]
                );

                Route::get(
                    '/penugasandosen',
                    [
                        'uses' => 'ExportDataController@penugasandosen',
                        'as' => 'exportdata.penugasandosen'
                    ]
                );
                Route::post(
                    '/penugasandosenstore',
                    [
                        'uses' => 'ExportDataController@penugasandosenstore',
                        'as' => 'exportdata.penugasandosen.store'
                    ]
                );

                Route::get(
                    '/matakuliah',
                    [
                        'uses' => 'ExportDataController@matakuliah',
                        'as' => 'exportdata.matakuliah'
                    ]
                );
                Route::post(
                    '/matakuliahstore',
                    [
                        'uses' => 'ExportDataController@matakuliahstore',
                        'as' => 'exportdata.matakuliah.store'
                    ]
                );

                Route::get(
                    '/kelasperkuliahan',
                    [
                        'uses' => 'ExportDataController@kelasperkuliahan',
                        'as' => 'exportdata.kelasperkuliahan'
                    ]
                );
                Route::post(
                    '/kelasperkuliahanstore',
                    [
                        'uses' => 'ExportDataController@kelasperkuliahanstore',
                        'as' => 'exportdata.kelasperkuliahan.store'
                    ]
                );

                Route::get(
                    '/krs',
                    [
                        'uses' => 'ExportDataController@krs',
                        'as' => 'exportdata.krs'
                    ]
                );
                Route::post(
                    '/krsstore',
                    [
                        'uses' => 'ExportDataController@krsstore',
                        'as' => 'exportdata.krs.store'
                    ]
                );

                Route::get(
                    '/aktivitaskuliah',
                    [
                        'uses' => 'ExportDataController@aktivitaskuliah',
                        'as' => 'exportdata.aktivitaskuliah'
                    ]
                );
                Route::post(
                    '/aktivitaskuliahstore',
                    [
                        'uses' => 'ExportDataController@aktivitaskuliahstore',
                        'as' => 'exportdata.aktivitaskuliah.store'
                    ]
                );

                Route::get(
                    '/mahasiswalulusdo',
                    [
                        'uses' => 'ExportDataController@mahasiswalulusdo',
                        'as' => 'exportdata.mahasiswalulusdo'
                    ]
                );
                Route::post(
                    '/mahasiswalulusdostore',
                    [
                        'uses' => 'ExportDataController@mahasiswalulusdostore',
                        'as' => 'exportdata.mahasiswalulusdo.store'
                    ]
                );

                Route::get(
                    '/aktivitasmengajardosen',
                    [
                        'uses' => 'ExportDataController@aktivitasmengajardosen',
                        'as' => 'exportdata.aktivitasmengajardosen'
                    ]
                );
                Route::post(
                    '/aktivitasmengajardosenstore',
                    [
                        'uses' => 'ExportDataController@aktivitasmengajardosenstore',
                        'as' => 'exportdata.aktivitasmengajardosen.store'
                    ]
                );

                Route::get(
                    '/transkripnilai',
                    [
                        'uses' => 'ExportDataController@transkripnilai',
                        'as' => 'exportdata.transkripnilai'
                    ]
                );
                Route::post(
                    '/transkripnilaistore',
                    [
                        'uses' => 'ExportDataController@transkripnilaistore',
                        'as' => 'exportdata.transkripnilai.store'
                    ]
                );

            }
        );

        Route::prefix('kategorikegiatan')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KategoriKegiatanController@data',
                        'as' => 'kategorikegiatan.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'KategoriKegiatanController@index',
                        'as' => 'kategorikegiatan.index'
                    ]
                );
                Route::get(
                    '/create',
                    [
                        'uses' => 'KategoriKegiatanController@create',
                        'as' => 'kategorikegiatan.create'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'KategoriKegiatanController@store',
                        'as' => 'kategorikegiatan.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'KategoriKegiatanController@edit',
                        'as' => 'kategorikegiatan.edit'
                    ]
                );
                Route::post(
                    '/update/{id}',
                    [
                        'uses' => 'KategoriKegiatanController@update',
                        'as' => 'kategorikegiatan.update'
                    ]
                );


                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KategoriKegiatanController@destroy',
                        'as' => 'kategorikegiatan.destroy'
                    ]
                );
            }
        );

        // rekapitulasi
        Route::prefix('rekappelaporan')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'RekapitulasiController@index_rekappelaporan',
                        'as' => 'rekappelaporan.index'
                    ]
                );
                Route::post(
                    '/show',
                    [
                        'uses' => 'RekapitulasiController@show_rekappelaporan',
                        'as' => 'rekappelaporan.show'
                    ]
                );
            }
        );

        Route::prefix('jumlahmahasiswa')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'RekapitulasiController@index_jumlahmahasiswa',
                        'as' => 'jumlahmahasiswa.index'
                    ]
                );
                Route::post(
                    '/show',
                    [
                        'uses' => 'RekapitulasiController@show_jumlahmahasiswa',
                        'as' => 'jumlahmahasiswa.show'
                    ]
                );
            }
        );

        Route::prefix('jumlahdosen')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'RekapitulasiController@index_jumlahdosen',
                        'as' => 'jumlahdosen.index'
                    ]
                );
                Route::post(
                    '/show',
                    [
                        'uses' => 'RekapitulasiController@show_jumlahdosen',
                        'as' => 'jumlahdosen.show'
                    ]
                );
            }
        );

        Route::prefix('ipsmahasiswa')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'RekapitulasiController@index_ipsmahasiswa',
                        'as' => 'ipsmahasiswa.index'
                    ]
                );
                Route::post(
                    '/show',
                    [
                        'uses' => 'RekapitulasiController@show_ipsmahasiswa',
                        'as' => 'ipsmahasiswa.show'
                    ]
                );
            }
        );

        Route::get(
            '/krsmahasiswa',
            [
                'uses' => 'RekapitulasiController@krsmahasiswa',
                'as' => 'krsmahasiswa.index'
            ]
        );
        Route::post(
            '/krsmahasiswastore',
            [
                'uses' => 'RekapitulasiController@krsmahasiswastore',
                'as' => 'krsmahasiswa.store'
            ]
        );

        Route::get(
            '/khsmahasiswa',
            [
                'uses' => 'RekapitulasiController@khsmahasiswa',
                'as' => 'khsmahasiswa.index'
            ]
        );
        Route::post(
            '/khsmahasiswastore',
            [
                'uses' => 'RekapitulasiController@khsmahasiswastore',
                'as' => 'khsmahasiswa.store'
            ]
        );
        Route::prefix('laporanstatusmahasiswa')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'RekapitulasiController@index_laporanstatusmahasiswa',
                        'as' => 'laporanstatusmahasiswa.index'
                    ]
                );
                Route::post(
                    '/show',
                    [
                        'uses' => 'RekapitulasiController@show_laporanstatusmahasiswa',
                        'as' => 'laporanstatusmahasiswa.show'
                    ]
                );
            }
        );

        Route::prefix('sksdosenmengajar')->group(
            function () {
                Route::get(
                    '/',
                    [
                        'uses' => 'RekapitulasiController@index_sksdosenmengajar',
                        'as' => 'sksdosenmengajar.index'
                    ]
                );
                Route::post(
                    '/show',
                    [
                        'uses' => 'RekapitulasiController@show_sksdosenmengajar',
                        'as' => 'sksdosenmengajar.show'
                    ]
                );
            }
        );

        //Konversi Kampus Merdeka
        Route::prefix('konversikampusmerdeka')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'KonversiKampusMedekaController@data',
                        'as' => 'konversikampusmerdeka.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'KonversiKampusMedekaController@index',
                        'as' => 'konversikampusmerdeka.index'
                    ]
                );
                Route::post(
                    '/store',
                    [
                        'uses' => 'KonversiKampusMedekaController@storeNilaiKampusMerdeka',
                        'as' => 'konversikampusmerdeka.store'
                    ]
                );
                Route::get(
                    '/{id}/edit',
                    [
                        'uses' => 'KonversiKampusMedekaController@edit',
                        'as' => 'konversikampusmerdeka.edit'
                    ]
                );
                Route::get(
                    '/{id}/delete',
                    [
                        'uses' => 'KonversiKampusMedekaController@destroyNilai',
                        'as' => 'konversikampusmerdeka.destroy'
                    ]
                );

                Route::get(
                    '/datapesertaaktif/{id}',
                    [
                        'uses' => 'KonversiKampusMedekaController@dataPesertaAktif',
                        'as' => 'konversikampusmerdeka.datapesertaaktif'
                    ]
                );
                Route::get(
                    '/datapesertaaktif/detail/{id}/{mahasiswa_id}',
                    [
                        'uses' => 'KonversiKampusMedekaController@detailPesertaAktif',
                        'as' => 'konversikampusmerdeka.detailpesertaaktif'
                    ]
                );
                Route::get(
                    '/datapesertaaktif/detail/data/{id}/{mahasiswa_id}',
                    [
                        'uses' => 'KonversiKampusMedekaController@detailNilaiKampusMerdeka',
                        'as' => 'konversikampusmerdeka.detailnilaikampusMedeka'
                    ]
                );
                Route::post(
                    '/cek',
                    [
                        'uses' => 'KonversiKampusMedekaController@cekSubmit',
                        'as' => 'konversikampusmerdeka.cek'
                    ]
                );
            }
        );

        Route::prefix('transkripnilai')->group(
            function () {
                Route::get(
                    '/data',
                    [
                        'uses' => 'TranskripNilaiController@data',
                        'as' => 'transkripnilai.data'
                    ]
                );
                Route::get(
                    '/',
                    [
                        'uses' => 'TranskripNilaiController@index',
                        'as' => 'transkripnilai.index'
                    ]
                );
                Route::get(
                    '/calculate/{id}',
                    [
                        'uses' => 'TranskripNilaiController@hitungTranskrip',
                        'as' => 'transkripnilai.hitungTranskrip'
                    ]
                );
            });
            Route::prefix('cektranskripmahasiswa')->group(
                function () {
                    Route::get(
                        '/data/{id}',
                        [
                            'uses' => 'TranskripNilaiController@checkTranskripMahasiswaData',
                            'as' => 'cektranskripmahasiswa.data'
                        ]
                    );
                    Route::get(
                        '/mahasiswa/{id}',
                        [
                            'uses' => 'TranskripNilaiController@getMahasiswa',
                            'as' => 'cektranskripmahasiswa.getmahasiswa'
                        ]
                    );
                    Route::get(
                        '/',
                        [
                            'uses' => 'TranskripNilaiController@checkTranskripMahasiswa',
                            'as' => 'cektranskripmahasiswa.index'
                        ]
                    );
                    Route::post(
                        '/simpan',
                        [
                            'uses' => 'TranskripNilaiController@storeTranskripNilai',
                            'as' => 'cektranskripmahasiswa.store'
                        ]
                    );
                });
    });
});
