<?php

namespace App\Http\Controllers\case_study;

use App\Http\Controllers\Controller;
use App\Models\age_group\AgeGroup;
use App\Models\case_study\CaseStudy;
use App\Models\programme\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CaseStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $case_studies = CaseStudy::latest()->get();

        return view('case_studies.index', compact('case_studies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programmes = Programme::get();
        $ageGroups = AgeGroup::get(['id', 'bracket']);

        return view('case_studies.create', compact('programmes', 'ageGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
            'full_name' => 'required',
            'situation' => 'required',
            'intervention' => 'required',
            'impact' => 'required',
        ], [
            'situation.required' => 'Introduction is required',
            'intervention.required' => 'Experience is required',
            'impact.required' => 'Personal transformation is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Input all required(*) fields'], 400);
        }

        $validator = Validator::make($request->all(), [
            'image1' => $request->image1? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image2' => $request->image2? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image3' => $request->image3? 'required|mimes:png,jpg,jpeg' : 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Unsupported image format! Use png, jpg or jpeg'], 400);
        }

        // dd($request->all());

        $input = $request->except('_token');
        $images = $request->only('image1', 'image2', 'image3');
        foreach ($images as $key => $value) {
            $file = $request->file($key);
            if ($file) {
                $file_name = $this->uploadFile($file);
                $input[$key] = $file_name;
            }
        }

        try {
            $input = inputClean($input); 
            $case_study = CaseStudy::create($input); 

            return response()->json(['success' => true, 'message' => 'Testimonial created successfully', 'redirectTo' => route('case_studies.edit', $case_study)]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CaseStudy $case_study)
    {
        return view('case_studies.view', compact('case_study'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CaseStudy $case_study)
    {
        $programmes = Programme::get();
        $ageGroups = AgeGroup::get(['id', 'bracket']);

        return view('case_studies.edit', compact('case_study', 'programmes', 'ageGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CaseStudy $case_study)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
            'full_name' => 'required',
            'situation' => 'required',
            'intervention' => 'required',
            'impact' => 'required',
        ], [
            'situation.required' => 'Introduction is required',
            'intervention.required' => 'Experience is required',
            'impact.required' => 'Personal transformation is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Input all required(*) fields'], 400);
        }

        $validator = Validator::make($request->all(), [
            'image1' => $request->image1? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image2' => $request->image2? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image3' => $request->image3? 'required|mimes:png,jpg,jpeg' : 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Unsupported image format! Use png, jpg or jpeg'], 400);
        }

        $input = $request->except('_token');
        $images = $request->only('image1', 'image2', 'image3');
        foreach ($images as $key => $value) {
            $file = $request->file($key);
            if ($file) {
                $file_name = $this->uploadFile($file);
                $input[$key] = $file_name;
            }
        }
        
        try {
            $input = inputClean($input); 
            $case_study->update($input);

            return response()->json(['success' => true, 'message' => 'Testimonial updated successfully']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()], 500);
        }
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CaseStudy $case_study)
    { 
        try {
            $case_study->delete();
            return redirect(route('case_studies.index'))->with(['success' => 'Testimonial deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting testimonial!', $th);
        }
    }

    /**
     * Remove the image from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete_image(Request $request)
    { 
        try {
            $case_study = CaseStudy::find($request->case_study_id);
            $this->deleteFile($case_study[$request->field]);
            $case_study->update([$request->field => null]);

            return response()->json(['success' => true, 'message' => 'Image deleted successfully', 'redirectTo' => route('case_studies.show', $case_study)]);
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
        $file_path = 'images' . DIRECTORY_SEPARATOR . 'case_studies' . DIRECTORY_SEPARATOR;
        Storage::disk('public')->put($file_path . $file_name, file_get_contents($file->getRealPath()));
        return $file_name;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile($file_name)
    {
        $file_path = 'images' . DIRECTORY_SEPARATOR . 'case_studies' . DIRECTORY_SEPARATOR;
        $file_exists = Storage::disk('public')->exists($file_path . $file_name);
        if ($file_exists) Storage::disk('public')->delete($file_path . $file_name);
        return $file_exists;
    }
}
