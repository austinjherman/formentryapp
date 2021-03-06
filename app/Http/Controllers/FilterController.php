<?php

namespace App\Http\Controllers;

use App\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilterController extends Controller
{

    public function index() {

        $filters = Filter::all();
        
        return response()->json([
            'success' => true,
            'data' => $filters
        ], 200);

    }

    /**
     * Store a new filter.
     *
     * @return void
     */
    public function create(Request $request) {
        
        // validate incoming request
        $v = Validator::make($request->all(), [
            'filter_group_id' => 'required|integer',
            'value' => 'required'
        ]);
        if($v->fails()) {
            return response()->json([
                'success' => false,
                'reason' => 'Form validation failed',
                'errors' => $v->errors()
            ], 400);
        }

        // store if request is valid
        $filter = new Filter();
        $filter->value = $request->input('value');
        $filter->filter_group_id = $request->input('filter_group_id');
        $filter->save();

        // return created object
        return response()->json([
            'success' => true,
            'data' => $filter
        ], 200);

    }

    /**
     * Get a filter from storage.
     *
     * @return void
     */
    public function read(Request $request) {
        //
    }

    /**
     * Update an existing filter.
     *
     * @return void
     */
    public function update(Request $request, $id) {

        // validate incoming request
        $v = Validator::make($request->all(), [
            'value' => 'required'
        ]);
        if($v->fails()) {
            return response()->json([
                'success' => false,
                'reason' => 'Form validation failed',
                'errors' => $v->errors()
            ], 400);
        }

        $filter = Filter::find($id);
        $filter->value = $request->input('value');
        $filter->save();

        // return created object
        return response()->json([
            'success' => true,
            'data' => $filter
        ], 200);

    }

    /**
     * Delete an existing filter.
     *
     * @return void
     */
    public function delete($id) {
        
        $filter = Filter::find($id);
        $filter->delete();
        
        // return created object
        return response()->json([
            'success' => true,
            'message' => 'Filter deleted',
            'data' => null
        ], 200);

    }

}
