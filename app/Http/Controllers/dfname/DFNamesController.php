<?php

namespace App\Http\Controllers\dfname;

use App\Http\Controllers\Controller;
use App\Models\dfname\DFName;
use App\Models\dfzone\DFZone;
use App\Models\item\ProposalItem;
use Illuminate\Http\Request;

class DFNamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dfnames = DFName::latest()->get();

        return view('dfnames.index', compact('dfnames'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dfzones = DFZone::latest()->get();
        return view('dfnames.create', compact('dfzones'));
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
        $data = $request->only(['name', 'dfzone_id']);

        try {            
            DFName::create($data);
            return redirect(route('dfnames.index'))->with(['success' => 'DF Name created successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error creating DF Name!', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DFName $dfname)
    {
        $proposal_items = ProposalItem::whereHas('participant_lists', function ($q) use($dfname) {
            $q->where('region_id', $dfname->id)->where('total_count', '>', 0);
        })
        ->with(['participant_lists' => fn($q) => $q->where('region_id', $dfname->id)->where('total_count', '>', 0)])
        ->with('participant_regions')
        ->get();
        // append regions and dates 
        foreach ($proposal_items as $item) {
            $item->regions = $item->participant_regions->pluck('name')->toArray();
            $item->dates = $item->participant_lists->pluck('date')->toArray();
            $item->dates = array_map(fn($v) => dateFormat($v), $item->dates);
        }

        return view('dfnames.view', compact('dfname', 'proposal_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DFName $dfname)
    {
        $dfzones = DFZone::latest()->get();
        return view('dfnames.edit', compact('dfname', 'dfzones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DFName $dfname)
    {
        $request->validate(['name' => 'required']);
        $data = $request->only(['name', 'dfzone_id']);

        try {            
            $dfname->update($data);
            return redirect(route('dfnames.index'))->with(['success' => 'DF Name updated successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error updating DF Name!', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DFName $dfname)
    {
        try {            
            $dfname->delete();
            return redirect(route('dfnames.index'))->with(['success' => 'DF Name deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting DF Name!', $th);
        }
    }
}
