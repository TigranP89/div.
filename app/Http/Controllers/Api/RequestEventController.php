<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreRequestEvent;
use App\Http\Requests\UpdateRequestEvent;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use App\Models\RequestEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RequestEventController extends BaseController
{
  /**
   * RequestEventController constructor.
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(Request $request)
  {
    /*
     * Request Body:
     * {
     *   "statusOrder": "Filter by status",
     *   "dateOrder": "Filter by date",
     *   "pageSize": "Pagination size",
     * }
     *
     * @var string $statusOrder The filter status by default is 'asc'.
     * @var string $dateOrder The filter status by default is 'desc'.
     * @var int $pageSize The size of pagination by default is 15.
     */
    try {
      $statusOrder = $request->input('statusOrder') == null ? 'asc' : $request->input('statusOrder');
      $dateOrder = $request->input('dateOrder') == null ? 'desc' : $request->input('dateOrder');
      $pageSize = $request->input('pageSize') == null ? 10 : $request->input('pageSize');

      $requests = RequestEvent::orderBy('status', $statusOrder)
                                ->orderBy('updated_at', $dateOrder)
                                ->paginate($pageSize);

      return response()->json([
        'requests' => $requests,
        'status' => 200,
        'message' => "Request successfully get"
      ]);
    } catch (\Exception $e) {
      return response()->json([
        "status" => 400,
        "message" => $e->getMessage()
      ]);
    }
  }

  /**
   * @param StoreRequestEvent $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreRequestEvent $request)
  {
  /*
   * Request Body:
   * {
   *   "message": "Message of RequestEvent",
   * }
   */
    try {

      $requestEvent = new RequestEvent;
      $requestEvent->name = Auth::user()->name;
      $requestEvent->email = Auth::user()->email;
      $requestEvent->message =$request->input('message');
      $requestEvent->save();

      return response()->json([
        'status' => 200,
        'message' => "Request successfully stored"
      ]);
    } catch (\Exception $e) {
      return response()->json([
        "status" => 400,
        "message" => $e->getMessage()
      ]);
    }
  }


  /**
   * @param UpdateRequestEvent $request
   * @param string $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateRequestEvent $request, string $id)
  {
  /*
   * Request Body:
   * {
   *   "comment": "Admin comment"
   * }
   */
    try {
      $event = RequestEvent::find($id);

      if ($event->status == "Active"){
        $event->status = "Resolved";
        $event->comment = $request->input('comment');
        $event->update();

        $mailData = RequestEvent::find($id)->toArray();

        Mail::to($mailData['email'])->send(new SendEmail($mailData));

        return response()->json([
            'status' => 200,
            'message' => "Request successfully Resolved"
        ]);
      }

      return response()->json([
        'status' => 400,
        'message' => "Request already Resolved"
      ]);

    } catch (\Exception $e) {
      return response()->json([
        "status" => 400,
        "message" => $e->getMessage()
      ]);
    }
  }
}
