<?php

namespace App\Http\Controllers\api;
use App\Models\StudentFollowup;
use App\Models\Student;
use App\Http\Requests\StudentFollowupRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentFollowupController extends Controller
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
    public function store(StudentFollowupRequest $request)
    {
        return StudentFollowup::create($request->all());
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
        $student->studentfollowups;
        return response()->json($student->studentfollowups);
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
    public function deletefile($id)
    {
        $followup= \App\Models\StudentFollowup::findOrFail($id);
        return response()->json($followup->delete());
    }
}
