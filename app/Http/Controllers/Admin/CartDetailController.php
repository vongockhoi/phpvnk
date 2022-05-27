<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCartDetailRequest;
use App\Http\Requests\StoreCartDetailRequest;
use App\Http\Requests\UpdateCartDetailRequest;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartDetailController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cart_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cartDetails = CartDetail::with(['cart', 'product', 'free_one_product_parent'])->get();

        return view('admin.cartDetails.index', compact('cartDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('cart_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = Cart::pluck('total_price', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $free_one_product_parents = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.cartDetails.create', compact('carts', 'products', 'free_one_product_parents'));
    }

    public function store(StoreCartDetailRequest $request)
    {
        $cartDetail = CartDetail::create($request->all());

        return redirect()->route('admin.cart-details.index');
    }

    public function edit(CartDetail $cartDetail)
    {
        abort_if(Gate::denies('cart_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carts = Cart::pluck('total_price', 'id')->prepend(trans('global.pleaseSelect'), '');

        $products = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $free_one_product_parents = Product::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cartDetail->load('cart', 'product', 'free_one_product_parent');

        return view('admin.cartDetails.edit', compact('carts', 'products', 'free_one_product_parents', 'cartDetail'));
    }

    public function update(UpdateCartDetailRequest $request, CartDetail $cartDetail)
    {
        $cartDetail->update($request->all());

        return redirect()->route('admin.cart-details.index');
    }

    public function show(CartDetail $cartDetail)
    {
        abort_if(Gate::denies('cart_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cartDetail->load('cart', 'product', 'free_one_product_parent');

        return view('admin.cartDetails.show', compact('cartDetail'));
    }

    public function destroy(CartDetail $cartDetail)
    {
        abort_if(Gate::denies('cart_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cartDetail->delete();

        return back();
    }

    public function massDestroy(MassDestroyCartDetailRequest $request)
    {
        CartDetail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
