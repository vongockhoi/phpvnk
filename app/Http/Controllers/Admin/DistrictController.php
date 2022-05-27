<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDistrictRequest;
use App\Http\Requests\StoreDistrictRequest;
use App\Http\Requests\UpdateDistrictRequest;
use App\Models\District;
use App\Models\Province;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DistrictController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('district_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $districts = District::with(['province'])->get();

        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        abort_if(Gate::denies('district_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provinces = Province::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.districts.create', compact('provinces'));
    }

    public function store(StoreDistrictRequest $request)
    {
        $district = District::create($request->all());

        return redirect()->route('admin.districts.index');
    }

    public function edit(District $district)
    {
        abort_if(Gate::denies('district_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provinces = Province::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $district->load('province');

        return view('admin.districts.edit', compact('provinces', 'district'));
    }

    public function update(UpdateDistrictRequest $request, District $district)
    {
        $district->update($request->all());

        return redirect()->route('admin.districts.index');
    }

    public function show(District $district)
    {
        abort_if(Gate::denies('district_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $district->load('province');

        return view('admin.districts.show', compact('district'));
    }

    public function destroy(District $district)
    {
        abort_if(Gate::denies('district_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $district->delete();

        return back();
    }

    public function massDestroy(MassDestroyDistrictRequest $request)
    {
        District::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function filterDistrictFromProvince(Request $request)
    {
        if(!empty($request->get('province_id'))){
            $districts = District::where('province_id', $request->get('province_id'));
            $districts = $districts->get()->pluck('name', 'id');
        }else{
            $districts = [];
        }

        return $districts;
    }
}
