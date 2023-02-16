<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    //listing of countries
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Country::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm editCountry">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteCountry">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('country.crud');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Country::updateOrCreate(
            [
                'id'        => $request->country_id
            ],
            [
                'country_name' => $request->country_name,

            ]
        );

        return response()->json(['success' => 'Member saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $countries = Country::find($id);
        return response()->json($countries);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        if ($country->states()->count() > 0) {
            $country->contacts()->delete();
            $states = $country->states()->get();
            if ($states->count() > 0) {

                foreach ($states as $state) {
                    $state->cities()->delete();
                    $state->delete();
                }
            }
        }
        $country->delete();
        return response()->json(['success' => 'Member deleted successfully.']);
    }
}
