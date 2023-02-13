<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Contact;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    //fetch countries
    public function index()
    {
        //get countries  name
        $data['countries'] = Country::get(["country_name", "id"]);
        return view('dropdown', $data);
    }
    //fetch states
    public function fetchState(Request $request)
    {
        //get states name
        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["state_name", "id"]);
        return response()->json($data);
    }
    //fetch cities
    public function fetchCity(Request $request)
    {
        //get cities name
        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["city_name", "id"]);
        return response()->json($data);
    }
    //show contact function
    public function Showcontact()
    {
        $contacts    = Contact::simplepaginate(5);
        $countries   = Country::all();
        $states      = State::all();
        $cities      = City::all();
        return view('contact/index', ['contacts' => $contacts], ['countries' => $countries], ['states' => $states], ['cities' => $cities]);
    }
    //create contact
    public function Contactcreate(Request $request)
    {
        //validation
        $request->validate([
            'contact_name' => 'required|alpha',
            'phone_no'     => 'required|numeric|min:10',

        ]);
        //create contact
        Contact::create($request->only('contact_name', 'phone_no', 'country_id', 'state_id', 'city_id'));
        return redirect('Showcontact')->with('status', 'Inserted Succesfully');
    }
    //edit contact
    public function Contactedit($id)
    {
        //get countries name
        $contact = Contact::where('id', $id)->first();
        $countries = DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['countries'] = $countries;

        //get states name
        $states = DB::table('states')->where('country_id', $contact->country_id)->orderBy('state_name', 'ASC')->get();
        $data['states'] = $states;

        //get cities name
        $cities = DB::table('cities')->where('state_id', $contact->state_id)->orderBy('city_name', 'ASC')->get();
        $data['cities'] = $cities;

        //redirection
        if ($contact == null) {
            return redirect('Showcontact');
        }
        $data['contact'] = $contact;
        return view('contact/edit', $data);
    }
    //update contact
    public function Contactupdate(Request $request, $id)
    {
        //validation
        $request->validate([
            'contact_name' => 'required|alpha',
            'phone_no' => 'required|numeric|min:10',

        ]);
        //update contact
        Contact::findOrFail($id)->update($request->only('contact_name', 'phone_no', 'country_id', 'state_id', 'city_id'));
        return redirect('Showcontact')->with('status', 'Updated Succesfully');
    }
    //delete contact
    public function Contactdelete($id)
    {
        //delete contact
        Contact::destroy($id);
        return redirect('Showcontact')->with('status', 'Deleted Succesfully');
    }
}
