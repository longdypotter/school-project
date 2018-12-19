<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\DocumentTypeRequest as StoreRequest;
use App\Http\Requests\UpdateDocumentTypeRequest as UpdateRequest;

/**
 * Class DocumentTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DocumentTypeCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\DocumentType');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/documenttype');
        $this->crud->setEntityNameStrings('Document Type', 'Document Types');

        // //Button Custom Delete
        // $this->crud->removeButton('delete');
        // $this->crud->addButton('line','custom','view','documenttypes.delete','right');
        // //EndButton


        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => trans('flexi.name'), // Table column heading
            'type' => 'text'
        ]);
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        // $tabOne = trans('flexi.whatever');
        // $tabTwo = trans('flexi.family');
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
        //$this->crud->setFromDb();

        // add asterisk for fields that are required in DocumentTypeRequest
        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list', 'create', 'update', 'show', 'reorder', 'delete']);

        if($user->can('list documenttypes')) $this->crud->allowAccess('list');
        //if($user->can('show documenttypes')) $this->crud->allowAccess('show');
        if($user->can('create documenttypes')) $this->crud->allowAccess('create');
        if($user->can('update documenttypes')) $this->crud->allowAccess('update');
        if($user->can('reorder documenttypes')) $this->crud->allowAccess('reorder');
        if($user->can('delete documenttypes')) $this->crud->allowAccess('delete');
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
       // $this->crud->setFromDb();

        // add asterisk for fields that are required in DocumentTypeRequest
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
    public function destroy($id){
        $count = count($this->crud->getCurrentEntry()->hasDownloadCenters);
        //return response()->json($count);
        if($count > 0 )
        {
            return response()->json(['message' => 'error'], 500);
        }
        $redirect_location = parent::destroy($id);
        return $redirect_location;
    }
}
