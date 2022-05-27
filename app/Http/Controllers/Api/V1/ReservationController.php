<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\LoggingHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Reservation\StoreReservationRequest;
use App\Http\Resources\Admin\ReservationResource;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Exception;

class ReservationController extends Controller
{
    public function storeReservation(StoreReservationRequest $request)
    {
        try {
            $request['code'] = $this->_generateUniqueCodeOrder();
            $request['status_id'] = 1; //Cho xac nhan

            $validated = $request->validated();
            $request['phone'] = convertPhone($validated['phone']);
            $customer = Customer::where("phone", $request['phone'])->first();
            if (!empty($customer) && !$request->has('customer_id')) {
                $request['customer_id'] = $customer->id;
            }

            $reservation = Reservation::create($request->all());

            return (new ReservationResource($reservation))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        } catch (Exception $exception) {
            LoggingHelper::logException($exception);
        }
    }

    public function getReservations(Request $request)
    {
        $customer_id = Auth::id();
        $limit = $request->get("limit", 10);
        $status_id = $request->get("status_id", null);

        $reservations = Reservation::where("customer_id", $customer_id);

        if (!empty($status_id)) {
            $reservations = $reservations->where("status_id", $status_id);
        }

        return new ReservationResource($reservations->paginate($limit));
    }

    public function getReservationStatus()
    {
        $reservationstatus = ReservationStatus::all();

        return new ReservationResource($reservationstatus);
    }

    private function _generateUniqueCodeOrder()
    {
        $code = generateUniqueCode();

        if (Reservation::where('code', $code)->exists()) {
            $this->_generateUniqueCodeOrder();
        }

        return $code;
    }
}
