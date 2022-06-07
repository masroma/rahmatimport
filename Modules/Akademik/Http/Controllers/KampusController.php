<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Kampus;
use App\Models\kampus_address;
use App\Models\kampus_akta_pendirian;
use App\Models\kampus_detail;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

class KampusController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    use ValidatesRequests;

    function __construct()
    {
         $this->middleware('permission:kampus-view|kampus-create|kampus-edit|kampus-show|kampus-delete', ['only' => ['index','store']]);
         $this->middleware('permission:kampus-view', ['only' => ['index']]);
         $this->middleware('permission:kampus-create', ['only' => ['create','store']]);
         $this->middleware('permission:kampus-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:kampus-show', ['only' => ['show']]);
         $this->middleware('permission:kampus-delete', ['only' => ['destroy']]);

    }

    public function data()
    {
        try {
            $canShow = Gate::allows('kampus-show');
            $canUpdate = Gate::allows('kampus-edit');
            $canDelete = Gate::allows('kampus-delete');
            $data = Kampus::all();
            return DataTables::of($data)

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete, $canShow) {

                        $btn = '';

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="kampus/' .$data->id. '/edit"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirm('.$data->id.')"><i class="material-icons">delete</i></button>';
                        }

                        if ($canShow) {
                            $btn .= '<a class="btn-floating green darken-1 btn-small" href="kampus/' .$data->id. '/show"><i class="material-icons">remove_red_eye</i></a>';
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
        $canCreate = Gate::allows('kampus-create');
        $name_page = "kampus";
        $data = array(
            'page' => $name_page,
            'canCreate' => $canCreate
        );
        return view('akademik::kampus.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $name_page = "kampus";
        $province = Province::all();

        $data = array(
            'page' => $name_page,
            'province' => $province,

        );

        return view('akademik::kampus.create')->with($data);
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'kode_kampus' => 'required',
                'cabang_kampus' => 'required',
                'email' => 'email',
                'telephone' => 'numeric'
            ]);

            $save = new Kampus();
            $save->nama_kampus = $request->nama_kampus ?? 'universitas paramadina';
            $save->kode_kampus = $request->kode_kampus;
            $save->cabang_kampus = $request->cabang_kampus;
            $save->telephone = $request->telephone ?? null;
            $save->faximile = $request->faximile ?? null;
            $save->email = $request->email ?? null;
            $save->website = $request->website ?? null;
            $save->save();


            $idKampus = $save->id;

            $this->storeAddressKampus($request, $idKampus);
            $this->storeDetailsKampus($request, $idKampus);
            $this->storeAktaKampus($request, $idKampus);

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('kampus.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('kampus.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function storeAddressKampus(Request $request, $idKampus)
    {

        DB::beginTransaction();
        try {
            $save = new kampus_address();
            $save->kampus_id = $idKampus;
            $save->jalan = $request->jalan ?? null;
            $save->province_id = $request->province_id ?? null;
            $save->city_id = $request->city_id ?? null;
            $save->district_id = $request->district_id ?? null;
            $save->village_id = $request->village_id ?? null;
            $save->kode_pos = $request->kode_pos ??  null;
            $save->rt = $request->rt ??  null;
            $save->rw = $request->rw ??  null;
            $save->google_map = $request->google_map ??  null;
            $save->longitude = $request->longitude ??  null;
            $save->latitude = $request->latitude ??  null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function storeDetailsKampus(Request $request, $idKampus)
    {
        DB::beginTransaction();
        try {
            $save = new kampus_detail();
            $save->kampus_id = $idKampus;
            $save->bank = $request->bank ?? null;
            $save->unit_cabang = $request->unit_cabang ?? null;
            $save->no_rekening = $request->no_rekening ?? null;
            $save->mbs = $request->mbs ?? 0;
            $save->luas_tanah_milik = $request->luas_tanah_milik ?? 0;
            $save->luas_tanah_bukan_milik = $request->luas_tanah_bukan_milik ?? 0;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function storeAktaKampus(Request $request, $idKampus)
    {
        DB::beginTransaction();
        try {
            $save = new kampus_akta_pendirian();
            $save->kampus_id = $idKampus;
            $save->no_sk_pendirian = $request->no_sk_pendirian ?? null;
            $save->tanggal_sk_pendirian = $request->tanggal_sk_pendirian ?? null;
            $save->status_kepemilikan = $request->status_kepemilikan ?? null;
            $save->status_perguruan_tinggi = $request->status_perguruan_tinggi ?? null;
            $save->sk_izin_operasional = $request->sk_izin_operasional ?? null;
            $save->tanggal_izin_operasional = $request->tanggal_izin_operasional ??  null;
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

        $kampus = Kampus::with('Address','Detail','Akta', 'Address.Provinsi','Address.Kota','Address.Kecamatan','Address.Kelurahan')->findOrFail($id);

        $name_page = "kampus";
        $data = array(
            'page' => $name_page,
            'kampus' => $kampus
        );
        return view('akademik::kampus.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $kampus = Kampus::with('Address','Detail','Akta')->findOrFail($id);
        $province = Province::all();
        $city = City::all();
        $district = District::all();
        $village = Village::all();

        $name_page = "kampus";
        $data = array(
            'page' => $name_page,
            'kampus' => $kampus,
            'province' => $province,
            'city' => $city,
            'village'=> $village,
            'district' => $district
        );
        return view('akademik::kampus.edit')->with($data);
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
                'kode_kampus' => 'required',
                'cabang_kampus' => 'required',
                'email' => 'email',
                'telephone' => 'numeric'
            ]);

            $update = Kampus::find($id);
            $update->kode_kampus = $request->kode_kampus;
            $update->cabang_kampus = $request->cabang_kampus;
            $update->telephone = $request->telephone ?? null;
            $update->faximile = $request->faximile ?? null;
            $update->email = $request->email ?? null;
            $update->website = $request->website ?? null;
            $update->save();
            $idKampus = $id;
            $this->updateAddressKampus($request, $idKampus);
            $this->updateDetailsKampus($request, $idKampus);
            $this->updateAktaKampus($request, $idKampus);
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


            if ($update) {
                //redirect dengan pesan sukses
                return redirect()->route('kampus.index')->with(['success' => 'Data Berhasil Diubah!']);
            } else {
                //redirect dengan pesan error
                return redirect()->route('kampus.index')->with(['error' => 'Data Gagal Diubah!']);
            }
    }

    public function updateAddressKampus(Request $request, $idKampus)
    {

        DB::beginTransaction();
        try {
            $save = kampus_address::where('kampus_id',$idKampus)->first();
            $save->kampus_id = $idKampus;
            $save->jalan = $request->jalan ?? null;
            $save->province_id = $request->province_id ?? null;
            $save->city_id = $request->city_id ?? null;
            $save->district_id = $request->district_id ?? null;
            $save->village_id = $request->village_id ?? null;
            $save->kode_pos = $request->kode_pos ??  null;
            $save->rt = $request->rt ??  null;
            $save->rw = $request->rw ??  null;
            $save->google_map = $request->google_map ??  null;
            $save->longitude = $request->longitude ??  null;
            $save->latitude = $request->latitude ??  null;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function updateDetailsKampus(Request $request, $idKampus)
    {
        DB::beginTransaction();
        try {
            $save = kampus_detail::where('kampus_id',$idKampus)->first();
            $save->kampus_id = $idKampus;
            $save->bank = $request->bank ?? null;
            $save->unit_cabang = $request->unit_cabang ?? null;
            $save->no_rekening = $request->no_rekening ?? null;
            $save->mbs = $request->mbs ?? 0;
            $save->luas_tanah_milik = $request->luas_tanah_milik ?? 0;
            $save->luas_tanah_bukan_milik = $request->luas_tanah_bukan_milik ?? 0;
            $save->save();
            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->with(['error' => $exception->getMessage()])->withError($exception->getMessage())->withInput();
        }

    }

    public function updateAktaKampus(Request $request, $idKampus)
    {
        DB::beginTransaction();
        try {
            $save = kampus_akta_pendirian::where('kampus_id',$idKampus)->first();
            $save->kampus_id = $idKampus;
            $save->no_sk_pendirian = $request->no_sk_pendirian ?? null;
            $save->tanggal_sk_pendirian = $request->tanggal_sk_pendirian ?? null;
            $save->status_kepemilikan = $request->status_kepemilikan ?? null;
            $save->status_perguruan_tinggi = $request->status_perguruan_tinggi ?? null;
            $save->sk_izin_operasional = $request->sk_izin_operasional ?? null;
            $save->tanggal_izin_operasional = $request->tanggal_izin_operasional ??  null;
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
        Kampus::find($id)->delete();
        kampus_detail::where('kampus_id', $id)->delete();
        kampus_address::where('kampus_id', $id)->delete();
        kampus_akta_pendirian::where('kampus_id', $id)->delete();
        return redirect()->route('kampus.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
