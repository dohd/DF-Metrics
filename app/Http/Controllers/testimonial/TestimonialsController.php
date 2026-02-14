<?php

namespace App\Http\Controllers\testimonial;

use App\Http\Controllers\Controller;
use App\Models\age_group\AgeGroup;
use App\Models\testimonial\Testimonial;
use App\Models\programme\Programme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::latest()->get();

        return view('testimonials.index', compact('testimonials'));
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

        return view('testimonials.create', compact('programmes', 'ageGroups'));
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
            $errors = $validator->errors(); // This is a MessageBag
            $errorMessages = $errors->all();
            return response()->json([
                'status' => 'error', 
                'message' => 'Validation failed! ' . implode(', ', $errorMessages),
                'errors' => $errors
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'image1' => $request->image1? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image2' => $request->image2? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image3' => $request->image3? 'required|mimes:png,jpg,jpeg' : 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Unsupported image format! Use png, jpg or jpeg'
            ], 422);
        }

        try {
            $input = $request->except('_token');
            $images = $request->only('image1', 'image2', 'image3');
            foreach ($images as $key => $value) {
                $file = $request->file($key);
                if ($file) {
                    $file_name = $this->uploadFile($file);
                    $input[$key] = $file_name;
                }
            }

            $input = inputClean($input); 
            $testimonial = Testimonial::create($input); 

            return response()->json(['success' => true, 'message' => 'Testimonial created successfully', 'redirectTo' => route('testimonials.index', $testimonial)]);
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
    public function show(Testimonial $testimonial)
    {
        return view('testimonials.view', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validator = Validator::make($request->all(), [
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
            $errors = $validator->errors(); // This is a MessageBag
            $errorMessages = $errors->all();
            return response()->json([
                'status' => 'error', 
                'message' => 'Validation failed! ' . implode(', ', $errorMessages),
                'errors' => $errors
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'image1' => $request->image1? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image2' => $request->image2? 'required|mimes:png,jpg,jpeg' : 'nullable',
            'image3' => $request->image3? 'required|mimes:png,jpg,jpeg' : 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Unsupported image format! Use png, jpg or jpeg'
            ], 422);
        }

        try {
            $input = $request->except('_token');
            $images = $request->only('image1', 'image2', 'image3');
            foreach ($images as $key => $value) {
                $file = $request->file($key);
                if ($file) {
                    $file_name = $this->uploadFile($file);
                    $input[$key] = $file_name;
                }
            }

            $input = inputClean($input); 
            $testimonial->update($input);

            return response()->json(['success' => true, 'message' => 'Testimonial updated successfully', 'redirectTo' => route('testimonials.index', $testimonial)]);
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
    public function destroy(Testimonial $testimonial)
    { 
        try {
            $testimonial->delete();
            return redirect(route('testimonials.index'))->with(['success' => 'Testimonial deleted successfully']);
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
            $testimonial = Testimonial::find($request->testimonial_id);
            $this->deleteFile($testimonial[$request->field]);
            $testimonial->update([$request->field => null]);

            return response()->json(['success' => true, 'message' => 'Image deleted successfully', 'redirectTo' => route('testimonials.show', $testimonial)]);
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
        $file_path = 'images' . DIRECTORY_SEPARATOR . 'testimonials' . DIRECTORY_SEPARATOR;
        Storage::disk('public')->put($file_path . $file_name, file_get_contents($file->getRealPath()));
        return $file_name;
    }

    /**
     * Delete file from storage
     */
    public function deleteFile($file_name)
    {
        $file_path = 'images' . DIRECTORY_SEPARATOR . 'testimonials' . DIRECTORY_SEPARATOR;
        $file_exists = Storage::disk('public')->exists($file_path . $file_name);
        if ($file_exists) Storage::disk('public')->delete($file_path . $file_name);
        return $file_exists;
    }
}
