<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MasterController extends Controller
{
    public function getProvinces(): \Illuminate\Http\JsonResponse
    {
        $result = [];

        if (Cache::has('provinces')) {
            $result = Cache::get('provinces');
        } else {
            $provinces = \App\Models\Province::pluck('name', 'id')->toArray();

            $result = [];
            foreach ($provinces as $key => $province) {
                $result[] = [
                    'id' => $key,
                    'name' => $province,
                ];
            }

            Cache::forever('provinces', $result);
        }

        return response()->json($result);
    }

    public function getDistricts($provinceId): \Illuminate\Http\JsonResponse
    {
        $result = [];

        if (Cache::has('districts_' . $provinceId)) {
            $result = Cache::get('districts_' . $provinceId);
        } else {
            $districts = \App\Models\District::where('province_id', $provinceId)->pluck('name', 'id')->toArray();

            foreach ($districts as $key => $district) {
                $result[] = [
                    'id' => $key,
                    'name' => $district,
                ];
            }

            Cache::forever('districts_' . $provinceId, $result);
        }

        return response()->json($result);
    }

    public function getWards($districtId): \Illuminate\Http\JsonResponse
    {
        $result = [];

        if (Cache::has('wards_' . $districtId)) {
            $result = Cache::get('wards_' . $districtId);
        } else {
            $wards = \App\Models\Ward::where('district_id', $districtId)->pluck('name', 'id')->toArray();
            foreach ($wards as $key => $ward) {
                $result[] = [
                    'id' => $key,
                    'name' => $ward,
                ];
            }

            Cache::forever('wards_' . $districtId, $result);
        }

        return response()->json($result);
    }
}
