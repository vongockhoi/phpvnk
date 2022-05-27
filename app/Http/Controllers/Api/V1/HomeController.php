<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Address\StoreAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
use App\Http\Resources\Admin\AddressResource;
use App\Http\Resources\Admin\HomeResource;
use App\Models\Address;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use stdClass;
use Symfony\Component\HttpFoundation\Response;
use App\Constants\Globals\Cache as CacheConst;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/home/getHome",
     *     operationId="getHome",
     *     tags={"Home"},
     *     summary="Get Home",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getHome()
    {
        $key = CacheConst::KEY_NAME['HOME'];
        $timeToLife = CacheConst::TTL;

        return Cache::remember($key, $timeToLife, function() {
            $response = new stdClass();
            $banner = Banner::where("active", 1)
                ->orderbyDesc("updated_at")
                ->get(['id', 'description']);
            $productSpecial = Product::with(['restaurants', 'categories', 'product_unit'])
                ->whereHas("hash_tags", function($q) {
                    $q->where("hash_tag_id", 2); #Món ưu đãi
                })
                ->orderByDesc("updated_at")
                ->limit(10)
                ->get();

            $productBestSeller = Product::with(['restaurants', 'categories', 'product_unit'])
                ->whereHas("hash_tags", function($q) {
                    $q->where("hash_tag_id", 1); #Món bán chạy
                })
                ->orderByDesc("updated_at")
                ->limit(10)
                ->get();

            $response->banner = $banner;
            $response->productSpecial = $productSpecial;
            $response->productBestSeller = $productBestSeller;

            return new HomeResource((array)$response);
        });
    }
}
