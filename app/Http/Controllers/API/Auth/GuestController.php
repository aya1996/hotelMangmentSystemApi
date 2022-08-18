<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\GuestRequest;
use App\Http\Resources\GuestResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuestController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->handleError('Invalid credentials');
            }

            $guest = User::where('email', $request['email'])->firstOrFail();


            return $this->handleResponse(new GuestResource($guest), 'Login Successful');
        }
    }

    public function register(GuestRequest $request)
    {
        $guest = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false,

        ]);
        $guest->save();
        return $this->handleResponse(new GuestResource($guest), 'guest created successfully', Response::HTTP_CREATED);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(User::all()->where('is_admin', false), 'List of guests');
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guest = User::find($id)->where('is_admin', false);
        if (!$guest) {
            return $this->handleError(null, 'Guest not found', Response::HTTP_NOT_FOUND);
        }
        return $this->handleResponse($guest, 'Guest found successfully');
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
        $guest = User::find($id)->where('is_admin', false);
        if (!$guest) {
            return $this->handleError(null, 'Guest not found', Response::HTTP_NOT_FOUND);
        }
        $guest->update($request->only('name', 'email', 'phone_No', 'address'));
        return $this->handleResponse($guest, 'Guest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guest = User::find($id)->where('is_admin', false);
        if (!$guest) {
            return $this->handleError(null, 'Guest not found', Response::HTTP_NOT_FOUND);
        }
        $guest->delete();
        return $this->handleResponse(null, 'Guest deleted successfully');
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
