<?php

namespace App\Http\Controllers\department;

use App\Http\Controllers\Controller;
use App\Models\department\Department;
use App\Models\item\ProposalItem;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::latest()->get();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.create');
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
            Department::create($data);
            return redirect(route('departments.index'))->with(['success' => 'Department created successfully']);
        } catch (\Throwable $th) {
           return errorHandler('Error creating Department!', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $proposal_items = ProposalItem::whereHas('proposal', function ($q) use($department) {
            $q->whereHas('action_plans', fn($q) => $q->where('department_id', $department->id));
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
        
        return view('departments.view', compact('department', 'proposal_items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $request->validate(['name' => 'required']);
        $data = $request->only(['name']);

        try {            
            if ($department->update($data)) 
            return redirect(route('departments.index'))->with(['success' => 'Department updated successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error updating Department!', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        try {            
            $department->delete();
            return redirect(route('departments.index'))->with(['success' => 'Department deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting Department!', $th);
        }
    }
}
