<?php

namespace App\Http\Controllers\study_material;

use App\Http\Controllers\Controller;
use App\Models\study_material\StudyMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudyMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $study_materials = StudyMaterial::latest()->get();
        return view('study_materials.index', compact('study_materials'));
    }

    /**
     * StudyMaterials Datatable
     */
    public function datatable()
    {
        $study_materials = StudyMaterial::all();

        return view('study_materials.partial.study_material_datatable', compact('study_materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('study_materials.create');
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
            'subject' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'doc_file' => $request->doc_file? 'required' : 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect(route('study_materials.index'))->with(['error' => 'Unsupported file format!']);
        }

        $input = $request->only(['date', 'subject']);

        try {
            $file = $request->file('doc_file');
            if ($file) $input['doc_file'] = $this->uploadFile($file);

            $study_material = StudyMaterial::create($input);

            return redirect(route('study_materials.index'))->with(['success' => 'Study Material created successfully']);
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
    public function show(StudyMaterial $study_material)
    {
        return view('study_materials.view', compact('study_material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StudyMaterial $study_material)
    {
        return view('study_materials.edit', compact('study_material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudyMaterial $study_material)
    {
        
        $request->validate([
            'date' => 'required',
            'subject' => 'required',
        ]);

        $validator = Validator::make($request->all(), [
            'doc_file' => $request->doc_file? 'required|mimes:csv,pdf,xls,xlsx,doc,docx' : 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect(route('study_materials.index'))->with(['error' => 'Unsupported file format!']);
        }

        $input = $request->only(['date', 'subject']);


        try {
            $file = $request->file('doc_file');
            if ($file) {
                $this->deleteFile($study_material->doc_file);
                $input['doc_file'] = $this->uploadFile($file);
            }

            $study_material->update($input);    

            return redirect(route('study_materials.index'))->with(['success' => 'Study Material updated successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error updated study_material!', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudyMaterial $study_material)
    {
        try {
            $this->deleteFile($study_material->doc_file);
            $study_material->delete();
            return redirect(route('study_materials.index'))->with(['success' => 'Study Material deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting study material!', $th);
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
            $study_material = StudyMaterial::find($request->study_material_id);
            $this->deleteFile($study_material[$request->field]);
            $study_material->update([$request->field => null]);

            return response()->json(['success' => true, 'message' => 'File deleted successfully', 'redirectTo' => route('study_materials.show', $study_material)]);
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
        $file_path = 'study_material' . DIRECTORY_SEPARATOR;
        Storage::disk('public')->put($file_path . $file_name, file_get_contents($file->getRealPath()));
        return $file_name;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile($file_name)
    {
        $file_path = 'study_material' . DIRECTORY_SEPARATOR;
        $file_exists = Storage::disk('public')->exists($file_path . $file_name);
        if ($file_exists) Storage::disk('public')->delete($file_path . $file_name);
        return $file_exists;
    }
}
