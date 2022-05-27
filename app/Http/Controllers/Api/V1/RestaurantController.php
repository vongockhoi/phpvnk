<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Restaurant\GetRestaurantDetailRequest;
use App\Http\Resources\Admin\AddressResource;
use App\Http\Resources\Admin\RestaurantResource;
use App\Http\Resources\Admin\RestaurantStatusResource;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Province;
use App\Models\Restaurant;
use App\Models\RestaurantStatus;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestaurantController extends Controller
{
    /**
     * @OA\Get(
     *     path="/restaurant/getRestaurants",
     *     operationId="getRestaurants",
     *     tags={"Restaurants"},
     *     summary="Get a list of restaurant",
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
     *          name="province_id",
     *          in="query",
     *          description="Filter by privince",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="district_id",
     *          in="query",
     *          description="Filter by district",
     *          required=false,
     *          example=19,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="status_id",
     *          in="query",
     *          description="Filter by restaurant status",
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
    public function index(Request $request)
    {
        $limit = $request->get("limit", 10);
        $province_id = $request->get("province_id", null);
        $district_id = $request->get("district_id", null);
        $status_id = $request->get("status_id", null);

        $restaurants = Restaurant::with(['province', 'district', 'status', 'restaurantOperatingTimes']);

        if (!empty($province_id)) {
            $restaurants->where("province_id", $province_id);
        }

        if (!empty($district_id)) {
            $restaurants->where("district_id", $district_id);
        }

        if (!empty($status_id)) {
            $restaurants->where("status_id", $status_id);
        }

        return new RestaurantResource($restaurants->paginate($limit));
    }

    /**
     * @OA\Get(
     *     path="/restaurant/getRestaurantDetail",
     *     operationId="getRestaurant",
     *     tags={"Restaurants"},
     *     summary="Get detail restaurant",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
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
    public function show(GetRestaurantDetailRequest $request)
    {
        $restaurant_id = $request->id;
        $restaurant = Restaurant::cacheFor(now()->addHours(24))->with(['province', 'district', 'status', 'restaurantOperatingTimes'])->find($restaurant_id);

        if (empty($restaurant)) {
            return new RestaurantResource(array());
        }

        $arrCategories = DB::table("product_categories")->orderByDesc("updated_at")->get(['id']);
        foreach ($arrCategories as $category) {
            $category_id = $category->id;
            $_category = ProductCategory::cacheFor(now()->addHours(24))->find($category->id);
            $products = Product::cacheFor(now()->addHours(24))->with(['product_unit'])
                ->whereHas("categories", function($q) use ($category_id) {
                    $q->where("product_category_id", $category_id);
                })
                ->whereHas("restaurants", function($q) use ($restaurant_id) {
                    $q->where("restaurant_id", $restaurant_id);
                })
                ->orderByDesc("updated_at")
                ->limit(5)
                ->get();
            if (count($products) == 0) {
                continue;
            }
            $_category->products = $products;
            $categories[] = $_category;
        }

        //product_seller
        $productBestSeller = Product::cacheFor(now()->addHours(24))->with(['restaurants', 'categories', 'product_unit'])
            ->whereHas("hash_tags", function($q) {
                $q->where("hash_tag_id", 1); #Món bán chạy
            })
            ->whereHas("restaurants", function($q) use ($restaurant_id) {
                $q->where("restaurant_id", $restaurant_id);
            })
            ->orderByDesc("updated_at")
            ->limit(5)
            ->get();

        $restaurant->categories = $categories;
        $restaurant->best_seller = $productBestSeller;

        return new RestaurantResource($restaurant);
    }

    /**
     * @OA\Get(
     *     path="/restaurant/getRestaurantStatusList",
     *     operationId="getRestaurantStatusList",
     *     tags={"Restaurants"},
     *     summary="Get a list of restaurant status",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getRestaurantStatusList(Request $request)
    {
        return new RestaurantStatusResource(RestaurantStatus::all());
    }

    /**
     * @OA\Get(
     *     path="/restaurant/getProvinceList",
     *     operationId="getProvinceList",
     *     tags={"Restaurants"},
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getProvinceList(Request $request)
    {
        $provinces = Restaurant::all()->pluck('province_id')->toArray();
        $provinces = array_unique($provinces);
        $provinces = Province::whereIn("id", $provinces)->get();

        foreach ($provinces as $province) {
            unset($province->created_at);
            unset($province->updated_at);
            unset($province->deleted_at);
        }

        return new AddressResource($provinces);
    }

    public function getRestaurantAll(Request $request)
    {
        $restaurants = DB::table("restaurants")->get(["id", "name"]);

        return new RestaurantResource($restaurants);
    }
}
