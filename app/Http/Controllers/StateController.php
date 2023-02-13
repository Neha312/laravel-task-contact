<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;

class StateController extends Controller
{
    //listing of states
    public function Showstate()
    {
        $states = State::simplepaginate(5);
        $countries = Country::all();
        return view('state/index', ['states' => $states], ['countries' => $countries]);
    }
    //create state function
    public function stateCreate(Request $request)
    {
        //validation
        $request->validate([
            'state_name' => 'required|alpha',
        ]);
        //create state
        State::create($request->only('state_name', 'country_id'));
        return redirect('Showstate')->with('status', 'Inserted Succesfully');
    }
    //edit states
    public function stateEdit($id)
    {
        $state = State::findOrFail($id);
        return view('state/edit', ['state' =>  $state]);
    }
    //update states
    public function stateUpdate(Request $request, $id)
    {
        //validation
        $this->validate($request, ['state_name' => 'required|string']);
        //update states
        State::findOrFail($id)->update($request->only('state_name'));
        return redirect('Showstate')->with('status', 'Updated Succesfully');
    }
    //delete states
    public function stateDelete($id)
    {
        //delete state with contact & city
        $state = State::findOrFail($id);
        if ($state->cities()->count() > 0) {
            $state->contacts()->delete();
            $state->cities()->delete();
        }
        $state->delete();
        return redirect('Showstate')->with('status', 'Deleted Succesfully');
    }
}
