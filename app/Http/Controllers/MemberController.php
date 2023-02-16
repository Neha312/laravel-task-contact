<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Member::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-success btn-sm editMember">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteMember">Delete</a>';

                    return $btn;
                })
                ->addColumn('checkbox', '<input type="checkbox" name="users_checkbox[]" class="users_checkbox" value="{{$id}}" />')
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }

        return view('member.memberAjax');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Member::updateOrCreate(
            [
                'id'        => $request->member_id
            ],
            [
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname
            ]
        );

        return response()->json(['success' => 'Member saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $member = Member::find($id);
        return response()->json($member);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Member::find($id)->delete();
        return response()->json(['success' => 'Member deleted successfully.']);
    }
    public function removeall(Request $request)
    {
        $member_id_array = $request->input('id');
        $member = Member::whereIn('id', $member_id_array);
        if ($member->delete()) {
            echo 'Data Deleted';
        }
    }
    public function records(Request $request)
    {
        if ($request->ajax()) {

            if ($request->input('start_date') && $request->input('end_date')) {

                $start_date = Carbon::parse($request->input('start_date'));
                $end_date = Carbon::parse($request->input('end_date'));

                if ($end_date->greaterThan($start_date)) {
                    $students = Member::whereBetween('created_at', [$start_date, $end_date])->get();
                } else {
                    $students = Member::latest()->get();
                }
            } else {
                $students = Member::latest()->get();
            }

            return response()->json([
                'students' => $students
            ]);
        } else {
            abort(403);
        }
    }
    public function report(Request $request)
    {
        dd($request->all());
        // if (Auth::guest()) {
        //     return redirect()->route('/');
        // }
        $fromdate = $request->fromdate;
        // dd($fromdate);
        $todate = $request->todate;
        // $firstname = $request->firstname;

        $data = DB::select("SELECT * FROM `members` WHERE created_at BETWEEN '$fromdate 00:00:00' AND '$todate 00:00:00'");
        return view('member.memberAjax', compact('data'));
    }
}
