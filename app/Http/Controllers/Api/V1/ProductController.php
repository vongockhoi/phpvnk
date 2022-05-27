<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Globals\Cache as CacheConst;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductCategoryResource;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\ProductStatusResource;
use App\Models\Product;
use App\Constants\Product as ProductConst;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/product/getProducts",
     *     operationId="getProducts",
     *     tags={"Products"},
     *     summary="Get a list of product",
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
     *          name="restaurant_id",
     *          in="query",
     *          description="Filter by restaurant",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="status_id",
     *          in="query",
     *          description="Filter by product status",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="category_id",
     *          in="query",
     *          description="Filter by category",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="price_min",
     *          in="query",
     *          description="Filter by price min",
     *          required=false,
     *          example=1000,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="price_max",
     *          in="query",
     *          description="Filter by price max",
     *          required=false,
     *          example=100000,
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
        $restaurant_id = $request->get("restaurant_id", null);
        $status_id = $request->get("status_id", null);
        $category_id = $request->get("category_id", null);
        $price_min = $request->get("price_min", null);
        $price_max = $request->get("price_max", null);
        $keywork = $request->get("keywork", null);
        $product_collection_sn = $request->get("product_collection_sn", null);

        $products = Product::with(['restaurants', 'category', 'categories', 'product_unit']);
        if (!empty($restaurant_id)) {
            $products = $products->whereHas("restaurants", function ($q) use ($restaurant_id) {
                $q->where("restaurant_id", $restaurant_id);
            });
        }

        if (!empty($status_id)) {
            $products = $products->where("status_id", $status_id);
        }

        if (!empty($request->product_category_id)) {
            $product_category_id = $request->product_category_id;
            $products = $products->whereHas("categories", function($q) use ($product_category_id) {
                $q->where("product_category_id", $product_category_id);
            });
        }
        if (!empty($category_id)) {
            $products = $products->whereHas("categories", function($q) use ($category_id){
                $q->where("product_category_id", $category_id)->orderByDesc("updated_at");
            });
        }

        if (!empty($price_min)) {
            $products = $products->where("price", ">=", $price_min);
        }

        if (!empty($price_max)) {
            $products = $products->where("price", "<=", $price_max);
        }

        if (!empty($keywork)) {
            $products = $products->where("name", "LIKE", "%$keywork%");
        }

        if (!empty($product_collection_sn)) {
            switch ($product_collection_sn) {
                case ProductConst::PRODUCT_COLLECTION['SPECIAL'];
                    $products = $products->whereHas("hash_tags", function ($q) {
                        $q->where("hash_tag_id", 2); #Món ưu đãi
                    })->orderByDesc("updated_at");
                    break;
                case ProductConst::PRODUCT_COLLECTION['BEST_SELLER'];
                    $products = $products->whereHas("hash_tags", function ($q) {
                        $q->where("hash_tag_id", 1); #Món bán chạy
                    })->orderByDesc("updated_at");
                    break;
                default:
            }
        }

        $products = $products->orderByDesc("updated_at");

        return new ProductResource($products->paginate($limit));
    }

    /**
     * @OA\Get(
     *     path="/product/getProduct",
     *     operationId="getProduct",
     *     tags={"Products"},
     *     summary="Get product detail",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index of product",
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
    public function show(Request $request)
    {
        $product = Product::find($request->id);

        return new ProductResource($product ? $product->load(['category', 'status', 'restaurants.status', 'restaurants.restaurantOperatingTimes', 'product_unit', 'categories']) : []);
    }

    /**
     * @OA\Get(
     *     path="/product/getProductStatusList",
     *     operationId="getProductStatusList",
     *     tags={"Products"},
     *     summary="Get a list of product status",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getProductStatusList(Request $request)
    {
        return new ProductStatusResource(ProductStatus::all());
    }

    /**
     * @OA\Get(
     *     path="/product/getProductCategoryList",
     *     operationId="getProductCategoryList",
     *     tags={"Products"},
     *     summary="Get a list of product category",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getProductCategoryList(Request $request)
    {
        if($request->has('restaurant_id')){
            $categories = ProductCategory::cacheFor(now()->addHours(24))->with([
                'products' => function($q){
                    $q->orderByDesc("products.updated_at");
                },
                'products.restaurants' => function($q) use ($request){
                    $q->where("restaurants.id", $request->restaurant_id);
                },
                'products.product_unit',
            ])->whereHas('products.restaurants', function ($query) use ($request) {
                $query->where('restaurants.id', $request->restaurant_id);
            })->orderByDesc("updated_at")->get()->map(function($query) {
                $query->setRelation('products', $query->products->take(3));
                return $query;
            });
        }else{
            $categories = ProductCategory::cacheFor(now()->addHours(24))->with([
                'products' => function($q){
                    $q->orderByDesc("products.updated_at");
                },
                'products.restaurants',
                'products.product_unit',
            ])->orderByDesc("updated_at")->get()->map(function($query) {
                $query->setRelation('products', $query->products->take(3));
                return $query;
            });
        }

        return new ProductCategoryResource($categories);
    }
}
