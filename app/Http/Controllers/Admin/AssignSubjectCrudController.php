<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AssignSubjectRequest as StoreRequest;
use App\Http\Requests\AssignSubjectRequest as UpdateRequest;

/**
 * Class AssignSubjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AssignSubjectCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\AssignSubject');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/assignsubject');
        $this->crud->setEntityNameStrings('Assign Subject', 'Assign Subjects');
        $this->crud->setDefaultPageLength(10);
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
     //   $hasError=session()->exists('got_error') ? 'has-error' : '';
        $hasError = session()->exists('got_error') ? 'has-error' : '';
        $colMd6 = ['class' => 'form-group col-md-6 '.$hasError];
        $colMd4 = ['class' => 'form-group col-md-4 '.$hasError];
        $colMd3 = ['class' => 'form-group col-md-3 '.$hasError];
        $tabOne = trans('flexi.teacher');
        $tabTwo = trans('flexi.family');
        $user=\Auth::user();
        $both = 'update/create/both';

        
        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();



         $this->crud->addField([
                                'name' => 'class_id',
                                'label' => trans('flexi.class'),
                                'type' => 'select2_from_array',
                                'options' => \App\Models\Classes::pluck('name','id'),
                                'allows_null' => true,
                                //'default' => 'one',
                                'default' => session('got_error.class_id') ?? '',
                                'wrapperAttributes'=>$colMd4
         ],$both);
        $this->crud->addField([
                                'name'=>'section_id',
                                'label'=>trans('flexi.section'),
                                'type' => 'select2_from_array',
                                'options' => \App\Models\Section::pluck('name','id'),
                                'allows_null' => true,
                                //'default' => 'one',
                                'default' => session('got_error.section_id') ?? '',
                                'wrapperAttributes'=>$colMd4
        ],$both);
        $this->crud->addField([
                                'name'=>'teacher_id',
                                'label'=>trans('flexi.teacher'),
                                'type' => 'select2_from_array',
                                'options' => \App\Models\Teacher::pluck('name','id'),
                                'allows_null' => true,
                                //'default' => 'one',
                                'default' => session('got_error.teacher_id') ?? '',
                                'wrapperAttributes'=>$colMd4
        ],$both);
        $this->crud->addField([
                                'name'=>'subject_id',
                                'label'=>trans('flexi.subject'),
                                'type' => 'select2_from_array',
                                'options' => \App\Models\Subject::pluck('name','id'),
                                'allows_null' => true,
                                //'default' => 'one',
                                'default' => session('got_error.subject_id') ?? '',
                                'wrapperAttributes'=>$colMd4
        ],$both);

   

         $this->crud->addColumn([
                                'name'=>'class.name',
                                'label'=>trans('flexi.class'),
                                'type' => 'text',
                                'entity' => 'class',
                                    //'attribute' => "cruise_ship_name_date", // combined name & date column
                                    'model' => "App\Models\Class",
                                        'searchLogic' => function ($query, $column, $searchTerm) {
                                            $query->orWhereHas('class', function ($q) use ($column, $searchTerm) {
                                                $q->where('name', 'like', '%'.$searchTerm.'%');
                                            });
                                        }
        ],$both);
         $this->crud->addColumn([
                                'name'=>'section.name',
                                'label'=>trans('flexi.section'),
                                'type' => 'text',
                                'entity' => 'section',
                                    //'attribute' => "cruise_ship_name_date", // combined name & date column
                                    'model' => "App\Models\Section",
                                        'searchLogic' => function ($query, $column, $searchTerm) {
                                            $query->orWhereHas('section', function ($q) use ($column, $searchTerm) {
                                                $q->where('name', 'like', '%'.$searchTerm.'%');
                                            });
                                        }
        ],$both);
         $this->crud->addColumn([
                                'name'=>'teacher.name',
                                'label'=>trans('flexi.teacher'),
                                'type' => 'text',
                                'entity' => 'teacher',
                                'model' => "App\Models\Teacher",
                                    'searchLogic' => function ($query, $column, $searchTerm) {
                                        $query->orWhereHas('teacher', function ($q) use ($column, $searchTerm) {
                                            $q->where('name', 'like', '%'.$searchTerm.'%');
                                        });
                                    }
        ],$both);
         $this->crud->addColumn([
                                'name'=>'subject.name',
                                'label'=>trans('flexi.subject'),
                                'type' => 'text',
                                'entity' => 'subject',
                                'model' => "App\Models\Subject",
                                    'searchLogic' => function ($query, $column, $searchTerm) {
                                        $query->orWhereHas('subject', function ($q) use ($column, $searchTerm) {
                                            $q->where('name', 'like', '%'.$searchTerm.'%');
                                        });
                                    }
        ],$both);

        $this->crud->addFilter([ // select2 filter
            'name' => 'class_name',
            'type' => 'select2',
            'label'=> trans('flexi.class')
          ], function() {
              return \App\Models\Classes::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
                  $this->crud->addClause('where', 'class_id', $value);
          });    
          
          $this->crud->addFilter([ // select2 filter
            'name' => 'section_name',
            'type' => 'select2',
            'label'=> trans('flexi.section')
          ], function() {
              return \App\Models\Section::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
                  $this->crud->addClause('where', 'section_id', $value);
          }); 

          $this->crud->addFilter([ // select2 filter
            'name' => 'teacher_name',
            'type' => 'select2',
            'label'=> trans('flexi.teacher')
          ], function() {
              return \App\Models\Teacher::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
                  $this->crud->addClause('where', 'teacher_id', $value);
          }); 

          $this->crud->addFilter([ // select2 filter
            'name' => 'subject_name',
            'type' => 'select2',
            'label'=> trans('flexi.subject')
          ], function() {
              return \App\Models\Subject::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
                  $this->crud->addClause('where', 'subject_id', $value);
          }); 

         






        

        // $this->crud->addFilter([
        //                         'type' => 'text',
        //                         'name' => 'classname',
        //                         'label'=> trans('flexi.class')
        //                         ], 
        //                         false, 
        //                         function($value) {
        //                             $this->crud->query->whereHas('class', function($query) use($value)
        //                                 {
        //                                     $query->where('name','LIKE',"%$value%");
        //                                 });
        // }); 
        // $this->crud->addFilter([
        //                         'type'=>'text',
        //                         'name'=>'teachername',
        //                         'label'=>trans('flexi.teacher')
        //                         ],
        //                         false, 
        //                         function($value){
        //                             $this->crud->query->whereHas('teacher',function($query) use($value)
        //                             {
        //                                     $query->where('name','LIKE',"%$value%");
        //                         });
        // });
        // $this->crud->addFilter([
        //                         'type' => 'text',
        //                         'name' => 'sectionname',
        //                         'label'=> trans('flexi.section')
        //                         ], 
        //                         false, 
        //                         function($value) {
        //                             $this->crud->query->whereHas('section', function($query) use($value)
        //                                 {
        //                                     $query->where('name','LIKE',"%$value%");
        //                                 });
        // }); 

        // $this->crud->addFilter([
        //                         'type'=>'text',
        //                         'name'=>'subjectname',
        //                         'label'=>trans('flexi.subject')
        //                         ],false,
        //                         function($value){
        //                             $this->crud->query->whereHas('subject',function($query) use($value)
        //                             {
        //                                 $query->where('name','LIKE',"%$value%");
        //                             });
        //                         });



        // add asterisk for fields that are required in AssignSubjectRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');

        $this->crud->denyAccess(['list','create','update','reorder','delete']);

        if($user->can('list assignsubjects'))$this->crud->allowAccess('list');
        if($user->can('create assignsubjects'))$this->crud->allowAccess('create');
        if($user->can('update assignsubjects'))$this->crud->allowAccess('update');
        if($user->can('reorder assignsubjects'))$this->crud->allowAccess('reorder');
        if($user->can('delete assignsubjects'))$this->crud->allowAccess('delete');

        if ($user->hasAnyRole('Student')) {
            $student = $user->userRole()->first();
            
            $class = \App\Models\StudentSession::where('student_id', $student->type_id)->first();
            // $teacher = \App\Models\AssignSubject::where('teacher_id', $class->class_id)
            //  ->where('section_id', $class->section_id)->first();
            $subject = \App\Models\AssignSubject::where('class_id', $class->class_id)
             ->where('section_id', $class->section_id)->first();
             
            $this->crud->addClause('where', function ($q) use ($class, $subject) {
                if(!empty($class->class_id)) $q->where('class_id', $class->class_id);
                
                if(!empty($class->section_id) && !empty($class->class_id)) $q->where('section_id', $class->section_id);

                if(!empty($subject->subject_id) && !empty($class->section_id) && !empty($class->class_id)) $q->where('subject_id', $subject->subject_id);
            });
            // $this->crud->addClause('orWhereNull', 'class_id');
            // $this->crud->addClause('orWhereNull', 'section_id');
            // $this->crud->addClause('orWhereNull', 'subject_id');

        }




        if($user->hasAnyRole('Teacher')){
            $teacher=$user->userRole()->first();
          //  dd($teacher);
          $this->crud->addClause('where','teacher_id',$teacher->type_id)->count();
        }
    }


    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        
        $classsection= \App\Models\AssignSubject::where(function ($q) use ($request) {
            $q->where('class_id',$request->class_id);
            $q->where('section_id',$request->section_id);
        })->count();
      
        if($classsection > 0)
        {
            \Alert::warning('<p class="fa fa-warning">You Can Not AssignSubject Because Class and Section It was be AssignSubject Ready</p>')->flash();
            return redirect()->back()->with('got_error', [
                
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'teacher_id' => $request->teacher_id,
                'subject_id' => $request->subject_id,
                
            ]);
        }
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
    public function destroy($id)
    {
        // $class=count($this->crud->entry->getCurrentEntry()->class);
        // $section=count($this->crud->entry->getCurrentEntry()->section);
        // $subject=count($this->crud->entry->getCurrentEntry()->subject);
        // $teacher=count($this->crud->entry->getCurrentEntry()->teacher);
        
        // if($class > 0)
        // {
        //     return redirect()->back();
        // }
        // elseif($section > 0)
        // {
        //     return redirect()->back();
        // }
        // elseif($subject > 0)
        // {
        //     return redirect()->back();
        // }
        // elseif($teacher > 0)
        // {
        //     return redirect()->back();
        // }
        $redirect_location = parent::destroy($id);
        
        return $redirect_location;
    }

}
