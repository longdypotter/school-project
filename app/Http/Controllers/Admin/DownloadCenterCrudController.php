<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\DownloadCenterRequest as StoreRequest;
use App\Http\Requests\UpdateDownloadCenterRequest as UpdateRequest;

/**
 * Class DownloadCenterCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class DownloadCenterCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\DownloadCenter');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/downloadcenter');
        $this->crud->setEntityNameStrings('Download Center', 'Download Centers');
        //$this->crud->setShowView('download_centers.show');

        $this->crud->addButtonFromModelFunction('line', 'download', 'downloadButton', 'beginning');

       
       $this->user= \Auth::user();
      //  dd($showpc);

     //   $this->crud->addClause('where','author_id','=',\Auth::user()->id);
        

        $this->crud->addFilter([ // date filter
            'type' => 'date',
            'name' => 'public_date',
            'label'=> trans('flexi.public_date'),
          ],
          false,
          function($value) { // if the filter is active, apply these constraints
                            $this->crud->addClause('where', 'public_date', '=', $value);
          });
          
        // $this->crud->addFilter([ // date filter
        //     'type' => 'text',
        //     'name' => 'class',
        //     'label'=> trans('flexi.class'),
        //   ],
        //   false,
        //   function($value) { // if the filter is active, apply these constraints
        //                     $this->crud->query->whereHas('class',function($query) use($value){
        //                     $query->where('name','like',"%$value%");
        //                     });
        //   });

        $this->crud->addFilter([ // select2 filter
            'name' => 'class',
            'type' => 'select2',
            'label'=> trans('flexi.class'),
          ], function() {
              return \App\Models\Classes::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
                   $this->crud->addClause('where', 'class_id', $value);
                
          });

          $this->crud->addFilter([ // select2 filter
            'name' => 'section',
            'type' => 'select2',
            'label'=> trans('flexi.section'),
          ], function() {
              return \App\Models\Section::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
                   $this->crud->addClause('where', 'section_id', $value);
                
          });

          $this->crud->addFilter([ // select2 filter
            'name' => 'subject',
            'type' => 'select2',
            'label'=> trans('flexi.subject'),
          ], function() {
              return \App\Models\Subject::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
                   $this->crud->addClause('where', 'subject_id', $value);
                
          });

        // $this->crud->addFilter([ // date filter
        //     'type' => 'text',
        //     'name' => 'section',
        //     'label'=> trans('flexi.section'),
        //   ],
        //   false,
        //   function($value) { // if the filter is active, apply these constraints
        //                     $this->crud->query->whereHas('section',function($query) use($value){
        //                     $query->where('name','like',"%$value%");
        //                     });
        //   });
        // $this->crud->addFilter([ // date filter
        //     'type' => 'text',
        //     'name' => 'subject',
        //     'label'=> trans('flexi.subject'),
        //   ],
        //   false,
        //   function($value) { // if the filter is active, apply these constraints
        //                     $this->crud->query->whereHas('subject',function($query) use($value){
        //                     $query->where('name','like',"%$value%");
        //                     });
        //   });

        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $user = \Auth::user();
        $both = 'update/create/both';


        $this->crud->addColumn([
            'name' => 'name', 
            'label' => trans('flexi.name'),
            'type' => 'text'
        ]);
        $this->crud->addColumn([

            'label' =>  trans('flexi.document_type'),
            'type' => "select",
            'name' => 'document_type_id',
            'entity' => 'documentType',
            'attribute' => "name",
            'limit' => 15,
        ]);
       
        $this->crud->addColumn([

            'label' =>  trans('flexi.class'),
            'type' => "select",
            'name' => 'class_id',
            'entity' => 'class',
            'attribute' => "name",
            'limit' => 15,
        ]);
        $this->crud->addColumn([

            'label' =>  trans('flexi.section'),
            'type' => "select",
            'name' => 'section_id',
            'entity' => 'section',
            'attribute' => "name",
            'limit' => 15,
        ]);
        $this->crud->addColumn([

            'label' =>  trans('flexi.subject'),
            'type' => "select",
            'name' => 'subject_id',
            'entity' => 'subject',
            'attribute' => "name",
            'limit' => 15,
        ]);
        $this->crud->addColumn([

            'label' =>  trans('flexi.user'),
            'type' => "select",
            'name' => 'user_id',
            'entity' => 'user',
            'attribute' => "name",
            'limit' => 15,
        ]);
        $this->crud->addColumn([
            // 'name' => 'public_date',
            // 'label' => trans('flexi.public_date'),
            // 'type' => 'text',
            
           // 'default' => date('d-m-Y'),
           'name' => "public_date", // The db column name
            'label' => trans('flexi.public_date'), // Table column heading
            'type' => "date",
            //'format' => 'l j F Y',
            // 'format' => '',
        ]);

        $this->crud->addField([ 
            'name' => 'name',
            'label' => trans('flexi.name'),
            'type' => 'text',
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 

            'name' => 'document_type_id',
            'label' => trans('flexi.document_type'),
            'type' => 'select2_from_array',
            'options' => \App\Models\DocumentType::pluck('name','id'),
            'allows_null' => true,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            // 'name' => 'public_date',
            // 'label' => trans('flexi.public_date'),
            // 'type' => 'datetime_picker',
            // //'tab' => $tabOne,
            // 'datetime_picker_options' => [
            //     'format' => 'DD-MM-YYYY',
            // ],
            // 'allows_null' => true,
            // 'default' => date('d-m-Y'),
            'name' => 'public_date',
            'type' => 'date_picker',
            'label' => trans('flexi.public_date'),
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

            'name' => 'class_id',
            'label' => trans('flexi.class'),
            'type' => 'select2_from_array',
            'options' => \App\Models\Classes::pluck('name','id'),
            'allows_null' => true,
            'wrapperAttributes'=>$colMd6,           
        ],$both);

        $this->crud->addField([ 

            'name' => 'section_id',
            'label' => trans('flexi.section'),
            'type' => 'select2_from_array',
            'options' => \App\Models\Section::pluck('name','id'),
            'allows_null' => true,
            'wrapperAttributes'=>$colMd6,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'subject_id',
            'label' => trans('flexi.subject'),
            'type' => 'select2_from_array',
            'options' => \App\Models\Subject::pluck('name','id'),
            'allows_null' => true,         
        ],$both);

    $this->crud->addField([ 
            'name' =>'user_id',
            'label' => trans('flexi.user'),
          //  'type' => 'select2',
            //'entity' => 'user',
            'value'=>$this->user->id,
            'type'=>'hidden',
            //'attribute' => 'name'
            
        ],$both);


        // $this->crud->addField([
        //     'name' => 'user_id',
        //     'label' => 'User',
        //     'type'=>'select',
        //     'attribute' => 'name',
        //     'model'=>\Auth::user()->name,
        // ]);

        $this->crud->addField([ 
            'name' => 'description',
            'label' => trans('flexi.description'),
            'type' => 'textarea',
            //'tab' => $tabOne,
            //'wrapperAttributes'=>$colMd4,           
        ],$both);

        // $this->crud->addField([ 
        //     'name' => 'file',
        //     'label' => trans('flexi.file'),
        //     'type' => 'upload',
        //     'upload' => true,
        //     //'tab' => $tabOne,
        //     'disk' => 'uploads',
        //     //'wrapperAttributes'=>$colMd4,           
        // ],$both);

        $this->crud->addField([ 
            'name' => 'file',
            'label' => trans('flexi.file'),
            'type' => 'upload_multiple',
            'upload' => true,
            //'tab' => $tabOne,
            'disk' => 'uploads',
            //'limit'=> 10,
            //'wrapperAttributes'=>$colMd4,           
        ],$both);

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        // add asterisk for fields that are required in DownloadCenterRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list','create','update','reorder','delete','show','download']);

        if($user->can('list downloadcenters'))$this->crud->allowAccess('list');
        if($user->can('create downloadcenters'))$this->crud->allowAccess('create');
        if($user->can('update downloadcenters'))$this->crud->allowAccess('update');
        if($user->can('reorder downloadcenters'))$this->crud->allowAccess('reorder');
        if($user->can('delete downloadcenters'))$this->crud->allowAccess('delete');
        //if($user->can('show downloadcenters'))$this->crud->allowAccess('show');
        if($user->can('download downloadcenters'))$this->crud->allowAccess('download');

        if ($user->hasAnyRole('Student')) {
            $student = $user->userRole()->first();
       
            $class = \App\Models\StudentSession::where('student_id', $student->type_id)->first();
          //  dd($class);
           // $teacherid=\App\Models\AssignSubject::where('class_id',$class->class_id)->get();
          // dd($teacherid);
            $subject = \App\Models\AssignSubject::where('class_id', $class->class_id)
             ->where('section_id', $class->section_id)->where('teacher_id', $class->teacher_id)->first();
             
            $this->crud->addClause('where', function ($q) use ($class, $subject) {
                if(!empty($class->class_id)) $q->where('class_id', $class->class_id);

                if(!empty($class->user_id)) $q->where('user_id', $teacherid->teacher_id);

                // if(!empty($class->user_id)) $q->where('user_id', $student->user_id);
                
                if(!empty($class->section_id) && !empty($class->class_id)) $q->where('section_id', $class->section_id);

                if(!empty($subject->subject_id) && !empty($class->section_id) && !empty($class->class_id)) $q->where('subject_id', $subject->subject_id);

                if(!empty($subject->subject_id) && !empty($class->section_id) && !empty($class->class_id)) $q->where('public_date', '<=', date('Y-m-d'));

                
            });

            // if(!empty($class->class_id)) $this->crud->addClause('orWhereNull', 'class_id');
            // if(!empty($class->section_id) && !empty($class->class_id)) $this->crud->addClause('orWhereNull', 'section_id');
            // if(!empty($subject->subject_id) && !empty($class->section_id) && !empty($class->class_id)) $this->crud->addClause('orWhereNull', 'subject_id');

        }
        if ($user->hasAnyRole('Teacher')) {
            $student = $user->userRole()->first();
            
            $class = \App\Models\AssignSubject::where('teacher_id', $student->type_id)->pluck('teacher_id')->unique();
          
           //dd($class);
            //DownloadCenter
         // $downloadcenters= \App\Models\DownloadCenter::where('user_id',$student->user_id)->get();
        // dd($downloadcenters);

            // $this->crud->addClause('where',function($q) use($class,$teacherid){
            //     // $q->where('user_id',$class->teacher_id);
            //    // $q->whereIn('class_id',$class);
            //     $q->whereIn('user_id',$teacherid);
                
            // });
           $this->crud->addClause('where','user_id',$student->user_id);
            
            
            
            
                        //EndDownloadCenter
            
            
            

            // $subject = \App\Models\AssignSubject::where('teacher_id', $class->class_id)
            //  ->where('section_id', $class->section_id)->first();
             
            // $this->crud->addClause('where', function ($q) use ($class, $subject) {
            //     if(!empty($class->class_id)) $q->where('class_id', $class->class_id);
                
            //     if(!empty($class->section_id) && !empty($class->class_id)) $q->where('section_id', $class->section_id);

            //     if(!empty($subject->subject_id) && !empty($class->section_id) && !empty($class->class_id)) $q->where('subject_id', $subject->subject_id);

            //     if(!empty($subject->subject_id) && !empty($class->section_id) && !empty($class->class_id)) $q->where('public_date', '<=', date('Y-m-d'));

       // });
        //     // $this->crud->addClause('orWhereNull', 'class_id');
        //     // $this->crud->addClause('orWhereNull', 'section_id');
        //     // $this->crud->addClause('orWhereNull', 'subject_id');

         }


    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        
    // $s= \Auth::user()->id;
       // dd($s);
    //$downloadcenter = \App\Models\DownloadCenter::create(['user_id'=>$s]);
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
    // public function download($id){
    //     $entry = $this->crud->getEntry($id);
    //     $disk = \Storage::disk('uploads');

    //     if (!$disk->exists($entry->file)) {
    //         abort(404);
    //     }
    //     // return response()->json($entry);
    //     return response()->download($entry->file);


    // }
}
