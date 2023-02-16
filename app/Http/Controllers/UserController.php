<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{

    public function login_view()
    {
        return view('auth.login');
    }
    public function home()
    {
        $result = DB::select("SELECT product_type, COUNT(*) as total_product,product_type FROM products GROUP BY product_type");
        $chartData = "";
        foreach ($result as $list) {
            $chartData .= "['" . $list->product_type . " '," . $list->total_product . " ],";
        }
        $grp['chartData'] = rtrim($chartData, ",");

        $result = DB::select("SELECT COUNT(*) as
        total_product,product_type FROM products GROUP BY product_type");
        $graphData = "";
        foreach ($result as $list) {
            $graphData .= "['" . $list->product_type . " '," . $list->total_product . " ],";
        }
        $grp['graphData'] = rtrim($graphData, ",");

        // dd($grp, $arr);
        return view('home', ['grp' => $grp]);
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
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password.");
        }

        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            // Current password and new password same
            return redirect()->back()->with("error", "New Password cannot be same as your current password.");
        }

        $request->validate([
            'current-password' => 'required',
            'new-password'     => 'required|confirmed|min:8',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success", "Password successfully changed!");
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
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm editUser">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user.crud');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::updateOrCreate(
            [
                'id'        => $request->user_id
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
            ]
        );

        return response()->json(['success' => 'Member saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['success' => 'Member deleted successfully.']);
    }
}
