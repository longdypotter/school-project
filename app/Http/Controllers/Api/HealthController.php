<?php

namespace App\Http\Controllers\Api;
use App\Models\Health;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HealthRequest;
class HealthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 'hi';
        $health=Health::get();
        return $health;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HealthRequest $request)
    {
        // $data=$request->all();
        // $health=new Health($data);
        // $health->save();
        // return $health;
        // return response()->json($health->save());
        return Health::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $student=\App\Models\Student::findOrFail($id);
        // $student->healths;
        // return response()->json($student->healths);

        $student=\App\Models\Student::findOrFail($id);
        $student->healths;
        //  return 
        return response()->json($student->healths);
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
        
        $health = health::find($id);

        return response()->json($health->delete());

    }
}
