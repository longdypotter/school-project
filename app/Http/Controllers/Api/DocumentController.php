<?php

namespace App\Http\Controllers\api;

use App\Models\File;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        $data=$request->all();
        return File::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $student = Student::findOrFail($id);

        return response()->json($student->file);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function deletefile($id){
        
        $file = File::find($id);

        return response()->json($file->delete());
    }
    public function showclass($id)
    {
        $class=\App\Models\Classes::find($id);
        //return 'hi';
       return response()->json($class);

    }
}
