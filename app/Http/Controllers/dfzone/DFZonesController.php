<?php

namespace App\Http\Controllers\dfzone;

use App\Http\Controllers\Controller;
use App\Models\dfzone\DFZone;
use App\Models\item\ProposalItem;
use Illuminate\Http\Request;

class DFZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dfzones = DFZone::latest()->get();
        return view('dfzones.index', compact('dfzones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dfzones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $data = $request->except('_token');

        try {            
            DFZone::create($data);
            return redirect(route('dfzones.index'))->with(['success' => 'DF Zone created successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error creating DF Zone!', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DFZone $dfzone)
    {
        return view('dfzones.view', compact('dfzone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DFZone $dfzone)
    {
        return view('dfzones.edit', compact('dfzone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DFZone $dfzone)
    {
        $request->validate(['name' => 'required']);
        $data = $request->except('_token');

        try {            
            $dfzone->update($data);
            return redirect(route('dfzones.index'))->with(['success' => 'DF Zone updated successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error updating DF Zone!', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DFZone $dfzone)
    {
        try {            
            $dfzone->delete();
            return redirect(route('dfzones.index'))->with(['success' => 'DF Zone deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting DF Zone!', $th);
        }
    }
}
