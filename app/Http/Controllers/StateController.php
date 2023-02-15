<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{

    public function index(Request $request)
    {
        $countries = Country::all();
        if ($request->ajax()) {
            $data = State::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm editState">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteState">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('state.crud', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        State::updateOrCreate(
            [
                'id'        => $request->state_id
            ],
            [
                'state_name' => $request->state_name,
                'country_id' => $request->country_id,

            ]
        );

        return response()->json(['success' => 'Member saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $states = State::find($id);
        return response()->json($states);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        if ($state->cities()->count() > 0) {
            $state->contacts()->delete();
            $state->cities()->delete();
        }
        $state->delete();
        return response()->json(['success' => 'Member deleted successfully.']);
    }
}
