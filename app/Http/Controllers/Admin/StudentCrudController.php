<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;


// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StudentRequest as StoreRequest;
use App\Http\Requests\StudentRequest as UpdateRequest;
use App\Models\Files;

/**
 * Class StudentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StudentCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
 
        $this->crud->setModel('App\Models\Student');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/student');
        $this->crud->setEntityNameStrings('Student', 'students');
        $this->crud->allowaccess('show');
        $this->crud->with(['file']);
        $this->crud->enableExportButtons();
        
      //  $this->crud->setListView('students.download');
    //     [
    //     'name' => 'name', // The db column name
    //     'label' => "Tag Name", // Table column heading
    //     'type' => 'view',
    //     'view' => 'students.download', // or path to blade file
    //   ];

        '<a><i class="fa fa-file-pdf-o"></i></span></a>';
       
        // dd(\App\Models\Student::find(15)->with(['file'])->first());

        // $this->crud->orderBy('id','desc')->where('student_status','active')->get();
        $this->crud->setShowView('students.show');
        
       // $this->crud->removeButton('delete');

        $this->crud->orderBy('id', 'desc');

        // $this->crud->addFilter();

        //  $this->crud->removeButton('delete');
        //$this->crud->addButton('line','custom','view','student.button','end');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        // $this->crud->setFromDb();

        $colMd12 =['class'=> 'form-group col-md-12' ]; 
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        
        $tabOne = trans('flexi.personal');
        $tabTwo = trans('flexi.family');
        // $tabThree = trans('flexi.heath');
        // $tabFour = trans('flexi.pre-Test_Result');
        // $tabFive = trans('flexi.criminal');
        // $tabSix = trans('flexi.document');
        $tabSeven = trans('flexi.student_section');
        $user = \Auth::user();
        $both = 'update/create/both';
        $create = 'create';
       
       // $this->crud->enableAjaxTable();

        $this->crud->denyAccess(['list','create','update','reorder','delete','download']);

        if($user->can('list students')) $this->crud->allowAccess('list');
        if($user->can('show students')) $this->crud->allowAccess('show');
        if($user->can('create students')) $this->crud->allowAccess('create');
        if($user->can('update students')) $this->crud->allowAccess('update');
        if($user->can('reorder students')) $this->crud->allowAccess('reorder');
        if($user->can('delete students')) $this->crud->allowAccess('delete');

        if($user->can('download students')) $this->crud->allowAccess('download');

        // $this->crud->addFilter([ 
        //     'name' => 'class',
        //     'type' => 'text',
        //     'label'=> trans('flexi.class')
        //   ],false,
        //   function($value) {
        //       $this->crud->query->whereHas('studentsession.classes',function($query) use($value)
        //       {
        //         $query->where('name','LIKE',"%$value%");
        //       });
        //   });



        //   $this->crud->addFilter([ // select2 filter
        //     'name' => 'class_name',
        //     'type' => 'select2',
        //     'label'=> trans('flexi.class')
        //   ], function() {
        //       return \App\Models\Classes::all()->pluck('name', 'id')->toArray();
        //   }, function($value) { // if the filter is active
        //     $this->crud->query->whereHas('studentsession.classes',function($query) use($value)
        //       {
        //         $query->where('name','LIKE',"%$value%");
        //         //$this->crud->addClause('where', 'class_id', $value);
        //       });
        //   });  

          $this->crud->addFilter([ // select2 filter
            'name' => 'class_id',
            'type' => 'select2',
            'label'=> trans('flexi.class')
          ], function() {
            return \App\Models\Classes::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
            $this->crud->query->whereHas('studentsession',function($query) use($value)
              {
                $query->where('class_id',$value);
                //$this->crud->addClause('where', 'class_id', $value);
              });
          });  

          $this->crud->addFilter([ // select2 filter
            'name' => 'section_id',
            'type' => 'select2',
            'label'=> trans('flexi.section')
          ], function() {
              return \App\Models\Section::all()->pluck('name', 'id')->toArray();
          }, function($value) { // if the filter is active
            $this->crud->query->whereHas('studentsession',function($query) use($value)
              {
                $query->where('section_id',$value);
                //$this->crud->addClause('where', 'class_id', $value);
              });
          });  

          $this->crud->addFilter([ // select2 filter
            'name' => 'student_status',
            'type' => 'select2',
            'label'=> trans('flexi.status'),
            // 'options'=> \App\Models\Student::all()->pluck('student_status'),
          ],[
                'active'=>'active',
                'inactive'=>'inactive',
            ],
          function($value) { // if the filter is active
                $this->crud->addClause('where', 'student_status', $value);
          });  
          
                // $this->crud->addField([ 
        //     'name' => 'student_status',
        //     'label' => trans('flexi.student_status'),
        //     'type' => 'select2_from_array',
        //     'options' => \App\Models\Student::pluck('student_status'),
        //     'allows_null' => false,
        //     'tab' => $tabSeven,
        //     'wrapperAttributes'=>$colMd4,           
        // ],$create);
          
        //   $this->crud->addFilter([ // select2 filter
        //     'name' => 'section_name',
        //     'type' => 'select2',
        //     'label'=> trans('flexi.section')
        //   ], function() {
        //       return \App\Models\Section::all()->pluck('name', 'id')->toArray();
        //   }, function($value) { // if the filter is active
        //          // $this->crud->addClause('where', 'section_id', $value);
        //          $this->crud->query->whereHas('studentsession.sections',function($query) use($value)
        //       {
        //          $query->where('name','LIKE',"%$value%");
        //         //$this->crud->addClause('where', 'name', $value);
        //       });
        //   }); 

        // $this->crud->addFilter([ // select2 filter
        //     'name' => 'session',
        //     'type' => 'text',
        //     'label'=> trans('flexi.session')
        //   ],false,
        //   function($value) { 
        //       $this->crud->query->whereHas('studentsession.sessions',function($query) use($value)
        //       {
        //         $query->where('session','LIKE',"%$value%");
        //       });
        //   });



        //   $this->crud->addFilter([ // select2 filter
        //     'name' => 'section',
        //     'type' => 'text',
        //     'label'=> trans('flexi.section')
        //   ],false,
        //   function($value) { 
        //       $this->crud->query->whereHas('studentsession.sections',function($query) use($value)
        //       {
        //         $query->where('name','LIKE',"%$value%");
        //       });
        //   });
          

          //    

        $this->crud->addField([ 
            'name' => 'khmer_name',
            'label' => trans('flexi.khmer_name'),
            'type' => 'text',
            'tab' => $tabOne,
           'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'english_name',
            'label' => trans('flexi.english_name'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'gender',
            'label' => trans('flexi.gender'),
            'type' => 'select2_from_array',
            'options' => ['ប្រុស' => 'ប្រុស', 'ស្រី' => 'ស្រី'],
            'allows_null' => true,
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'ethnicity',
            'label' => trans('flexi.ethnicity'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'nationality',
            'label' => trans('flexi.nationality'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        

        $this->crud->addField([ 
            'name' => 'date_of_birth',
            'label' => trans('flexi.date_of_birth'),
            'type' => 'date_picker',
            'date_picker_options' => [
                'todayBtn' => true,
                'format' => 'dd-mm-yyyy',
                'language' => 'en'
             ],
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'place_of_birth',
            'label' => trans('flexi.place_of_birth'),
            'type' => 'textarea',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd12,           
        ],$both);


        // $this->crud->addField([ 
        //     'name' => 'place_of_birth',
        //     'label' => trans('flexi.place_of_birth'),
        //     'type' => 'flexiaddress',
        //     'tab' => $tabOne,
        //     'wrapperAttributes'=> $colMd12,           
        // ],$both);

        $this->crud->addField([ 
            'name' => 'status',
            'label' => trans('flexi.status'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'occupation',
            'label' => trans('flexi.occupation'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);


        $this->crud->addField([ 
            'name' => 'education',
            'label' => trans('flexi.education'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'health',
            'label' => trans('flexi.health'),
            'type' => 'textarea',
            'tab' => $tabOne,
            //'wrapperAttributes'=>$colMd4,           
        ],$both);
        
        $this->crud->addField([ 
            'name' => 'phone',
            'label' => trans('flexi.phone'),
            'type' => 'number',
            'tab' => $tabOne,
            'wrapperAttributes'=> $colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'email',
            'label' => trans('flexi.email'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd4,         
        ],$both);

        $this->crud->addField([ // select_from_array
            'name' => 'student_status',
            'label' => trans('flexi.student_status'),
            'type' => 'select2_from_array',
            'options' => ['active' => 'active', 'inactive' => 'inactive'],
            'allows_null' => false,
            //'default' => 'one',
            'tab' => $tabOne,
            'wrapperAttributes'=> $colMd4,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ],$both);
        
        
        $this->crud->addField([ 
            'name' => 'house_no',
            'label' => trans('flexi.house_no'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd6,           
        ],$both);
        
        $this->crud->addField([ 
            'name' => 'street_no',
            'label' => trans('flexi.street_no'),
            'type' => 'text',
            'tab' => $tabOne,
            'wrapperAttributes'=>$colMd6,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'address',
            'label' => trans('flexi.address'),
            'type' => 'flexiaddress',
            'tab' => $tabOne,
            'wrapperAttributes'=> $colMd12,           
        ],$both);
 
        $this->crud->addField([ // image
            'name' => "profile",
            'label' => trans('flexi.profile'),
            'type' => 'image' ,
            'upload' => true,
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
            // 'disk' => 'public', // in case you need to show images from a different disk
            // 'prefix' => 'storage/', // in case you only store the filename in the database, this text will be prepended to the database value
            'tab'=> $tabOne,

        ],$both);

        $this->crud->addField([ 
            'name' => 'father_name',
            'label' => trans('flexi.father_name'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'father_occupation',
            'label' => trans('flexi.father_occupation'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);
        $this->crud->addField([ 
            'name' => 'father_phone',
            'label' => trans('flexi.father_phone'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'mother_name',
            'label' => trans('flexi.mother_name'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'mother_occupation',
            'label' => trans('flexi.mother_occupation'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        
        
        $this->crud->addField([ 
            'name' => 'mather_phone',
            'label' => trans('flexi.mother_phone'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);
        $this->crud->addField([ 
            'name' => 'parent_house_no',
            'label' => trans('flexi.parent_house_no'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd6,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'parent_street_no',
            'label' => trans('flexi.parent_street_no'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd6,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'parent_address',
            'label' => trans('flexi.parent_address'),
            'type' => 'flexiaddress',
            'tab' => $tabTwo,   
            'wrapperAttributes'=>$colMd12,           
        ],$both);

            $this->crud->addField([   // CustomHTML
                'name' => 'separator',
                'type' => 'custom_html',
                'value' => '<hr>',
                'tab' => $tabTwo,
            ]);

        $this->crud->addField([ 
            'name' => 'guardian_name',
            'label' => trans('flexi.guardian_name'),
            'type' => 'text',
        
            'tab' => $tabTwo,
            'wrapperAttributes'=>[
                'class' => 'form-group col-md-4',
                
            ],           
        ],$both);

        $this->crud->addField([ 
            'name' => 'guardian_occupation',
            'label' => trans('flexi.guardian_occupation'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'guardian_phone',
            'label' => trans('flexi.guardian_phone'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd4,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'guardian_house_no',
            'label' => trans('flexi.guardian_house_no'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd6,           
        ],$both);


        $this->crud->addField([ 
            'name' => 'guardian_street_no',
            'label' => trans('flexi.guardian_street_no'),
            'type' => 'text',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd6,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'guardian_address',
            'label' => trans('flexi.guardian_address'),
            'type' => 'flexiaddress',
            'tab' => $tabTwo,
            'wrapperAttributes'=>$colMd12,           
        ],$both);

        $this->crud->addField([ 
            'name' => 'session_id',
            'label' => trans('flexi.session'),
            'type' => 'select2_from_array',
            'options' => \App\Models\Session::pluck('session','id'),
            'allows_null' => true,
            'tab' => $tabSeven,
            'wrapperAttributes'=>$colMd4,           
        ],$create);

        $this->crud->addField([ 
            'name' => 'class_id',
            'label' => trans('flexi.class'),
            'type' => 'select2_from_array',
            'options' => \App\Models\Classes::pluck('name','id'),
            'allows_null' => true,
            'tab' => $tabSeven,
            'wrapperAttributes'=>$colMd4,           
        ],$create);

  

        $this->crud->addField([ 
            'name' => 'section_id',
            'label' => trans('flexi.section'),
            'type' => 'select2_from_array',
            'options' => \App\Models\Section::pluck('name','id'),
            'allows_null' => true,
            'tab' => $tabSeven,
            'wrapperAttributes'=>$colMd4,           
        ],$create);

        // $this->crud->addColumn([
        //     'name'=>'khmer_name',
        //     'label'=>trans('flexi.khmer_name')
        // ]);



        $this->crud->addColumn([
            'name'=>'english_name',
            'label'=>trans('flexi.name')
        ]);
     


        // $test = \App\Models\Student::find(5);
        // dd($test->userRole()->first()->user()->first());

        $this->crud->addColumn([
            'name'=>'gender',
            'label'=>trans('flexi.gender')
        ]);
        $this->crud->addColumn([
            'name'=>'studentsession.classes.name',
            'label'=>trans('flexi.class'),
            'type' => 'text',
             'entity' => 'classes',
            //     //'attribute' => "cruise_ship_name_date", // combined name & date column
            'model' => "App\Models\Class",
            'searchLogic' => function ($query, $column, $searchTerm) {
                         $query->orWhereHas('studentsession.classes', function ($q) use ($column, $searchTerm) {
                        $q->where('name', 'like', '%'.$searchTerm.'%');
                      });
                   }
        ],$both);
       

        $this->crud->addColumn([
            'name'=>'studentsession.sections.name',
            'label'=>trans('flexi.section'),
            'type' => 'text',
             'entity' => 'sections',
            //     //'attribute' => "cruise_ship_name_date", // combined name & date column
            'model' => "App\Models\Section",
            'searchLogic' => function ($query, $column, $searchTerm) {
                         $query->orWhereHas('studentsession.sections', function ($q) use ($column, $searchTerm) {
                        $q->where('name', 'like', '%'.$searchTerm.'%');
                      });
                   }
        ],$both);
        
        
        $this->crud->addColumn([
            'name'=>'email',
            'label'=>trans('flexi.email'),
        ]);
        $this->crud->addColumn([
            'name'=>'student_status',
            'label'=>trans('flexi.status'),
            //'options' => \App\Models\Student::where('student_status','inactive'),
        ]);

 

    //     $this->crud->addColumn([
    //         'name'=>'addressFull._path_en',
    //         'label'=>'flexi.address',
    //         'type' => 'closure',
    // 'function' => function($entry) {
    //     return 'Created on '.optional($entry->addressFull)->_path_en;
    // }
    //     ]);
        $this->crud->addColumn([
            'name'=>'phone',
            'label'=>trans('flexi.phone'),
        ]);
        $this->crud->addColumn([
            'name' => 'health',
            'label' => trans('flexi.health'),
            'type' => 'closure',
            'function' => function($entry) {
                $get = $entry->healths->sortByDesc('id')->first();
                return $get['title'];
            }
        ]);

        // add asterisk for fields that are required in StudentRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        if ($user->hasAnyRole('Student')) {
            $getCurrentStudent = optional($user->userRole);
            $this->crud->addClause('where', 'id', $getCurrentStudent->type_id);

        }
        if($user->hasAnyRole('Teacher'))
        {
            $teacher=$user->userRole()->first();


            $class = \App\Models\AssignSubject::where('teacher_id',$teacher->type_id)->get()->groupBy('class_id');
            // dd($class->toArray());
            $this->crud->addClause('whereHas','studentsessions',function($q) use($class){
                            // $q->whereIn('class_id',$class);
                            $q->where(function ($qq) use ($class) {
                                foreach($class as $k => $v):
                                    // dd($v->pluck('section_id'));
                                    $qq->orWhere('class_id', $k);
                                    $qq->whereIn('section_id', $v->pluck('section_id'));
                                endforeach;
                            });
                        });
        }
    }


    public function store(StoreRequest $request)
    {
        // your additional operations before save here
    $redirect_location = parent::storeCrud($request);
        $users=User::where('email',$request->email)->first();
        if(!$users)
        {
            $users=new User;
            $users->name=$request->english_name;
            $users->email=$request->email;
            $users->password=bcrypt('1111111111');
            $users->save();

            auth()->user()->find($users->id)->assignRole('Student');
        }
        $createUserTeacher= \App\Models\UserRole::create([
                                                        'user_id'=>$users->id,
                                                        'type_id'=>$this->crud->entry->id,
                                                        'type_role'=>"Student",
        ]);
      
        $createsection = $this->crud->entry->studentsessions()->create($request->all());
        //dd($createsection->id);

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        
         //   dd($request->profile);
        
        $redirect_location = parent::updateCrud($request);
        
        
        //$this->crud->entry->file()->update($request->only(['name','type','name']));
        // $updatefile->file()->update();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        
        //update email user
        $this->crud->getCurrentEntry()->userRole()->first()->user->update([
                                                                            'name'=>$request->english_name,
                                                                            'email'=>$request->email
                                                                         ]);
        //end update email user

        return $redirect_location;
    }

    public function destroy($id)
    {
     //$student=\App\Models\Student::findOrFail($id);
      //  dd($student);
        $student=$this->crud->getCurrentEntry();
       //dd($student->userRole()->first()->user()->delete());
       
        // return response()->json($student->id, 500);

        //deletefiledoc
        $deleteFile=$student->file;

        if($deleteFile){
            foreach($deleteFile as $d)
            {
                if ($d->url != '') \Storage::disk('uploads')->delete($d->url);
            }
            $student->file()->delete();
        }

         //deletehealth
        if($student->healths)
         {
            foreach($student->healths as $h)
            {
                if($h->files !='') \Storage::disk('uploads')->delete($h->files);
            }
            $student->healths()->delete();
        }
         //testresult
        if($student->testresult)
        {   
            foreach($student->testresult as $tr)
            {
                if($tr->file !='') \Storage::disk('uploads')->delete($tr->file);
            }
            $student->testresult()->delete();
        }

        //criminal
        if($student->criminalresult){
            foreach($student->criminalresult as $tr)
            {
                if($tr->file !='') \Storage::disk('uploads')->delete($tr->file);
            }
            $student->criminalresult()->delete();
        }

        //followup
        if($student->followups){
            foreach($student->followups as $f)
            {
                if($f->files !='') \Storage::disk('uploads')->delete($f->files);
            }
            $student->followups()->delete();
        }

        // deleteUserAccount
        if($student->userRole()->first()){
            $student->userRole()->first()->user()->delete();
            // deleteRoleUser
            $student->userRole()->delete();
        }
      
       // studentsession
        if($student->studentsession){
          $student->studentsession()->delete();
        }
   
        $redirect_location = parent::destroy($id);
        return $redirect_location;

    }
     
    public function download($id)
    {
        $this->crud->hasAccessOrFail('download');  
        $entry = $this->crud->getEntry($id);
        $disk = \Storage::disk('uploads');

        if (!$disk->exists($entry->file)) {
            abort(404);
        }
        // return response()->json($entry);
        return response()->download($entry->file);


    }
    public function show($id)
    {
        $this->crud->hasAccessOrFail('show');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;

        // set columns from db
        $this->crud->setFromDb();

        // cycle through columns
        foreach ($this->crud->columns as $key => $column) {
            // remove any autoset relationship columns
            if (array_key_exists('model', $column) && array_key_exists('autoset', $column) && $column['autoset']) {
                $this->crud->removeColumn($column['name']);
            }

            // remove the row_number column, since it doesn't make sense in this context
            if ($column['type'] == 'row_number') {
                $this->crud->removeColumn($column['name']);
            }
        }

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;

        // remove preview button from stack:line
        //$this->crud->removeButton('show');
        //$this->crud->removeButton('delete');


        $this->data['type_options'] = \App\Models\FileType::pluck('name');
        $this->data['health_types'] = \App\Models\HealthType::pluck('name');

        $getstudentid=\App\Models\StudentSession::where('student_id',$id)->pluck('class_id')->unique();
        $getsectionid=\App\Models\StudentSession::where('student_id',$id)->pluck('section_id')->unique();
        // dd($getstudentid);
        $countTeacher = \App\Models\AssignSubject::where('class_id', $getstudentid)->where('section_id',$getsectionid)->get();
       //dd($countTeacher);
        // foreach($countTeacher as $t)
        // {
        //     dd($t->teacher_id);
        // }
        $this->data['getteacher']=$countTeacher;
        $this->data['student_followup_types']= \App\Models\StudentFollowupType::pluck('name');
      //  $this->data['health_types'] = \App\Models\HealthType::pluck('name','id');
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getShowView(), $this->data);
    }
    // public function deletefile($id){
    //     $student = \App\Models\Student::find($id);
    //     foreach($student->file as $i)
    //     {
    //         return $i;
    //     }
    //     return $student->file;
    // }
}
