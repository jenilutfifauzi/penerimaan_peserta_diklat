<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiklatIntelijenTingkatDasar;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    public function deleteAll(Request $request)
    {
        $kode_pelatihan = $request->kode_pelatihan;
        DiklatIntelijenTingkatDasar::whereIn('kode_pelatihan', explode(",", $kode_pelatihan))->delete();
        return back();
    }
}
