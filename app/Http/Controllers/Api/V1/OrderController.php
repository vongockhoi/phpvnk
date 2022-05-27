<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Order as OrderConst;
use App\Helpers\ConvertHelper;
use App\Helpers\ConvertV2Helper;
use App\Helpers\LoggingHelper;
use App\Helpers\RequestHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\AddToCartRequest;
use App\Http\Requests\Api\Order\CheckOutCartRequest;
use App\Http\Requests\Api\Order\GetOrdersRequest;
use App\Http\Resources\Admin\OrderResource;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\CouponCustomer;
use App\Models\Membership;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Setting;
use App\Models\UserBooking;
use Gate;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use stdClass;
use App\Constants\CouponCustomer as CouponCustomerConst;

class OrderController extends Controller
{
    /**
     * @OA\Post(
     *     path="/order/addToCart",
     *     operationId="addToCart",
     *     tags={"Orders"},
     *     summary="Add product into cart",
     *     description="",
     *     security={{"bearerAuth":{},"secretCode":{}}},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *               mediaType="application/json",
     *    		     @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                       property="product_list",
     *                       type="array",
     *                       @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                              property="product_id",
     *                              type="integer",
     *                              example=1,
     *                              description="Index of product, field required.",
     *                          ),
     *                          @OA\Property(
     *                              property="quantity",
     *                              type="integer",
     *                              example=2,
     *                              description="Quantity of product, field required.",
     *                          ),
     *                          @OA\Property(
     *                              property="note",
     *                              type="string",
     *                              example="Note: bo nhieu ot",
     *                              description="Note for product, field my can empty",
     *                          ),
     *                       ),
     *                       description="Index of product_list, required field.",
     *                   ),
     *
     *                  @OA\Property(
     *                       property="address_id",
     *                       type="integer",
     *                       example=1,
     *                       description="Index of address, field may be empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="coupon_customer_id",
     *                       type="integer",
     *                       example=1,
     *                       description="Index of coupon_customer, field may be empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="restaurant_id",
     *                       type="integer",
     *                       example=1,
     *                       description="Index of coupon_customer, field may be empty.",
     *                   ),
     *                  @OA\Property(
     *                       property="isDelivery",
     *                       type="boolean",
     *                       example="false",
     *                       description="false: not ship, true: ship, field may be empty.",
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

    public function addToCart(AddToCartRequest $request)
    {
        try {
            $customer_id = Auth::id();
            $membership_id = Auth::user()->membership_id;
            $product_id = $request->product_id;
            $quantity = $request->quantity;
            $note = $request->note;
            $coupon_customer_id = $request->coupon_customer_id;
            $address = $request->address_id;
            $typeAction = $request->typeAction;
            $restaurant_id = $request->restaurant_id;
            $isDelivery = intval($request->is_delivery);

            //Check coupon
            if (!empty($coupon_customer_id)) {
                $coupon_customer = CouponCustomer::find($coupon_customer_id);
                $dateNow = Carbon::now()->toDateString();
                $start_date = Carbon::parse($coupon_customer->coupon->start_date)->toDateString();
                if (empty($coupon_customer)) {
                    return ResponseHelper::failed("Coupon không tồn tại.", 401);
                }
                if ($dateNow < $start_date) {
                    return ResponseHelper::failed("Coupon chưa tới ngày sử dụng.", 401);
                }
                if ($coupon_customer->status_id != CouponCustomerConst::STATUS['NOT_USED']) {
                    return ResponseHelper::failed("Coupon không đủ điều kiện áp dụng.", 401);
                }
            }

            //Check cart, them cart detail
            $cart = Cart::where("customer_id", $customer_id)->first();
            if (empty($cart)) {
                $add = Address::where("customer_id", $customer_id)->where("is_default", 1)->first();
                //Addtocart lan dau
                $cart = Cart::create([
                    'customer_id' => $customer_id,
                    'is_delivery' => 1,
                    'address_id'  => $add ? $add->id : null,
                ]);
            }
            $cart_id = $cart->id;

            //Product
            if (!empty($product_id)) {
                //Check gio hang rong khong the remove product
                //                if ($typeAction == 2) {
                //                    $count = CartDetail::where("product_id", $product_id)->where("cart_id", $cart_id)->get()->count();
                //                    if ($count == 0) {
                //                        return ResponseHelper::failed("Sản phẩm này không có trong giỏ hàng.", 401);
                //                    }
                //                }

                //Xu ly add hoac remove product
                //$typeAction ( 1: add, 2: remove, null: replace )
                if ($request->has('restaurant_id')) {
                    if ($cart->restaurant_id != $restaurant_id) {
                        CartDetail::where("cart_id", $cart_id)->delete();
                    }
                }
                $cartDetail = CartDetail::where("product_id", $product_id)->where("cart_id", $cart_id)->first();
                if ($typeAction == 2 && !empty($cartDetail)) {
                    $cartDetail->delete();

                    #Xoa het SP trong cart_detail thi cung xoa res trong cart
                    $existProduct = CartDetail::where("cart_id", $cart_id)->first();
                    if (empty($existProduct)) {
                        Cart::find($cart_id)->update([
                            "restaurant_id" => null,
                        ]);
                    }
                } else {
                    $quantity_product = Product::find($product_id)->quantity;
                    if ($quantity_product <= 0) {
                        return ResponseHelper::failed("Món tạm hết quý khách ơi 😢.");
                    }

                    if (!empty($cartDetail)) {
                        if ($typeAction == 1) {
                            $quantity += $cartDetail->quantity;
                        }

                        $cartDetail->update([
                            'quantity'                   => $quantity,
                            'note'                       => $note,
                            'free_one_product_parent_id' => null,
                        ]);
                    } else {
                        CartDetail::create([
                            'cart_id'                    => $cart_id,
                            'quantity'                   => $quantity,
                            'note'                       => $note,
                            'product_id'                 => $product_id,
                            'free_one_product_parent_id' => null,
                        ]);
                    }
                }
            }

            //Coupon
            if ($request->has('coupon_customer_id')) {
                $cart->update(['coupon_customer_id' => $coupon_customer_id]);
            }

            //Address
            if ($request->has('address_id')) {
                $cart->update(['address_id' => $address]);
            }

            //Restaurant
            if ($request->has('restaurant_id')) {
                $cart->update(['restaurant_id' => $restaurant_id]);
            }

            //is_delivery
            if ($request->has('is_delivery')) {
                $cart->update(['is_delivery' => $isDelivery]);
            }

            /*****************************/
            $cart = Cart::find($cart_id);
            $coupon_customer = $cart->coupon_customer;
            if (!empty($coupon_customer)) {
                if ($coupon_customer->status_id != CouponCustomerConst::STATUS['NOT_USED']) {
                    $cart->update([
                        'coupon_customer_id' => null,
                    ]);
                    $cart = Cart::find($cart_id);
                }
            }
            //Tinh tien
            $this->_calculate($cart, $membership_id);

