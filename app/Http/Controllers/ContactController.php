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
    public function index()
    {
        $data['countries'] = Country::get(["country_name", "id"]);
        return view('dropdown', $data);
    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["state_name", "id"]);
        return response()->json($data);
    }
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["city_name", "id"]);
        return response()->json($data);
    }
    public function Showcontact()
    {
        $contacts    = Contact::simplepaginate(5);
        $countries   = Country::all();
        $states      = State::all();
        $cities      = City::all();
        return view('contact/index', ['contacts' => $contacts], ['countries' => $countries], ['states' => $states], ['cities' => $cities]);
    }
    public function Contactcreate(Request $request)
    {

        $request->validate([
            'contact_name' => 'required|alpha',
            'phone_no'     => 'required|numeric|min:10',

        ]);
        Contact::create($request->only('contact_name', 'phone_no', 'country_id', 'state_id', 'city_id'));
        return redirect('Showcontact')->with('status', 'Inserted Succesfully');
    }
    public function Contactedit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact/edit', ['contact' =>  $contact]);
    }
    public function Contactupdate(Request $request, $id)
    {
        $request->validate([
            'contact_name' => 'required|alpha',
            'phone_no' => 'required|numeric|min:10',

        ]);
        Contact::findOrFail($id)->update($request->only('contact_name', 'phone_no'));
        return redirect('Showcontact')->with('status', 'Updated Succesfully');
    }
    public function Contactdelete($id)
    {
        Contact::destroy($id);
        return redirect('Showcontact')->with('status', 'Deleted Succesfully');
    }
}
