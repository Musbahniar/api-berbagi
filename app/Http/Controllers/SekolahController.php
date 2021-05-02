<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; //untuk class database
use Illuminate\Http\Request;
use App\Models\SekolahModel; 

class SekolahController extends Controller
{
    //

	public function index () {
		$data = SekolahModel::where('cIsAktif', 'Aktif')->orderBy('cNamaSekolah')->take(5)->get();
		return $this->responWithData(true, "Data Sekolah Ditemukan", 200, $data);
	}

	public function showById ($idSekolah) {
		$data = ModelSekolah::where('cIdSekolah', $idSekolah)->where('cIsAktif', 'Aktif')->first();

		return $this->responWithData(
			true, $data != null ? "Data Sekolah DiTemukan" : "Data Sekolah Tidak DiTemukan" , 200, $data
		);
	}

	public function destroy ($idSekolah) {
		$data = SekolahModel::where('cIdSekolah', $idSekolah)->delete();
		return response([
			"success" => $data >= 1 ? true : false,
			"message" => $data >= 1 ? "Data Sekolah Berhasil DiHapus" : "Data Sekolah Gagal DiHapus",
			"status_code" => 200, 
		]);
	}

	public function update (Request $request, $idSekolah) {
		$input = $request->all();
		$validationRules = [
			"namasekolah"   => 'required|string',
			"status"        => 'required|in:Aktif,NonAktif',
		];

		$validator = \Validator::make($input, $validationRules);

		if($validator->fails()) {
			return $this->responWithoutData(false, $validator->errors(), 400);
		} else {
			$data = SekolahModel::where('cIdSekolah', $idSekolah)
			->update([
				'cNamaSekolah' => $request->input('namasekolah'),
				'cIsAktif' => $request->input('status')
			]);

			return $this->responWithoutData(
				$data >= 1 ? true : false, $data >= 1 ? "Data Sekolah Berhasil DiUpdate" : "Data Sekolah Gagal DiUpdate", 200
			);
		}
	}


	public function store (Request $request) {
		$input = $request->all();
		$validationRules = [
			"idsekolah"     => 'required|numeric',
			"namasekolah"   => 'required|string',
			"status"        => 'required|in:Aktif,NonAktif',
		];

		$validator = \Validator::make($input, $validationRules);

		if($validator->fails()) {
			return $this->responWithoutData(false, $validator->errors(), 400);
		} else {
			$data = SekolahModel::create([
				'cIdSekolah' =>  $request->input('idsekolah'),
				'cNamaSekolah' =>  $request->input('namasekolah'),
				'cIsAktif' =>  $request->input('status')
			]);

   		return $this->responWithoutData(true, "Data sekolah BERHASIL ditambah", 200);
		}
	}

}
