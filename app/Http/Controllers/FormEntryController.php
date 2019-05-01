<?php

namespace App\Http\Controllers;

use App\FormEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormEntryController extends Controller
{

    /**
     * Store a new form entry.
     *
     * @return void
     */
    public function create(Request $request) {

        // validate incoming request
        $v = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|max:25',
            'email' => 'required|email',
            'additional_fields' => 'json',
        ]);
        if($v->fails()) {
            return response()->json([
                'success' => false,
                'reason' => 'Form validation failed',
                'errors' => $v->errors()
            ], 400);
        }

        // store if request is valid
        $formEntry = new FormEntry;
        $formEntry->first_name = $request->input('first_name');
        $formEntry->last_name = $request->input('last_name');
        $formEntry->email = $request->input('email');
        $formEntry->phone = $request->input('phone');
        if($af = $request->input('additional_fields')) {
            $formEntry->additional_fields = $af;
        }
        $formEntry->save();

        // return created object
        return response()->json([
            'success' => true,
            'data' => $formEntry
        ], 200);

    }

    /**
     * Get a form entry from storage.
     *
     * @return void
     */
    public function read($id) {

        $formEntry = FormEntry::find($id);

        if($formEntry) {
            return response()->json([
                'success' => true,
                'data' => $formEntry
            ], 200);
        }

        else {
            return response()->json([
                'success' => false,
                'reason' => 'Not found',
                'data' => $formEntry
            ], 404);
        }

        
    }

    /**
     * Update an existing form entry.
     *
     * @return void
     */
    public function update($id) {
        //
    }

    /**
     * Delete an existing form entry.
     *
     * @return void
     */
    public function delete($id) {
        //
    }

}
