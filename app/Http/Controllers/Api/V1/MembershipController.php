<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Http\Resources\Admin\MembershipResource;
use App\Models\Customer;
use App\Models\Membership;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use Log;

class MembershipController extends Controller
{
    /**
     * @OA\Get(
     *     path="/membership/getMemberships",
     *     operationId="getMemberships",
     *     tags={"Menberships"},
     *     summary="Get a list of membership",
     *     description="",
     *     security={{"secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getMemberships()
    {
        return new MembershipResource(Membership::all());
    }

    /**
     * @OA\Get(
     *     path="/membership/getMembershipInfo",
     *     operationId="getMembershipInfo",
     *     tags={"Menberships"},
     *     summary="Get membership of customer",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getMembershipInfo()
    {
        $customer_id = Auth::id();
        $membership_id = Auth::user()->membership_id;

        $customer = Customer::find(Auth::id());

        $info = new \stdClass();
        $info->customer_id = $customer_id;
        $info->membership_id = $membership_id;
        $info->membership = $customer->membership;
        $info->my_points = $customer->myPoints ? $customer->myPoints->num_of_point : 0;

        if (empty($membership_id)) {
            $info->membership_next = Membership::find(1);
        } else {
            $next_membership_id = Membership::find($membership_id)->next_membership_id;
            $next_membership = Membership::find($next_membership_id);
            $info->membership_next = $next_membership;

        }

        return new MembershipResource((array)($info));

    }
}
