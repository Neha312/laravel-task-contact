<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    //listing of countries
    public function index()
    {
        $countries = Country::orderBy('country_name')->simplePaginate(5);
        return view('country/index', ['countries' => $countries]);
    }
    //create user function
    public function countryCreate(Request $request)
    {
        //validation
        $request->validate([
            'country_name' => 'required|alpha',
        ]);
        //create country
        Country::create($request->only('country_name'));
        return redirect('index')->with('status', 'Inserted Succesfully');
    }
    //edit country function
    public function countryEdit($id)
    {
        $country = Country::findOrFail($id);
        return view('country/edit', ['country' =>  $country]);
    }
    //update country function
    public function countryUpdate(Request $request, $id)
    {
        //validation
        $this->validate($request, ['country_name' => 'required|string']);
        //update country
        Country::findOrFail($id)->update($request->only('country_name'));
        return redirect('index')->with('status', 'Updated Succesfully');
    }
    //delete country function
    public function countryDelete($id)
    {
        //delete country with state ,city & contact
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
        return redirect('index')->with('status', 'Deleted Succesfully');
    }
}
