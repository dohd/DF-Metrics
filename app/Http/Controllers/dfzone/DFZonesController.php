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
        $zones = collect();
        return view('dfzones.create', compact('zones'));
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
        $data = $request->only(['name']);

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
        $proposal_items = ProposalItem::whereHas('participant_lists', function ($q) use($dfzone) {
            $q->where('region_id', $dfzone->id)->where('total_count', '>', 0);
        })
        ->with(['participant_lists' => fn($q) => $q->where('region_id', $dfzone->id)->where('total_count', '>', 0)])
        ->with('participant_regions')
        ->get();
        // append regions and dates 
        foreach ($proposal_items as $item) {
            $item->regions = $item->participant_regions->pluck('name')->toArray();
            $item->dates = $item->participant_lists->pluck('date')->toArray();
            $item->dates = array_map(fn($v) => dateFormat($v), $item->dates);
        }

        return view('dfzones.view', compact('dfzone', 'proposal_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DFZone $dfzone)
    {
        $zones = collect();
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
        $data = $request->only(['name']);

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
