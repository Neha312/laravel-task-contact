<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function Showcity()
    {
        $cities = City::simplepaginate(5);
        $states = State::all();
        return view('city/index', ['cities' => $cities], ['states' => $states]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'city_name' => 'required|alpha',
        ]);
        City::create($request->only('city_name', 'state_id'));
        return redirect('Showcity')->with('status', 'Inserted Succesfully');
    }
    public function edit($id)
    {
        $city = City::findOrFail($id);
        return view('city/edit', ['city' =>  $city]);
    }
    public function update(Request $request, $id)
    {
        City::findOrFail($id)->update($request->only('city_name'));
        return redirect('Showcity')->with('status', 'Updated Succesfully');
    }
    public function delete($id)
    {
        City::destroy($id);
        return redirect('Showcity')->with('status', 'Deleted Succesfully');
    }
}
