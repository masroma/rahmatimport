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
            }
        );

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
                    '/datakurikulummatakuliah',
                    [
                        'uses' => 'KurikulumController@dataKurikulumMatakuliah',
                        'as' => 'kurikulummatakuliah.data'
                    ]
                );

                Route::get(
                    '/datakurikulummatakuliahbelumterdaftar',
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
                        'uses' => 'RuangPerkuliahanController@show',
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
                    '/datakelas/{id}',
                    [
                        'uses' => 'RuangPerkuliahanController@dataKelas',
                        'as' => 'ruangperkuliahan.datakelas'
                    ]
                );
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
            }
        );


    });
});
