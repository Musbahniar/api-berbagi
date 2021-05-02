<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; //untuk class database
use Illuminate\Http\Request; // untuk class mengambil parameter melalui http
use Illuminate\Http\Response;

class SiswaController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index() {
      $data = DB::select("SELECT * FROM tbl_siswa LIMIT 5");
      return $this->responWithData(true, "Data Siswa Ditemukan", 200, $data);
    }

    public function showById($idbiodata) {
      $data = DB::select("SELECT * FROM tbl_siswa WHERE cIdBiodata = ?", [$idbiodata]);

      if($data == null) {
        return $this->responWithoutData(true, "Data siswa tidak ada", 200);
      } else {
        return $this->responWithData(true, "Data siswa ditemukan", 200, $data);
      }
    }

    public function destroy($idbiodata) {
      $data = DB::delete("DELETE FROM tbl_siswa WHERE cIdBioData = ?", [$idbiodata]);

      if ($data >= 1) {
        return $this->responWithoutData(true, "Data siswa BERHASIL dihapus", 200);
      } else {
        return $this->responWithoutData(false, "Data siswa GAGAL dihapus", 200);
      }
    }

    public function update(Request $request, $idbiodata) {
      $input = $request->all();
      $validationRules = [
        "tp"           => 'required|min:9|max:9',
        "namasiswa"    => 'required|string',
        "idgedung"     => 'required|numeric',
      ];

      $validator = \Validator::make($input, $validationRules);

      if($validator->fails()) {
        return $this->responWithoutData(false, $validator->errors(), 400);
      } else {
        $data = DB::update("
          UPDATE tbl_siswa SET
          cNamaLengkap = ?,
          cTahunAjaran = ?,
          cIdGedung = ?
          WHERE cIdBioData = ?
          ",
          [
            $request->input('namasiswa'),
            $request->input('tp'),
            $request->input('idgedung'),
            $idbiodata
          ]
        );

        if($data >= 1) {
          return $this->responWithoutData(false, "Update data siswa BERHASIL", 200); 
        } else {
          return $this->responWithoutData(false, "Update data siswa GAGAL", 400); 
        }
      }
    }

    public function store(Request $request) {
      $input = $request->all();
      $validationRules = [
        "nis"          => 'required|min:12|max:12|string',
        "namasiswa"    => 'required|string',
        "kelas"        => 'required|numeric',
        "tp"           => 'required|min:9|max:9',
        "gedung"       => 'required|numeric',
        "sekolah"      => 'required|string',
        "tk"           => 'required|string',
      ];

      $validator = \Validator::make($input, $validationRules);

      if($validator->fails()) {
        return response([
          "success" => false,
          "message" => $validator->errors(),
          "status_code" => 400, 
        ]);
      } else {
        $data = DB::update("
            INSERT INTO tbl_siswa (cNIS,cNamaLengkap,cIdKelas,cTahunAjaran,cIdGedung,cIdSekolah,cTingkatSekolah,cAlamat)
            VALUES (?,?,?,?,?,?,?,?)",
            [
              $request->input('nis'),
              $request->input('namasiswa'),
              $request->input('kelas'), 
              $request->input('tp'), 
              $request->input('gedung'), 
              $request->input('sekolah'), 
              $request->input('tk'), 
              $request->input('alamat') 
            ]
        );

        if($data >= 1) {
          return $this->responWithoutData(true, "Data siswa BERHASIL ditambah", 200); 
        } else {
          return $this->responWithoutData(false, "Data siswa GAGAL ditambah", 400); 
        }
      }
    }

    public function showByIdCompleted ($idbiodata) {
      $data = DB::select("SELECT 
          siswa.cIdBioData AS ID, siswa.cNIS AS NIS, siswa.cNamaLengkap AS NamaSiswa, siswa.cAlamat AS AlamatSiswa, siswa.cTingkatSekolah AS TingkatSekolah,
          kelas.cNamaKelas AS NamaKelas, sekolah.cNamaSekolah AS AsalSekolah
          FROM tbl_siswa siswa JOIN tbl_kelas kelas
          ON siswa.cIdKelas = kelas.cIdKelas JOIN tbl_sekolah sekolah
          ON sekolah.cIdSekolah = siswa.cIdSekolah 
          ORDER BY RAND() LIMIT 10");


      if($data == null) {
        return $this->responWithoutData(true, "Data siswa tidak ada", 200);
      } else {
        return $this->responWithData(true, "Data siswa ditemukan", 200, $data);
      }
    }
    //
}
