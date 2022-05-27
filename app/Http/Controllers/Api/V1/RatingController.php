<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rating\StoreRatingRequest;
use App\Http\Requests\Api\Rating\UpdateRatingRequest;
use App\Http\Resources\Admin\RatingResource;
use App\Models\Rating;
use Auth;
use App\Helpers\Convert;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RatingController extends Controller
{
    public function getRatings(Request $request)
    {
        $customer_id = Auth::id();
        $limit = $request->get("limit", 10);

        $ratings = Rating::with(["order" => function ($q) use ($customer_id) {
            $q->where("customer_id", $customer_id);
        }])->orderByDesc("id");

        return new RatingResource($ratings->paginate($limit));
    }

    public function storeRating(StoreRatingRequest $request)
    {
        $rating = Rating::create($request->validated());

        return (new RatingResource($rating))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function updateRating(UpdateRatingRequest $request)
    {
        $validated = $request->validated();
        $order_id = $validated['order_id'];
        $rating = Rating::where("order_id", $order_id)->first();
        if ($rating) {
            $rating->update($request->all());
            return new RatingResource($rating);
        }

        return new RatingResource(null);

    }

}
