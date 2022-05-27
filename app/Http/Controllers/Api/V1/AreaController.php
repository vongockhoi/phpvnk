<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Address\StoreAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Http\Resources\Admin\AddressResource;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Helpers\Convert;

class AreaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/area/getProvinces",
     *     operationId="getProvinces",
     *     tags={"Areas"},
     *     summary="Get province list",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          example=10,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getProvinces(Request $request)
    {
//        $limit = $request->get("limit", 10);
        $provinces = Province::with([])->get();
        foreach ($provinces as $province){
            unset($province->created_at);
            unset($province->updated_at);
            unset($province->deleted_at);
        }
        return new AddressResource($provinces);
    }

    /**
     * @OA\Get(
     *     path="/area/getDistricts",
     *     operationId="getDistricts",
     *     tags={"Areas"},
     *     summary="Get district list",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Parameter(
     *          name="province_id",
     *          in="query",
     *          description="Index province",
     *          required=true,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Limit",
     *          required=false,
     *          example=10,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getDistricts(Request $request)
    {
//        $limit = $request->get("limit", 10);
        $province_id = $request->province_id;
        $districts = District::with([]);
        if(!empty($province_id)){
            $districts = $districts->where("province_id", $province_id);
        }

        $districts = $districts->get();
        foreach ($districts as $district){
            unset($district->created_at);
            unset($district->updated_at);
            unset($district->deleted_at);
        }
        return new AddressResource($districts);
    }
}
