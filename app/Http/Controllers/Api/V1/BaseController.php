<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Device as DeviceConst;
use App\Helpers\LoggingHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DeviceResource;
use App\Models\Device;
use App\Models\Versions;
use Illuminate\Http\Request;
use Auth;
use PHPUnit\Exception;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    /**
     * @OA\Get(
     *    path="/base/getDevices",
     *     operationId="getDevices",
     *     tags={"Bases"},
     *     summary="Get devices",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getDevices(Request $request)
    {
        $custormer_id = Auth::id();
        $devices = Device::where("customer_id", $custormer_id)->get();

        return new DeviceResource($devices);
    }

    /**
     * @OA\Post(
     *    path="/base/storeDevice",
     *     operationId="storeDevice",
     *     tags={"Bases"},
     *     summary="storeDevice",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="device_token",
     *                       type="string",
     *                       example="device_token",
     *                       description="Index of province, required field.",
     *                   ),
     *                  @OA\Property(
     *                       property="device_name",
     *                       type="string",
     *                       example="Iphone 3",
     *                       description="Index of province, required field.",
     *                   ),
     *                  @OA\Property(
     *                       property="platform",
     *                       type="integer",
     *                       example="1",
     *                       description="1: android, 2: iso",
     *                   ),
     *               ),
     *            ),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function storeDevice(Request $request)
    {
        try {
            $request['customer_id'] = Auth::id();
            $device = Device::where("device_id", $request->device_id)->first();
            if (!empty($device)) {
                $device->update($request->all());
            } else {
                $device = Device::create($request->all());
            }

            return (new DeviceResource($device))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (Exception $exception) {
            LoggingHelper::logException($exception);
        }
    }

    public function getVersionDetail(): DeviceResource
    {
        $android = Versions::where('platform', DeviceConst::PLATFORM['ANDROID'])->first();
        $ios = Versions::where('platform', DeviceConst::PLATFORM['IOS'])->first();

        $form = new stdClass();
        $form->android = $android->version ?? '1.0';
        $form->ios = $ios->version ?? '1.0';

        return new DeviceResource((array)$form);
    }
}
