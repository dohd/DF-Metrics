<?php

namespace App\Http\Controllers\narrative;

use App\Http\Controllers\Controller;
use App\Models\narrative\Narrative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NarrativesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $narratives = Narrative::latest()->get();
        return view('narratives.index', compact('narratives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('narratives.create');
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

        $input = $request->except('_token');
        
        try {
            $input = inputClean($input); 
            $narrative = Narrative::create($input); 

            return response()->json(['success' => true, 'message' => 'Narrative created successfully', 'redirectTo' => route('narratives.index', $narrative)]);
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
        return view('narratives.edit', compact('narrative'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
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
        
        $input = $request->except('_token');

        try {
            $input = inputClean($input); 
            $narrative->update($input);

            return response()->json(['success' => true, 'message' => 'Narrative updated successfully', 'redirectTo' => route('narratives.index', $narrative)]);
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
    public function destroy(Narrative $narrative)
    { 
        try {
            $narrative->delete();
            return redirect(route('narratives.index'))->with(['success' => 'Narrative deleted successfully']);
        } catch (\Throwable $th) {
            return errorHandler('Error deleting testimonial!', $th);
        }
    }
}
