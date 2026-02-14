<?php

namespace App\Http\Controllers\age_group;

use App\Http\Controllers\Controller;
use App\Models\age_group\AgeGroup;
use App\Models\item\ProposalItem;
use Illuminate\Http\Request;

class AgeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $age_groups = AgeGroup::latest()->get();

        return view('age_groups.index', compact('age_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('age_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate(['bracket' => 'required']);
        $data = $request->only(['bracket']);

        try {            
            AgeGroup::create($data);
            return redirect(route('age_groups.index'))->with(['success' => 'Age Group created successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error creating Age Group!', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AgeGroup $age_group)
    {
        $proposal_items = ProposalItem::whereHas('participants', fn($q) => $q->where('age_group_id', $age_group->id))
        ->with(['participants' => fn($q) => $q->where('age_group_id', $age_group->id)])
        ->with('participant_regions')
        ->get();
        // append regions and dates 
        foreach ($proposal_items as $item) {
            $item->regions = $item->participant_regions->pluck('name')->toArray();
            $item->dates = $item->participants->pluck('date')->toArray();
            $item->dates = array_map(fn($v) => dateFormat($v), $item->dates);
        }

        return view('age_groups.view', compact('age_group', 'proposal_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AgeGroup $age_group)
    {
        return view('age_groups.edit', compact('age_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgeGroup $age_group)
    {
        $request->validate(['bracket' => 'required']);
        $data = $request->only(['bracket']);

        try {            
            $age_group->update($data);
            return redirect(route('age_groups.index'))->with(['success' => 'Age Group updated successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error updating Age Group!', $th);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgeGroup $age_group)
    {
        try {            
            $age_group->delete();
            return redirect(route('age_groups.index'))->with(['success' => 'Age Group deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting Age Group!', $th);
        }  
    }
}
