<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    //listing of cities
    public function Showcity()
    {
        $cities = City::simplepaginate(5);
        $states = State::all();
        return view('city/index', ['cities' => $cities], ['states' => $states]);
    }

    //create city function
    public function create(Request $request)
    {
        //validation
        $request->validate([
            'city_name' => 'required|alpha',
        ]);
        //create city
        City::create($request->only('city_name', 'state_id'));
        return redirect('Showcity')->with('status', 'Inserted Succesfully');
    }
    //edit city function
    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('city/edit', ['city' =>  $city]);
    }
    //update city function
    public function update(Request $request, $id)
    {
        //Upddate city
        City::findOrFail($id)->update($request->only('city_name'));
        return redirect('Showcity')->with('status', 'Updated Succesfully');
    }
    //delete city function
    public function delete($id)
    {
        //delete city
        City::destroy($id);
        return redirect('Showcity')->with('status', 'Deleted Succesfully');
    }
}
