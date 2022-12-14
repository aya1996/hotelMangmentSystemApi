<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->handleResponse(User::all()->where('is_admin', true), 'List of admins');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->handleError('Invalid credentials');
            }

            $user = User::where('email', $request['email'])->firstOrFail();


            return $this->handleResponse(new UserResource($user), 'Login Successful');
        }
    }

    public function register(UserRequest $attr)
    {

        $user = User::create([
            'name'      => $attr['name'],
            'email'     => $attr['email'],
            'password'  => Hash::make($attr['password']),
            'is_admin'  => true,
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->plainTextToken;

        return $this->handleResponse(new UserResource($user), 'user created successfully', Response::HTTP_CREATED);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id)->where('is_admin', true);
        if (!$user) {
            return $this->handleError('user not found');
        }
        return $this->handleResponse(new UserResource($user), 'user found');
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
        $user = User::find($id);
        if (!$user) {
            return $this->handleError('user not found');
        }
        $user->update($request->all());
        return $this->handleResponse(new UserResource($user), 'user updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->where('is_admin', true);
        if (!$user) {
            return $this->handleError('user not found');
        }
        $user->delete();
        return $this->handleResponse(new UserResource($user), 'user deleted successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
