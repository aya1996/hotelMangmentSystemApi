<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {
        $booking = Booking::create($request->all());
        if(Room::find($request->room_id)->available_rooms < $request->no_of_rooms) {
            return $this->handleResponse(null, 'Not enough rooms available', Response::HTTP_BAD_REQUEST);
        }
        Room::find($request->room_id)->decrement('available_rooms', $request->no_of_rooms);
        
        $booking->save();
        return $this->handleResponse(new BookingResource($booking), Response::HTTP_CREATED);
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
