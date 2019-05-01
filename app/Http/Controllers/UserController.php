<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Store a new.
     *
     * @return void
     */
    public function create(Request $request) {

        // validate incoming request
        $v = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed',
        ]);
        if($v->fails()) {
            return response()->json([
                'success' => false,
                'reason' => 'Form validation failed',
                'errors' => $v->errors()
            ], 400);
        }

        // store if request is valid
        $user = new User;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // return created object
        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);

    }

    /**
     * Get a user from storage.
     *
     * @return void
     */
    public function read($id) {

        $user = User::find($id);

        if($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        }

        else {
            return response()->json([
                'success' => false,
                'reason' => 'Not found',
                'data' => $user
            ], 404);
        }

        
    }

    /**
     * Update an existing user.
     *
     * @return void
     */
    public function update($id) {
        //
    }

    /**
     * Delete an existing user.
     *
     * @return void
     */
    public function delete($id) {
        //
    }

}
