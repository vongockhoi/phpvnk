<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountTypeRequest;
use App\Http\Requests\UpdateDiscountTypeRequest;
use App\Http\Resources\Admin\DiscountTypeResource;
use App\Models\DiscountType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DiscountTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('discount_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DiscountTypeResource(DiscountType::all());
    }

    public function store(StoreDiscountTypeRequest $request)
    {
        $discountType = DiscountType::create($request->all());

        return (new DiscountTypeResource($discountType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DiscountType $discountType)
    {
        abort_if(Gate::denies('discount_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DiscountTypeResource($discountType);
    }

    public function update(UpdateDiscountTypeRequest $request, DiscountType $discountType)
    {
        $discountType->update($request->all());

        return (new DiscountTypeResource($discountType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DiscountType $discountType)
    {
        abort_if(Gate::denies('discount_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $discountType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
