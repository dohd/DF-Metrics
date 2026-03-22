<?php

namespace App\Http\Controllers\memberlist;

use App\Http\Controllers\Controller;
use App\Models\age_group\AgeGroup;
use App\Models\department\Department;
use App\Models\dfname\DFName;
use App\Models\memberlist\Memberlist;
use App\Models\ministry\Ministry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            'dfname_id' => 'required|unique:memberlists,dfname_id',
            'memberlist_items' => 'required|array|min:1',
        ],
        [
            'dfname_id.unique' => 'This DF Name already exists',
        ]);

        $input = $request->only('date', 'dfname_id');
        $inputItems = $request->memberlist_items;
       
        try {
            DB::beginTransaction();

            // create memberlist
            $input = inputClean($input); 
            $memberlist = Memberlist::create($input); 

            // create memberlist items
            foreach ($inputItems as $value) {
                unset($value['memberlist_item_id']);
               $memberlist->items()->create($value);
            }

            // create team
            $team = $memberlist->team()->create([
                'dfname_id' => $memberlist->dfname->id,
                'name' => $memberlist->dfname->name,
            ]);
            // create team members
            foreach ($memberlist->items as $item) {
                $team->members()->create([
                    'memberlist_item_id' => $item->id,
                    'full_name' => $item->member_name,
                    'df_name' => $memberlist->dfname->name,
                    'phone_no' => $item->phone_no,
                    'physical_addr' => $item->residence,
                ]);
            }

            DB::commit();
            return redirect(route('memberlists.index'))->with(['success' => 'Member List created successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error creating Member List!', $th);
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
            'dfname_id' => 'required|unique:memberlists,dfname_id,' . $memberlist->id . ',id',
            'memberlist_items' => 'required|array|min:1',
        ],
        [
            'dfname_id.unique' => 'The selected DF Name already exists',
        ]);

        $input = $request->only('date', 'dfname_id');
        $inputItems = $request->memberlist_items;
       
        try {
            DB::beginTransaction();

            // create memberlist
            $input = inputClean($input); 
            $memberlist->update($input); 

            // create memberlist items
            foreach ($inputItems as $value) {
                $id = $value['memberlist_item_id'];
                unset($value['memberlist_item_id']);
                if (empty($id)) $memberlist->items()->create($value);
                else $memberlist->items()->where('id', $id)->update($value); 
            }

            // create team if none exists
            if (empty($memberlist->team)) {
                $team = $memberlist->team()->create([
                    'dfname_id' => $memberlist->dfname->id,
                    'name' => $memberlist->dfname->name,
                ]);
                // create team members
                foreach ($memberlist->items as $item) {
                    $team->members()->create([
                        'memberlist_item_id' => $item->id,
                        'full_name' => $item->member_name,
                        'df_name' => $memberlist->dfname->name,
                        'phone_no' => $item->phone_no,
                        'physical_addr' => $item->residence,
                    ]);
                }                
            } else {
                $memberlist->team()->update(['name' => $memberlist->dfname->name]);
                foreach ($memberlist->items as $item) {
                    $memberlist->team->members()
                    ->updateOrCreate(['memberlist_item_id' => $item->id], [
                        'full_name' => $item->member_name,
                        'df_name' => $memberlist->dfname->name,
                        'phone_no' => $item->phone_no,
                        'physical_addr' => $item->residence,
                    ]);                                        
                }
            }

            DB::commit();
            return redirect(route('memberlists.index'))->with(['success' => 'Member List updated successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error updating Member List!', $th);
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
        if ($memberlist->team) {
            return errorHandler('Member list has an associated team #' . tidCode('', $memberlist->team->tid));
        }

        try {
            DB::beginTransaction();

            $memberlist->team->members()->delete();
            $memberlist->team()->delete();

            $memberlist->items()->delete();
            $memberlist->delete();

            DB::commit();
            return redirect(route('memberlists.index'))->with(['success' => 'Member List deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting Member List!', $th);
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
