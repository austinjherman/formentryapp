<?php

namespace App\Http\Controllers;

use App\FormEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FormEntryController extends Controller
{

    public function index(Request $request) {

        // pagination variables
        $page = (int) $request->input('page');
        if(!$page) {
            $page = 1;
        }
        $perPage = (int) $request->input('per-page');
        if(!$perPage || $perPage > 100) {
            $perPage = 100;
        }

        // initial query
        $formEntries = DB::table(
            with(new FormEntry)->getTable()
        )->orderBy('created_at', 'desc');

        //additional filters
        $addFilters = $request->input('add-filters');
        if($addFilters) {

            // + symbol is converted to a space in URL params
            // first we will split by + to get the different filter
            // groups
            $addFilters = explode(' ', $request->input('add-filters'));

            if(count($addFilters) > 0) {
                foreach($addFilters as $af) {

                    // for each filter group, we will explode by
                    // : to get <filtergroup>:<filters>
                    $af = explode(':', $af);

                    if(count($af) === 2) {

                        // individual filters are separated by .
                        $values = explode('.', $af[1]);
                        $valueCount= count($values);

                        // create where groups for both cases
                        if($valueCount > 1) {
    
                            $formEntries->where(function($query) use($af, $values, $valueCount) {

                                // if there's more than one filter, the first should be a where
                                // followed by orWheres
                                for($i=0; $i < $valueCount; $i++) {
                                    if($i === 0) {
                                        $query->where("additional_fields->$af[0]", '=', $values[$i]);
                                    }
                                    else {
                                        $query->orWhere("additional_fields->$af[0]", '=', $values[$i]);
                                    }
                                }
                            });
                        }

                        // single where for one single filter
                        elseif($valueCount === 1 ) {
                            $formEntries->where(function($query) use($af) {
                                $query->where("additional_fields->$af[0]", '=', $af[1]);
                            });
                        }
                    }
                    
                }
            }
        }

        $formEntries = $formEntries->get();
        $totalEntries = count($formEntries);
        $formEntries = $formEntries->forPage($page, $perPage);
        $formEntries = $formEntries->values()->all();

        return response()->json([
            'success' => true,
            'total_entries' => $totalEntries,
            'per_page' => $perPage,
            'page' => $page,
            'data' => $formEntries
        ], 200);

    }

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

    public function filters() {

        $entries = FormEntry::all();

        $filters = [];
        $return = [];

        foreach($entries as $entry) {
            $additional_fields = json_decode($entry->additional_fields);
            foreach($additional_fields as $key => $value) {
                if(!isset($filters[$key])) {
                    $filters[$key][] = $value;
                }
                else {
                    if(!in_array($value, $filters[$key])) {
                        $filters[$key][] = $value;
                    }
                }
            }
        }

        foreach($filters as $key => $value) {
            $return[] = [
                'name' => $key,
                'values' => $value
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $return
        ], 200);


    }

}
