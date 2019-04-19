<?php

namespace App\Http\Controllers;

use App\FormEntry;
use Illuminate\Http\Request;
use App\Http\Request\FormEntryStore;
use Illuminate\Support\Facades\Validator;

class FormEntryController extends Controller
{

    /**
     * Store a new form entry.
     *
     * @return void
     */
    public function create(FormEntryStore $request) {

        $request->validateOrRespond();
        return response()->json(['data' => 'validation passed']);

        // $formEntry = new FormEntry;
        // $formEntry->first_name = $request->input('first_name');
        // $formEntry->last_name = $request->input('last_name');
        // $formEntry->email = $request->input('email');
        // $formEntry->phone = $request->input('phone');
        // $formEntry->save();

    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function read($id) {
        return User::findOrFail($id);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function update() {
        //
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function delete() {
        //
    }

}
