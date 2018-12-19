<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exam;
class StudentExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $classid=$request->class;
        $name=$request->name;
        $exam_date=$request->exam_date;
        
       // dd($classid);
      
        //$exam = Exam::pluck('assign_subject_id');
        $exam=Exam::where('name',$name)->where('exam_date',$exam_date)->get();
        //dd($exam);
        $result=[];
        foreach($exam as $e)
        {
            // echo ($e->assign_subject_id);
            $getclass = \App\Models\AssignSubject::where('id', $e->assign_subject_id)->where('class_id', $classid)->get();
            foreach($getclass as $r):
            
                $result[] = $r->section;
                
            endforeach;
        }
        return ($result);
        // $as = \App\Models\AssignSubject::whereIn('id', $exam)->where('class_id', $classid)->get();
        // $result = [];
        // foreach($getclass as $r):
            
        //     $result[] = $r->section;
            
        // endforeach;
        // dd($result);
        
       //return $result;
        // $exam= Exam::get(); 
        // $getclasstosection=$exam->first()->assignsubject->where('class_id',$classid)->get();
        // $result = [];
        // foreach($getclasstosection as $getsection)
        // {
        //     $result[]=$getsection->section->name;
        // }
        // return $result;
       // Rresult[] = 
      // return response()->json($getclasstosection->);
        // foreach($getclasstosection as $s){
        //     return response()->json($s->section);
        // }
    //    return response()->json($getclasstosection);
       
        // $exam= Exam::whereHas('assignsubject',function($q) use($classid){
        //         $q->where('class_id',$classid);
        // })->get();
       
       
        // foreach($exam as $e)
        // {
        //     echo $e->assignsubject->section->name;
        // }
    }
    public function sectiontosubject(Request $request){
        // dd($request->all());
        $classid=$request->class_id;
        $sectionid=$request->section_id;
        $exam=Exam::pluck('assign_subject_id');
        //dd($exam);
        //$as = \App\Models\AssignSubject::whereIn('id', $exam)->where('class_id', $classid)->where('section_id',$sectionid)->get();
        $classsection=\App\Models\AssignSubject::where(function($q) use($exam,$classid,$sectionid){
            $q->whereIn('id',$exam);
            $q->where('class_id',$classid);
            $q->where('section_id',$sectionid);
        })->get();
        $result=[];
        foreach($classsection as $cs)
        {
            $result[]=$cs->subject;
        }
        return response()->json($result);
        //dd($classsection);
        //dd($classid);
    }

    public function nametoexamdate(Request $request)
    {
        // dd('nametoexamdate');
        // dd($request->name);
        $name=$request->name;
       
            $getexamdate=Exam::where('name',$name)->get();
            $result=[];
            foreach($getexamdate as $examdate)
            {
                    $result[]= $examdate->exam_date;
                    // dd($result);
            }
        
        return $result;
        
        
        // echo $getexamdate->exam_date;
        // return $getexamdate;
        
    }
    public function examdatetoclass(Request $request)
    {
        $name=$request->name;
        $getexamdate=$request->examdate;
        //class
        $examdate=Exam::where('exam_date',$getexamdate)->where('name',$name)->get();

        $result=[];
        foreach($examdate as $d)
        {
           
            $getClass=\App\Models\AssignSubject::where('id',$d->assign_subject_id)->get();

            foreach($getClass as $s)
            {
               
                $result[]=$s->class;
            }
        }
         return $result;
        
        // $as = \App\Models\AssignSubject::where('id', $examdate->assign_subject_id)->get();
        // foreach($as as $e)
        //   {
        //       echo ($e);
        //   }
       //   $assignsubject=$examdate->assign_subject_id;

        //    
        //   // dd($as->id);
        //   foreach($as as $e)
        //   {
        //       echo ($e->class->name);
        //   }
           //echo $result;
          // foreach($as as $a)
          // {
               //echo ($a->class_id);
                // if (!in_array($a->class_id, $blackList)) $result[]=$a->class;
                // if (!in_array($a->class_id, $blackList)) $blackList[] = $a->class_id; 
                //$result[]=$a->class;
           //}
        
        // dd($blackList);

       
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
