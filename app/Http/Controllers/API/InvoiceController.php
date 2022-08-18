<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->handleResponse(InvoiceResource::collection(Invoice::all()), 'List of Invoices');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoiceRequest $request)
    {
        $booking = Booking::find($request->booking_id);
        $total = 0;


        if ($booking->booking_type == false) {
            $booking->rooms->each(function ($room) use (&$total) {
                $total += $room->price_per_hour;
            });
            // return $total;
            // $total += $booking->rooms()  * $request->hours_duration;
        } else {

            $booking->rooms->each(function ($room) use (&$total) {
                $total += $room->price_per_day;
            });
        }
        $discount = 0;
        if ($booking->rooms()->count() >= 2) {
            $discount = ($total * 10) / 100;
            $sub_total = $total - $discount;
        } else {
            $sub_total = $total;
        }

        $invoice = Invoice::create([
            'invoice_number' => uniqid(),
            'total_amount' => $total,
            'guest_id' => auth()->user()->id,
            'sub_total' => $sub_total,
            'discount' =>  $discount,
            'invoiceDate' => request('invoiceDate'),
        ]);




        return $this->handleResponse(new InvoiceResource($invoice), 'Invoice created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return $this->handleError(null, Response::HTTP_NOT_FOUND);
        }
        return $this->handleResponse(new InvoiceResource($invoice), Response::HTTP_OK);
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
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return $this->handleError(null, Response::HTTP_NOT_FOUND);
        }
        $invoice->update($request->all());
        return $this->handleResponse(new InvoiceResource($invoice), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return $this->handleError(null, Response::HTTP_NOT_FOUND);
        }
        $invoice->delete();
        return $this->handleResponse(null, 'Invoice deleted successfully', Response::HTTP_NO_CONTENT);
    }
}
