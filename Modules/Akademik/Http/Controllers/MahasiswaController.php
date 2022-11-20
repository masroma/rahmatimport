<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\AktivitasKuliahMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MahasiswaDetail;
use App\Models\MahasiswaDetailOrangTua;
use App\Models\MahasiswaDetailWali;
use App\Models\MahasiswaDetailKebutuhanKhusus;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Krs;
use App\Models\JenisSemester;
use App\Models\Kewarganegaraan;
use App\Models\KelasPerkuliahan;
use App\Models\PerguruanTinggi;
use App\Models\MataKuliah;
use App\Models\NilaiTransfer;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Providers\NeoFeederProvider;
use Carbon\Carbon;
use Throwable;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:mahasiswa-view|mahasiswa-create|mahasiswa-edit|mahasiswa-show|mahasiswa-delete', ['only' => ['index','store']]);
         $this->middleware('permission:mahasiswa-view', ['only' => ['index']]);
         $this->middleware('permission:mahasiswa-create', ['only' => ['create','store']]);
         $this->middleware('permission:mahasiswa-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:mahasiswa-show', ['only' => ['show']]);
         $this->middleware('permission:mahasiswa-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            $canShow = Gate::allows('mahasiswa-show');
            $canUpdate = Gate::allows('mahasiswa-edit');
            $canDelete = Gate::allows('mahasiswa-delete');
            $data = Mahasiswa::with('Detail','OrangTua','Wali','KebutuhanKhusus')->get();
            return DataTables::of($data)
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete, $canShow) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="mahasiswa/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating green darken-1 btn-small" href="mahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
                        }

                        return $btn;
                    })
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ]
            );
        }


    }

    public function index()
    {
        $canCreate = Gate::allows('mahasiswa-create');
        $name_page = "mahasiswa";
        $title = "Mahasiswa";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::mahasiswa.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $canCreate = Gate::allows('mahasiswa-create');
        $name_page = "mahasiswa";
        $title = "Mahasiswa";
        $kewarganegaraan = Kewarganegaraan::all();
        $province = Province::all();
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'province' => $province,
            'kewarganegaraan' => $kewarganegaraan
        );
        return view('akademik::mahasiswa.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function addKrsMahasiswa(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'matakuliah_id' => 'required',
            ]);

            $getsemesterterbaru  = JenisSemester::latest()->first();
            $matakuliah = KelasPerkuliahan::findOrFail($request->matakuliah_id);

            $save = new Krs();
            $save->jenissemester_id = $request->jenissemester_id ?? $getsemesterterbaru->id;
            $save->mahasiswa_id = $request->mahasiswa_id;
            $save->matakuliah_id = $matakuliah->matakuliah_id;
            $save->kelas_id = $request->matakuliah_id;
            $save->save();


            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'KRS Berhasil Ditambah!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'KRS Gagal Ditambah!']);
        }
    }

    public function store(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nama' => 'required',
                'tempat_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'ibu_kandung' => 'required',
                'tanggal_lahir' => 'required',
                'agama'=>'required',
                //
                'nik' => 'required|min:16|max:16',
                'nisn' => 'required',
                'kewarganegaraan_id' => 'required'
            ]);

            $save = new Mahasiswa();
            $save->nim = $request->nim ?? null;
            $save->nama = $request->nama;
            $save->tempat_lahir = $request->tempat_lahir;
            $save->jenis_kelamin = $request->jenis_kelamin;
            $save->ibu_kandung = $request->ibu_kandung ?? null;
            $save->tanggal_lahir = $request->tanggal_lahir ?? null;
            $save->agama = $request->agama ?? null;
            $save->save();

            $idMahasiswa = $save->id;
            $this->storeMahasiswaDetail($request, $idMahasiswa);
            $this->storeMahasiswaDetailOrangTua($request, $idMahasiswa);
            $this->storeMahasiswaDetailWali($request, $idMahasiswa);
            $this->storeMahasiswaDetailKebutuhanKhusus($request, $idMahasiswa);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('mahasiswa.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('mahasiswa.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function destroyKrs($id)
    {
        DB::beginTransaction();
        try {
            $delete = Krs::find($id)->delete();
                DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function storeMahasiswaDetail(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = new MahasiswaDetail();
            $save->mahasiswa_id = $idMahasiswa;
            $save->kewarganegaraan_id = $request->kewarganegaraan_id ?? null;
            $save->nisn = $request->nisn ?? null;
            $save->email = $request->email ?? null;
            $save->ktp = $request->nik ?? null;
            $save->npwp = $request->npwp ?? null;
            $save->jalan = $request->jalan ??  null;
            $save->telephone = $request->telephone ??  null;
            $save->dusun = $request->dusun ??  null;
            $save->rt = $request->rt ??  null;
            $save->rw = $request->rw ??  null;
            $save->kode_pos = $request->kode_pos ??  null;
            $save->handphone = $request->handphone ??  null;
            $save->penerima_kps = $request->penerima_kps ??  null;
            $save->province_id = $request->province_id ??  null;
            $save->city_id = $request->city_id ??  null;
            $save->district_id = $request->district_id ??  null;
            $save->village_id = $request->village_id ??  null;
            $save->jenis_tinggal = $request->jenis_tinggal ??  null;
            $save->alat_transportasi = $request->alat_transportasi ??  null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function storeMahasiswaDetailOrangTua(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = new MahasiswaDetailOrangTua();
            $save->mahasiswa_id = $idMahasiswa;
            $save->nik_ayah = $request->nik_ayah ?? null;
            $save->nama_ayah = $request->nama_ayah ?? null;
            $save->tanggal_lahir_ayah = $request->tanggal_lahir_ayah ?? null;
            $save->pendidikan_ayah = $request->pendidikan_ayah ?? null;
            $save->pekerjaan_ayah = $request->pekerjaan_ayah ?? null;
            $save->penghasilan_ayah = $request->penghasilan_ayah ??  null;
            $save->nik_ibu = $request->nik_ayah ?? null;
            $save->nama_ibu = $request->nama_ayah ?? null;
            $save->tanggal_lahir_ibu = $request->tanggal_lahir_ibu ?? null;
            $save->pendidikan_ibu = $request->pendidikan_ibu ?? null;
            $save->pekerjaan_ibu = $request->pekerjaan_ibu ?? null;
            $save->penghasilan_ibu = $request->penghasilan_ibu ??  null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function storeMahasiswaDetailWali(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = new MahasiswaDetailWali();
            $save->mahasiswa_id = $idMahasiswa;
            $save->nama_wali = $request->nama_wali ?? null;
            $save->tanggal_lahir_wali = $request->tanggal_lahir_wali ?? null;
            $save->pendidikan_wali = $request->pendidikan_wali ?? null;
            $save->pekerjaan_wali = $request->pekerjaan_wali ?? null;
            $save->penghasilan_wali = $request->penghasilan_wali ??  null;

            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function storeMahasiswaDetailKebutuhanKhusus(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = new MahasiswaDetailKebutuhanKhusus();
            $save->mahasiswa_id = $idMahasiswa;
            $save->kebutuhan_khusus = $request->kebutuhan_khusus ?? null;

            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }



    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        $mahasiswa = Mahasiswa::with(['Detail','Detail.Provinsi','Detail.Kota','Detail.Kecamatan','Detail.Kelurahan','OrangTua', 'Wali','KebutuhanKhusus','Riwayatpendidikan'=>function($e){
            $e->with(['Programstudy'=>function($d){
                $d->with('jurusan');
            }]);
        }])->findOrFail($id);

        $perguruan_tinggi = PerguruanTinggi::all();
        $mata_kuliah = MataKuliah::all();

        $name_page = "mahasiswa";
        $title = "Mahasiswa";
        $data = array(
            'page' => $name_page,
            'mahasiswa' => $mahasiswa,
            'perguruan_tinggi'=>$perguruan_tinggi,
            'title' => $title,
            'mata_kuliah'=>$mata_kuliah
        );
        return view('akademik::mahasiswa.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */

    public function edit($id)
    {
        $mahasiswa = Mahasiswa::with('Detail','OrangTua', 'Wali','KebutuhanKhusus')->findOrFail($id);
        // $datakrs = Krs::with('Kelas','MataKuliah','JenisSemester','JenisSemester.TahunAjaran')->where('mahasiswa_id',$id)->get();
        $datakrs = Krs::with('Kelas','MataKuliah','JenisSemester','JenisSemester.tahun_ajarantest')->where('mahasiswa_id',$id)->get();
        $jenissemester = JenisSemester::all();
        $totalsks = 0;
        foreach($datakrs as $dk){
            $totalsks += $dk->matakuliah->bobot_mata_kuliah;
        }

        $datakelas = KelasPerkuliahan::with("Programstudy","Matakuliah")->get();

        $name_page = "mahasiswa";
        $title = "Mahasiswa";
        $kewarganegaraan = Kewarganegaraan::all();
        $province = Province::all();
        $city = City::where('province_id',$mahasiswa->Detail->province_id)->get();
        $district = District::where('regency_id',$mahasiswa->Detail->city_id)->get();
        $village = Village::where('district_id',$mahasiswa->Detail->district_id)->get();
        $data = array(
            'page' => $name_page,
            'mahasiswa' => $mahasiswa,
            'title' => $title,
            'province' => $province,
            'city' => $city,
            'village'=> $village,
            'district' => $district,
            'kewarganegaraan' => $kewarganegaraan,
            "totalsks" => $totalsks,
            "jenissemester" => $jenissemester,
            "datakelas" => $datakelas
        );
        return view('akademik::mahasiswa.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nama' => 'required',
                'tempat_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'ibu_kandung' => 'required',
                'tanggal_lahir' => 'required',
                'agama'=>'required',
                //
                'nik' => 'required|min:16|max:16',
                'nisn' => 'required',
                'kewarganegaraan_id' => 'required'
            ]);

            $update = mahasiswa::find($id);
            $update->nim = $request->nim ?? null;
            $update->nama = $request->nama;
            $update->tempat_lahir = $request->tempat_lahir;
            $update->jenis_kelamin = $request->jenis_kelamin;
            $update->ibu_kandung = $request->ibu_kandung ?? null;
            $update->tanggal_lahir = $request->tanggal_lahir ?? null;
            $update->agama = $request->agama ?? null;
            $update->save();

            $idMahasiswa = $update->id;
            $this->updateMahasiswaDetail($request, $idMahasiswa);
            $this->updateMahasiswaDetailOrangTua($request, $idMahasiswa);
            $this->updateMahasiswaDetailWali($request, $idMahasiswa);
            $this->updateMahasiswaDetailKebutuhanKhusus($request, $idMahasiswa);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('mahasiswa.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('mahasiswa.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    public function updateMahasiswaDetail(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = MahasiswaDetail::where('mahasiswa_id', $idMahasiswa)->first();
            $save->mahasiswa_id = $idMahasiswa;
            $save->kewarganegaraan_id = $request->kewarganegaraan_id ?? null;
            $save->nisn = $request->nisn ?? null;
            $save->email = $request->email ?? null;
            $save->ktp = $request->nik ?? null;
            $save->npwp = $request->npwp ?? null;
            $save->jalan = $request->jalan ??  null;
            $save->telephone = $request->telephone ??  null;
            $save->dusun = $request->dusun ??  null;
            $save->rt = $request->rt ??  null;
            $save->rw = $request->rw ??  null;
            $save->kode_pos = $request->kode_pos ??  null;
            $save->handphone = $request->handphone ??  null;
            $save->penerima_kps = $request->penerima_kps ??  null;
            $save->province_id = $request->province_id ??  null;
            $save->city_id = $request->city_id ??  null;
            $save->district_id = $request->district_id ??  null;
            $save->village_id = $request->village_id ??  null;
            $save->jenis_tinggal = $request->jenis_tinggal ??  null;
            $save->alat_transportasi = $request->alat_transportasi ??  null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function updateMahasiswaDetailOrangTua(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = MahasiswaDetailOrangTua::where('mahasiswa_id', $idMahasiswa)->first();
            $save->mahasiswa_id = $idMahasiswa;
            $save->nik_ayah = $request->nik_ayah ?? null;
            $save->nama_ayah = $request->nama_ayah ?? null;
            $save->tanggal_lahir_ayah = $request->tanggal_lahir_ayah ?? null;
            $save->pendidikan_ayah = $request->pendidikan_ayah ?? null;
            $save->pekerjaan_ayah = $request->pekerjaan_ayah ?? null;
            $save->penghasilan_ayah = $request->penghasilan_ayah ??  null;
            $save->nik_ibu = $request->nik_ayah ?? null;
            $save->nama_ibu = $request->nama_ibu ?? null;
            $save->tanggal_lahir_ibu = $request->tanggal_lahir_ibu ?? null;
            $save->pendidikan_ibu = $request->pendidikan_ibu ?? null;
            $save->pekerjaan_ibu = $request->pekerjaan_ibu ?? null;
            $save->penghasilan_ibu = $request->penghasilan_ibu ??  null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function updateMahasiswaDetailWali(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = MahasiswaDetailWali::where('mahasiswa_id', $idMahasiswa);
            $save->mahasiswa_id = $idMahasiswa;
            $save->nama_wali = $request->nama_wali ?? null;
            $save->tanggal_lahir_wali = $request->tanggal_lahir_wali ?? null;
            $save->pendidikan_wali = $request->pendidikan_wali ?? null;
            $save->pekerjaan_wali = $request->pekerjaan_wali ?? null;
            $save->penghasilan_wali = $request->penghasilan_wali ??  null;

            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function updateMahasiswaDetailKebutuhanKhusus(Request $request, $idMahasiswa)
    {

        DB::beginTransaction();
        try {
            $save = MahasiswaDetailKebutuhanKhusus::where('mahasiswa_id', $idMahasiswa)->first();
            $save->mahasiswa_id = $idMahasiswa;
            $save->kebutuhan_khusus = $request->kebutuhan_khusus ?? null;

            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Mahasiswa::find($id)->delete();
            MahasiswaDetail::where('mahasiswa_id', $id)->delete();
            MahasiswaDetailOrangTua::where('mahasiswa_id', $id)->delete();
            MahasiswaDetailWali::where('mahasiswa_id', $id)->delete();
            MahasiswaDetailKebutuhanKhusus::where('mahasiswa_id', $id)->delete();
            MahasiswaHistoryPendidikan::where('mahasiswa_id',$id)->delete();

                DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Data berhasil dihapus');
    }

    public function dataTrash()
    {
        try {

            $data = Mahasiswa::onlyTrashed()->get();
            return DataTables::of($data)
            ->addColumn('action', function ($data)  {

                $btn = '';
                    $btn .= '<a class="btn-floating btn-small" href=" '.$data->id. '/restore"><i class="material-icons">autorenew</i></a>';

                return $btn;
            })
                    ->addIndexColumn()
                    ->make(true);

        } catch (Exception $e) {
            DB::commit();
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage()
                ]
            );
        }
    }

    public function trash()
    {

        $name_page = "mahasiswa";
        $title = "Mahasiswa";
        $data = array(
            'page' => $name_page,
            'title' => $title
        );
        return view('akademik::mahasiswa.trash')->with($data);
    }

    public function restore($id)
    {
        try {
            $data = Mahasiswa::onlyTrashed()->where('id',$id);
            $data->restore();
            $data = MahasiswaDetail::onlyTrashed()->where('mahasiswa_id',$id);
            $data->restore();
            $data = MahasiswaDetailKebutuhanKhusus::onlyTrashed()->where('mahasiswa_id',$id);
            $data->restore();
            $data = MahasiswaDetailOrangTua::onlyTrashed()->where('mahasiswa_id',$id);
            $data->restore();
            $data = MahasiswaDetailWali::onlyTrashed()->where('mahasiswa_id',$id);
            $data->restore();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

        if ($data) {
            //redirect dengan pesan sukses
            return redirect()->route('mahasiswa.index')->with(['success' => 'Data Berhasil Dikembalikan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('mahasiswa.index')->with(['error' => 'Data Gagal Dikembalikan!']);
        }
    }
    public function getAkm($id)
    {
        $data = AktivitasKuliahMahasiswa::with(['Semester','Status'])->join('calculate_ips_ipk',function($join){
            $join->on('calculate_ips_ipk.mahasiswa_id','aktivitas_kuliah_mahasiswas.mahasiswa_id');
            $join->on('calculate_ips_ipk.semester_id','aktivitas_kuliah_mahasiswas.semester_id');
        })->where('aktivitas_kuliah_mahasiswas.mahasiswa_id',$id)->get();
        // dd($data);
            return DataTables::of($data)
                ->addColumn('semester', function($data){
                    return $data->Semester->Tahunajaran->tahun_ajaran .'-'. $data->Semester->jenis_semester;
                })
                ->addColumn('status', function($data){
                    return $data->Status->status_mahasiswa;
                })
                ->addIndexColumn()
                ->make(true);
    }
    public function getTransrip($id)
    {
        $data = DB::select("SELECT d.kode_matakuliah, d.nama_matakuliah, d.bobot_mata_kuliah,a.nilai_angka,a.nilai_huruf,c.nilai_index,d.bobot_mata_kuliah*c.nilai_index nindex
        FROM nilai_perkuliahans a
        JOIN kelas_perkuliahans b ON a.kelas_id = b.id
        JOIN skala_nilais c ON c.programstudy_id = b.programstudy_id AND a.nilai_huruf = c.nilai_huruf
        JOIN mata_kuliahs d ON d.id = b.matakuliah_id
        ");
        return DataTables::of($data)
                ->rawColumns(['colors','action','checkbox'])
                ->addIndexColumn()
                ->make(true);

    }
    public function getTransfer($id)
    {
        $data = NilaiTransfer::with(['mata_kuliah'])->where('mahasiswa_id',$id)->get();
        $canShow = Gate::allows('mahasiswa-show');
        $canUpdate = Gate::allows('mahasiswa-edit');
        $canDelete = Gate::allows('mahasiswa-delete');
        return DataTables::of($data)
        ->addColumn('kode_mk_diakui', function($data){
            return $data->mata_kuliah->kode_matakuliah;
        })
        ->addColumn('matakuliah_diakui', function($data){
            return $data->mata_kuliah->nama_matakuliah;
        })
        ->addColumn('sks_diakui', function($data){
            return $data->mata_kuliah->bobot_mata_kuliah;
        })
        ->addColumn('action', function ($data) use ($canUpdate, $canDelete, $canShow) {

            $btn = '';

            if ($canDelete) {
                $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
            }

            if ($canShow) {
                $btn .= '<a class="btn-floating green darken-1 btn-small" href="mahasiswa/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
            }

            return $btn;
        })
        ->rawColumns(['colors','action','checkbox'])
        ->addIndexColumn()
        ->make(true);
    }
    public function nilaiTransferStore()
    {
        DB::beginTransaction();
        try {
            $nilaiTransfer = new NilaiTransfer();
            $params = array_filter(request()->all(),function($key) use ($nilaiTransfer){
                return in_array($key,$nilaiTransfer->fillable)!==false;
            },ARRAY_FILTER_USE_KEY);
            $save = NilaiTransfer::create($params);
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with('success', $exception->getMessage());
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
    public function deleteNilaiTranfer($id)
    {
        DB::beginTransaction();
        try {
            $delete = NilaiTransfer::find($id)->delete();
                DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

        if ($delete) {
            //redirect dengan pesan sukses
            return redirect()->back()->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            //redirect dengan pesan error
            return redirect()->back()->with(['error' => 'Data Gagal Dihapus!']);
        }
    }

    public function printNilaiTransfer($id)
    {
        $data = NilaiTransfer::with(['mata_kuliah'])->where('mahasiswa_id',$id)->get();
        $mahasiswa = Mahasiswa::with(['Detail','Detail.Provinsi','Detail.Kota','Detail.Kecamatan','Detail.Kelurahan','OrangTua', 'Wali','KebutuhanKhusus','Riwayatpendidikan'=>function($e){
            $e->with(['Programstudy'=>function($d){
                $d->with('jurusan');
            }]);
        }])->findOrFail($id);
        return view('akademik::mahasiswa.print-nilai-transfer',compact('data','mahasiswa'));
    }

    public function syncMasiswaData(Request $request) {
        try{
            $mahasiswa = Mahasiswa::find($request->id);
            $neoFeeder = new NeoFeederProvider();
            if(!$mahasiswa) {
                throw new Exception("Invalid mahasiswa id");
            }

            $record_body = [];

            if(!$mahasiswa->neo_feeder_mahasiswa_id) {
                $record_body['nama_mahasiswa'] = $mahasiswa->nama;
                $record_body['jenis_kelamin'] = $mahasiswa->jenis_kelamin == 'laki-laki' ? 'L' : 'P';
                $record_body['nama_ibu_kandung'] = $mahasiswa->ibu_kandung;
                $record_body['tanggal_lahir'] = date($mahasiswa->tanggal_lahir. 'Y/m/d');
                $record_body['id_agama'] = $neoFeeder->getAgamaId($mahasiswa->agama);
                $record_body['nik'] = $mahasiswa->mahasiswa_detail->ktp;
                $record_body['nisn'] = $mahasiswa->mahasiswa_detail->nisn;
                $record_body['kewarganegaraan'] = 'Indonesia';
                $record_body['jalan'] = $mahasiswa->mahasiswa_detail->jalan;
                $record_body['dusun'] = $mahasiswa->mahasiswa_detail->dusun;
                $record_body['rt'] = $mahasiswa->mahasiswa_detail->rt;
                $record_body['rw'] = $mahasiswa->mahasiswa_detail->rw;
                $record_body['kelurahan'] = $mahasiswa->mahasiswa_detail->village->name;
                $record_body['kode_pos'] = $mahasiswa->mahasiswa_detail->kode_pos;
            }



            $neoFeeder->sendRequestToNewFeeder('InsertBiodataMahasiswa', [
                'record' => [
                    "nama_mahasiswa" => "A'gung Hapsari",
                    "jenis_kelamin" => "L",
                    "tempat_lahir" => "Bojong Sari II",
                    "tanggal_lahir" => "1999/07/29",
                    "id_agama" => 97,
                    "nik" => "1233333333333333",
                    "nisn" => "123",
                    "kewarganegaraan" => "IT",
                    "jalan" => "Jagakarsa",
                    "dusun" => "Jagakarsa",
                    "rt" => "2",
                    "rw" => "5",
                    "kelurahan" => "Jagakarsa",
                    "kode_pos" => "66666",
                    "id_wilayah" => "016300  ",
                    "id_jenis_tinggal" => "3",
                    "id_alat_transportasi" => "5",
                    "telepon" => "81219982331",
                    "handphone" => "81219982331",
                    "email" => "jorginho@gmail.com",
                    "penerima_kps" => "Ya",
                    "nomor_kps" => "12",
                    "nik_ayah" => "2222222222222222",
                    "nama_ayah" => "A'gung Father",
                    "tanggal_lahir_ayah" => "1970/08/01",
                    "id_pendidikan_ayah" => "6",
                    "id_pekerjaan_ayah" => 3,
                    "id_penghasilan_ayah" => 14,
                    "nik_ibu" => "1111111111111111",
                    "nama_ibu_kandung" => "A'gung Mother",
                    "tanggal_lahir_ibu" => "1976/04/13",
                    "id_pendidikan_ibu" => "5",
                    "id_pekerjaan_ibu" => 8,
                    "id_penghasilan_ibu" => 13,
                    "npwp" => "43223",
                    "nama_wali" => "Jorginho Wali",
                    "tanggal_lahir_wali" => "2021/08/19",
                    "id_pendidikan_wali" => "6",
                    "id_pekerjaan_wali" => 6,
                    "id_penghasilan_wali" => 15,
                    "id_kebutuhan_khusus_mahasiswa" => 0,
                    "id_kebutuhan_khusus_ayah" => 0,
                    "id_kebutuhan_khusus_ibu" => 0
                ]
            ]);
        }catch(Exception $exception){
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

}
