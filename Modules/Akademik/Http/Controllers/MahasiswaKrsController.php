<?php

namespace Modules\Akademik\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Krs;
use App\Models\JenisSemester;
use DataTables;
use Exception;
use Auth;
use Gate;
use DB;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;

class MahasiswaKrsController extends Controller
{
    public function datakrs(Request $request, $id)
    {
        try {
            $tahunajaran = $request->tahunajaran ?? NULL;

            $canUpdate = Gate::allows('mahasiswa-edit');
            $canDelete = Gate::allows('mahasiswa-delete');
            $jenissemesterterbaru = JenisSemester::latest()->first();
            $data = Krs::with('Kelas','MataKuliah','JenisSemester','JenisSemester.TahunAjaran')->where('mahasiswa_id',$id)
            ->when(
                $tahunajaran == NULL,
                function ($q) use ($tahunajaran, $jenissemesterterbaru){
                    return  $q->where('jenissemester_id', $jenissemesterterbaru->id);
                }
            )

            ->when(
                $tahunajaran != NULL,
                function ($q) use ($tahunajaran) {
                    return $q->where('jenissemester_id', $tahunajaran);
                }
            )
            ->get();


            return DataTables::of($data)

                    ->addColumn("namakelas", function($data){
                        return $data->kelas->nama_kelas.$data->kelas->kode;
                    })

                    ->addColumn('action', function ($data) use ($canUpdate, $canDelete) {

                        $btn = '';

                        $url = route('mahasiswa.editpendidikan',$data->id);

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

    public function TotalSks(Request $request, $id)
    {
        try{
            $tahunajaran = $request->tahunajaran ?? NULL;
            $jenissemesterterbaru = JenisSemester::latest()->first();
            $datakrs = Krs::with('Kelas','MataKuliah','JenisSemester','JenisSemester.TahunAjaran')->where('mahasiswa_id',$id)->when(
                $tahunajaran == NULL,
                function ($q) use ($tahunajaran, $jenissemesterterbaru){
                    return  $q->where('jenissemester_id', $jenissemesterterbaru->id);
                }
            )

            ->when(
                $tahunajaran != NULL,
                function ($q) use ($tahunajaran) {
                    return $q->where('jenissemester_id', $tahunajaran);
                }
            )->get();

            $totalsks = 0;
            foreach($datakrs as $dk){
                $totalsks += $dk->matakuliah->bobot_mata_kuliah;
            }

            return response()->json(
                [
                    'status' => true,
                    'data' => $totalsks
                ]
            );
        }catch (Exception $e) {
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
        $JalurMasuk = JalurMasukInternal::all();
        $TypeMahasiswa = TypeMahasiswa::All();
        $JenisPendaftaran = JenisPendaftaran::all();
        $JalurPendaftaran = JalurPendaftaran::all();
        $PeriodePendaftaran = JenisSemester::all();
        $Peminatan = Peminatan::all();
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
            'TypeMahasiswa' => $TypeMahasiswa,
            "JalurMasuk" => $JalurMasuk,
            "Peminatan" => $Peminatan,
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
                'jalurmasukinternal_id' => 'required',
                'typemahasiswa_id' => 'required',
                // 'perminatan_id' => 'required',
            ]);

            $save = new MahasiswaHistoryPendidikan();
            $save->mahasiswa_id = $request->mahasiswa_id ?? NULL;
            $save->nim = $request->nim;
            $save->jalurmasukinternal_id = $request->jalurmasukinternal_id;
            $save->typemahasiswa_id = $request->typemahasiswa_id;
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
        $JalurMasuk = JalurMasukInternal::all();
        $TypeMahasiswa = TypeMahasiswa::All();
        $JenisPendaftaran = JenisPendaftaran::all();
        $JalurPendaftaran = JalurPendaftaran::all();
        $PeriodePendaftaran = JenisSemester::all();
        $PembiayaanAwal = PembiayaanAwal::all();
        $Peminatan = Peminatan::all();
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
            'TypeMahasiswa' => $TypeMahasiswa,
            "JalurMasuk" => $JalurMasuk,
            "Peminatan" => $Peminatan,
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
                'jalurmasukinternal_id' => 'required',
                'typemahasiswa_id' => 'required',
                // 'perminatan_id' => 'required',
            ]);

            $save = MahasiswaHistoryPendidikan::find($id);
            $save->mahasiswa_id = $request->mahasiswa_id ?? NULL;
            $save->nim = $request->nim;
            $save->jenis_pendaftaran = $request->jenis_pendaftaran;
            $save->jalurmasukinternal_id = $request->jalurmasukinternal_id;
            $save->typemahasiswa_id = $request->typemahasiswa_id;
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
