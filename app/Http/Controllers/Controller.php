<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
	public function responWithData($prmSukses, $prmPesan, $prmStatusKode, $prmData) {
		return response([
			"success" => $prmSukses,
			"message" => $prmPesan,
			"status_code" => $prmStatusKode,
			"data" => $prmData
		]);
	}

	public function responWithoutData($prmSukses, $prmPesan, $prmStatusKode) {
		return response([
			"success" => $prmSukses,
			"message" => $prmPesan,
			"status_code" => $prmStatusKode
		]);
	}
}
