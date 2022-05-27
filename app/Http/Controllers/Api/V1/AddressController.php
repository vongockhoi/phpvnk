<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Address\StoreAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Http\Resources\Admin\AddressResource;
use App\Models\Address;
use App\Models\District;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AddressController extends Controller
{
    /**
     * @OA\Get(
     *     path="/address/getAddresses",
     *     operationId="getAddresses",
     *     tags={"Address"},
     *     summary="Get addresses",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function index()
    {
        $custormer_id = Auth::id();
        $addresses = Address::with(['province', 'district'])
            ->where("customer_id", $custormer_id)
            ->get();

        foreach ($addresses as $address) {
            $address->is_default = boolval($address->is_default);
        }

        return new AddressResource($addresses);
    }

    /**
     * @OA\Post(
     *    path="/address/storeAddress",
     *     operationId="storeAddress",
     *     tags={"Address"},
     *     summary="Store address",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="province_id",
     *                       type="integer",
     *                       example=1,
     *                       description="Index of province, required field.",
     *                   ),
     *                  @OA\Property(
     *                       property="district_id",
     *                       type="integer",
     *                       example=1,
     *                       description="Index of district, required field.",
     *                   ),
     *                  @OA\Property(
     *                       property="is_default",
     *                       type="boolean",
     *                       example=false,
     *                       description="Is the default address?, can empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="address",
     *                       type="string",
     *                       example="Số 43, đường 43",
     *                       description="Address detail, can empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="name",
     *                       type="string",
     *                       example="Địa chỉ nhà riêng",
     *                       description="Nam of address, can empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="note",
     *                       type="string",
     *                       description="Note of address, can empty.",
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
    public function store(StoreAddressRequest $request)
    {
        $request['customer_id'] = Auth::id();

        //Cap nhat lai isDefault cho khach hang
        if ($request->is_default) {
            $addresses = Address::with(['province', 'district'])
                ->where("customer_id", $request['customer_id'])
                ->where("is_default", 1)
                ->get();
            if (!empty($addresses)) {
                foreach ($addresses as $address) {
                    Address::find($address->id)->update(["is_default" => 0]);
                }
            }
        }

        //
        $request['province_id'] = $request['province_id'] ?? null;
        if (empty($request['province_id'])) {
            $district = District::find($request['district_id']);
            $request['province_id'] = $district ? $district->province_id : null;
        }

        $address = Address::create($request->all());

        return (new AddressResource($address))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/address/getAddress",
     *     operationId="getAddress",
     *     tags={"Address"},
     *     summary="Get address",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index of customer address",
     *          required=true,
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
    public function show(Request $request)
    {
        $address = Address::find($request->id);

        return new AddressResource($address->load(['province', 'district']));
    }

    /**
     * @OA\Put(
     *    path="/address/updateAddress",
     *     operationId="updateAddress",
     *     tags={"Address"},
     *     summary="UpdateAddress",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index of customer address",
     *          required=true,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="province_id",
     *                       type="integer",
     *                       example=1,
     *                       description="Index of province, required field.",
     *                   ),
     *                  @OA\Property(
     *                       property="district_id",
     *                       type="integer",
     *                       example=1,
     *                       description="Index of district, required field.",
     *                   ),
     *                  @OA\Property(
     *                       property="is_default",
     *                       type="boolean",
     *                       example=false,
     *                       description="Is the default address?, can empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="address",
     *                       type="string",
     *                       example="Số 43, đường 43",
     *                       description="Address detail, can empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="name",
     *                       type="string",
     *                       example="Địa chỉ nhà riêng",
     *                       description="Nam of address, can empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="note",
     *                       type="string",
     *                       description="Note of address, can empty.",
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
    public function update(UpdateAddressRequest $request)
    {
        $request['customer_id'] = Auth::id();

        //Cap nhat lai isDefault cho khach hang
        if ($request->is_default) {
            $addresses = Address::where("customer_id", $request['customer_id'])
                ->where("is_default", 1)
                ->get();
            if (!empty($addresses)) {
                foreach ($addresses as $add) {
                    Address::find($add->id)->update(["is_default" => 0]);
                }
            }
        }

        $address = Address::find($request->id);
        $address->update($request->all());

        return (new AddressResource($address))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(
     *    path="/address/removeAddresses",
     *     operationId="removeAddresses",
     *     tags={"Address"},
     *     summary="Remove addresses",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index of customer address",
     *          required=true,
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
    public function destroy(Request $request)
    {
        $address = Address::find($request->id);
        if (!empty($address)) {
            $address->delete();

            return response(null, Response::HTTP_NO_CONTENT);
        }
    }
}
