<?php

namespace App\Http\Controllers\Api;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\ResultRequest;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Result=Result::get();
        return $Result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResultRequest $request)
    {
        // $data=$request->all();
        // $result=new Result($data);
        // //$result->save();
        return Result::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student=Student::findOrFail($id);
        $student->testresult;
        //  return 
        return response()->json($student->testresult);
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
        
        $result = Result::find($id);

        return response()->json($result->delete());

    }
}
