<?php

namespace App\Http\Controllers;

use App\FilterGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilterGroupController extends Controller
{


    /**
     * Return a listing of this resource.
     *
     * @return void
     */
    public function index() {
        
        $fgs = FilterGroup::all();

        foreach($fgs as $fg) {
            $fg->filters = $fg->filters()->get();
        }

        return response()->json([
            'success' => true,
            'data' => $fgs
        ], 200);

    }


    /**
     * Store a new filter group.
     *
     * @return void
     */
    public function create(Request $request) {
        
        // validate incoming request
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'group_key' => 'required'
        ]);
        if($v->fails()) {
            return response()->json([
                'success' => false,
                'reason' => 'Form validation failed',
                'errors' => $v->errors()
            ], 400);
        }

        // store if request is valid
        $filterGroup = new FilterGroup();
        $filterGroup->name = $request->input('name');
        $filterGroup->group_key = $request->input('group_key');
        $filterGroup->save();

        // return created object
        return response()->json([
            'success' => true,
            'data' => $filterGroup
        ], 200);

    }

    /**
     * Get a filter group from storage.
     *
     * @return void
     */
    public function read($id) {

        $fg = FilterGroup::find($id);

        if(!$fg) {
            return response()->json([
                'success' => false,
                'reason' => 'That filter group wasn\'t found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $fg
        ], 200);

    }

    /**
     * Update an existing filter group.
     *
     * @return void
     */
    public function update($id) {
        //
    }

    /**
     * Delete an existing filter group.
     *
     * @return void
     */
    public function delete($id) {
        //
    }

}
