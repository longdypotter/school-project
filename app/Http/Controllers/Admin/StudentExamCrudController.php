<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Illuminate\Http\Request;
// use App\Libraries\StudentExam;
use App\Models\StudentExam;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StudentExamRequest as StoreRequest;
use App\Http\Requests\StudentExamRequest as UpdateRequest;
use App\Http\Requests\UpdateStudentExamRequest as UpdateStudentRequest;

/**
 * Class StudentExamCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StudentExamCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\StudentExam');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/studentexam');
        $this->crud->setEntityNameStrings('Student Exam', 'Student Exams');
        
        $this->crud->addButton('top', 'create', 'view', 'exams.students.buttonaddstudentexam','beginning');
        $this->crud->addButton('line', 'delete', 'view', 'exams.students.buttondelete','beginning');
        $this->crud->addButton('line', 'preview', 'view', 'exams.students.buttonpreview','beginning');
        

        $colMd12 =['class'=> 'form-group col-md-12' ]; 
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
 
        $this->crud->addClause('groupBy','created_at');

        $this->crud->removeButton('update');
        $this->crud->removeButton('show');
        //$this->crud->allowaccess('show');
        

        $user = \Auth::user();
        $both = 'update/create/both';
        $create = 'create';

        


        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumn([
                                'label'=> trans('flexi.exam_date'),
                                'name' => 'exam.exam_date',
                                'type' => 'text',
        ]);
        $this->crud->addColumn([
                                'label'=> trans('flexi.name'),
                                'name' => 'exam.name',
                                'type' => 'text',
        ]);
        $this->crud->addColumn([
                                'label'=> trans('flexi.class'),
                                'name' => 'exam.assignsubject.class.name',
                                'type' => 'text',
        ]);
        $this->crud->addColumn([
                                'label'=> trans('flexi.teacher'),
                                'name' => 'exam.teacher.name',
                                'type' => 'text',
        ]);
         $this->crud->addColumn([
                                'label'=> trans('flexi.section'),
                                'name' => 'exam.assignsubject.section.name',
                                'type' => 'text',
        ]);
          $this->crud->addColumn([
                                'label'=> trans('flexi.subject'),
                                'name' => 'exam.assignsubject.subject.name',
                                'type' => 'text',
        ]);
        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        // add asterisk for fields that are required in StudentExamRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');


        $this->crud->denyAccess(['list','create','update','reorder','delete']);

        if($user->can('list studentexams')) $this->crud->allowAccess('list');
        if($user->can('show studentexams')) $this->crud->allowAccess('show');
        if($user->can('create studentexams')) $this->crud->allowAccess('create');
        if($user->can('update studentexams')) $this->crud->allowAccess('update');
        if($user->can('reorder studentexams')) $this->crud->allowAccess('reorder');
        if($user->can('delete studentexams')) $this->crud->allowAccess('delete');

    }

    public function store(StoreRequest $request)
    {
     
        
        $student_id=$request->student_id;
     
        $mark=$request->mark;
         
        $exam_id = $request->exam_id;
        // dd($exam_id);

       
            $getalreadyexamid=\App\Models\StudentExam::where('exam_id',$exam_id)->first();

            if(!$getalreadyexamid)
            {
            
                foreach (array_combine($student_id, $mark) as $student => $m) {
                
                    // $markall = in_array($student, $request->mark) ? $request->mark: $request->mark;
                    // dd($markall);
                $createstudentexam=\App\Models\StudentExam::create([
                                                                    'student_id' => $student,
                                                                    'exam_id'   => $exam_id,
                                                                    'user_id'   => $request->user_id,
                                                                    'mark'      => $m
                ]);
                
                \Alert::success('<i class="fa fa-check"></i> Was Be Add StudentExam Complete.')->flash();   
                }
            }
            else
            
            {
                $mark=$request->txtmark;
                $id=$request->id; 
                foreach($id as $key=>$i)
                {
                    $updatestudentupate=\App\Models\StudentExam::find($i);
                    $updatestudentupate->update(['mark'=>$request['txtmark'][$key],
                    ]);
                    \Log::error($request['txtmark'][$key]);
       
                }
                \Alert::success('<i class="fa fa-check"></i> Update Complete.')->flash();   
                // return redirect()->back();
                // \Alert::warning('<i class="fa fa-check"></i> Was Be Add Aleady Complete.')->flash();   
            }
            return redirect()->back();

       
            // \Alert::warning('<i class="fa fa-exclamation-triangle"></i> Was Be Add Error Complete.')->flash();   
         
       

    }

    public function update(UpdateRequest $request)
    {
        return 'update';
        // your additional operations before save here
        // $redirect_location = parent::updateCrud($request);
        // // your additional operations after save here
        // // use $this->data['entry'] or $this->crud->entry
        // return $redirect_location;
    }
    public function formstudentexam(Request $request)
    {
        $crud=$this->crud;
        $user=\Auth::user();
        if($user->hasAnyRole('Developer|Admin'))
        {
           
            $this->data['crud']=$this->crud;
            $this->data['exam']=\App\Models\Exam::get();
            $this->data['entry'] = StudentExam::studentexam();
        
            $this->data['examname']=\App\Models\Exam::pluck('name')->unique();
            return view('exams.students.studentexam',$this->data);
        }
        
        else if($user->hasAnyRole('Teacher'))
        {
            $teacher=$user->userRole()->first();
            $this->data['crud']=$this->crud;
            $this->data['exam']=\App\Models\Exam::get();
            $this->data['entry'] = StudentExam::studentexam();
            $this->data['examname']=\App\Models\Exam::where('teacher_id',$teacher->type_id)->pluck('name')->unique();
            return view('exams.students.studentexam',$this->data);
        }

        //$exam=\App\Models\Exam::get();
        //$entry=StudentExam::studentexam();
        
        $this->data['crud']=$this->crud;
        $this->data['exam']=\App\Models\Exam::get();
        //$exam=\App\Models\Exam::get();
        // if($request->has('class')){
        //     dd($request->class);
        // };
        
        
        // $classid=$request->class;
        // $section=\App\Models\Exam::whereHas('assignsubject',function($q) use($classid){
        //     $q->where('class_id',$classid);
        // })->get();
        
        $this->data['entry'] = StudentExam::studentexam();
        return view('exams.students.studentexam',$this->data);
        //return view('exams.students.studentexam',compact('crud','exam','entry','classid','section','examname'));
    }
    public function showstudentexam($id)
    {
        
        $crud = $this->crud;
        
     
        $getstudent=StudentExam::where('exam_id',$id)->first();

        $studentexam=StudentExam::where('exam_id',$id)->get();
        $getexam=[];
        foreach($studentexam as $g)
        {
            $getexam[]=$g;
        
        }

        //update
       
        // dd($getexam);
         return view('exams.students.viewstudentexam',compact('getstudent','crud','getexam'));
        // dd($getexam);
        // $assignsubject=\App\Models\AssignSubject::where('id',$getexam->assign_subject_id)->get();
        // $getstudent=[];
        // foreach($assignsubject as $s)
        // {
        //     $classid=$s->class_id;
        //     $sectionid=$s->section_id;
        //     $studentsession=\App\Models\StudentSession::where('class_id',$classid)->where('section_id',$sectionid)->get();
        //     foreach($studentsession as $student){
        //       $getstudent[]=$student;
        //     }
        // }
        // return view('exams.students.viewstudentexam',compact('getstudent','crud','getexam'));
        // $getexam = \App\Models\StudentExam::where('exam_id',$id)->get();
        // foreach($getexam)
        // //$this->data['attendentstudent']=\App\Models\AttendentStudent::get();
        // $this->data['crud'] = $this->crud;
        // return view('exams.students.viewstudentexam',$this->data);
    }
    public function deletestudentexam($id)
    {
        $deletestudentexam=\App\Models\StudentExam::where('created_at',$id)->get();
        foreach($deletestudentexam as $d)
        {
            $d->delete();
        }
        
         \Alert::success('<i class="fa fa-check"></i> Delete Complete.')->flash();   
         return redirect()->back();
    }


    public function updatestudentexam(UpdateStudentRequest $request,$id)
    {
         $mark=$request->txtmark;
         $id=$request->id; 
         foreach($id as $key=>$i)
         {
             $updatestudentupate=\App\Models\StudentExam::find($i);
             $updatestudentupate->update(['mark'=>$request['txtmark'][$key],
             ]);
             \Log::error($request['txtmark'][$key]);

         }
         \Alert::success('<i class="fa fa-check"></i> Update Complete.')->flash();   
         return redirect()->back();

    }
 
}