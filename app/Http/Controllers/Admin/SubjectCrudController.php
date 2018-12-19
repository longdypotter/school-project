<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SubjectRequest as StoreRequest;
use App\Http\Requests\SubjectRequest as UpdateRequest;

/**
 * Class SubjectCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SubjectCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Subject');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/subject');
        $this->crud->setEntityNameStrings('Subject', 'subjects');
        $user=\Auth::user();
         //Button Custom Delete
        //  $this->crud->removeButton('delete');
        //  $this->crud->addButton('line','custom','view','subjects.delete','right');
         //EndButton

        $user=\Auth::user();

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $tabOne = trans('flexi.subject');
        $tabTwo = trans('flexi.family');
        $both = 'update/create/both';
        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();
        
        $this->crud->addField([
                        'name'=>'name',
                        'label'=>trans('flexi.name'),
                        'type'=>"text",

        ],$both);
        $this->crud->addColumn([
                        'name'=>'name',
                        'label'=>trans('flexi.name'),
        ],$both);



        // add asterisk for fields that are required in SubjectRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');

        $this->crud->denyAccess(['list','create','update','reorder','delete']);

        if($user->can('list subjects'))$this->crud->allowAccess('list');
        if($user->can('create subjects'))$this->crud->allowAccess('create');
        if($user->can('update subjects'))$this->crud->allowAccess('update');
        if($user->can('reorder subjects'))$this->crud->allowAccess('reorder');
        if($user->can('delete subjects'))$this->crud->allowAccess('delete');

        if ($user->hasAnyRole('Student')) {
            
            $student = $user->userRole()->first();
            
           // $class=\App\Models\StudentSession::where('student_id',$student->type_id)->pluck('class_id')->unique();

            $class=\App\Models\StudentSession::where('student_id',$student->type_id)->first();
            // dd($class);
            
           // $section=\App\Models\AssignSubject::where('class_id',$class)->pluck('section_id')->count();
            //dd($section);
           //dd($class);
            //$countsubject=\App\Models\AssignSubject::where('class_id',$class)->pluck('subject_id')->count(); 


            //$countsubject=\App\Models\AssignSubject::where('section_id',$section)->pluck('subject_id')->unique(); 

           // $countsubject=\App\Models\AssignSubject::where('section_id',$section)->pluck('subject_id')->count(); 
           // dd($countsubject);
          $this->crud->addClause('whereHas','assignsubjects',function($q) use($class){
            if(!empty($class->class_id)) $q->where('class_id', $class->class_id);
            if(!empty($class->section_id)) $q->where('section_id', $class->section_id);

          });
        }

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
    public function destroy($id)
    {
        $subject=count($this->crud->getCurrentEntry()->assignsubjects);
        $downloadcenters=count($this->crud->getCurrentEntry()->downloadcenters);
        
        if($downloadcenters > 0)
        {
           return redirect()->back();
        }
        if($subject > 0)
        {
            return redirect()->back();
        }
        $redirect_location=parent::destroy($id);
        return $redirect_location;
    }





    
}
