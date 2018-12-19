<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Session;
use App\Models\Section;


use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $user=\Auth::user();
        // // $students = new Student;
        // // if ($user->hasAnyRole('Teacher')) {
        // //     $students->where();
        // // } 
        // //$student = $students->count();
        // if($user->hasAnyRole('Teacher'))
        // {
        //     $teacher=$user->userRole()->first();  
        // }

        $user=\Auth::user();
        if ($user->hasAnyRole('Teacher')) {
            // $students = '0';
            
          $teacher = $user->userRole()->first();
          $class = \App\Models\AssignSubject::where('teacher_id',$teacher->type_id)->get()->groupBy('class_id');
          
           // dd($sectionId);
           $countStudent = \App\Models\StudentSession::where(function ($q) use ($class) {
                foreach($class as $k => $v):
                    //dd($v->pluck('section_id'));
                    $q->orWhere('class_id', $k);
                    $q->whereIn('section_id', $v->pluck('section_id'));
                endforeach;
           })->count();

            $classes = $class->count(); 
            $student = $countStudent;
        }
           // dd($student);
        

        if ($user->hasAnyRole('Student')) {
            $student = $user->userRole()->first();

            return redirect(backpack_url('student/'.$student->type_id));

            //class
            // $class = \App\Models\StudentSession::where('student_id', $student->type_id)->pluck('class_id')->unique();
            // //dd($teacher);
            // $countTeacher = \App\Models\AssignSubject::whereIn('teacher_id', $class)->count();
            //class
            $subject = \App\Models\StudentSession::where('student_id', optional($student)->type_id)->first();

            // $class = \App\Models\StudentSession::where('student_id', $student->type_id)->pluck('section_id')->unique();
           //dd($class);
            $countsubject = \App\Models\AssignSubject::where(function ($q) use ($subject) {
                $q->where('class_id', optional($subject)->class_id);
                $q->where('section_id', optional($subject)->section_id);
            })->count();
          //  dd($countsubject);
           
            //dd($teacher);
            $teacher=\App\Models\StudentSession::where('student_id',optional($student)->type_id)->first();
            $countTeacher = \App\Models\AssignSubject::where(function($q) use($teacher){
                $q->where('class_id',optional($teacher)->class_id);
                $q->where('section_id',optional($teacher)->section_id);
            })->count();
          

            $subject = $countsubject;
            $teacher = $countTeacher;  
        }
        
       

        if ($user->hasAnyRole('Developer|Admin')) $student = Student::count();
        if ($user->hasAnyRole('Developer|Admin')) $graduatestudent = Student::where('student_status','inactive')->count();
        if ($user->hasAnyRole('Developer|Admin')) $classes = Classes::count();
        if ($user->hasAnyRole('Developer|Admin')) $teacher = Teacher::count();
       
        
        if ($user->hasAnyRole('Developer|Admin')) $subject = Subject::count();




       // $student = Student::count();
       // $classes = Classes::count();
       // $subject = Subject::count();
        //$teacher = Teacher::count();
        // $session = Session::count();
        $section = Section::count();
       // return $student;
        return view('vendor.backpack.base.dashboard',compact('student','graduatestudent','classes','subject','teacher','session','section'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
