<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartDetailRequest;
use App\Http\Requests\UpdateCartDetailRequest;
use App\Http\Resources\Admin\CartDetailResource;
use App\Models\CartDetail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartDetailApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('cart_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CartDetailResource(CartDetail::with(['cart', 'product', 'free_one_product_parent'])->get());
    }

    public function store(StoreCartDetailRequest $request)
    {
        $cartDetail = CartDetail::create($request->all());

        return (new CartDetailResource($cartDetail))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CartDetail $cartDetail)
    {
        abort_if(Gate::denies('cart_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CartDetailResource($cartDetail->load(['cart', 'product', 'free_one_product_parent']));
    }

    public function update(UpdateCartDetailRequest $request, CartDetail $cartDetail)
    {
        $cartDetail->update($request->all());

        return (new CartDetailResource($cartDetail))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CartDetail $cartDetail)
    {
        abort_if(Gate::denies('cart_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cartDetail->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
