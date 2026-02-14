<?php

namespace App\Http\Controllers\narrative;

use App\Http\Controllers\Controller;
use App\Models\age_group\AgeGroup;
use App\Models\agenda\Agenda;
use App\Models\item\NarrativeItem;
use App\Models\narrative\Narrative;
use App\Models\narrative_pointer\NarrativePointer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NarrativeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $narratives = Narrative::latest()->get();
        $status_grp = Narrative::selectRaw('status, COUNT(*) as count')->groupBy('status')->pluck('count', 'status');

        return view('narratives.index', compact('narratives', 'status_grp'));
    }

    /**
     * Narratives Datatable
     */
    public function datatable()
    {
        $narratives = Narrative::all();

        return view('narratives.partial.narrative_datatable', compact('narratives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agenda = collect();
        $narrative_pointers = collect();
        $ageGroups = AgeGroup::get(['id', 'bracket']);
        
        return view('narratives.create', compact('agenda', 'narrative_pointers', 'ageGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'date' => 'required',
            'subject' => 'required',
            'age_group_id' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'doc_file' => $request->doc_file? 'required|mimes:csv,pdf,xls,xlsx,doc,docx' : 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect(route('narratives.index'))->with(['error' => 'Unsupported file format!']);
        }

        $data = $request->only(['date', 'subject', 'age_group_id']);
        $data_items = $request->only(['agenda_item_id', 'narrative_pointer_id', 'response']);

        $file = $request->file('doc_file');
        if ($file) $data['doc_file'] = $this->uploadFile($file);

        DB::beginTransaction();

        try {
            $narrative = Narrative::create($data);

            $data_items = databaseArray($data_items);
            $data_items = fillArrayRecurse($data_items, [
                'narrative_id' => $narrative->id, 
            ]);
            NarrativeItem::insert($data_items);

            DB::commit();
            return redirect(route('narratives.index'))->with(['success' => 'Study Material created successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error creating study material!', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Narrative $narrative)
    {
        return view('narratives.view', compact('narrative'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Narrative $narrative)
    {
        $narrative_pointers = NarrativePointer::all();
        $narr_agenda = Agenda::find($narrative->agenda_id);
        $agenda = Agenda::doesntHave('narrative')->get();
        $agenda->add($narr_agenda);

        $ageGroups = AgeGroup::get(['id', 'bracket']);

        return view('narratives.edit', compact('agenda', 'narrative', 'narrative_pointers', 'ageGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Narrative $narrative)
    {
        if (request('status')) {
            try {
                $narrative->update(['status' => request('status')]);
                return redirect()->back()->with('success', 'Status updated successfully');
            } catch (\Throwable $th) {
                return errorHandler('Error updating status!', $th);
            }
        } else {
            // dd($request->all());
            $request->validate([
                'date' => 'required',
                'subject' => 'required',
                'age_group_id' => 'required',
            ]);

            $validator = Validator::make($request->all(), [
                'doc_file' => $request->doc_file? 'required|mimes:csv,pdf,xls,xlsx,doc,docx' : 'nullable',
            ]);
            if ($validator->fails()) {
                return redirect(route('narratives.index'))->with(['error' => 'Unsupported file format!']);
            }
    
            $data = $request->only(['date', 'subject', 'age_group_id']);
            $data_items = $request->only(['item_id', 'agenda_item_id', 'narrative_pointer_id', 'response']);

            $file = $request->file('doc_file');
            if ($file) {
                $this->deleteFile($narrative->doc_file);
                $data['doc_file'] = $this->uploadFile($file);
            }

            DB::beginTransaction();
    
            try {
                $narrative->update($data);
    
                $data_items = databaseArray($data_items);
                foreach ($data_items as $item) {
                    $narr_item = NarrativeItem::find($item['item_id']);
                    unset($item['item_id']);
                    $narr_item->update($item);
                }
                
                DB::commit();
                return redirect(route('narratives.index'))->with(['success' => 'Study Material updated successfully']);
            } catch (\Throwable $th) {
                return errorHandler('Error updated narrative!', $th);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Narrative $narrative)
    {
        try {
            $this->deleteFile($narrative->doc_file);
            $narrative->delete();
            return redirect(route('narratives.index'))->with(['success' => 'Study Material deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting study material!', $th);
        }
    }

    /**
     * Narrative select options
     */
    public function narrative_items()
    {
        $narrative_items = NarrativeItem::where('narrative_id', request('narrative_id'))
            ->orderBy('row_index', 'asc')
            ->get();
    
        return view('action_plans.partials.narrative_items', compact('narrative_items'));
    }

    /**
     * Narrative Form Table
     */
    public function narrative_table(Request $request)
    {
        $agenda = Agenda::find($request->agenda_id);
        $narrative = Narrative::find($request->narrative_id);
        $narrative_pointers = NarrativePointer::all();

        return view('narratives.partial.narrative_table', compact('agenda', 'narrative', 'narrative_pointers'));
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
            $narrative = Narrative::find($request->narrative_id);
            $this->deleteFile($narrative[$request->field]);
            $narrative->update([$request->field => null]);

            return response()->json(['success' => true, 'message' => 'File deleted successfully', 'redirectTo' => route('narratives.show', $narrative)]);
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
        $file_path = 'narrative' . DIRECTORY_SEPARATOR;
        Storage::disk('public')->put($file_path . $file_name, file_get_contents($file->getRealPath()));
        return $file_name;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile($file_name)
    {
        $file_path = 'narrative' . DIRECTORY_SEPARATOR;
        $file_exists = Storage::disk('public')->exists($file_path . $file_name);
        if ($file_exists) Storage::disk('public')->delete($file_path . $file_name);
        return $file_exists;
    }
}
