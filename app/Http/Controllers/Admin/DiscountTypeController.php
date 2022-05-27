<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDiscountTypeRequest;
use App\Http\Requests\StoreDiscountTypeRequest;
use App\Http\Requests\UpdateDiscountTypeRequest;
use App\Models\DiscountType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DiscountTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('discount_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $discountTypes = DiscountType::all();

        return view('admin.discountTypes.index', compact('discountTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('discount_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.discountTypes.create');
    }

    public function store(StoreDiscountTypeRequest $request)
    {
        $discountType = DiscountType::create($request->all());

        return redirect()->route('admin.discount-types.index');
    }

    public function edit(DiscountType $discountType)
    {
        abort_if(Gate::denies('discount_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.discountTypes.edit', compact('discountType'));
    }

    public function update(UpdateDiscountTypeRequest $request, DiscountType $discountType)
    {
        $discountType->update($request->all());

        return redirect()->route('admin.discount-types.index');
    }

    public function show(DiscountType $discountType)
    {
        abort_if(Gate::denies('discount_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.discountTypes.show', compact('discountType'));
    }

    public function destroy(DiscountType $discountType)
    {
        abort_if(Gate::denies('discount_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $discountType->delete();

        return back();
    }

    public function massDestroy(MassDestroyDiscountTypeRequest $request)
    {
        DiscountType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
