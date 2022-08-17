<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(RoomTypeResource::collection(RoomType::all()), trans('response.roomTypes_retrieved_successfully'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $roomType = RoomType::create($request->all());
        $roomType->save();
        return $this->handleResponse(new RoomTypeResource($roomType), trans('response.roomType_created_successfully'), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->handleResponse(new RoomTypeResource(RoomType::find($id)), trans('response.roomType_retrieved_successfully'));
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
        $roomType = RoomType::find($id);
        $roomType->update($request->all());
        $roomType->save();
        return $this->handleResponse(new RoomTypeResource($roomType), trans('response.roomType_updated_successfully'), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roomType = RoomType::find($id);
        $roomType->delete();

        return $this->handleResponse(true, trans('response.roomType_deleted_successfully'), Response::HTTP_OK);
    }
}
