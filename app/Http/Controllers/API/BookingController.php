<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Models\Transaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Baro\PipelineQueryCollection\BooleanFilter;
use Baro\PipelineQueryCollection\DateFromFilter;
use Baro\PipelineQueryCollection\DateToFilter;
use Baro\PipelineQueryCollection\RelationFilter;
use Baro\PipelineQueryCollection\RelativeFilter;
use Baro\PipelineQueryCollection\ScopeFilter;


class BookingController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $bookings = app(Pipeline::class)
        ->send(Booking::query())
        ->through([
            new ScopeFilter('search'),
            new RelativeFilter('name'),
            new BooleanFilter('booking_type'),
            new RelativeFilter('booking_date'),
            new DateFromFilter('check_in_date'),
            new DateToFilter('check_out_date'),
            new RelationFilter('guest_id', 'id'),
            new RelationFilter('room_id', 'id'),

        ])->thenReturn()
        ->paginate(10);

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
            // dd($request->all());
            if (!$room) {
                return $this->handleError(null, 'Room not found', Response::HTTP_NOT_FOUND);
            }
            $bookings = Booking::where('check_in_date', '<=', $request->check_in_date)->where('check_out_date', '>=', $request->check_in_date)->get();
            foreach ($bookings as $booking) {
                $checkInDate = $booking->check_in_date;
                $checkOutDate = $booking->check_out_date;
                $isBooked = CarbonPeriod::create($checkInDate, $checkOutDate);
                if ($isBooked) {
                    return $this->handleError(null, 'Room not available in these dates', Response::HTTP_NOT_FOUND);
                }
            }

            if ($room->availability == 0) {
                return $this->handleError(null, 'this room is not available', Response::HTTP_BAD_REQUEST);
            }
            $rooms[] = $room;
        }

        $booking = Booking::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_No' => $request->phone_No,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'address' => $request->address,
            'booking_date' => $request->booking_date,
            'hour_booking' => $request->hour_booking,
            'day_booking' => $request->day_booking,
            'guest_id' => auth()->user()->id,
        ]);

        $booking->save();
        $booking->rooms()->attach($request->room_id);
        foreach ($rooms as $room) {
            $room->availability = 0;
            $room->save();
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

    public function cancelBooking(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {

            return $this->handleError(null, Response::HTTP_NOT_FOUND);
        }
        $booking->update([
            'status' => 'cancelled',
        ]);
        foreach ($booking->rooms as $room) {
            Room::where('id', $room->id)->update(['availability' => 1]);
        }
        Transaction::where('booking_id', $id)->update(['payment_status' => 'cancelled', 'is_refunded' => 1]);
        return $this->handleResponse(null, Response::HTTP_OK);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getBookings()
    {
        $bookings = Booking::where('guest_id', auth()->user()->id)->get();
        return $this->handleResponse(BookingResource::collection($bookings), Response::HTTP_OK);
    }
    /*************
     *    get available days
     * @return \Illuminate\Http\Response
     */
    public function  availableDates()
    {
        $bookings = Booking::AvailableDays();

        //  return $bookings;
        $dates = [];
        foreach ($bookings as $booking) {

            $is_booked = CarbonPeriod::create($booking->check_in_date, $booking->check_out_date);
            foreach ($is_booked as $book) {
                $DaysBooked[] = $book->format('Y-m-d');
            }
            $start = Carbon::parse($booking->check_in_date)->startOfMonth();
            $end = Carbon::parse($booking->check_in_date)->endOfMonth();
            $period = CarbonPeriod::create($start, $end);
        }
        // return $DaysBooked;
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
            for ($i = 0; $i < count($DaysBooked); $i++) {
                if ($date->format('Y-m-d') == $DaysBooked[$i]) {
                    $dates = array_diff($dates, [$date->format('Y-m-d')]);

                 
                }
             
                
            }
            
        }


        return $this->handleResponse($dates, Response::HTTP_OK);
    }
}
