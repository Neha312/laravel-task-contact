<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function home()
    {
        return view('home');
    }
    //user login function
    public function login(Request $request)
    {
        //validation
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|min:8'
        ]);
        //checkk credntails
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('home');
        }
        return redirect('login')->with('error', 'Invalid credentials');
    }
    //register page
    public function register_view()
    {
        return view('auth.register');
    }
    //register user functions
    public function register(Request $request)
    {
        //validation
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed|min:8'
        ]);
        //save in database
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        return redirect('login')->with('success', 'User Register Succesfully');
    }
    //logout function
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
    //Change Password blade file
    public function changePassword()
    {
        return view('auth.change-password');
    }
    //Change Password Function
    public function updatePassword(Request $request)
    {
        // # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        // #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        // #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
}
