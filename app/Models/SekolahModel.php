<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SekolahModel extends Model
{
	protected $table = 'tbl_sekolah';
	protected $primaryKey = 'cIdSekolah';
	public $timestamps = false;
	protected $fillable = ['cIdSekolah','cNamaSekolah','cIsAktif'];

}