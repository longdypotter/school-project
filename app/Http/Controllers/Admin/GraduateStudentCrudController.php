<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\GraduateStudentRequest as StoreRequest;
use App\Http\Requests\GraduateStudentRequest as UpdateRequest;

/**
 * Class GraduateStudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class GraduateStudentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Student');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/graduatestudent');
        $this->crud->setEntityNameStrings('Graduate Student', 'Graduate Students');
        $this->crud->removeButton('create');
        $this->crud->orderBy('id','desc')->where('student_status','inactive')->get();
        $this->crud->allowAccess('show');
        $this->crud->setShowView('graduatestudents.show');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        $user=\Auth::user();
        $this->crud->addFilter([ // select2 filter
            'name' => 'class_id',
            'type' => 'select2',
            'label'=> trans('flexi.class')
          ], function() {
            return \App\Models\Classes::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
            $this->crud->query->whereHas('studentsession',function($query) use($value)
              {
                $query->where('class_id',$value);
                //$this->crud->addClause('where', 'class_id', $value);
              });
          });  

          $this->crud->addFilter([ // select2 filter
            'name' => 'section_id',
            'type' => 'select2',
            'label'=> trans('flexi.section')
          ], function() {
              return \App\Models\Section::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
            $this->crud->query->whereHas('studentsession',function($query) use($value)
              {
                $query->where('section_id',$value);
                //$this->crud->addClause('where', 'class_id', $value);
              });
          });  

        $this->crud->addColumn([
            'name'=>'english_name',
            'label'=>trans('flexi.name'),
        ]);
      
        $this->crud->addColumn([
            'name'=>'gender',
            'label'=>trans('flexi.gender')
        ]);
        $this->crud->addColumn([
            'name'=>'studentsession.classes.name',
            'label'=>trans('flexi.class'),
            'type' => 'text',
            'entity' => 'classes',
            'model' => "App\Models\Class",
            'searchLogic' => function ($query, $column, $searchTerm) {
                         $query->orWhereHas('studentsession.classes', function ($q) use ($column, $searchTerm) {
                        $q->where('name', 'like', '%'.$searchTerm.'%');
                      });
                   }
        ]);
        $this->crud->addColumn([
            'name'=>'studentsession.sections.name',
            'label'=>trans('flexi.section'),
            'type' => 'text',
             'entity' => 'sections',
            'model' => "App\Models\Section",
            'searchLogic' => function ($query, $column, $searchTerm) {
                         $query->orWhereHas('studentsession.sections', function ($q) use ($column, $searchTerm) {
                        $q->where('name', 'like', '%'.$searchTerm.'%');
                      });
                   }
        ]);

        // $this->crud->addColumn([
        //     'name'=>'student_status',
        //     'label'=>trans('flexi.student_status'),
        //     //'options' => \App\Models\Student::where('student_status','inactive'),
        // ]);

        // $this->crud->addColumn([
        //     'name'=>'email',
        //     'label'=>trans('flexi.email'),
        // ]);
        $this->crud->addColumn([
            'name'=>'phone',
            'label'=>trans('flexi.phone'),
        ]);
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
       // $this->crud->setFromDb();
        
        // add asterisk for fields that are required in GraduateStudentRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list','create','update','reorder','delete','show']);

        if($user->can('list graduatestudents'))$this->crud->allowAccess('list');
        if($user->can('show graduatestudents'))$this->crud->allowAccess('show');
        if($user->can('create graduatestudents'))$this->crud->allowAccess('create');
        if($user->can('update graduatestudents'))$this->crud->allowAccess('update');
        if($user->can('reorder graduatestudents'))$this->crud->allowAccess('reorder');
        if($user->can('delete graduatestudents'))$this->crud->allowAccess('delete');
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
    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        // set columns from db
        $this->crud->setFromDb();

        // cycle through columns
        foreach ($this->crud->columns as $key => $column) {
            // remove any autoset relationship columns
            if (array_key_exists('model', $column) && array_key_exists('autoset', $column) && $column['autoset']) {
                $this->crud->removeColumn($column['name']);
            }

            // remove the row_number column, since it doesn't make sense in this context
            if ($column['type'] == 'row_number') {
                $this->crud->removeColumn($column['name']);
            }
        }

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;


        $getclass=\App\Models\StudentSession::where('student_id',$id)->pluck('class_id')->unique();
        $getSection=\App\Models\StudentSession::where('student_id',$id)->pluck('section_id')->unique();

        $countTeacher=\App\Models\AssignSubject::where('class_id',$getclass)->where('section_id',$getSection)->get();

        // dd($countTeacher->get());



        // remove preview button from stack:line
        //$this->crud->removeButton('show');
        //$this->crud->removeButton('delete');
        $this->data['type_options'] = \App\Models\FileType::pluck('name');
        $this->data['health_types'] = \App\Models\HealthType::pluck('name');
        $this->data['student_followup_types']= \App\Models\StudentFollowupType::pluck('name');
        $this->data['getteacher']=$countTeacher;
      //  $this->data['health_types'] = \App\Models\HealthType::pluck('name','id');
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getShowView(), $this->data);
    }
    
}
