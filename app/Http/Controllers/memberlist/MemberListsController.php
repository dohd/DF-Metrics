<?php

namespace App\Http\Controllers\memberlist;

use App\Http\Controllers\Controller;
use App\Models\action_plan\ActionPlan;
use App\Models\age_group\AgeGroup;
use App\Models\cohort\Cohort;
use App\Models\department\Department;
use App\Models\dfname\DFName;
use App\Models\disability\Disability;
use App\Models\item\ProposalItem;
use App\Models\memberlist\Memberlist;
use App\Models\memberlist\MemberlistItem;
use App\Models\ministry\Ministry;
use App\Models\proposal\Proposal;
use App\Models\region\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MemberListsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memberlists = Memberlist::latest()->get();

        return view('memberlists.index', compact('memberlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $age_groups = AgeGroup::get(['id', 'bracket']);
        $dfnames = DFName::latest()->get(['id', 'name']);
        $ministries = Ministry::latest()->get(['id', 'name']);
        $departments = Department::latest()->get(['id', 'name']);
        
        return view('memberlists.create', compact('departments', 'ministries', 'dfnames', 'age_groups'));
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
            'date' => 'required',
            'dfname_id' => 'required',
        ]);

        $input = $request->only('date', 'dfname_id');
       
        try {
            DB::beginTransaction();

            $input = inputClean($input);
            $memberlist = Memberlist::create($input);

            $input_items = $request->memberlist_items;
            foreach ($input_items as $key => $value) {
                $input_items[$key] = array_replace($value, [
                    'memberlist_id' => $memberlist->id,
                ]);
            }
            MemberlistItem::insert($input_items);

            DB::commit();
            return redirect(route('memberlists.index'))->with(['success' => 'Family Member List created successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error creating Family Member List!', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Memberlist $memberlist)
    {
        return view('memberlists.view', compact('memberlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Memberlist $memberlist)
    {
        $dfnames = DFName::latest()->get(['id', 'name']);
        $ministries = Ministry::latest()->get(['id', 'name']);
        $departments = Department::latest()->get(['id', 'name']);
        $age_groups = AgeGroup::all();

        return view('memberlists.edit', compact('memberlist', 'dfnames', 'ministries', 'departments', 'age_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memberlist $memberlist)
    {
        $request->validate([
            'date' => 'required',
            'dfname_id' => 'required',
        ]);

        $input = $request->only('date', 'dfname_id');

        try {     
            DB::beginTransaction();

            $input = inputClean($input);
            $memberlist->update($input);

            $input_items = $request->memberlist_items;
            foreach ($input_items as $key => $value) {
                $input_items[$key] = array_replace($value, [
                    'memberlist_id' => $memberlist->id,
                ]);
            }
            $memberlist->items()->delete();
            MemberlistItem::insert($input_items);

            DB::commit();
            return redirect(route('memberlists.index'))->with(['success' => 'Family Member List updated successfully']);              
        } catch (\Throwable $th) {
            return errorHandler('Error updating Family Member List!', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memberlist $memberlist)
    {
        try {
            $memberlist->items()->delete();
            $memberlist->delete();
            return redirect(route('memberlists.index'))->with(['success' => 'Family Member List deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting Family Member List!', $th);
        }
    }

    /**
     * Remove the file from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_file(Request $request)
    { 
        try {
            $memberlist = Memberlist::find($request->memberlist_id);
            $this->deleteFile($memberlist[$request->field]);
            $memberlist->update([$request->field => null]);

            return response()->json(['success' => true, 'message' => 'File deleted successfully', 'redirectTo' => route('memberlists.show', $memberlist)]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Upload file to storage
     */
    public function uploadFile($file)
    {
        $file_name = time() . '_' . $file->getClientOriginalName();
        $file_path = 'memberlist' . DIRECTORY_SEPARATOR;
        Storage::disk('public')->put($file_path . $file_name, file_get_contents($file->getRealPath()));
        return $file_name;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile($file_name)
    {
        $file_path = 'memberlist' . DIRECTORY_SEPARATOR;
        $file_exists = Storage::disk('public')->exists($file_path . $file_name);
        if ($file_exists) Storage::disk('public')->delete($file_path . $file_name);
        return $file_exists;
    }
}
