<?php

namespace App\Http\Controllers;

use App\Models\WomansClubRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WomansClubRequestController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        return view('admin.womans-club.index');
    }


    // Load all Woman's Club Request helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){

            $womans_club_requests = WomansClubRequest::latest()->get();

            return DataTables::of($womans_club_requests)
            ->addIndexColumn()
            ->addColumn('actions', function ($row){
                return '<a class="btn btn-sm btn-primary" href="'.route('womans-club.details',encrypt($row->id)).'"><i class="fa-solid fa-eye"><i></a>';
            })
            ->rawColumns(['actions'])
            ->make(true);
        }
    }


    // Show the form for creating a new resource.
    public function create()
    {
        //
    }


    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        //
    }


    // Display the specified resource.
    public function show($id)
    {
        try {
            $woman_club_request = WomansClubRequest::find(decrypt($id));
            return view('admin.womans-club.show', compact(['woman_club_request']));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Show the form for editing the specified resource.
    public function edit(WomansClubRequest $womansClubRequest)
    {
        //
    }


    // Update the specified resource in storage.
    public function update(Request $request, WomansClubRequest $womansClubRequest)
    {
        //
    }


    // Remove the specified resource from storage.
    public function destroy(WomansClubRequest $womansClubRequest)
    {
        //
    }
}
