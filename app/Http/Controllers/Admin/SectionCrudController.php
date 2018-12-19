<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SectionRequest as StoreRequest;
use App\Http\Requests\SectionRequest as UpdateRequest;

/**
 * Class SectionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SectionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Section');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/section');
        $this->crud->setEntityNameStrings('Section', 'sections');

        //  //Button Custom Delete
        //  $this->crud->removeButton('delete');
        //  $this->crud->addButton('line','custom','view','sections.delete','right');
        //  //EndButton

        $user=\Auth::user();
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $tabOne = trans('flexi.section');
        $tabTwo = trans('flexi.family');
        $both = 'update/create/both';

        // TODO: remove setFromDb() and manually define Fields and Columns
       // $this->crud->setFromDb();
       $this->crud->addField([
                                'name'=>'name',
                                'label'=>trans('flexi.name'),
                                'type'=>'text',
       ],$both);
        $this->crud->addColumn([
                                'name'=>'name',
                                'label'=>trans('flexi.name')
        ],$both);
        // add asterisk for fields that are required in SectionRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list','create','update','reorder','delete']);
        
        if($user->can('list sections'))$this->crud->allowaccess('list');
        if($user->can('create sections'))$this->crud->allowaccess('create');
        if($user->can('update sections'))$this->crud->allowaccess('update');
        if($user->can('reorder sections'))$this->crud->allowaccess('reorder');
        if($user->can('delete sections'))$this->crud->allowaccess('delete');
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

        $this->crud->hasAccessOrFail('delete');
        $section=count($this->crud->getCurrentEntry()->assignsubjects);
        $downloadcenters=count($this->crud->getCurrentEntry()->downloadcenters);
        
        if($downloadcenters > 0)
        {
           return redirect()->back();
        }
        if($section > 0)
        {
           return redirect()->back();
        }
        $entry = $this->crud->getEntry($id);
        $entry->classes()->detach();
        return response()->json($entry->delete());
    }
}
