<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Libraries\AttendentStudent as AttendentStudentLib;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SearchAttendentStudentRequest as StoreRequest;
use App\Http\Requests\SearchAttendentStudentRequest as UpdateRequest;
use Illuminate\Support\Facades\Input;
/**
 * Class SearchAttendentStudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SearchAttendentStudentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\AssignSubject');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/searchattendentstudent');
        $this->crud->setEntityNameStrings('searchattendentstudent', 'Attendent Students');

        /*
        |---------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        // add asterisk for fields that are required in SearchAttendentStudentRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }
    public function index()
    {
        $user=\Auth::user();
       
        $this->crud->hasAccessOrFail('list');
        
      

            
            
            //$this->crud->addClause('where','user_id',$teacher->user_id);
            $assignsubjes=\App\Models\AssignSubject::get();
            if($user->hasAnyRole('Developer|Admin'))
            {
                $this->data['classes']=\App\Models\Classes::pluck('name','id');
            }

        if($user->hasAnyRole('Teacher'))
        {
            $teacher = $user->userRole()->first();
          // dd($teacher->user_id);
            
            //$assignsubjes=\App\Models\AssignSubject::whereIn('class_id',$teacher->type_id)->first();
             //dd($assignsubjes);
            $classname= \App\Models\AssignSubject::where('teacher_id',$teacher->type_id)->get();
           //dd($classname);
        //    foreach($classname as $c){
        //        print_r($c->class->name);
        //        $this->data['classes']=$c->class->name;
        //    }
            $this->data['classes']=$classname;
      
           // dd($classname->class->name);
            // foreach($classname as $c)
            // {
                $sectionname= \App\Models\AssignSubject::where('teacher_id',$teacher->type_id)->get();
           //dd($classname);
        //    foreach($classname as $c){
        //        print_r($c->class->name);
        //        $this->data['classes']=$c->class->name;
        //    }
            $this->data['sections']=$sectionname;
            $subjectnname= \App\Models\AssignSubject::where('teacher_id',$teacher->type_id)->get();
            //dd($classname);
         //    foreach($classname as $c){
         //        print_r($c->class->name);
         //        $this->data['classes']=$c->class->name;
         //    }
             $this->data['subjects']=$subjectnname;
               // sections
                
            //}
            // $this->data['classes']= \App\Models\AssignSubject::whereHas('teacher',function($q) use($assignsubjes){
            //     $q->whereIn('teacher_id',$assignsubjes);
            // })->pluck('class_id');
    
    }
        
        $this->data['section']=\App\Models\Section::pluck('name','id');

        $this->data['subject']=\App\Models\Subject::pluck('name','id');
        
        $this->data['crud'] = $this->crud;
        
        $this->data['attendentdate']= \App\Models\AttendentStudent::get();

        $this->data['entry'] = AttendentStudentLib::getReportAttendentStudentBy();
       
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);

        
        return view('attendents.students.attendent_student',$this->data);
      
    }
    public function createattendentstudent(StoreRequest $request)
    {
       //$get=Input::all();
        $getstudentid=\App\Models\StudentSession::get();
        //dd($request->all());
        //dd($request->student_id);
        $attendents = $request->input('attendent');
        // $att = $request->input('att');
        //dd($attendents);
    
        // {
            
            foreach($request->student_id as $student){
                $hasRecord = \App\Models\AttendentStudent::where(function ($q) use ($student,$request) {
                                $q->where('student_id', $student);
                                $q->where('attendent_date', $request->attendent_date);
                            })->first();

                if (!$hasRecord){
                // $date = in_array($student, $request->attendent_date) ? now() : '';
                if($request->has('attendent')) $status = in_array($student, $request->attendent) ? 'Present' : 'Absent';
                else $status = 'Absent';

                // if (count((array)$request->attendent) <= 0) {
                //     $status = 'Absent';
                // }
                 //if (in_array($student, $request->attendent))
                //      {
                    // {
                   // dd($student);
               
                    $creatattendent=\App\Models\AttendentStudent::create([
                                                                        'student_id'=>$student,
                                                                        'attendent_date'=>$request->attendent_date,
                                                                        'assign_subject_id'=>$request->assign_subject_id,
                                                                        'user_id'=>$request->user_id,
                                                                        'status'    =>$status,
                                    ]);

                   // echo 'have value'.'<br>';      
                   \Alert::success('<i class="fa fa-check"></i> Was Be Add Attendent Complete.')->flash();         
                        
                   }
                   else
                   {
                   \Alert::warning('<i class="fa fa-exclamation-triangle"></i> Was Be Add Attendent already.')->flash();
                   }
                }
                   


                
            // }
                
        
    
        // else
        // {
        //     dd('havenull');
        // }
        // foreach($getstudentid as $getst)
        // {
        //     if( $request->has('attendent') === null && $getst->students->id !=null) 
        //     {
        //         echo 'havenull';
        //     }
        // }
    
        //dd($request->all());
        //  foreach($getstudentid as $g){
             
        //          $getattendent=count($g->attendentstudent);
        //          if($getattendent > 0){
        //             \Alert::warning('<i class="fa fa-check"></i> Was Be already Complete.')->flash();
        //              return redirect()->back();
                 
        //      }
        //  }
        
            
        // dd($request->all());

        // if ( $request->has('attendent')) {
        //     foreach($attendents as $a){
                
        //         $hasRecord = \App\Models\AttendentStudent::where(function ($q) use ($a,$request) {
        //             $q->where('student_id', $a);
        //             $q->where('attendent_date', $request->attendent_date);
        //         })->first();
        //            if (! $hasRecord)
        //            { $creatattendent=\App\Models\AttendentStudent::create([
        //                                                                     'student_id'=>$a,
        //                                                                     'attendent_date'=>$request->attendent_date,
        //             ]);
        //             \Alert::success('<i class="fa fa-check"></i> Was Be Add Attendent Complete.')->flash();
        //            }
        //            else
        //            {
        //            \Alert::warning('<i class="fa fa-exclamation-triangle"></i> Was Be Add Attendent already.')->flash();
        //            }
        //         }
    
        // }
        // foreach($student  as $a){

        // if ( $request->has('attendent')) {
           
                
        //             $creatattendent=\App\Models\AttendentStudent::create([
        //                                                                     'student_id'=>$a,
        //                                                                     'attendent_date'=>$request->attendent_date,
        //                                                                     'status'    =>'Present',
        //             ]);
        //             \Alert::success('<i class="fa fa-check"></i> Was Be Add Attendent Complete.')->flash();
                   

        // }
        // else
        // {
        //         $creatattendent1=\App\Models\AttendentStudent::create([
        //             // 'student_id'=>$,
        //             'attendent_date'=>$request->attendent_date,
        //             'status'    =>'Absent',
        //             ]);
        //             \Alert::success('<i class="fa fa-check"></i> Was Be Add absent Complete.')->flash();
                
        // }
    
        // }


        //     foreach($getstudentid as $gets)
        //     {
        //         foreach($gets->attendentstudent as $ss)
        //         {
        //             $getfindid=$ss;
        //             $getfindid->delete();
        //              \Alert::success('<i class="fa fa-check"></i> Was Be Update Complete.')->flash();
        //         }
        //     }
        // }
 
        return redirect()->back();
    }


    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
    
}
