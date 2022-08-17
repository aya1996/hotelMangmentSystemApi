<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Image;
use App\Models\Room;
use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return  $this->handleResponse(RoomResource::collection(Room::all()), 'List of rooms');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {

        $room = Room::create($request->all());

        $room->save();
        if ($request->hasfile('images')) {

            foreach ($request->file('images') as $image) {
                $images[] = $this->saveImages($image);
            }

            $image = new Image();
            $image->image_path = json_encode($images);
            $image->room_id = $room->id;
        }
        $image->save();
        $room->facilities()->attach($request->facilities);
        return $this->handleResponse(new RoomResource($room), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $room = Room::findOrFail($id);
        return $this->handleResponse(new RoomResource($room), Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->all());

        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $this->saveImages($image);
            }
            $image = new Image();
            $image->image_path = json_encode($images);
            $image->room_id = $room->id;
        }
        $image->save();
        
        return $this->handleResponse(new RoomResource($room), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $room = Room::findOrFail($id);
        $room->delete();
        return $this->handleResponse(null, Response::HTTP_OK);
    }
}
