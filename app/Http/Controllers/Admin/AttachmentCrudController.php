<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AttachmentRequest as StoreRequest;
use App\Http\Requests\AttachmentRequest as UpdateRequest;

/**
 * Class AttachmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AttachmentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Attachment');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/attachment');
        $this->crud->setEntityNameStrings('Attachment', 'Attachments');
        $this->crud->addButtonFromModelFunction('line', 'download', 'downloadButton', 'beginning');

        $colMd12 = ['class' => 'form-group col-md-12' ];
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $tabOne = trans('flexi.teacher');
        $tabTwo = trans('flexi.family');
        $both = 'update/create/both';

        $user= \Auth::user();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addField([ 
                    'name' => 'title',
                    'label' => trans('flexi.title'),
                    'type' => 'text',
                    'wrapperAttributes'=>$colMd4,           
        ],$both);
        
        $this->crud->addField([
                    'name' => 'type',
                    'label' => trans('flexi.type'),
                    'type' => 'select2_from_array',
                    'options' => \App\Models\AttachmentType::pluck('name','id'),
                    'allows_null' => true,
                    //'default' => 'one',
                    // 'default' => session('got_error.class_id') ?? '',
                    'wrapperAttributes'=>$colMd4,
        ],$both);

        $this->crud->addField([ 
                    'name' => 'date',
                    'type' => 'date_picker',
                    'label' => trans('flexi.date'),
                    // optional:
                    'date_picker_options' => [
                        'todayBtn' => true,
                        'format' => 'dd-mm-yyyy',
                        // 'language' => 'fr'
                    ],
                    'default' => date('Y-m-d'),
                    'wrapperAttributes'=>$colMd4,        
        ],$both);

        $this->crud->addField([ 
                    'name' =>'user_id',
                    'label' => trans('flexi.user'),
                    'value'=>$user->id,
                    'type'=>'hidden',       
        ],$both);

        $this->crud->addField([ 
                    'name' => 'description',
                    'label' => trans('flexi.description'),
                    'type' => 'textarea',
                    'wrapperAttributes'=>$colMd12,           
        ],$both);

        $this->crud->addField([ 
                    'name' => 'files',
                    'label' => trans('flexi.file'),
                    'type' => 'upload_multiple',
                    'upload' => true,          
        ],$both);

        $this->crud->addColumn([
                    'name' => 'title', 
                    'label' => trans('flexi.title'),
                    'type' => 'text'
        ]);
         $this->crud->addColumn([
                    'label' =>  trans('flexi.type'),
                    'type' => "select",
                    'name' => 'type',
                    'entity' => 'attachmenttype',
                    'attribute' => "name",
                    'limit' => 15,
        ]);
       
        $this->crud->addColumn([
                    'name' => 'description', 
                    'label' => trans('flexi.description'),
                    'type' => 'text'
        ]);
        $this->crud->addColumn([
                    'name' => 'user_id', 
                    'label' => trans('flexi.user'),
                    'type' => 'select',
                    'entity' => 'user',
                    'attribute' => 'name',
        ]);
        $this->crud->addColumn([
            
           'name' => "date", // The db column name
            'label' => trans('flexi.date'), // Table column heading
            'type' => "date",
            //'format' => 'l j F Y',
            // 'format' => '',
        ]);
        
        // TODO: remove setFromDb() and manually define Fields and Columns
       // $this->crud->setFromDb();

        // add asterisk for fields that are required in AttachmentRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        
        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list','create','update','reorder','delete','show','download']);

        if($user->can('list attachments'))$this->crud->allowAccess('list');
        if($user->can('create attachments'))$this->crud->allowAccess('create');
        if($user->can('update attachments'))$this->crud->allowAccess('update');
        if($user->can('reorder attachments'))$this->crud->allowAccess('reorder');
        if($user->can('delete attachments'))$this->crud->allowAccess('delete');
        //if($user->can('show downloadcenters'))$this->crud->allowAccess('show');
        if($user->can('download attachments'))$this->crud->allowAccess('download');

        if ($user->hasAnyRole('Teacher')) {

            $teacher = $user->userRole()->first();
            
            $this->crud->addClause('where','user_id',$teacher->user_id);
            
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
}
