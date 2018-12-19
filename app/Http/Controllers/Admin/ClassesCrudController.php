<?php

namespace App\Http\Controllers\Admin;
use App\Http\Models\Classes;
use App\Http\Models\ClassSection;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ClassesRequest as StoreRequest;
use App\Http\Requests\ClassesRequest as UpdateRequest;

/**
 * Class ClassesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ClassesCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Classes');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/class');
        $this->crud->setEntityNameStrings('Class', 'classes');

         $this->crud->setShowView('classes.show');

            // //Button Custom Delete
            // $this->crud->removeButton('delete');
            // $this->crud->addButton('line','custom','view','classes.delete','right');
            // //EndButton

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $tabOne = trans('flexi.classes');
        $tabTwo = trans('flexi.family');
        $user=\Auth::user(); 
        $both = 'update/create/both';

        $this->crud->addField([
                                'name'=>'name',
                                'label'=>trans('flexi.name'),
                                'type'=>'text',       
        ],$both);

        $this->crud->addField([
                                'label'     => trans('flexi.section'),
                                'type'      => 'checklist',
                                'name'      => 'sections',
                                'entity'    => 'sections',
                                'attribute' => 'name',
                                'model'     => "\App\Models\Section",
                                'pivot'     => true,
        ],$both);

        $this->crud->addColumn([
                                'name'=>'name',
                                'label'=>trans('flexi.class')
        ],$both);

        $this->crud->addColumn([
 
                
                    'name'=>'sections',
                    'label'=>trans('flexi.section'),
                    'type'=>'view',
                    'view'=>'classes.sectionview',
                    'entity' => 'sections',
                                'model' => "App\Models\Section",
                                    'searchLogic' => function ($query, $column, $searchTerm) {
                                        $query->orWhereHas('sections', function ($q) use ($column, $searchTerm) {
                                            $q->where('name', 'like', '%'.$searchTerm.'%');
                                        });
                                    }
                
        ],$both);


            $this->crud->addFilter([ // select2 filter
                'name' => 'class_name',
                'type' => 'select2',
                'label'=> trans('flexi.class')
              ], function() {
                  return \App\Models\Classes::all()->pluck('name', 'id')->toArray();
              }, function($value) { // if the filter is active
                    
                      $this->crud->addClause('where', 'id', $value);
              });    

            //   $this->crud->addFilter([ // select2 filter
            //     'name' => 'section_name',
            //     'type' => 'select2',
            //     'label'=> trans('flexi.section')
            //   ], function() {
            //       return \App\Models\Section::all()->pluck('name', 'id')->toArray();
            //   }, function($value) {  
              
            //     $this->crud->addClause('where', 'id',$value);
                                             
            //   });   
              
          

        

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        // add asterisk for fields that are required in ClassesRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');
        
        $this->crud->denyAccess(['list','create','update','reorder','delete']);

        if($user->can('list classes'))$this->crud->allowaccess('list');
        if($user->can('create classes'))$this->crud->allowaccess('create');
        if($user->can('update classes'))$this->crud->allowaccess('update');
        if($user->can('reorder classes'))$this->crud->allowaccess('reorder');
        if($user->can('delete classes'))$this->crud->allowaccess('delete');

        if($user->hasAnyRole('Teacher'))
        {
            $teacher=$user->userRole()->first();
            //Class
            $class= \App\Models\AssignSubject::where('teacher_id',$teacher->type_id)->pluck('class_id')->unique();
            $this->crud->addClause('whereIn','id',$class);
            //EndClass
        }
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here

        $redirect_location = parent::storeCrud($request);

        // $classid=$this->crud->entry->id;

        // $classSection->create([
        //     'class_id'=>$classid
        // ]);

        
      // return  reponse()->json($request);

        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        // $section= \App\Models\Section::get();
        // return $section[0]->id;
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

        $assignsubjects=count($this->crud->getCurrentEntry()->assignsubjects);
        $downloadcenters=count($this->crud->getCurrentEntry()->downloadcenters);
        if($assignsubjects > 0)
        {
           return redirect()->back();
        }
        if($downloadcenters > 0)
        {
           return redirect()->back();
        }
        
        $entry = $this->crud->getCurrentEntry();
        $entry->sections()->detach();
        return response()->json($entry->delete());
    }
}
