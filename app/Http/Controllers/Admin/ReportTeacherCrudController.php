<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ReportTeacherRequest as StoreRequest;
use App\Http\Requests\ReportTeacherRequest as UpdateRequest;
use App\Libraries\Teacher as TeacherLib;
/**
 * Class ReportTeacherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ReportTeacherCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Teacher');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/reportteacher');
        $this->crud->setEntityNameStrings('Report Teacher', 'Report Teachers');

        $this->crud->denyAccess(['create', 'update', 'reorder', 'delete']);
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in ReportTeacherRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }
    public function index()
    {
        $this->crud->hasAccessOrFail('list');
  
        $this->data['session']=\App\Models\Session::pluck('session','id');
        $this->data['classes']=\App\Models\Classes::pluck('name','id');
        $this->data['section']=\App\Models\Section::pluck('name','id');
        $this->data['subject']=\App\Models\Subject::pluck('name','id');
       
       
         $this->data['entry'] = TeacherLib::getReportTeachertBy();
        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);

        return view('reports.teachers.teacher_info_list',$this->data);
    }

    // public function store(StoreRequest $request)
    // {

     
    //     // // your additional operations before save here
    //     // $redirect_location = parent::storeCrud($request);
    //     // // your additional operations after save here
    //     // // use $this->data['entry'] or $this->crud->entry
    //     // return $redirect_location;
    // }

    // public function update(UpdateRequest $request)
    // {
    //     // your additional operations before save here
    //     $redirect_location = parent::updateCrud($request);
    //     // your additional operations after save here
    //     // use $this->data['entry'] or $this->crud->entry
    //     return $redirect_location;
    // }
}
