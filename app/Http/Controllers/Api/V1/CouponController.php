<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Coupon\GetCouponCustomerDetailRequest;
use App\Http\Resources\Admin\CouponCustomerResource;
use App\Http\Resources\Admin\CouponCustomerStatusResource;
use App\Http\Resources\Admin\CouponResource;
use App\Http\Resources\Admin\CouponTypeResource;
use App\Http\Resources\Admin\DiscountTypeResource;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Coupon;
use App\Models\CouponCustomer;
use App\Models\CouponCustomerStatus;
use App\Models\CouponType;
use App\Models\DiscountType;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use App\Constants\CouponCustomer as CouponCustomerConst;

class CouponController extends Controller
{
    /**
     * @OA\Get(
     *     path="/coupon/getCoupons",
     *     operationId="getCoupons",
     *     tags={"Coupons"},
     *     summary="Get coupons",
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
     *     @OA\Parameter(
     *          name="discount_type_id",
     *          in="query",
     *          description="Index of discount type",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="coupon_type_id",
     *          in="query",
     *          description="Index of coupon type",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="restaurant_id",
     *          in="query",
     *          description="Index of restaurant",
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
    public function getCoupons(Request $request)
    {
        $limit = $request->get("limit", 10);
        $discount_type_id = $request->get("discount_type_id", null);
        $coupon_type_id = $request->get("coupon_type_id", null);
        $restaurant_id = $request->get("restaurant_id", null);

        $coupon = Coupon::with(['discount_type', 'restaurants', 'coupon_type']);

        if(!empty($discount_type_id)){
            $coupon->where("discount_type_id", $discount_type_id);
        }

        if(!empty($coupon_type_id)){
            $coupon->where("coupon_type_id", $coupon_type_id);
        }

        if(!empty($restaurant_id)){
            $coupon->whereHas("restaurants", function($q) use ($restaurant_id){
                $q->where("restaurant_id", $restaurant_id);
            });
        }

        return new CouponResource($coupon->paginate($limit));
    }

    /**
     * @OA\Get(
     *     path="/coupon/getCoupon",
     *     operationId="getCoupon",
     *     tags={"Coupons"},
     *     summary="Get coupon detail",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index of coupon",
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
    public function getCoupon(Request $request)
    {
        $coupon = Coupon::find($request->id);

        return new CouponResource($coupon ? $coupon->load(['discount_type', 'restaurants', 'coupon_type']) : []);
    }

    /**
     * @OA\Get(
     *     path="/coupon/getCouponsCustomer",
     *     operationId="getCouponsCustomer",
     *     tags={"Coupons"},
     *     summary="Get coupon list of customer",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
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
     *     @OA\Parameter(
     *          name="coupon_id",
     *          in="query",
     *          description="Filter by coupon id",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="status_id",
     *          in="query",
     *          description="Filter by coupon status",
     *          required=false,
     *          example=2,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getCouponsCustomer(Request $request)
    {
        $limit = $request->get("limit", 10);
        $coupon_id = $request->get("coupon_id", null);
        $status_id = $request->get("status_id", null);

        $customer_id = Auth::id();
        $couponCustomer = CouponCustomer::with(['coupon', 'status'])
            ->where("status_id", CouponCustomerConst::STATUS['NOT_USED'])
            ->where("customer_id", $customer_id);

        if(!empty($coupon_id)){
            $couponCustomer = $couponCustomer->where("coupon_id", $coupon_id);
        }

        if(!empty($status_id)){
            $couponCustomer = $couponCustomer->where("status_id", $status_id);
        }

        return new CouponCustomerResource($couponCustomer->paginate($limit));
    }

    /**
     * @OA\Get(
     *     path="/coupon/getCouponCustomerDetail",
     *     operationId="getCouponCustomerDetail",
     *     tags={"Coupons"},
     *     summary="Get detail of coupon customer",
     *     description="",
     *     security={{"bearerAuth":{},"secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index coupon of customer",
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
    public function getCouponCustomerDetail(GetCouponCustomerDetailRequest $request)
    {
        $id = $request->id;
        $customer_id = Auth::id();
        $couponCustomer = CouponCustomer::with(['coupon', 'status'])
            ->where("customer_id", $customer_id)
            ->where("id", $id)
            ->first();

        return new CouponCustomerResource($couponCustomer);
    }

    /**
     * @OA\Get(
     *     path="/coupon/getDiscountTypes",
     *     operationId="getDiscountTypes",
     *     tags={"Coupons"},
     *     summary="Get a list discount types of coupon",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getDiscountTypes()
    {
        return new DiscountTypeResource(DiscountType::all());
    }

    /**
     * @OA\Get(
     *     path="/coupon/getCouponTypes",
     *     operationId="getCouponTypes",
     *     tags={"Coupons"},
     *     summary="Get a list of coupon types",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getCouponTypes()
    {
        return new CouponTypeResource(CouponType::all());
    }

    /**
     * @OA\Get(
     *     path="/coupon/getCouponsCustomerStatuses",
     *     operationId="getCouponsCustomerStatuses",
     *     tags={"Coupons"},
     *     summary="Get a list of states coupon customer",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getCouponsCustomerStatuses()
    {
        return new CouponCustomerStatusResource(CouponCustomerStatus::all());
    }
}
