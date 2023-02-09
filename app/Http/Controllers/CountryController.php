<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->simplePaginate(5);
        return view('country/index', ['countries' => $countries]);
    }

    public function countryCreate(Request $request)
    {
        $request->validate([
            'country_name' => 'required|alpha',
        ]);
        Country::create($request->only('country_name'));
        return redirect('index')->with('status', 'Inserted Succesfully');
    }
    public function countryEdit($id)
    {
        $country = Country::findOrFail($id);
        return view('country/edit', ['country' =>  $country]);
    }
    public function countryUpdate(Request $request, $id)
    {
        $this->validate($request, ['country_name' => 'required|string']);
        Country::findOrFail($id)->update($request->only('country_name'));
        return redirect('index')->with('status', 'Updated Succesfully');
    }
    public function countryDelete($id)
    {
        Country::destroy($id);
        return redirect('index')->with('status', 'Deleted Succesfully');
    }
}
