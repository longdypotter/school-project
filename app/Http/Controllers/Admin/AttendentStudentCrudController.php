<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// use App\Libraries\AttendentStudent as AttendentStudentLib;
// use Illuminate\Support\Facades\Input;
use App\Models\AttendentStudent;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AttendentStudentRequest as StoreRequest;
use App\Http\Requests\AttendentStudentRequest as UpdateRequest;

/**
 * Class AttendentStudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AttendentStudentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\AttendentStudent');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/attendentstudent');
        $this->crud->setEntityNameStrings('Attendent Student', 'Attendent Students');

       // $this->crud->denyAccess(['create', 'update', 'reorder', 'delete']);

        $hasError = session()->exists('got_error') ? 'has-error' : '';
        $colMd6 = ['class' => 'form-group col-md-6 '.$hasError];
        $colMd4 = ['class' => 'form-group col-md-4 '.$hasError];
        $colMd3 = ['class' => 'form-group col-md-3 '.$hasError];
        $tabOne = trans('flexi.teacher');
        $tabTwo = trans('flexi.family');
        $user=\Auth::user();
        $both = 'update/create/both';
        $this->crud->addButton('top', 'create', 'view', 'attendents.students.buttonaddattendentstudent','beginning');
        
        //$this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');

        $this->crud->orderBy('attendent_date','desc');
        $this->crud->addButton('line', 'delete', 'view', 'attendents.students.buttondelete','beginning');
        $this->crud->addButton('line', 'preview', 'view', 'attendents.students.buttonpreview','beginning');
        //unique attendent_date
        $this->crud->addClause('groupBy', 'attendent_date');
        $this->crud->addClause('groupBy', 'assign_subject_id');


        // $this->crud->allowaccess('attendents.attendent_student_list');
        /*
        |-----------------------------------------------------------------------.---
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        // foreach($studentsession as $s){
        // dd($s->students);
        // }
        // TODO: remove setFromDb() and manually define Fields and Columns
       // $this->crud->setFromDb();
    //    $this->crud->addField([ 
    //                     'name' => 'class_id',
    //                     'label' => trans('flexi.class'),
    //                     'type' => 'select2_from_array',
    //                     'options' => \App\Models\Classes::pluck('name','id'),
    //                     'allows_null' => true,
    //                     'wrapperAttributes'=>$colMd4,           
    //     ],$both);
    //     $this->crud->addField([ 
    //                     'name' => 'section_id',
    //                     'label' => trans('flexi.section'),
    //                     'type' => 'select2_from_array',
    //                     'options' => \App\Models\Section::pluck('name','id'),
    //                     'allows_null' => true,
    //                     'wrapperAttributes'=>$colMd4,           
    //     ],$both);

            // $this->crud->addColumn([
            //     'label' =>  trans('flexi.attendent_date'),
            //     'name' => 'attendent_date',
            //     'type' => 'text',
            // ]);


            $this->crud->addColumn([
                            'label' =>  trans('flexi.attendent_date'),
                            'name' => 'attendent_date',
                            'type' => 'text',
                            //'view' => 'attendents.attendentviewdate',  
                            // 'type' => "date",
                            // 'format' => ' j m Y',
                                   
            ]);
            $this->crud->addColumn([
                            'label' =>  trans('flexi.teacher'),
                            'name' => 'teacher_id',
                            'type' => 'select',
                            'entity' => 'assignsubject.teacher',
                            'attribute' => 'name',  
                            'model' => "App\Models\AttendentStudent",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('assignsubject.teacher', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }                         
            ]);
            $this->crud->addColumn([
                            'label' =>  trans('flexi.class'),
                            'name' => 'class_id',
                            'type' => 'select',
                            'entity' => 'assignsubject.class',
                            'attribute' => 'name', 
                            'model' => "App\Models\AttendentStudent",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('assignsubject.class', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }              
                                     
            ]);
            $this->crud->addColumn([
                            'label' =>  trans('flexi.section'),
                            'name' => 'section_id',
                            'type' => 'select',
                            'entity' => 'assignsubject.section',
                            'attribute' => 'name', 
                            'model' => "App\Models\AttendentStudent",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('assignsubject.section', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }                      
            ]);
            $this->crud->addColumn([
                            'label' =>  trans('flexi.subject'),
                            'name' => 'assignsubject.subject.name',
                            'type' => 'select',
                            'entity' => 'assignsubject.subject',
                            'attribute' => 'name', 
                            'model' => "App\Models\AttendentStudent",
                            'searchLogic' => function ($query, $column, $searchTerm) {
                                $query->orWhereHas('assignsubject.subject', function ($q) use ($column, $searchTerm) {
                                    $q->where('name', 'like', '%'.$searchTerm.'%');
                                });
                            }                       
            ]);
            // $this->crud->addFilter([ // select2 filter
            //     'name' => 'subject',
            //     'type' => 'select2',
            //     'label'=> trans('flexi.subject'),
            //   ], function() {
            //       return \App\Models\Subject::all()->pluck('name', 'id')->toArray();
            //   }, function($value) { // if the filter is active
            //            $this->crud->addClause('Where', 'assignsubject.subject_id', $value);
                    
            //   });
            $this->crud->addFilter([ // select2 filter
                'name' => 'attendent_date',
                'type' => 'select2',
                'label'=> trans('flexi.attendent_date'),
              ], function() {
                  return \App\Models\AttendentStudent::all()->pluck('attendent_date', 'attendent_date')->toArray();
              }, function($value) { // if the filter is active
                       $this->crud->addClause('where', 'attendent_date', $value);
                    
              });
            $this->crud->addFilter([ // select2 filter
                'name' => 'subject_id',
                'type' => 'select2',
                'label'=> trans('flexi.subject')
              ], function() {
                  return \App\Models\Subject::all()->pluck('name', 'id')->toArray();
              }, function($values) { // if the filter is active
                    $this->crud->query = $this->crud->query->whereHas('assignsubject.subject', function ($query) use ($values) {
                        $query->where('subject_id', $values);
                    });
               
                    //$this->crud->addClause('whereHas','subject_id', $value);
              }); 


        // add asterisk for fields that are required in AttendentStudentRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        $this->crud->denyAccess(['list','create','update','reorder','delete','show','download']);

        if($user->can('list attendentstudents'))$this->crud->allowAccess('list');
        if($user->can('create attendentstudents'))$this->crud->allowAccess('create');
        if($user->can('update attendentstudents'))$this->crud->allowAccess('update');
        if($user->can('reorder attendentstudents'))$this->crud->allowAccess('reorder');
        if($user->can('delete attendentstudents'))$this->crud->allowAccess('delete');
        //if($user->can('show downloadcenters'))$this->crud->allowAccess('show');
        if($user->can('download attendentstudents'))$this->crud->allowAccess('download');

        if ($user->hasAnyRole('Teacher')) {

            $teacher = $user->userRole()->first();
            
            $this->crud->addClause('where','user_id',$teacher->user_id);
            
        }

    }
    public function viewattendentstudent($att)
    {
        // $attendentdate=
        $this->data['attendentdate'] = \App\Models\AttendentStudent::where('created_at',$att)->get();
        $this->data['attendentstudent']=\App\Models\AttendentStudent::get();
        
        $this->data['crud'] = $this->crud;
        return view('attendents.students.viewattendentstudent',$this->data);
        //return 2;
        // $getattendentdate=\App\Models\AttendentStudent::find($attendentdate)->first();
        // dd($getattendentdate);
    }
    // public function form()
    // {
       
    //     $this->crud->hasAccessOrFail('list');
        
    //     $this->data['classes']=\App\Models\Classes::pluck('name','id');
    
    //     $this->data['section']=\App\Models\Section::pluck('name','id');
        
    //     $this->data['crud'] = $this->crud;
        
    //     $this->data['attendentdate']= \App\Models\AttendentStudent::get();
      
    //     $this->data['entry'] = AttendentStudentLib::getReportAttendentStudentBy();
       
    //     $this->data['title'] = ucfirst($this->crud->entity_name_plural);

        
    //     return view('attendents.attendent_student',$this->data);
      
    // }
    // public function store(StoreRequest $request,$id)
    // {
    //    // return $this->crud->Entry($id)->student_id;
    //    $getid=$this->crud->getCurrentEntry();
    //     if($request->attendent_date.isNotEmpty())
    //     {
    //         dd('was complete');
    //     }
    //     else
    //     {
    //         dd('null');
    //     }
    //     // $creatattendent=\App\Models\AttendentStudent::create([
    //     //                                                         'student_id'=>$this->crud->Entry($id)->student_id,
    //     //                                                         'attendent_date'=>$request->attendent_date,
    //     // ]);
    //    // return 'hi';
    //     // your additional operations before save here
    //    // $redirect_location = parent::storeCrud($request);
    //     // your additional operations after save here
    //     // use $this->data['entry'] or $this->crud->entry
    //     //return $redirect_location;
    // }
    // public function createatt(StoreRequest $request)
    // {

    // //     $post_data = Input::get('attendent');
    // // //    dd($post_data);
    // //     if(is_array($post_data))
    // //     {
    // //         if($request->has('attendent'))
    // //         {
    // //         foreach ($post_data as $checkbox)
    // //         {       
    // //                 $product = \App\Models\StudentSession::find($checkbox);
    // //                 //echo $product;

    // //             if(!empty($product))
    // //             {
    // //                dd('save');
    // //             }
    // //             else{
    // //                 // $product->is_checked    = '0';
    // //                 dd('upate');
    // //             }
    // //                 // $product->save();
    // //         }
    // //     }
    // //     }

    // // Session::flash('success', 'Success message here');
    // // return Redirect::to('overview');




    //     //dd(Input::());
    //    $get=Input::all();
    //     $getstudentid=\App\Models\StudentSession::get();
        
    //      $attendents = $request->input('attendent');
    //        // dd($get);
    //     // dd($cameraVideo);
    //     if ( $request->has('attendent')) {
    //         // dd($request->attendent);
    //         foreach($attendents as $a){
    //           //  echo $a;
    //         //     $n=Input::all();
               
    //                 $creatattendent=\App\Models\AttendentStudent::create([
    //                                                                         'student_id'=>$a,
    //                                                                         'attendent_date'=>$request->attendent_date,
    //                 ]);
    //                 \Alert::success('<i class="fa fa-check"></i> Was Be Add Attendent Complete.')->flash();
    //             }
                
    //         //}
    //     }
    //     else{
    //       //      dd($getstudentid->attendentstudent);
    //     //   $post_data = Input::get('attendent');
    //     //   if(is_array($post_data))   {
    //     //     foreach ($post_data as $checkbox)
    //     //     {       
    //     //             $product = \App\Models\StudentSession::find($checkbox);
    //     //             foreach($product->attendentstudent as $ss){
    //     //                 $getiddelete=$ss;
    //     //                 $getiddelete->delete();
    //     //             }
    //     //   }
    //     // }
    //         foreach($getstudentid as $gets)
    //         {
    //             foreach($gets->attendentstudent as $ss)
    //             {
    //                 $getfindid=$ss;
    //                 $getfindid->delete();
    //                  \Alert::success('<i class="fa fa-check"></i> Was Be Update Complete.')->flash();
    //             }
    //         }
    //        //dd('empty');
    //         // $post_data = Input::get('attendent');
    //         // dd($post_data);
    //         // //if(is_array($post_data))   {
            
    //         // foreach ($post_data as $checkbox)
    //         // {       
    //         //         $product = \App\Models\StudentSession::find($checkbox);
    //         //         if(empty($checkbox))
    //         //      {
    //         //         dd('save');
    //         //     }
    //         //        //$product->attendentstudent->delete();
    //         // }
    //         // \Alert::success('<i class="fa fa-check"></i> Was Be delete Attendent Complete.')->flash();

    //         // }
    //     }
      
    //     // else if($att->attendent_date != null)


    //      return redirect()->back();
    // }

    // public function update(UpdateRequest $request)
    // {
    //     // your additional operations before save here
    //     $redirect_location = parent::updateCrud($request);
    //     // your additional operations after save here
    //     // use $this->data['entry'] or $this->crud->entry
    //     return $redirect_location;
    // }

        //public function <p>require</p>
        public function deleteattendentstudent($id)
        {
            //return 'hi';
           
                $attendentdatedelete=\App\Models\AttendentStudent::where('created_at',$id);
                // if (confirm($attendentdate == true) {
                
                $attendentdatedelete->delete();
               //x }
                \Alert::success('<i class="fa fa-check"></i> Was Be delete Attendent Complete.')->flash();
           
            
            return redirect()->back();
            
        }

    }