            //Response mobile
            $cart = Cart::with(['cartCartDetails.product.product_unit', 'customer.membership', 'address', 'coupon_customer', 'restaurant'])->where("customer_id", $customer_id)->first();
            if (!empty($cart)) {
                $cart->price_ship_text = numberToWord((int)$cart->price_ship);
                $cart->price_original_text = numberToWord((int)$cart->price_original);
                $cart->total_price_text = numberToWord((int)$cart->total_price);
                $cart->is_delivery = boolval($cart->is_delivery);

                return new OrderResource($cart);
            }

            return new OrderResource(null);
        } catch (\Exception $exception) {
            LoggingHelper::logException($exception);
        }
    }

    private function _calculate($cart, $membership_id)
    {
        $cart_id = $cart->id;
        $products = CartDetail::where("cart_id", $cart_id)->get();
        $priceOriginal = 0; //Tong gia
        $pricePaid = 0; //Gia user thanh toan
        foreach ($products as $product) {
            $pro = Product::find($product->product_id);

            //Gia discount
            if (!empty($pro->price_discount)) {
                $price = $pro->price_discount;
            } else {
                $price = $pro->price;
            }
            $priceOriginal += ($price * $product['quantity']);
        }
        $pricePaid = $priceOriginal;

        //Áp dụng coupon
        $discountCoupon = 0;
        $coupon = null;
        $coupon_customer_id = $cart->coupon_customer_id;
        if (!empty($coupon_customer_id)) {
            $coupon = CouponCustomer::find($coupon_customer_id)->coupon;
            $discount_type_id = $coupon->discount_type_id;
            switch ($discount_type_id) {
                case 1:
                    $discountCoupon = ($pricePaid * $coupon->value) / 100;
                    break;
                case 2:
                    $discountCoupon = $coupon->value;
                    break;
                default:
                    $discountCoupon = 0;
            }
        }
        $pricePaid = $pricePaid - $discountCoupon;

        //Áp dụng cho membership
        $discountMembership = 0;
        $membership = null;
        if (!empty($membership_id)) {
            $membership = Membership::find($membership_id);
            $discountValue = $membership->discount_value;
            $discountMembership = ($pricePaid * $discountValue) / 100;
        }
        $pricePaid = $pricePaid - $discountMembership;

        $price_ship = 0;
        //Phi ship
        if ($cart->is_delivery) {
        }

        //Update lai cart
        Cart::find($cart_id)->update([
            "price_ship"          => $price_ship,
            "price_original"      => $priceOriginal,
            "discount_coupon"     => $discountCoupon,
            "discount_membership" => $discountMembership,
            "total_price"         => $pricePaid,
        ]);
    }

    public function addToCartV2(AddToCartRequest $request)
    {
        $customer_id = Auth::id();
        $membership_id = Auth::user()->membership_id;
        $typeAction = $request->typeAction;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $note = $request->note;
        $coupon_customer_id = $request->coupon_customer_id;
        $address = $request->address_id;
        $typeAction = $request->typeAction;
        $restaurant_id = $request->restaurant_id;
        $isDelivery = intval($request->is_delivery);

        //Check coupon
        if (!empty($coupon_customer_id)) {
            $coupon_customer = CouponCustomer::find($coupon_customer_id);
            $dateNow = Carbon::now()->toDateString();
            $start_date = Carbon::parse($coupon_customer->coupon->start_date)->toDateString();
            $end_date = Carbon::parse($coupon_customer->coupon->end_date)->toDateString();
            if (empty($coupon_customer)) {
                return ResponseHelper::failed("Coupon không tồn tại", 401);
            }
            if ($coupon_customer->status_id == 1) {
                return ResponseHelper::failed("Coupon đã sử dụng", 401);
            }
            if ($dateNow < $start_date) {
                return ResponseHelper::failed("Coupon chưa tới ngày sử dụng", 401);
            }
            if ($dateNow > $end_date) {
                return ResponseHelper::failed("Coupon đã hết hạn sử dụng", 401);
            }
        }

        //Check cart, them cart detail
        $cart = Cart::where("customer_id", $customer_id)->first();
        if (empty($cart)) {
            $add = Address::where("customer_id", $customer_id)->where("is_default", 1)->first();
            //Addtocart lan dau
            $cart = Cart::create([
                'customer_id' => $customer_id,
                'is_delivery' => 1,
                'address_id'  => $add ? $add->id : null,
            ]);
        }
        $cart_id = $cart->id;

        //Product
        if (!empty($product_id)) {
            //Check gio hang rong khong the remove product
            if ($typeAction == 2) {
                $count = CartDetail::where("product_id", $product_id)->where("cart_id", $cart_id)->get()->count();
                if ($count == 0) {
                    return ResponseHelper::failed("Sản phẩm này không có trong giỏ hàng.", 401);
                }
            }

            //Xu ly add hoac remove product
            //$typeAction ( 1: add, 2: remove, null: replace )
            $cartDetail = CartDetail::where("product_id", $product_id)->where("cart_id", $cart_id)->where("restaurant_id", $restaurant_id)->first();
            if ($typeAction == 2) {
                $cartDetail->delete();
            } else {
                if (!empty($cartDetail)) {
                    if ($typeAction == 1) {
                        $quantity += $cartDetail->quantity;
                    }

                    $cartDetail->update([
                        'quantity'                   => $quantity,
                        'note'                       => $note,
                        'free_one_product_parent_id' => null,
                        'restaurant_id'              => $restaurant_id,
                    ]);
                } else {
                    CartDetail::create([
                        'cart_id'       => $cart_id,
                        'quantity'      => $quantity,
                        'note'          => $note,
                        'product_id'    => $product_id,
                        'restaurant_id' => $restaurant_id,
                    ]);
                }
            }
        }

        //Coupon
        if ($request->has('coupon_customer_id')) {
            $cart->update(['coupon_customer_id' => $coupon_customer_id]);
        }

        //Address
        if ($request->has('address_id')) {
            $cart->update(['address_id' => $address]);
        }

        //Restaurant
        //        if ($request->has('restaurant_id')) {
        //            $cart->update(['restaurant_id' => $restaurant_id]);
        //        }

        //is_delivery
        if ($request->has('is_delivery')) {
            $cart->update(['is_delivery' => $isDelivery]);
        }

        /*****************************/
        $cart = Cart::find($cart_id);
        //Tinh tien
        $products = CartDetail::where("cart_id", $cart_id)->get();
        $priceOriginal = 0; //Tong gia
        $pricePaid = 0; //Gia user thanh toan
        foreach ($products as $product) {
            $pro = Product::find($product->product_id);

            //Gia discount
            if (!empty($pro->price_discount)) {
                $price = $pro->price_discount;
            } else {
                $price = $pro->price;
            }
            $priceOriginal += ($price * $product['quantity']);
        }
        $pricePaid = $priceOriginal;

        //Áp dụng coupon
        $discountCoupon = 0;
        $coupon = null;
        $coupon_customer_id = $cart->coupon_customer_id;
        if (!empty($coupon_customer_id)) {
            $coupon = CouponCustomer::find($coupon_customer_id)->coupon;
            $discount_type_id = $coupon->discount_type_id;
            switch ($discount_type_id) {
                case 1:
                    $discountCoupon = ($pricePaid * $coupon->value) / 100;
                    break;
                case 2:
                    $discountCoupon = $coupon->value;
                    break;
                default:
                    $discountCoupon = 0;
            }
        }
        $pricePaid = $pricePaid - $discountCoupon;

        //Áp dụng cho membership
        $discountMembership = 0;
        $membership = null;
        if (!empty($membership_id)) {
            $membership = Membership::find($membership_id);
            $discountValue = $membership->discount_value;
            $discountMembership = ($pricePaid * $discountValue) / 100;
        }
        $pricePaid = $pricePaid - $discountMembership;

        $price_ship = 0;
        //Phi ship
        if ($cart->is_delivery) {
        }

        //Update lai cart
        Cart::find($cart_id)->update([
            "price_ship"          => $price_ship,
            "price_original"      => $priceOriginal,
            "discount_coupon"     => $discountCoupon,
            "discount_membership" => $discountMembership,
            "total_price"         => $pricePaid,
        ]);

        //Response mobile
        $cart = Cart::with(['customer.membership', 'address', 'coupon_customer', 'restaurant'])->where("customer_id", $customer_id)->first();
        if (!empty($cart)) {
            $cart->price_ship_text = numberToWord((int)$cart->price_ship);
            $cart->price_original_text = numberToWord((int)$cart->price_original);
            $cart->total_price_text = numberToWord((int)$cart->total_price);
            $cart->is_delivery = boolval($cart->is_delivery);

            $restaurantList = $cart->cartCartDetails->pluck("restaurant_id")->toArray();
            $restaurantList = array_unique($restaurantList);
            $restaurants = array();
            foreach ($restaurantList as $restaurant_id) {
                $restaurant = Restaurant::with(["cartDetail.product"])->select(["id", "name"])->find($restaurant_id);
                array_push($restaurants, $restaurant);
            }
            $cart->restaurants = $restaurants;

            return new OrderResource($cart);
        }

        return new OrderResource(null);
    }

    /**
     * @OA\Get(
     *     path="/order/getCartDetail",
     *     operationId="getCartDetail",
     *     tags={"Orders"},
     *     summary="Get detail of cart",
     *     description="",
     *     security={{"bearerAuth":{},"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getCartDetail()
    {
        $customer_id = Auth::id();
        $membership_id = Auth::user()->membership_id;

        //Response mobile
        $cart = Cart::with(['cartCartDetails.product.product_unit', 'customer.membership', 'address', 'coupon_customer.coupon', 'restaurant'])->where("customer_id", $customer_id)->first();
        if (!empty($cart)) {
            $coupon_customer = $cart->coupon_customer;
            if (!empty($coupon_customer)) {
                if ($coupon_customer->status_id != CouponCustomerConst::STATUS['NOT_USED']) {
                    $cart->update([
                        'coupon_customer_id' => null,
                    ]);
                    $cart = Cart::with(['cartCartDetails.product.product_unit', 'customer.membership', 'address', 'coupon_customer', 'restaurant'])->where("customer_id", $customer_id)->first();
                    $this->_calculate($cart, $membership_id);
                }
            }

            #
            $cart->price_ship_text = numberToWord((int)$cart->price_ship);
            $cart->price_original_text = numberToWord((int)$cart->price_original);
            $cart->total_price_text = numberToWord((int)$cart->total_price);
            $cart->is_delivery = boolval($cart->is_delivery);

            return new OrderResource($cart);
        } else {
            return null;
        }

    }

    public function getCartDetailV2()
    {
        $customer_id = Auth::id();

        //Response mobile
        $cart = Cart::with(['customer.membership', 'address', 'coupon_customer', 'restaurant'])->where("customer_id", $customer_id)->first();
        if (!empty($cart)) {
            $cart->price_ship_text = numberToWord((int)$cart->price_ship);
            $cart->price_original_text = numberToWord((int)$cart->price_original);
            $cart->total_price_text = numberToWord((int)$cart->total_price);
            $cart->is_delivery = boolval($cart->is_delivery);

            $restaurantList = $cart->cartCartDetails->pluck("restaurant_id")->toArray();
            $restaurantList = array_unique($restaurantList);
            $restaurants = array();
            foreach ($restaurantList as $restaurant_id) {
                $restaurant = Restaurant::with(["cartDetail.product"])->select(["id", "name"])->find($restaurant_id);
                array_push($restaurants, $restaurant);
            }
            $cart->restaurants = $restaurants;

            return new OrderResource($cart);
        }

        return new OrderResource(null);

    }

    /**
     * @OA\Post(
     *     path="/order/checkOutCart",
     *     operationId="checkOutCart",
     *     tags={"Orders"},
     *     summary="Check out cart",
     *     description="",
     *     security={{"bearerAuth":{},"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function checkOutCart(CheckOutCartRequest $request)
    {
        $customer_id = Auth::id();
        $validated = $request->validated();
        $payment_method = $validated['payment_method'] ?? null;
        $momo_token = $validated['momo_token'] ?? null; //Token from momo to app

        $cart = Cart::where("customer_id", $customer_id)->first();
        if (!empty($cart)) {
            $cartDetails = CartDetail::with("product")->where("cart_id", $cart->id)->get();
            if (!empty($cartDetails)) {
                DB::beginTransaction();
                try {
                    #check payment_method
                    if ($payment_method != OrderConst::PAYMENT_METHOD['ON_DELIVERY']) {
                        return $this->_paymentProcessing($payment_method, $momo_token, $cart);
                    }

                    #Them du lieu
                    $order = Order::create([
                        'code'                => $this->_generateUniqueCodeOrder(),
                        'total_price'         => $cart->total_price,
                        'is_prepay'           => 0,
                        'customer_id'         => $cart->customer_id,
                        'address_id'          => $cart->address_id ?? null,
                        'status_id'           => 1, //Cho xac nhan
                        'reservation_id'      => null,
                        'coupon_customer_id'  => $cart->coupon_customer_id,
                        'restaurant_id'       => $cart->restaurant_id,
                        'is_delivery'         => $cart->is_delivery,
                        'price_original'      => $cart->price_original,
                        'discount_coupon'     => $cart->discount_coupon,
                        'discount_membership' => $cart->discount_membership,
                    ]);
                    foreach ($cartDetails as $cartDetail) {
                        #check quantity
                        $quantity_product = Product::find($cartDetail->product_id)->quantity;
                        if ($quantity_product <= 0) {
                            return ResponseHelper::failed("Món tạm hết quý khách ơi 😢.");
                        }

                        OrderDetail::create([
                            'quantity'   => $cartDetail->quantity,
                            'note'       => $cartDetail->note,
                            'order_id'   => $order->id,
                            'product_id' => $cartDetail->product_id,
                        ]);

                        //Cap nhat so luong ton
                        //                        $product = Product::find($cartDetail->product_id);
                        //                        $quantityInventory = $product->quantity - $cartDetail->quantity;
                        //                        if ($quantityInventory >= 0) {
                        //                            $product->update(['quantity' => $quantityInventory]);
                        //                        } else {
                        //                            if ($product->quantity == 0) {
                        //                                $message = "Sản phẩm {$product->name} đã hết hàng";
                        //                            } else {
                        //                                $message = "Sản phẩm {$product->name} chỉ còn số lượng là {$product->quantity}";
                        //                            }
                        //                            throw new HttpResponseException(ResponseHelper::failed($message, 401));
                        //                        }

                        //Xoa cartdetail
                        $cartDetail->delete();
                    }

                    #Thay doi trang thai coupon neu co
                    if (!empty($cart->coupon_customer_id)) {
                        CouponCustomer::find($cart->coupon_customer_id)->update([
                            'status_id' => CouponCustomerConst::STATUS['USED'],
                        ]);
                    }

                    #Xoa cart
                    CartDetail::where("cart_id", $cart->id)->delete();
                    $cart->delete();

                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    LoggingHelper::logException($exception);
                }

            }

            return (new OrderResource($order))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        return new OrderResource(null);
    }

    private function _paymentProcessing($payment_method, $momo_token, $cart)
    {
        switch ($payment_method) {
            case OrderConst::PAYMENT_METHOD['MOMO']:
            {
                $apiEndpoint = config('momo.apiEndpoint');
                $publicKey = config('momo.publicKey');

                $inputs['partnerCode'] = config('momo.partnerCode');
                $inputs['customerNumber'] = $cart->customer ? $cart->customer->phone : null;
                $inputs['partnerRefId'] = $cart->id;
                $inputs['appData'] = $momo_token; //Token nhận được từ app MoMo
                $inputs['amount'] = 5000;//////////////////////////////////hard code //////////////////
                //                $inputs['amount'] = intval($cart->total_price);
                $inputs['hash'] = $this->_createHashString($inputs['amount'], $inputs['partnerCode'], $inputs['partnerRefId'], $publicKey);
                $inputs['description'] = "Thanh toan cho don hang id {$cart->id} qua MoMo";
                $inputs['version'] = 2; //Version momo
                $inputs['payType'] = 3; //Giá trị là 3
                $response = RequestHelper::requestExternalApi($inputs, $apiEndpoint, 'POST', OrderConst::PROVIDER['MOMO']);
                //                return $response;
                break;
            }
            default:
                throw new Exception('No payment method found!');
        }
    }

    private function _createHashString($amount, $partnerCode, $partnerRefId, $publicKey)
    {
        $momoOrderForm = new stdClass();
        $momoOrderForm->amount = $amount;
        $momoOrderForm->partnerCode = $partnerCode;
        $momoOrderForm->partnerRefId = $partnerRefId;
        $json = ConvertV2Helper::toJson($momoOrderForm);
        $rsa = ConvertV2Helper::encryptRSA($json, $publicKey);

        return $rsa;
    }

    private function _generateUniqueCodeOrder()
    {
        $code = generateUniqueCode();

        if (Order::where('code', $code)->exists()) {
            $this->_generateUniqueCodeOrder();
        }

        return $code;
    }

    /**
     * @OA\Get(
     *     path="/order/getOrders",
     *     operationId="getOrders",
     *     tags={"Orders"},
     *     summary="Get a list order of customer",
     *     description="",
     *     security={{"bearerAuth":{},"secretCode":{}}},
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
     *          name="status_id",
     *          in="query",
     *          description="Filter by order status",
     *          required=false,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          description="Filter by sort",
     *          required=false,
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="enum", enum={"desc", "asc"}),
     *              example={"desc"}
     *          )
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getOrders(GetOrdersRequest $request)
    {
        $customer_id = Auth::id();
        $limit = $request->get("limit", 10);
        $status_id = $request->get("status_id", null);
        $sort = $request->get("sort", "desc");

        $orders = Order::with(['address', 'restaurant'])->where("customer_id", $customer_id);

        if (!empty($status_id)) {
            $orders = $orders->whereIn("status_id", $status_id);
        }

        $orders->orderBy("id", $sort);

        return new OrderResource($orders->paginate($limit));
    }

    /**
     * @OA\Get(
     *     path="/order/getOrderDetail",
     *     operationId="getOrderDetail",
     *     tags={"Orders"},
     *     summary="Get a list of order status",
     *     description="",
     *     security={{"bearerAuth":{},"secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index of order",
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
    public function getOrderDetail(Request $request)
    {
        $customer_id = Auth::id();
        $order = Order::with(["status", "coupon_customer", "orderOrderDetails.product.categories", "orderOrderDetails.product.product_unit", "address", 'restaurant', 'rating'])
            ->where("id", $request->id)->where("customer_id", $customer_id)->first();

        return new OrderResource($order);
    }

    /**
     * @OA\Get(
     *     path="/order/getOrderStatuses",
     *     operationId="getOrderStatuses",
     *     tags={"Orders"},
     *     summary="Get a list of order status",
     *     description="",
     *     security={{"bearerAuth":{},"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getOrderStatuses()
    {
        $orderStatus = OrderStatus::all();

        return new OrderResource($orderStatus);
    }

    public function cancelOrder(Request $request)
    {
        $customer_id = Auth::id();
        $order = Order::where("id", $request->order_id)->where("customer_id", $customer_id)->first();
        if (empty($order)) {
            return ResponseHelper::failed("Đơn hàng không tồn tại.", 401);
        }

        if (!in_array($order->status_id, [1])) {
            return ResponseHelper::failed("Đơn hàng không thể hủy.", 401);
        }

        $order->update(['status_id' => 6]);

        return new OrderResource($order);
    }
}
