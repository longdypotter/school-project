<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StudentExamRequest as StoreExamRequest;
use App\Http\Requests\ExamRequest as StoreRequest;
use App\Http\Requests\ExamRequest as UpdateRequest;
use App\Models\Exam;
use App\Models\StudentExam;
/**
 * Class ExamCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ExamCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Exam');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/exam');
        $this->crud->setEntityNameStrings('Exam', 'Exams');
        $this->crud->orderBy('id','desc');
        $this->crud->removeButton('show'); 
        $this->crud->removeButton('update');

        $this->crud->addButton('line', 'preview', 'view', 'exams.students.buttonpreview','beginning');
        $this->crud->addButton('line', 'create', 'view', 'exams.students.buttonmark','beginning');

        //$this->crud->setShowView('exams.examform');
        /*
         
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $colMd12 =['class'=> 'form-group col-md-12' ]; 
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];

        $user = \Auth::user();
        $both = 'update/create/both';
       

     
        $this->crud->addField([ 
            'name' => 'name',
            'label' => trans('flexi.name'),
            'type' => 'text',
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'exam_date',
            'type' => 'date_picker',
            'label' => trans('flexi.exam_date'),
            // optional:
            'date_picker_options' => [
                'todayBtn' => true,
                'format' => 'dd-mm-yyyy',
            ],
            'default' => date('Y-m-d'),
            'wrapperAttributes'=>$colMd4,

        ],$both);
        


        // $this->crud->addField([ 
        //     'name' => 'teacher_id',
        //     'label' => trans('flexi.teacher'),
        //     'type' => 'select2',
        //     //'model' => \App\Models\AssignSubject::pluck('section_id')->unique(),
        //     'entity' => 'assignsubject.teacher',
        //     'attribute' => 'name',
        //     'wrapperAttributes'=>$colMd4,           
        // ],$both);

        $this->crud->addField([ 
            'name' => 'teacher_id',
            'label' => trans('flexi.teacher'),
            'type' => 'view',
            'view' => 'exams.students.dropdownteacher',
            'wrapperAttributes'=>$colMd4,  
                 
        ],$both);

        $this->crud->addField([ 
            'name' => 'class_id',
            'label' => trans('flexi.class'),
            'type' => 'view',
            //'model' => \App\Models\AssignSubject::pluck('section_id')->unique(),
            'view' => 'exams.students.dropdownclass',
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'section_id',
            'label' => trans('flexi.section'),
            'type' => 'view',
            //'model' => \App\Models\AssignSubject::pluck('section_id')->unique(),
            'view' => 'exams.students.dropdownsection',
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'subject_id',
            'label' => trans('flexi.subject'),
            'type' => 'view',
            //'model' => \App\Models\AssignSubject::pluck('section_id')->unique(),
            'view' => 'exams.students.dropdownsubject',
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        // $this->crud->addField([ 
        //     'name' => 'subject_id',
        //     'label' => trans('flexi.subject'),
        //     'type' => 'select2_from_array',
        //     'options' => \App\Models\Teacher::pluck('name','id'),
        //     'allows_null' => true,
        //     'wrapperAttributes'=>$colMd4,           
        // ],$both);


        $this->crud->addColumn([
            'name'  => 'exam_date',
            'label' => trans('flexi.exam_date'),
            'type' => 'datetime',
            'format' => 'd-m-Y'
        ]);

        $this->crud->addColumn([
            'name'  => 'name',
            'label' => trans('flexi.name'),
            'type' => 'text',
           
        ]);

        $this->crud->addColumn([
            'name'  => 'teacher.name',
            'label' => trans('flexi.teacher'),
            'type' => 'text',
            'entity' => 'teacher',
            //'attribute' => "cruise_ship_name_date", // combined name & date column
            'model' => "App\Models\Teacher",
                'searchLogic' => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('teacher', function ($q) use ($column, $searchTerm) {
                        $q->where('name', 'like', '%'.$searchTerm.'%');
                    });
                }
        ]);

        $this->crud->addColumn([
            'name'  => 'assignsubject.class.name',
            'label' => trans('flexi.class'),
            'type' => 'text',
            'model' => "App\Models\AssignSubject",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('assignsubject.class', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            }
        ]);
        $this->crud->addColumn([
            'name'  => 'assignsubject.section.name',
            'label' => trans('flexi.section'),
            'type' => 'text',
            'model' => "App\Models\AssignSubject",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('assignsubject.section', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            }
        
        ]);
        $this->crud->addColumn([
            'name'  => 'assignsubject.subject.name',
            'label' => trans('flexi.subject'),
            'type' => 'text',
            'model' => "App\Models\AssignSubject",
            'searchLogic' => function ($query, $column, $searchTerm) {
                $query->orWhereHas('assignsubject.subject', function ($q) use ($column, $searchTerm) {
                    $q->where('name', 'like', '%'.$searchTerm.'%');
                });
            }
        
        ]);

       
        $this->crud->addFilter([ // date filter
            'type' => 'date',
            'name' => 'exam_date',
            'label'=> trans('flexi.exam_date'),
          ],
          false,
          function($value) { // if the filter is active, apply these constraints
                            $this->crud->addClause('where', 'exam_date', '=', $value);
          });


          $this->crud->addFilter([ // select2 filter
            'name' => 'subject_id',
            'type' => 'select2',
            'label'=> trans('flexi.subject')
          ], function() {
              return \App\Models\Subject::all()->pluck('name', 'id')->toArray();
          }, function($values) { // if the filter is active
                $this->crud->query = $this->crud->query->whereHas('assignsubject.subject', function ($query) use ($values) {
                    $query->where('subject_id', $values);
                });
           
                //$this->crud->addClause('whereHas','subject_id', $value);
          }); 
            
        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        // add asterisk for fields that are required in ExamRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        
        $this->crud->denyAccess(['list','create','update','reorder','delete']);

        if($user->can('list exams')) $this->crud->allowAccess('list');
        if($user->can('show exams')) $this->crud->allowAccess('show');
        if($user->can('create exams')) $this->crud->allowAccess('create');
        if($user->can('update exams')) $this->crud->allowAccess('update');
        if($user->can('reorder exams')) $this->crud->allowAccess('reorder');
        if($user->can('delete exams')) $this->crud->allowAccess('delete');

        if($user->hasAnyRole('Teacher'))
        {
            $teacher=$user->userRole()->first();
            // dd($teacher->type_id);
            $this->crud->addClause('where','teacher_id',$teacher->type_id)->get();
        }

        

    }

    public function store(StoreRequest $request)
    {
       $teacher=$request->teacher_id;
       //dd($teacher);
       $class=$request->class_id;
       $section=$request->section_id;
       $subject=$request->subject_id;

        $assignsubject= \App\Models\AssignSubject::where(function($q) use($class,$section,$subject,$teacher){
                $q->where('class_id',$class);
                $q->where('section_id',$section);
                $q->where('subject_id',$subject);
                $q->where('teacher_id',$teacher);
        })->first();
        $createExam=Exam::create([
                                    'name' => $request->name,
                                    'teacher_id' => $teacher,
                                    'assign_subject_id' => optional($assignsubject)->id,
                                    'exam_date' => $request->exam_date,
        ]);
        \Alert::success('<i class="fa fa-check"></i>The item has been added successfully')->flash();
       // dd(optional($assignsubject)->id);
        // your additional operations before save here
       // $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return redirect()->back();
    }

 
    
    public function inputmarkstudentexam($id)
    {
        $studentexam=StudentExam::where('exam_id',$id)->get();
        $getmarkexam=[];
        foreach($studentexam as $g)
        {
            $getmarkexam[]=$g;
        }
        $crud = $this->crud;
        $getexam=$this->crud->getCurrentEntry();
     //   dd($getexam->studentexams);
        $getexamfirst=\App\Models\Exam::find($id);
        $assignsubject=\App\Models\AssignSubject::where('id',$getexam->assign_subject_id)->get();
        $getstudent=[];
        foreach($assignsubject as $s)
        {
            $classid=$s->class_id;
            $sectionid=$s->section_id;
            $studentsession=\App\Models\StudentSession::where('class_id',$classid)->where('section_id',$sectionid)->get();
            foreach($studentsession as $student){
              $getstudent[]=$student;
             
            }
        }
        return view('exams.students.markstudentexam',compact('getstudent','crud','getexam','getexamfirst','getmarkexam'));
        // echo $getexamid->assign_subject_id;
 
    }
    public function destroy($id)
    {
        $getexam=$this->crud->getCurrentEntry();
         $getexam->delete();
        if($getexam->studentexams)
        {
            $getexam->studentexams()->delete();
        }
       
    }



}
