<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function index(Request $request)
    {

        $states = State::all();
        $countries = Country::all();
        if ($request->ajax()) {
            $data = City::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm editCity">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteCity">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('city.crud', ['states' => $states, ['countries' => $countries]]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        City::updateOrCreate(
            [
                'id'        => $request->city_id
            ],
            [
                'city_name' => $request->city_name,
                'state_id' => $request->state_id,

            ]
        );

        return response()->json(['success' => 'Member saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cities = City::find($id);
        return response()->json($cities);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        City::destroy($id);
        return response()->json(['success' => 'Member deleted successfully.']);
    }
}
