<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(BookingResource::collection(Booking::all()), 'List of bookings');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {

        foreach (Room::find($request->room_id) as $room) {
            if (!$room) {
                return $this->handleError(null, 'Room not found', Response::HTTP_NOT_FOUND);
            }
            if ($room->check_in_date > $request->check_in_date || $room->check_out_date < $request->check_out_date) {
                return $this->handleError(null, 'Room not available in these dates', Response::HTTP_NOT_FOUND);
            }

            if ($room->availability == 0) {
                return $this->handleError(null, 'this room is not available', Response::HTTP_BAD_REQUEST);
            } else {
                $rooms[] = $room;
                $booking = Booking::create($request->all());
                $booking->save();
                $booking->rooms()->attach($request->room_id);
                Room::where('id', $room->id)->update(['availability' => 0]);
            }
        }
    
   
           


        return $this->handleResponse(new BookingResource($booking), 'Your booking is successfully created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return $this->handleError(null, Response::HTTP_NOT_FOUND);
        }
        return $this->handleResponse(new BookingResource($booking), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return $this->handleError(null, Response::HTTP_NOT_FOUND);
        }
        $booking->update($request->all());
        return $this->handleResponse(new BookingResource($booking), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return $this->handleError(null, Response::HTTP_NOT_FOUND);
        }
        $booking->delete();
        return $this->handleResponse(null, Response::HTTP_OK);
    }
}
