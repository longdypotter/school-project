<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AttachmentTypeRequest as StoreRequest;
use App\Http\Requests\AttachmentTypeRequest as UpdateRequest;

/**
 * Class AttachmentTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AttachmentTypeCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\AttachmentType');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/attachmenttype');
        $this->crud->setEntityNameStrings('Attachment Type', 'Attachment Types');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => trans('flexi.name'), // Table column heading
            'type' => 'text'
        ]);
        $user = \Auth::user();
        $both = 'update/create/both';

        $this->crud->addField([ 
            'name' => 'name',
            'label' => trans('flexi.name'),
            'type' => 'text',
            //'tab' => $tabOne,
            //'wrapperAttributes'=>$colMd4,           
        ],$both);

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in AttachmentTypeRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
