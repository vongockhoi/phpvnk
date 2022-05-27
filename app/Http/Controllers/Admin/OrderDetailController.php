<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOrderDetailRequest;
use App\Http\Requests\StoreOrderDetailRequest;
use App\Http\Requests\UpdateOrderDetailRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderDetailController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('order_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $orderDetails = OrderDetail::with(['order', 'product']);

        if($user->isAdmin){
            $orderDetails->whereHas('order', function ($query) use ($user) {
                $query->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
            });
        }

        $orderDetails = $orderDetails->get();

        return view('admin.orderDetails.index', compact('orderDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('order_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $orders = Order::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        if($user->isAdmin){
            $orders = Order::whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray())->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.orderDetails.create', compact('orders', 'products'));
    }

    public function store(StoreOrderDetailRequest $request)
    {
        $orderDetail = OrderDetail::create($request->all());

        return redirect()->route('admin.order-details.index');
    }

    public function edit(OrderDetail $orderDetail)
    {
        abort_if(Gate::denies('order_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $orders = Order::pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');

        if($user->isAdmin){
            $orders = Order::whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray())->pluck('code', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $orderDetail->load('order', 'product');

        return view('admin.orderDetails.edit', compact('orders', 'products', 'orderDetail'));
    }

    public function update(UpdateOrderDetailRequest $request, OrderDetail $orderDetail)
    {
        $orderDetail->update($request->all());

        return redirect()->route('admin.order-details.index');
    }

    public function show(OrderDetail $orderDetail)
    {
        abort_if(Gate::denies('order_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderDetail->load('order', 'product');

        return view('admin.orderDetails.show', compact('orderDetail'));
    }

    public function destroy(OrderDetail $orderDetail)
    {
        abort_if(Gate::denies('order_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orderDetail->delete();

        return back();
    }

    public function massDestroy(MassDestroyOrderDetailRequest $request)
    {
        OrderDetail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
