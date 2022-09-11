<?php

namespace App\Http\Controllers\API;

use App\City;
use App\Courier;
use App\Helpers\ResponseFormatter;
use App\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class ShippingController extends Controller
{
    public function getProvince() 
    { 
        $provinces = RajaOngkir::provinsi()->all();
        return ResponseFormatter::success($provinces);
    }

    public function getCities($id) 
    { 
        $cities = RajaOngkir::kota()->dariProvinsi($id)->get();

        return ResponseFormatter::success($cities);
    }

    public function getPrice(Request $request) 
    { 
        $harga = RajaOngkir::ongkosKirim([
            'origin' => 290,
            'destination' => $request->destination_id,
            'weight' => $request->weight,
            'courier' => $request->courier
        ])->get();

        return ResponseFormatter::success($harga);
    }

}
