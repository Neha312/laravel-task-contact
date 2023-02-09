<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function Showstate()
    {
        $states = State::simplepaginate(5);
        $countries = Country::all();
        return view('state/index', ['states' => $states], ['countries' => $countries]);
    }

    public function stateCreate(Request $request)
    {
        $request->validate([
            'state_name' => 'required|alpha',
        ]);
        State::create($request->only('state_name', 'country_id'));
        return redirect('Showstate')->with('status', 'Inserted Succesfully');
    }
    public function stateEdit($id)
    {
        $state = State::findOrFail($id);
        return view('state/edit', ['state' =>  $state]);
    }
    public function stateUpdate(Request $request, $id)
    {
        $this->validate($request, ['state_name' => 'required|string']);
        State::findOrFail($id)->update($request->only('state_name'));
        return redirect('Showstate')->with('status', 'Updated Succesfully');
    }
    public function stateDelete($id)
    {
        State::destroy($id);
        return redirect('Showstate')->with('status', 'Deleted Succesfully');
    }
}
