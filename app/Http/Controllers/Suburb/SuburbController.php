<?php

namespace App\Http\Controllers\Suburb;

use App\DataTables\Admin\SuburbsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Suburb;
use Illuminate\Http\Request;

class SuburbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SuburbsDataTable $dataTable): mixed
    {
        return $dataTable->render('template.admin.datatable.datatable', ['title' => 'Suburbs']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.admin.suburbs.create_suburb');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'suburb' => ['required','string', 'unique:suburbs'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $suburb = Suburb::create([
            'suburb' => $request->suburb,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => $request->status,
        ]);
        return back()->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Suburb $suburb)
    {
        //dd($suburb);
        return view('template.admin.suburbs.edit_suburb', compact('suburb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suburb $suburb)
    {
        $request->validate([
            'suburb' => ['required','string'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
        ]);

        $suburb->suburb = $request->suburb;
        $suburb->latitude = $request->latitude;
        $suburb->longitude = $request->longitude;
        //dd($request->all());
        $suburb->status = boolval($request->status);
        $suburb->save();
        return back()->with('success', 'Updated  successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suburb $suburb)
    {
        $suburb->delete();
        return back()->with('success', 'Deleted  successfully');

    }
}
