<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


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
        //Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        //Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        //Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }
    //forget password page
    public function forget()
    {
        return view('auth.forget-password');
    }
    //forget password function
    public function forgetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = Str::random(40);
        $domain = URL::to('/');
        $url = $domain . '/reset-password?token=' . $token;
        if ($user) {
            $data['url'] = $url;
            $data['email'] = $user->email;
            $data['title'] = 'Password Reset';
            $data['body'] = 'Please click on below link to reset password ';
            PasswordReset::create([
                'email' => $user->email,
                'token' => $token
            ]);
            Mail::to($user->email)->send(new ForgotPasswordMail($data));
            return back()->with('success', 'Please check your mail to reset your password');
        } else {
            return back()->with('error', 'Email Not Exists!');
        }
    }
    // check token in reset password function
    public function reset(Request $request)
    {
        $pwd = PasswordReset::where('token', $request->token)->first();
        if ($pwd) {
            $user = User::where('email', $pwd->email)->first();
            $pwd->delete();
            return view('auth.resetPassword', ['data' => $user]);
        } else {
            return view('404');
        }
    }
    //reset password function
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);
        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('login');
    }
    //user list function
    public function list(Request $request)
    {
        // $users = User::all();
        if ($request->ajax()) {
            $data = User::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" name="edit" id="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</button> &nbsp;<button type="button" name="delete" id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('new.user');
    }
    //create user view file
    public function createUser()
    {
        return view('new.create');
    }
    //create user function
    public function addUser(Request $request)
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
        return redirect('list')->with('success', 'User Register Succesfully');
    }
    //edit user function
    public function editUser($id)
    {
        $users = User::findOrFail($id);
        return view('new/edit', ['users' =>  $users]);
    }
    //update user function
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required',
        ]);
        User::findOrFail($id)->update($request->only('name', 'email'));
        return redirect('list')->with('success', 'Updated Succesfully');
    }
    //delete user function
    public function deleteUser($id)
    {
        User::destroy($id);
        return redirect('list')->with('success', 'Deleted Succesfully');
    }
}
