<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOperatingTimeRequest;
use App\Http\Requests\UpdateOperatingTimeRequest;
use App\Http\Resources\Admin\OperatingTimeResource;
use App\Models\OperatingTime;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OperatingTimeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('operating_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OperatingTimeResource(OperatingTime::with(['restaurant'])->get());
    }

    public function store(StoreOperatingTimeRequest $request)
    {
        $operatingTime = OperatingTime::create($request->all());

        return (new OperatingTimeResource($operatingTime))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OperatingTime $operatingTime)
    {
        abort_if(Gate::denies('operating_time_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OperatingTimeResource($operatingTime->load(['restaurant']));
    }

    public function update(UpdateOperatingTimeRequest $request, OperatingTime $operatingTime)
    {
        $operatingTime->update($request->all());

        return (new OperatingTimeResource($operatingTime))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OperatingTime $operatingTime)
    {
        abort_if(Gate::denies('operating_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operatingTime->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
