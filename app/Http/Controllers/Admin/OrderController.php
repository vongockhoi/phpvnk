<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateAmountRequest;
use App\Http\Requests\MassDestroyOrderRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderCustomRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Address;
use App\Models\CouponCustomer;
use App\Models\Customer;
use App\Models\Membership;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('order_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());
        $restaurants = Restaurant::pluck('name', 'id')->prepend('Chọn nhà hàng', '');
        $order_status = OrderStatus::pluck('name', 'id')->prepend('Chọn trạng thái', '');
        $from_date = $request->from_date ?? '';
        $to_date = $request->to_date ?? '';
        $orders = Order::with(['customer', 'address', 'status', 'reservation', 'coupon_customer', 'restaurant']);

        if ($user->isAdmin) {
            $orders->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
        }

        if (!empty($request->restaurant_id)) {
            $orders = $orders->where("restaurant_id", $request->restaurant_id);
        }

        if (!empty($request->order_status_id)) {
            $orders = $orders->where("status_id", $request->order_status_id);
        }

        if (!empty($request->is_delivery)) {
            $orders = $orders->where("is_delivery", $request->is_delivery == 1 ? 1 : 0);
        }

        if (!empty($request->from_date)) {
            $orders = $orders->whereDate("created_at", '>=', $request->from_date);
        }
        if (!empty($request->to_date)) {
            $orders = $orders->whereDate("created_at", '<=', $request->to_date);
        }

        $orders = $orders->get();

        return view('admin.orders.index', compact('orders', 'order_status', 'restaurants','from_date','to_date'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $customers = Customer::pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $addresses = Address::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = OrderStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coupon_customers = CouponCustomer::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if ($user->isAdmin) {
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        return view('admin.orders.create', compact('customers', 'addresses', 'statuses', 'coupon_customers', 'restaurants'));
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->all());

        return redirect()->route('admin.orders.index');
    }

    public function edit(Order $order)
    {
        abort_if(Gate::denies('order_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $customers = Customer::pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $addresses = Address::pluck('address', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = OrderStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coupon_customers = CouponCustomer::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if ($user->isAdmin) {
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $order->load('customer', 'address', 'status', 'reservation', 'coupon_customer', 'coupon_customer.coupon', 'restaurant', 'orderOrderDetails', 'orderOrderDetails.product', 'orderOrderDetails.product.product_unit');

        return view('admin.orders.edit_custom', compact('customers', 'addresses', 'statuses', 'coupon_customers', 'order', 'restaurants'));
    }

    public function calculateAmount(CalculateAmountRequest $request)
    {
        $params = $request->all();
        $order = Order::with('coupon_customer', 'coupon_customer.coupon')->find($params['orderId']);

        $couponCustomer = null;
        if (!empty($order->coupon_customer->coupon)) {
            $couponCustomer = $order->coupon_customer;
        }

        $price = $this->_calculate($params['productArray'], $couponCustomer, $order->customer_id);

        return $price;

    }

    public function _calculate($products = [], $couponCustomer = null, $customerId = null)
    {
        $priceOriginal = 0;
        $pricePaid = 0;
        $discountCoupon = 0;
        $discountMembership = 0;
        $price_ship = 0;
        $price_multiplication_quantity_Array = [];

        if (!empty($products)) {
            foreach ($products as $product) {
                $pro = Product::find($product['productId']);

                //Gia discount
                if (!empty($pro->price_discount)) {
                    $price = $pro->price_discount;
                } else {
                    $price = $pro->price;
                }
                $quantity = str_replace(",", ".", $product['quantity']);

                $priceOriginal += ($price * $quantity);

                $price_multiplication_quantity = $price * $quantity;
                $price_multiplication_quantity_Array[] = ['id' => $product['productId'], 'price_multiplication_quantity' => $price_multiplication_quantity];
            }
            $pricePaid = $priceOriginal;
        }

        if (!empty($couponCustomer)) {
            $coupon = CouponCustomer::find($couponCustomer->id)->coupon;
            $discount_type_id = $coupon->discount_type_id;
            switch ($discount_type_id) {
                case 1:
                    $discountCoupon = ($pricePaid * $coupon->value) / 100;
                    break;
                case 2:
                    $discountCoupon = $coupon->value;
                    break;
            }
        }
        $pricePaid = $pricePaid - $discountCoupon;

        $customer = Customer::find($customerId);
        if (!empty($customer->membership_id)) {
            $membership = Membership::find($customer->membership_id);
            $discountValue = $membership->discount_value;
            $discountMembership = ($pricePaid * $discountValue) / 100;
        }
        $pricePaid = $pricePaid - $discountMembership;

        return [
            "price_ship"                    => $price_ship,
            "price_original"                => $priceOriginal,
            "discount_coupon"               => $discountCoupon,
            "discount_membership"           => $discountMembership,
            "total_price"                   => $pricePaid,
            "price_multiplication_quantity" => $price_multiplication_quantity_Array,
        ];

    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());

        return redirect()->route('admin.orders.index');
    }

    public function updateCustom(UpdateOrderCustomRequest $request)
    {
        $params = $request->all();

        $dataUpdate = [];
        if (!empty($params['status_id'])) {
            $dataUpdate['status_id'] = $params['status_id'];
        }
        if (!empty($params['is_prepay'])) {
            $dataUpdate['is_prepay'] = $params['is_prepay'];
        }
        if (!empty($params['is_delivery'])) {
            $dataUpdate['is_delivery'] = $params['is_delivery'];
        }
        if (!empty($params['address_id'])) {
            $dataUpdate['address_id'] = $params['address_id'];
        }
        if (!empty($params['deposit_amount'])) {
            $dataUpdate['deposit_amount'] = $params['deposit_amount'];
        }

        $order = Order::with('coupon_customer', 'coupon_customer.coupon')->find($params['order_id']);

        $couponCustomer = null;
        if (!empty($order->coupon_customer->coupon)) {
            $couponCustomer = $order->coupon_customer;
        }

        if ($params['status_id'] == 6) {
            $order->update(['status_id' => $params['status_id']]);
        } else {
            $price = $this->_calculate($params['productArray'], $couponCustomer, $order->customer_id);
            $order->update([
                'price_ship'          => $price['price_ship'],
                'price_original'      => $price['price_original'],
                'discount_coupon'     => $price['discount_coupon'],
                'discount_membership' => $price['discount_membership'],
                'total_price'         => $price['total_price'],
            ]);

            $order->update($dataUpdate);
            if (!empty($params['productArray'])) {
                foreach ($params['productArray'] as $product) {
                    OrderDetail::updateOrCreate(
                        ['product_id' => $product['productId'], 'order_id' => $params['order_id']],
                        ['quantity' => $product['quantity']]
                    );
                }
            }
        }

        return back();
    }

    public function show(Order $order)
    {
        abort_if(Gate::denies('order_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->load('customer', 'address', 'status', 'reservation', 'coupon_customer', 'orderOrderDetails');

        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        abort_if(Gate::denies('order_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $order->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderRequest $request)
    {
        Order::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function countNewOrder()
    {
        $count = Order::where('status_id', 1);

        $user = User::find(auth()->id());

        if ($user->isAdmin) {
            $count->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
        }

        $count = $count->count();

        return $count;
    }
}
