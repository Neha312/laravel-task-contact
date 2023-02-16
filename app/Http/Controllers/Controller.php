<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // public function fetchState(Request $request)
    // {
    //     //get states name
    //     $data['states'] = State::where("country_id", $request->country_id)
    //         ->get(["state_name", "id"]);
    //     return response()->json($data);
    // }
    // //fetch cities
    // public function fetchCity(Request $request)
    // {
    //     //get cities name
    //     $data['cities'] = City::where("state_id", $request->state_id)
    //         ->get(["city_name", "id"]);
    //     return response()->json($data);
    // }
    // public function index(Request $request)
    // {

    //     $data['countries'] = Country::get(["country_name", "id"]);
    //     $countries = Country::all();
    //     $states = State::all();
    //     $cities = City::all();
    //     if ($request->ajax()) {
    //         $contacts = Contact::all();
    //         return DataTables::of($contacts)
    //             ->addIndexColumn()
    //             ->addColumn('action', function ($row) {
    //                 $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm editContact">Edit</a>';

    //                 $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteContact">Delete</a>';

    //                 return $btn;
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     return view('contact.crud', ['data' => $data, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     City::updateOrCreate(
    //         [
    //             'id'        => $request->contact_id
    //         ],
    //         [
    //             'contact_name' => $request->cantact_name,
    //             'phone_no' => $request->phone_no,
    //             'country_id' => $request->city_id,
    //             'state_id' => $request->state_id,
    //             'city_id' => $request->city_id,

    //         ]
    //     );

    //     return response()->json(['success' => 'Member saved successfully.']);
    // }
    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit($id)
    // {
    //     $contact = Contact::where('id', $id)->first();
    //     $countries = DB::table('countries')->orderBy('country_name', 'ASC')->get();
    //     $data['countries'] = $countries;

    //     //get states name
    //     $states = DB::table('states')->where('country_id', $contact->country_id)->orderBy('state_name', 'ASC')->get();
    //     $data['states'] = $states;

    //     //get cities name
    //     $cities = DB::table('cities')->where('state_id', $contact->state_id)->orderBy('city_name', 'ASC')->get();
    //     $data['cities'] = $cities;
    //     $con = Contact::find($id);
    //     return response()->json($con);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy($id)
    // {
    //     Contact::destroy($id);
    //     return response()->json(['success' => 'Member deleted successfully.']);
    // }
}
