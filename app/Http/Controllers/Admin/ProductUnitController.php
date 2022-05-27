<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyProductUnitRequest;
use App\Http\Requests\StoreProductUnitRequest;
use App\Http\Requests\UpdateProductUnitRequest;
use App\Models\ProductUnit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductUnitController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_unit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productUnits = ProductUnit::all();

        return view('admin.productUnits.index', compact('productUnits'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_unit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productUnits.create');
    }

    public function store(StoreProductUnitRequest $request)
    {
        $productUnit = ProductUnit::create($request->all());

        return redirect()->route('admin.product-units.index');
    }

    public function edit(ProductUnit $productUnit)
    {
        abort_if(Gate::denies('product_unit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productUnits.edit', compact('productUnit'));
    }

    public function update(UpdateProductUnitRequest $request, ProductUnit $productUnit)
    {
        $productUnit->update($request->all());

        return redirect()->route('admin.product-units.index');
    }

    public function show(ProductUnit $productUnit)
    {
        abort_if(Gate::denies('product_unit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productUnits.show', compact('productUnit'));
    }

    public function destroy(ProductUnit $productUnit)
    {
        abort_if(Gate::denies('product_unit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productUnit->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductUnitRequest $request)
    {
        ProductUnit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
