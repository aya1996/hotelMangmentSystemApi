<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(TransactionResource::collection(Transaction::all()), 'List of Transactions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $transaction = new Transaction();
        $transaction->transaction_id = uniqid();
        $transaction->payment_method = $request->payment_method;
        $transaction->payment_status = $request->payment_status;
        $transaction->payment_amount = Invoice::find(auth()->user()->id)->sub_total;
        $transaction->payment_currency = $request->payment_currency;
        $transaction->payment_date = $request->payment_date;
        $transaction->transactionable()->associate(auth()->user());
        $transaction->save();

        return $this->handleResponse(new TransactionResource($transaction), 'Your transaction is successfully created', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return $this->handleError(null, 'Transaction not found', Response::HTTP_NOT_FOUND);
        }
        return $this->handleResponse(new TransactionResource($transaction), 'Transaction found');
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
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return $this->handleError(null, 'Transaction not found', Response::HTTP_NOT_FOUND);
        }
        $transaction->update($request->all());
        return $this->handleResponse(new TransactionResource($transaction), 'Transaction updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return $this->handleError(null, 'Transaction not found', Response::HTTP_NOT_FOUND);
        }
        $transaction->delete();
        return $this->handleResponse(null, 'Transaction deleted', Response::HTTP_NO_CONTENT);
    }
}
