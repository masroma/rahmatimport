<html>

<head></head>

<body data-new-gr-c-s-check-loaded="14.1014.0" data-gr-ext-installed="">
    <table width="100%">
        <tbody>
            <tr>
                <td colspan="4">
                    <div id="repHeader" style="width: 100%;">
                        <table width="100%" style="border-bottom-style:double;margin-bottom:10px;">
                            <tbody>
                                <tr>
                                    <td align="left">
                                        <div class="repTitle">
                                            <font size="5"><strong>PANGKALAN DATA PENDIDIKAN TINGGI</strong>
                                            </font>
                                            <br>
                                            <font size="4"><strong>Direktorat Jenderal Pendidikan Tinggi</strong>
                                            </font>
                                            <br><br>
                                            <font size="3"><strong>Universitas Paramadina</strong></font>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td align="center" colspan="4">
                    <strong>NILAI TRANSFER</strong>
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td align="left" width="20%"><strong>Nama Mahasiswa</strong></td>
                <td align="left" width="30%"><strong>:</strong> {{$mahasiswa->nama}}</td>
                <td align="left" width="20%"><strong>NIM</strong></td>
                <td align="left"><strong>:</strong> {{$mahasiswa->nim}}</td>
            </tr>
            <tr>
                <td align="left"><strong>Program Studi</strong></td>
                <td align="left"><strong>:</strong>  {{ $mahasiswa->Riwayatpendidikan->Programstudy->jurusan->nama_jurusan }}</td>
                <td align="left"><strong>Angkatan</strong></td>
                <td align="left"><strong>:</strong> {{date('Y',strtotime($mahasiswa->Riwayatpendidikan->tanggal_masuk))}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="100%" border="1|0" style="border-collapse: collapse;">
        <tbody>
            <tr>
                <th rowspan="2" width="5%">No</th>
                <th colspan="4">Nilai PT Asal</th>
                <th colspan="5">Konversi Nilai PT Baru(diakui)</th>
            </tr>
            <tr>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>SKS</th>
                <th>Nilai Huruf</th>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>SKS</th>
                <th>Nilai Huruf</th>
                <th>Nilai Angka</th>
            </tr>
            @php
                $sks_awal = [];
                $sks_diakui = [];
            @endphp
            @foreach ($data as $item)
                @php
                    array_push($sks_awal,$item->sks_asal);
                    array_push($sks_diakui,$item->mata_kuliah->bobot_mata_kuliah);
                @endphp
                <tr>
                    <td align="right"> 1</td>
                    <td style="text-align:center"> {{$item->kode_mk_asal}}</td>
                    <td> {{$item->matakuliah_asal}}</td>
                    <td style="text-align:center"> {{$item->sks_asal}}</td>
                    <td style="text-align:center"> {{$item->nilai_huruf_asal}}</td>
                    <td style="text-align:center"> {{$item->mata_kuliah->kode_matakuliah}}</td>
                    <td style="text-align:center"> {{$item->mata_kuliah->nama_matakuliah}}</td>
                    <td style="text-align:center"> {{$item->mata_kuliah->bobot_mata_kuliah}}</td>
                    <td style="text-align:center"> {{$item->nilai_huruf_diakui}}</td>
                    <td style="text-align:center"> {{$item->nilai_index_diakui}}</td>
                </tr>
                
            @endforeach
            <tr bgcolor="lightyellow">
                <td colspan="3">Jumlah SKS</td>
                <td style="text-align:center">{{array_sum($sks_awal)}} </td>
                <td colspan="3"></td>
                <td style="text-align:center">{{array_sum($sks_diakui)}} </td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

</body>

</html>
