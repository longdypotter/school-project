<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StudentsessionRequest as StoreRequest;
use App\Http\Requests\StudentsessionRequest as UpdateRequest;

/**
 * Class StudentsessionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StudentsessionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\StudentSession');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/studentsession');
        $this->crud->setEntityNameStrings('Student Session', 'Student Sessions');

        $colMd12 = ['class' => 'form-group col-md-12' ]; 
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $user = \Auth::user();
        $both = 'update/create/both';
        $create = 'create';
        $update = 'update';
        
        $this->crud->with('students');
        $this->crud->removeButton('delete');
        $this->crud->removeButton('create');

        $this->crud->addField([
                                'name'=> 'student_id',
                                'type'=> 'view',
                                'label'=>trans('flexi.student'),
                                // 'options'=>\App\Models\Student::pluck('english_name','id'),
                                'view' => 'student_session.text',
                                'attributes'=>['disabled'=>'disabled'],
                                'wrapperAttributes'=>$colMd4
        ],$update);
        $this->crud->addField([
                                'name'=> 'class_id',
                                'type'=> 'select2_from_array',
                                'label'=>trans('flexi.class'),
                                'options'=>\App\Models\Classes::pluck('name','id'),
                                'allows_null'=>true,
                                'wrapperAttributes'=>$colMd4
        ],$update);

        $this->crud->addField([
                                'name'=> 'session_id',
                                'type'=> 'view',
                                'label'=>trans('flexi.session'),
                                'view' => 'student_session.sessionText',
                                'attributes'=>['disabled'=>'disabled'],
                                'wrapperAttributes'=>$colMd4
        ],$update);

        // $this->crud->addField([
        //                         'name'=> 'session_id',
        //                         'type'=> 'select2_from_array',
        //                         'label' => trans('flexi.session '),
        //                         'options'=>\App\Models\Session::pluck('session','id'),
        //                         'wrapperAttributes'=>$colMd4
        // ],$update);

        $this->crud->addField([
                                'name'=> 'section_id',
                                'type'=> 'select2_from_array',
                                'label'=>trans('flexi.section'),
                                'options'=>\App\Models\Section::pluck('name','id'),
                                'allows_null'=>true,
                                'wrapperAttributes'=>$colMd4
        ],$update);  

        $this->crud->addcolumn([
                                'name'=> 'students.english_name',
                                'label'=>trans('flexi.student'),
                                'type'=>'text',
                                'entity' => 'students',
                                //'attribute' => "cruise_ship_name_date", // combined name & date column
                                'model' => "App\Models\Student",
                                    'searchLogic' => function ($query, $column, $searchTerm) {
                                        $query->orWhereHas('students', function ($q) use ($column, $searchTerm) {
                                            $q->where('english_name', 'like', '%'.$searchTerm.'%');
                                        });
                                    }
        ],$update);
        
        $this->crud->addcolumn([
                                'name'=> 'sessions.session',
                                'label'=>trans('flexi.session'),
                                'type'=>'text',
                                'entity' => 'sessions',
                                'model' => "App\Models\Session",
                                    'searchLogic' => function ($query, $column, $searchTerm) {
                                        $query->orWhereHas('sessions', function ($q) use ($column, $searchTerm) {
                                            $q->where('session', 'like', '%'.$searchTerm.'%');
                                        });
                                    }
        ],$update);

        $this->crud->addcolumn([
                                'name'=> 'classes.name',
                                'label'=>trans('flexi.class'),
                                'type'=>'text',
                                'entity' => 'classes',
                                'model' => "App\Models\Class",
                                    'searchLogic' => function ($query, $column, $searchTerm) {
                                        $query->orWhereHas('classes', function ($q) use ($column, $searchTerm) {
                                            $q->where('name', 'like', '%'.$searchTerm.'%');
                                        });
                                    }
        ],$update);

        $this->crud->addcolumn([
                                'name'=> 'sections.name',
                                'label'=>trans('flexi.section'),
                                'type'=>'text',
                                'entity' => 'sections',
                                'model' => "App\Models\Section",
                                    'searchLogic' => function ($query, $column, $searchTerm) {
                                        $query->orWhereHas('sections', function ($q) use ($column, $searchTerm) {
                                            $q->where('name', 'like', '%'.$searchTerm.'%');
                                        });
                                    }
        ],$update);  



        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'studentname',
            'label'=> trans('flexi.student')
            ], 
            false, 
            function($value) {
                $this->crud->query->whereHas('students', function($query) use($value)
                    {
                        $query->where(function ($q) use ($value) {
                            $q->orWhere('id','LIKE',"%$value%");
                            $q->orWhere('english_name','LIKE',"%$value%");
                            $q->orWhere('khmer_name','LIKE',"%$value%");
                            $q->orWhere('phone','LIKE',"%$value%");
                        });
                    });
               
            }); 
    //     $this->crud->addFilter([
    //         'type' => 'text',
    //         'name' => 'classname',
    //         'label'=> trans('flexi.class')
    //         ], 
    //         false, 
    //         function($value) {
    //             $this->crud->query->whereHas('classes', function($query) use($value)
    //                 {
    //                     $query->where('name','LIKE',"%$value%");
    //                 });
    //         }); 
    // $this->crud->addFilter([
    //                 'type'=>'text',
    //                 'name'=>'sessionname',
    //                 'label'=>trans('flexi.session')
    //                 ],
    //                 false,
    //                 function($value){
    //                     $this->crud->query->whereHas('sessions',function($query) use($value)
    //                     {
    //                             $query->where('session','LIKE',"%$value%");
    //                 });
    // });
    $this->crud->addFilter([ // select2 filter
        'name' => 'session_name',
        'type' => 'select2',
        'label'=> trans('flexi.session'),
      ], function() {
          return \App\Models\Session::all()->pluck('session', 'id')->toArray();
      }, function($value) { // if the filter is active
               $this->crud->addClause('where', 'session_id', $value);
            
      });
    $this->crud->addFilter([ // select2 filter
        'name' => 'class_name',
        'type' => 'select2',
        'label'=> trans('flexi.class')
      ], function() {
          return \App\Models\Classes::all()->pluck('name', 'id')->toArray();
      },  // if the filter is active
        function($value) { // if the filter is active
            $this->crud->addClause('where', 'class_id', $value);
      });    
      
      $this->crud->addFilter([ // select2 filter
        'name' => 'section',
        'type' => 'select2',
        'label'=> trans('flexi.section'),
      ], function() {
          return \App\Models\Section::all()->pluck('name', 'id')->toArray();
      }, function($value) { // if the filter is active
               $this->crud->addClause('where', 'section_id', $value);
            
      });
      



        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in StudentsessionRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->denyAccess(['list','update','reorder']);

        if($user->can('list studentsessions')) $this->crud->allowAccess('list');
        if($user->can('update studentsessions')) $this->crud->allowAccess('update');
        if($user->can('reorder studentsessions')) $this->crud->allowAccess('reorder');




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
        
        return $redirect_location;
    }
}
