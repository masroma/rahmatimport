<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\MahasiswaHistoryPendidikan;
use App\Models\JenisPendaftaran;
use App\Models\JalurPendaftaran;
use App\Models\JenisSemester;
use App\Models\PembiayaanAwal;
use App\Models\Kampus;
use App\Models\ProgramStudy;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MahasiswaHistoryPendidikanController extends Controller
{
    use ValidatesRequests;
    // pendidikan
    public function datapendidikan($id)
    {
        try {

            $canUpdate = Gate::allows('mahasiswa-edit');
            $canDelete = Gate::allows('mahasiswa-delete');
            $data = MahasiswaHistoryPendidikan::with('Jenispendaftaran','Jalurpendaftaran')->where('mahasiswa_id',$id)->get();
            return DataTables::of($data)

                    ->addColumn('jenispendaftaran',function($data){
                        return $data->Jenispendaftaran->jenis_pendaftaran;
                    })


                    ->addColumn('jalurpendaftaran',function($data){
                        return $data->Jalurpendaftaran->jalur_pendaftaran;
                    })

                    ->addColumn('periodependaftaran',function($data){
                        return $data->Jenissemester->Tahunajaran->tahun_ajaran .'-'.$data->Jenissemester->jenis_semester;
                    })

                    ->addColumn('tanggalmasuk', function($data){
                        return Carbon::parse($data->tanggal_masuk)->isoFormat('D MMMM Y');
                    })

                    ->addColumn('pembiayaanawal',function($data){
                        return $data->Pembiayaanawal->pembiayaan_awal;
                    })

                    ->addColumn('biayamasuk',function($data){
                        return number_format($data->biaya_masuk);
                    })

                    ->addColumn('kampus',function($data){
                        return $data->Kampus->nama_kampus .'-'. $data->Kampus->cabang_kampus;
                    })

                    ->addColumn('programstudy',function($data){
                        return $data->Programstudy->Jurusan->nama_jurusan;
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        $url = route('mahasiswa.editpendidikan',$data->id);

                        if ($canUpdate) {
                            $btn .= '<a class="btn-floating btn-small" href="'.$url.'"><i class="material-icons">edit</i></a>';
                        }

                        if ($canDelete) {
                            $btn .= '<button class="btn-floating purple darken-1 btn-small" type="button" onClick="deleteConfirmPendidikan('.$data->id.')"><i class="material-icons">delete</i></button>';
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

    public function creatependidikan($id)
    {
        $name_page = "riwayat pendidikan ";
        $title = "Riwayat pendidikan";
        $JenisPendaftaran = JenisPendaftaran::all();
        $JalurPendaftaran = JalurPendaftaran::all();
        $PeriodePendaftaran = JenisSemester::all();
        $PembiayaanAwal = PembiayaanAwal::all();
        $Kampus = Kampus::all();
        $ProgramStudy = ProgramStudy::all();
        $data = array(
            'page' => $name_page,
            'title' => $title,
            'id' => $id,
            'jenispendaftaran' => $JenisPendaftaran,
            'jalurpendaftaran' => $JalurPendaftaran,
            'periodependaftaran' => $PeriodePendaftaran,
            'pembiayaanawal' => $PembiayaanAwal,
            'programstudy' => $ProgramStudy,
            'kampus'=>$Kampus
        );
        return view('akademik::mahasiswa.creatependidikan')->with($data);
    }

    public function storeRiwayatpendidikan(Request $request)
    {

        // dd($request->all());
        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nim' => 'required',
                'jenis_pendaftaran' => 'required',
                'jalur_pendaftaran' => 'required',
                'periode_pendaftaran' => 'required',
                'tanggal_masuk'=> 'required',
                'pembiayaan_awal' => 'required',
                'kampus_id' => 'required',
                'programstudy_id' => 'required',
                // 'perminatan_id' => 'required',
            ]);

            $save = new MahasiswaHistoryPendidikan();
            $save->mahasiswa_id = $request->mahasiswa_id ?? NULL;
            $save->nim = $request->nim;
            $save->jenis_pendaftaran = $request->jenis_pendaftaran;
            $save->jalur_pendaftaran = $request->jalur_pendaftaran;
            $save->periode_pendaftaran = $request->periode_pendaftaran;
            $save->tanggal_masuk = $request->tanggal_masuk;
            $save->pembiayaan_awal = $request->pembiayaan_awal;
            $save->biaya_masuk = $request->biaya_masuk;
            $save->kampus_id = $request->kampus_id;
            $save->programstudy_id = $request->programstudy_id;
            $save->perminatan_id = $request->perminatan_id ?? 0;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }

        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('mahasiswa.edit',$request->mahasiswa_id)->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('mahasiswa.edit',$request->mahasiswa_id)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function editPendidikan($id)
    {

        $pendidikan = MahasiswaHistoryPendidikan::findOrFail($id);

        $name_page = "riwayat pendidikan ";
        $title = "Riwayat pendidikan";
        $JenisPendaftaran = JenisPendaftaran::all();
        $JalurPendaftaran = JalurPendaftaran::all();
        $PeriodePendaftaran = JenisSemester::all();
        $PembiayaanAwal = PembiayaanAwal::all();
        $Kampus = Kampus::all();
        $ProgramStudy = ProgramStudy::all();

        $data = array(
            'page' => $name_page,
            'pendidikan' => $pendidikan,
            'title' => $title,
            'jenispendaftaran' => $JenisPendaftaran,
            'jalurpendaftaran' => $JalurPendaftaran,
            'periodependaftaran' => $PeriodePendaftaran,
            'pembiayaanawal' => $PembiayaanAwal,
            'programstudy' => $ProgramStudy,
            'kampus' => $Kampus

        );
        return view('akademik::mahasiswa.editpendidikan')->with($data);
    }

    public function updatependidikan(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $this->validate($request, [
                'nim' => 'required',
                'jenis_pendaftaran' => 'required',
                'jalur_pendaftaran' => 'required',
                'periode_pendaftaran' => 'required',
                'tanggal_masuk'=> 'required',
                'pembiayaan_awal' => 'required',
                'kampus_id' => 'required',
                'programstudy_id' => 'required',
                // 'perminatan_id' => 'required',
            ]);

            $save = MahasiswaHistoryPendidikan::find($id);
            $save->mahasiswa_id = $request->mahasiswa_id ?? NULL;
            $save->nim = $request->nim;
            $save->jenis_pendaftaran = $request->jenis_pendaftaran;
            $save->jalur_pendaftaran = $request->jalur_pendaftaran;
            $save->periode_pendaftaran = $request->periode_pendaftaran;
            $save->tanggal_masuk = $request->tanggal_masuk;
            $save->pembiayaan_awal = $request->pembiayaan_awal;
            $save->biaya_masuk = $request->biaya_masuk;
            $save->kampus_id = $request->kampus_id;
            $save->programstudy_id = $request->programstudy_id;
            $save->perminatan_id = $request->perminatan_id ?? 0;
            $save->save();

            DB::commit();
        } catch (ModelNotFoundException $exception) {
            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }


        if ($save) {
            //redirect dengan pesan sukses
            return redirect()->route('mahasiswa.edit',$request->mahasiswa_id)->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('mahasiswa.edit',$request->mahasiswa_id)->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function destroyPendidikan($id)
    {
        DB::beginTransaction();
        try {
            $delete = MahasiswaHistoryPendidikan::find($id)->delete();
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

}
