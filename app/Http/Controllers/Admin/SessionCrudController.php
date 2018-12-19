<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SessionRequest as StoreRequest;
use App\Http\Requests\UpdateSessionRequest as UpdateRequest;

/**
 * Class SessionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class SessionCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Session');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/session');
        $this->crud->setEntityNameStrings('Session', 'sessions');
        $user=\Auth::user();






        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $tabOne = trans('flexi.session');
        $tabTwo = trans('flexi.family');

        $both = 'update/create/both';
 
        $this->crud->addColumn([
            'name' => 'session', // The db column name
            'label' => trans('flexi.session'), // Table column heading
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'is_active', // The db column name
            'label' => trans('flexi.is_active'), // Table column heading
            'type' => 'text'
        ]);
        $this->crud->addField([ 
            'name' => 'session',
            'label' => trans('flexi.session'),
            'type' => 'text',
            // 'attributes' => ['pattern'=> '[0-9\-]+']
            //'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],'create');
        $this->crud->addField([ 
            'name' => 'session',
            'label' => trans('flexi.session'),
            'type' => 'text',
            'attributes' => ['disabled'=> 'disabled'],
            //'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],'update');
            $this->crud->addField(
                [ // select_from_array
                    'name' => 'is_active',
                    'label' => trans('flexi.is_active'),
                    'type' => 'select2_from_array',
                    'options' => [
                                    'yes' => 'yes',
                                    'no' => 'no',
                                ],
                    'allows_null' => true,
                    //'default' => 'one',
                    // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                    'wrapperAttributes'=>$colMd4,    
                ],$both);
        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        // add asterisk for fields that are required in SessionRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list','create','update','reorder','delete','show']);

        if($user->can('list sessions'))$this->crud->allowAccess('list');
        //if($user->can('show sessions'))$this->crud->allowAccess('show');
        if($user->can('create sessions'))$this->crud->allowAccess('create');
        if($user->can('update sessions'))$this->crud->allowAccess('update');
        if($user->can('reorder sessions'))$this->crud->allowAccess('reorder');
        if($user->can('delete sessions'))$this->crud->allowAccess('delete');
    }

    public function store(StoreRequest $request)
    {
        //return $request->session;

        // if($request->is_active == 'yes'){
        //     $spltiYear = explode('-', $request->session);
        //     // return $spltiYear[0]+1;
        //     if(date('Y') > ($spltiYear[0]+1) || date('Y') < ($spltiYear[0]-1)){
        //         \Alert::error('Year equal present date')->flash();
        //         return redirect()->back();
        //     }
        // }
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);

        if($request->is_active == 'yes'){
            $id = $this->crud->entry->id;
            
            $this->crud->addClause('where', 'id', '<>', $id)->update(['is_active' => 'no']);
            // $this->crud->addClause('id', $entryId)->update(['is_active' => 'no']);
            // return response()->json($entry);
        }
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {  
        
        // $spltiYear = explode('-',$this->crud->getCurrentEntry()->session);
        // return $spltiYear[0]+1;

        // if($request->is_active == 'yes'){
        //     $spltiYear = explode('-',$this->crud->getCurrentEntry()->session);
        //     // return $spltiYear[0]+1;
        //     if(date('Y') > ($spltiYear[0]) || date('Y') < ($spltiYear[0])){
        //         //2018 > 2019
        //         \Alert::error('Year equal present date')->flash();
        //         return redirect()->back();
        //     }
        // }
        $redirect_location = parent::updateCrud($request);
        
        if($request->is_active == 'yes'){
            $id = $this->crud->entry->id;

            $this->crud->addClause('where', 'id', '<>', $id)->update(['is_active' => 'no']);
        }
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
    public function destroy($id)
    {
        $student=count($this->crud->getCurrentEntry()->studentSessions);
        if($student > 0)
        {
            return redirect()->back();
        }

        $redirect_location = parent::destroy($id);
        return $redirect_location;
    }

    private function checkYear($request)
    {
        $spltiYear = explode('-', $request->session);
        // return $spltiYear[0]+1;
        if(date('Y') > ($spltiYear[0]+1)){
            \Alert::error('Year Bigger than now cant add')->flash();
            return redirect()->back();
        }
    }
}
