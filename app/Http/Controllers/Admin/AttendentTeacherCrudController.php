<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AttendentTeacherRequest as StoreRequest;
use App\Http\Requests\AttendentTeacherRequest as UpdateRequest;
use Illuminate\Support\Facades\Input;
/**
 * Class AttendentTeacherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AttendentTeacherCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\AttendentTeacher');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/attendentteacher');
        $this->crud->setEntityNameStrings('Attendent Teacher', 'Attendent Teachers');
        $this->crud->addButton('top', 'create', 'view', 'attendents.teachers.buttonaddattendentteacher','beginning');

        $this->crud->orderBy('attendent_date','desc');
        $this->crud->addClause('groupBy', 'attendent_date');
        $this->crud->addClause('groupBy', 'teacher_id');
        //$this->crud->addClause('groupBy', 'assign_subject_id');
        $this->crud->removeButton('update');
        // $this->crud->addButton('line', 'preview', 'view', 'attendents.teachers.buttonpreview','beginning');
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();


        // $this->crud->addColumn([
        //     'label' =>  trans('flexi.attendent_date'),
        //     'name' => 'attendent_date',
        //     'type' => 'select',
        //     'model' => "App\Models\AttendentTeacher",
        //     'searchLogic' => function ($q, $column, $searchTerm) {
        //                             $q->where('attendent_date', 'like', '%'.$searchTerm.'%');
        
        //     }       
        // ]);
        $this->crud->addColumn([
            'name' => 'attendent_date', // there is no full_name column in the db, it's an accessor 
            'type' => 'text',
            //'view' => 'teachers.attendents.viewdate',
            'label' => trans('flexi.attendent_date'),
           
        ]);

        $this->crud->addColumn([
            'label' =>  trans('flexi.teacher'),
            'name' => 'teacher',
            'type' => 'select',
            'entity' => 'teacher',
            'attribute' => 'name', 
            'model' => "App\Models\AttendentTeacher",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('teacher', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }        
        ]);
        $this->crud->addColumn([

            'label' =>  trans('flexi.class'),
            'name' => 'class_id',
            // 'type' => 'select',
            // 'entity' => 'teacher.hasAssignsubjects.class',
            // 'attribute' => 'name', 
            'type' => 'view',
            'view' => 'teachers.attendents.viewclass',
            'model' => "App\Models\AttendentTeacher",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('teacher.hasAssignsubjects.class', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }           
        ]);

        $this->crud->addColumn([
            'label' =>  trans('flexi.section'),
            'name' => 'section',
            'type' => 'view',
            'view' => 'teachers.attendents.viewsection',
            'model' => "App\Models\AttendentTeacher",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('teacher.hasAssignsubjects.section', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }    
        ]);
         $this->crud->addColumn([
            'label' =>  trans('flexi.subject'),
            'name' => 'subject_id',
            'type' => 'view',
            'view' => 'teachers.attendents.viewsubject',
            'model' => "App\Models\AttendentTeacher",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('teacher.hasAssignsubjects.subject', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }    
        ]);
        // $this->crud->addColumn([
        //     'label' =>  trans('flexi.subject'),
        //     'name' => 'subject',
        //     'type' => 'view',
        //     'view' => 'teachers.attendents.viewsubject',
        //     'model' => "App\Models\AttendentTeacher",
        //                     'searchLogic' => function ($query, $column, $searchTerm) {
        //                         $query->orWhereHas('teacher.hasAssignsubjects.subject', function ($q) use ($column, $searchTerm) {
        //                             $q->where('name', 'like', '%'.$searchTerm.'%');
        //                         });
        //                     }    
        // ]);
        $this->crud->addColumn([
            'label' =>  trans('flexi.user'),
            'type' => "select",
            'name' => 'user_id',
            'entity' => 'user',
            'attribute' => "name",
            'limit' => 15,    
        ]);
        $this->crud->addColumn([
            'label' =>  trans('flexi.status'),
            'name' => 'status',
            'type' => 'text',    
        ]);

        // $this->crud->addFilter([ // select2 filter
        //     'name' => 'subject_id',
        //     'type' => 'select2',
        //     'label'=> trans('flexi.subject'),
        //   ], function() {
        //       return \App\Models\Subject::all()->pluck('name', 'id')->toArray();
        //   }, function($value) { // if the filter is active
        //            $this->crud->addClause('whereHas', 'teacher.hasAssignsubjects.subject', $value);
                
        //   });

        // add asterisk for fields that are required in AttendentTeacherRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        $attendents = $request->input('attendent');
        $teacher=$request->teacher_id;
            
            foreach($request->teacher_id as $teacher){
                $hasRecord = \App\Models\AttendentTeacher::where(function ($q) use ($teacher,$request) {
                                $q->where('teacher_id', $teacher);
                                $q->where('attendent_date', $request->attendent_date);
                            })->first();

                if (!$hasRecord){
                // $date = in_array($student, $request->attendent_date) ? now() : '';
                    if($request->has('attendent')) $status = in_array($teacher, $request->attendent) ? 'Present' : 'Absent';
                    else $status = 'Absent';
                        
                    $creatattendent=\App\Models\AttendentTeacher::create([
                                                                            'teacher_id'=>$teacher,
                                                                            'user_id'   => $request->user_id,
                                                                            'attendent_date'=>$request->attendent_date,
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
        
        return redirect()->back();
        // your additional operations before save here
        //$redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        //return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
    public function view()
    {
        $user=\Auth::user();
       
        $this->crud->hasAccessOrFail('list');
        $this->data['section']=\App\Models\Section::pluck('name','id');

        $this->data['subject']=\App\Models\Subject::pluck('name','id');
        
        $this->data['crud'] = $this->crud;
        $this->data['teacher'] = \App\Models\Teacher::get();
        $this->data['attendentdate']= \App\Models\AttendentStudent::get();
       
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);
        return view('attendents.teachers.attendent_teacher',$this->data);
    }
    public function destroy($id)
    {
        $redirect_location = parent::destroy($id);
        return $redirect_location;
    }
}
