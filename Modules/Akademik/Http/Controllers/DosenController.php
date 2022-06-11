<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\Dosen;
use App\Models\DosenDetail;
use App\Models\DosenAddress;
use App\Models\DosenKeluarga;
use App\Models\DosenKebutuhanKhusus;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:dosen-view|dosen-create|dosen-edit|dosen-show|dosen-delete', ['only' => ['index','store']]);
         $this->middleware('permission:dosen-view', ['only' => ['index']]);
         $this->middleware('permission:dosen-create', ['only' => ['create','store']]);
         $this->middleware('permission:dosen-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:dosen-show', ['only' => ['show']]);
         $this->middleware('permission:dosen-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            $canShow = Gate::allows('dosen-show');
            $canUpdate = Gate::allows('dosen-edit');
            $canDelete = Gate::allows('dosen-delete');
            $data = Dosen::all();
            return DataTables::of($data)
                    ->addColumn('tanggallahir', function($data){
                        return Carbon::parse($data->tanggal_lahir)->isoFormat('dddd, D MMMM Y');
                    })
                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete, $canShow) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="dosen/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating green darken-1 btn-small" href="dosen/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('dosen-create');
        $name_page = "dosen";
        $title = "Dosen";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title
        );
        return view('akademik::dosen.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $canCreate = Gate::allows('dosen-create');
        $name_page = "dosen";
        $title = "Dosen";
        $province = Province::all();
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate,
            'title' => $title,
            'province' => $province
        );
        return view('akademik::dosen.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'tanggal_lahir' => 'required',
                'tempat_lahir' => 'required',
                'agama'=>'required',
                'nik' => 'required|min:16|max:16'
            ]);

            $save = new Dosen();
            $save->nidn = $request->nidn ?? NULL;
            $save->nama_dosen = $request->nama;
            $save->tempat_lahir = $request->tempat_lahir;
            $save->jenis_kelamin = $request->jenis_kelamin;
            $save->tanggal_lahir = $request->tanggal_lahir ?? NULL;
            $save->agama = $request->agama ?? NULL;
            $save->save();

            $idDosen = $save->id;
            $this->storeDosenDetail($request, $idDosen);
            $this->storeDosenAddress($request, $idDosen);
            $this->storeDosenKebutuhanKhusus($request, $idDosen);
            $this->storeDosenKeluarga($request, $idDosen);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('dosen.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('dosen.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function storeDosenDetail(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = new DosenDetail();
            $save->dosen_id = $idDosen;
            $save->nik = $request->nik;
            $save->nip = $request->nip ?? NULL;
            $save->npwp = $request->npwp ?? NULL;
            $save->telephone = $request->telephone ?? NULL;
            $save->handphone = $request->handphone ?? NULL;
            $save->email = $request->email ?? NULL;
            $save->ikatan_kerja = $request->ikatan_kerja ?? NULL;
            $save->status_pegawai = $request->status_pegawai ?? NULL;
            $save->jenis_pegawai = $request->jenis_pegawai ?? NULL;
            $save->no_sk_cpns = $request->no_sk_cpns ?? NULL;
            $save->tanggal_sk_cpns = $request->tanggal_sk_cpns ?? NULL;
            $save->no_sk_pengangkatan = $request->no_sk_pengangkatan ?? NULL;
            $save->tanggal_sk_pengangkatan = $request->tanggal_sk_pengangkatan ?? NULL;
            $save->lembaga_pengangkatan = $request->embaga_pengangkatan ?? NULL;
            $save->lembaga_pengangkatan = $request->lembaga_pengangkatan ?? NULL;
            $save->pangkat_golongan = $request->pangkat_golongan ?? NULL;
            $save->sumber_lainya = $Request->sumber_lainya ?? NULL;

            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }


    public function storeDosenAddress(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = new DosenAddress();
            $save->dosen_id = $idDosen;
            $save->jalan = $request->jalan ?? NULL;
            $save->province_id = $request->province_id ?? NULL;
            $save->city_id = $request->city_id ?? NULL;
            $save->district_id = $request->district_id ?? NULL;
            $save->village_id = $request->village_id ?? NULL;
            $save->kode_pos = $request->kode_pos ?? NULL;
            $save->rt = $request->rt ?? NULL;
            $save->rw = $request->rw ?? NULL;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function storeDosenKeluarga(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = new DosenKeluarga();
            $save->dosen_id = $idDosen;
            $save->status_pernikahan = $request->status_pernikahan ?? NULL;
            $save->nama_pasangan = $request->nama_pasangan ?? NULL;
            $save->nip_pasangan = $request->nip_pasangan ?? NULL;
            $save->tmt_pasangan = $request->tmt_pasangan ?? NULL;
            $save->pekerjaan = $request->pekerjaan ?? NULL;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function storeDosenKebutuhanKhusus(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = new DosenKebutuhanKhusus();
            $save->dosen_id = $idDosen;
            $save->jenis_kebutuhan_khusus = json_encode($request->get('jenis_kebutuhan_khusus')) ?? NULL;
            $save->handle_kebutuhan_khusus = $request->handle_kebutuhan_khusus ?? NULL;
            $save->handle_bahasa_isyarat = $request->handle_bahasa_isyarat ?? NULL;
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
        return view('akademik::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $dosen = Dosen::with('Detail','Keluarga','KebutuhanKhusus','Address')->findOrFail($id);

        $name_page = "dosen";
        $title = "Dosen";
        $province = Province::all();
        $city = City::where('province_id',$dosen->Address->province_id)->get();
        $district = District::where('regency_id',$dosen->Address->city_id)->get();
        $village = Village::where('district_id',$dosen->Address->district_id)->get();
        $data = array(
            'page' => $name_page,
            'dosen' => $dosen,
            'title' => $title,
            'province' => $province,
            'city' => $city,
            'district' => $district,
            'village' => $village

        );
        return view('akademik::dosen.edit')->with($data);
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
                'tanggal_lahir' => 'required',
                'agama'=>'required',
                //

            ]);

            $update = Dosen::find($id);
            $update->nidn = $request->nidn ?? NULL;
            $update->nama_dosen = $request->nama;
            $update->tempat_lahir = $request->tempat_lahir;
            $update->jenis_kelamin = $request->jenis_kelamin;
            $update->tanggal_lahir = $request->tanggal_lahir ?? NULL;
            $update->agama = $request->agama ?? NULL;
            $update->save();

            $idDosen = $update->id;
            $this->updateDosenDetail($request, $idDosen);
            $this->updateDosenAddress($request, $idDosen);
            $this->updateDosenKebutuhanKhusus($request, $idDosen);
            $this->updateDosenKeluarga($request, $idDosen);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('dosen.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('dosen.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }


    public function updateDosenDetail(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = DosenDetail::where('dosen_id',$idDosen)->first();;
            $save->dosen_id = $idDosen;
            $save->nik = $request->nik;
            $save->nip = $request->nip ?? NULL;
            $save->npwp = $request->npwp ?? NULL;
            $save->telephone = $request->telephone ?? NULL;
            $save->handphone = $request->handphone ?? NULL;
            $save->email = $request->email ?? NULL;
            $save->ikatan_kerja = $request->ikatan_kerja ?? NULL;
            $save->status_pegawai = $request->status_pegawai ?? NULL;
            $save->jenis_pegawai = $request->jenis_pegawai ?? NULL;
            $save->no_sk_cpns = $request->no_sk_cpns ?? NULL;
            $save->tanggal_sk_cpns = $request->tanggal_sk_cpns ?? NULL;
            $save->no_sk_pengangkatan = $request->no_sk_pengangkatan ?? NULL;
            $save->tanggal_sk_pengangkatan = $request->tanggal_sk_pengangkatan ?? NULL;
            $save->lembaga_pengangkatan = $request->embaga_pengangkatan ?? NULL;
            $save->lembaga_pengangkatan = $request->lembaga_pengangkatan ?? NULL;
            $save->pangkat_golongan = $request->pangkat_golongan ?? NULL;
            $save->sumber_lainya = $Request->sumber_lainya ?? NULL;

            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }


    public function updateDosenAddress(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = DosenAddress::where('dosen_id',$idDosen)->first();;
            $save->dosen_id = $idDosen;
            $save->jalan = $request->jalan ?? NULL;
            $save->province_id = $request->province_id ?? NULL;
            $save->city_id = $request->city_id ?? NULL;
            $save->district_id = $request->district_id ?? NULL;
            $save->village_id = $request->village_id ?? NULL;
            $save->kode_pos = $request->kode_pos ?? NULL;
            $save->rt = $request->rt ?? NULL;
            $save->rw = $request->rw ?? NULL;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function updateDosenKeluarga(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = DosenKeluarga::where('dosen_id',$idDosen)->first();;
            $save->dosen_id = $idDosen;
            $save->status_pernikahan = $request->status_pernikahan ?? NULL;
            $save->nama_pasangan = $request->nama_pasangan ?? NULL;
            $save->nip_pasangan = $request->nip_pasangan ?? NULL;
            $save->tmt_pasangan = $request->tmt_pasangan ?? NULL;
            $save->pekerjaan = $request->pekerjaan ?? NULL;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function updateDosenKebutuhanKhusus(Request $request, $idDosen)
    {

        DB::beginTransaction();
        try {
            $save = DosenKebutuhanKhusus::where('dosen_id',$idDosen)->first();
            $save->dosen_id = $idDosen;
            $save->jenis_kebutuhan_khusus = json_encode($request->get('jenis_kebutuhan_khusus')) ?? NULL;
            $save->handle_kebutuhan_khusus = $request->handle_kebutuhan_khusus ?? NULL;
            $save->handle_bahasa_isyarat = $request->handle_bahasa_isyarat ?? NULL;
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
            Dosen::find($id)->delete();


                DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('dosen.index')->with('success', 'Data berhasil dihapus');
    }
}