<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\FileTypeRequest as StoreRequest;
use App\Http\Requests\FileTypeRequest as UpdateRequest;

/**
 * Class FileTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class FileTypeCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\FileType');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/filetype');
        $this->crud->setEntityNameStrings('File Type', 'File Types');
        $user=\Auth::user();

        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $both = 'update/create/both';
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addField([ 
            'name' => 'name',
            'label' => trans('flexi.name'),
            'type' => 'text',
            // 'tab' => $tabOne,
            // 'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addColumn([
            'name'=>'name',
            'label'=> trans('flexi.name')
            ]);
        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->setFromDb();

        // add asterisk for fields that are required in FileTypeRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list','create','update','reorder','delete']);
        
        if($user->can('list filetypes'))$this->crud->allowaccess('list');
        if($user->can('create filetypes'))$this->crud->allowaccess('create');
        if($user->can('update filetypes'))$this->crud->allowaccess('update');
        if($user->can('reorder filetypes'))$this->crud->allowaccess('reorder');
        if($user->can('delete filetypes'))$this->crud->allowaccess('delete');    
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
        $student=count($this->crud->getCurrentEntry()->students);
        
        if($student > 0)
        {
           return redirect()->back();
        }
        $redirect_location = parent::destroy($id);
        return $redirect_location;
    }
}
