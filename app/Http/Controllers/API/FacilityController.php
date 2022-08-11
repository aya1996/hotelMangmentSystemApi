<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(FacilityResource::collection(Facility::all()), 'List of facilities');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $facility = Facility::create($request->all());
        $facility->save();
        return $this->handleResponse(new FacilityResource($facility), trans('response.facility_created_successfully'), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->handleResponse(new FacilityResource(Facility::find($id)), 'Facility');
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
        $facility = Facility::find($id);
        $facility->update($request->all());
        $facility->save();
        return $this->handleResponse(new FacilityResource($facility), trans('response.facility_updated_successfully'), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facility = Facility::find($id);
        $facility->delete();
        return $this->handleResponse(true,trans('response.facility_deleted_successfully'), Response::HTTP_OK);
    }
}
