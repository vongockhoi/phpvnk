<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\LoggingHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CarBooking\StoreCarBookingRequest;
use App\Http\Resources\Admin\CarBookingResource;
use App\Models\CarBooking;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use App\Constants\CarBooking as CarBookingConst;

class CarBookingController extends Controller
{
    public function storeCarBooking(StoreCarBookingRequest $request)
    {
        try {
            $request['status_id'] = CarBookingConst::STATUS['PROCESSING'];
            $request['phone'] = convertPhone($request['phone']);
            $carBooking = CarBooking::create($request->all());

            return (new CarBookingResource($carBooking))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (Exception $exception) {
            LoggingHelper::logException($exception);
        }
    }
}
