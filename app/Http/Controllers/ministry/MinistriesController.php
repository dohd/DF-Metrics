<?php

namespace App\Http\Controllers\ministry;

use App\Http\Controllers\Controller;
use App\Models\item\ProposalItem;
use App\Models\ministry\Ministry;
use Illuminate\Http\Request;

class MinistriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ministries = Ministry::latest()->get();

        return view('ministries.index', compact('ministries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ministries.create');
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
            Ministry::create($data);
            return redirect(route('ministries.index'))->with(['success' => 'Ministry created successfully']);
        } catch (\Throwable $th) {
           return errorHandler('Error creating Ministry!', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ministry $ministry)
    {
        $proposal_items = ProposalItem::whereHas('proposal', function ($q) use($ministry) {
            $q->whereHas('action_plans', fn($q) => $q->where('ministry_id', $ministry->id));
        })
        ->whereHas('participant_lists', fn($q) => $q->where('total_count', '>', 0))
        ->with(['participant_lists' => fn($q) => $q->where('total_count', '>', 0)])
        ->with('participant_regions')
        ->get();
        // append regions and dates 
        foreach ($proposal_items as $item) {
            $item->regions = $item->participant_regions->pluck('name')->toArray();
            $item->dates = $item->participant_lists->pluck('date')->toArray();
            $item->dates = array_map(fn($v) => dateFormat($v), $item->dates);
        }
        
        return view('ministries.view', compact('ministry', 'proposal_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ministry $ministry)
    {
        return view('ministries.edit', compact('ministry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ministry $ministry)
    {
        $request->validate(['name' => 'required']);
        $data = $request->only(['name']);

        try {            
            if ($ministry->update($data)) 
            return redirect(route('ministries.index'))->with(['success' => 'Ministry updated successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error updating Ministry!', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ministry $ministry)
    {
        try {            
            $ministry->delete();
            return redirect(route('ministries.index'))->with(['success' => 'Ministry deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting Ministry!', $th);
        }
    }
}
