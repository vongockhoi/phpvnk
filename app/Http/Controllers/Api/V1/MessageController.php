<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\ReadMessageRequest;
use App\Http\Resources\Admin\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class MessageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/message/getMessages",
     *     operationId="getMessages",
     *     tags={"Message"},
     *     summary="Get message list",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="limit",
     *          required=false,
     *          example=10,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function getMessages(Request $request)
    {
        $customer_id = Auth::id();
        $limit = $request->get("limit", 10);
        $messages = Message::where("customer_id", $customer_id)->orderBy("id", "desc")->paginate($limit);

        return new MessageResource($messages);
    }


    /**
     * @OA\Get(
     *     path="/message/readMessage",
     *     operationId="readMessage",
     *     tags={"Message"},
     *     summary="Read message",
     *     description="",
     *     security={{"bearerAuth":{}, "secretCode":{}}},
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Index of message",
     *          required=true,
     *          example=1,
     *          @OA\Schema(type="integer"),
     *     ),
     *     @OA\Response(response=200, description="Successful operation.", @OA\MediaType(mediaType="application/json")),
     *     @OA\Response(response=400, description="Bad Request."),
     *     @OA\Response(response=401, description="Permission denied."),
     *     @OA\Response(response=404, description="404 not found."),
     *     @OA\Response(response=500, description="An error occurred in processing the request."),
     * )
     */
    public function readMessage(ReadMessageRequest $request)
    {
        $customer_id = Auth::id();
        $id = $request->get("id", null);

        $messages = Message::where("customer_id", $customer_id)->where("id", $id)->first();
        if (!empty($messages)) {
            $messages->update(['last_read_at' => Carbon::now()]);
        }

        return new MessageResource($messages);
    }
}
