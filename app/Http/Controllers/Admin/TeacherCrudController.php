<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TeacherRequest as StoreRequest;
use App\Http\Requests\UpdateTeacherRequest as UpdateRequest;

/**
 * Class TeacherCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TeacherCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Teacher');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/teacher');
        $this->crud->setEntityNameStrings('Teacher', 'teachers');
        
        $this->crud->setShowView('teachers.show');
        $this->crud->enableExportButtons();
        
        // $this->crud->addFilter([ // simple filter
        //     'type' => 'text',
        //     'name' => 'gender',
        //     'label'=> trans('flexi.gender'),
        //   ], 
        //   false, 
        //   function($value) { // if the filter is active
        //       $this->crud->addClause('where', 'gender', 'LIKE', "%$value%");
        //   } );
        //   $this->crud->addFilter([ // date filter
        //     'type' => 'date',
        //     'name' => 'date_of_birth',
        //     'label'=> trans('flexi.date_of_birth'),
        //   ],
        //   false,
        //   function($value) { // if the filter is active, apply these constraints
        //                     $this->crud->addClause('where', 'date_of_birth', '=', $value);
        //   });

          //Button Custom Delete
        // $this->crud->removeButton('delete');
        // $this->crud->addButton('line','custom','view','teachers.delete','right');
          //EndButton
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        $colMd6 = ['class' => 'form-group col-md-6' ];
        $colMd4 = ['class' => 'form-group col-md-4' ];
        $colMd3 = ['class' => 'form-group col-md-3' ];
        $tabOne = trans('flexi.teacher');
        $tabTwo = trans('flexi.family');
        $both = 'update/create/both';

        // TODO: remove setFromDb() and manually define Fields and Columns
        //$this->crud->setFromDb();

        $this->crud->addColumn([
            'name' => 'name', // The db column name
            'label' => trans('flexi.name'), // Table column heading
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'gender', // The db column name
            'label' => trans('flexi.gender'), // Table column heading
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'date_of_birth', // The db column name
            'label' => trans('flexi.date_of_birth'), // Table column heading
            'type' => 'date',
            'searchLogic'=>false,
        ]);
        
        $this->crud->addColumn([
            'name' => 'phone', // The db column name
            'label' => trans('flexi.phone'), // Table column heading
            'type' => 'text'
        ]);
        $this->crud->addColumn([
            'name' => 'email', // The db column name
            'label' => trans('flexi.email'), // Table column heading
            'type' => 'text'
        ]);
        // $this->crud->addColumn([
        //     'name' => 'address._path_en', // The db column name
        //     'label' => trans('flexi.address'), // Table column heading
        //     'type' => 'closure',
        //     'function' => function($entry) {
        //         return optional($entry->addressFull)->_path_kh;
        //     }
        // ]);
        // $this->crud->addColumn([
        //     'name' => 'curriculum',
        //     'label' => trans('flexi.curriculum'),
        //     'type' => 'closure',
        //     'limit'=> 10,
        //     'function' => function($entry) {
        //         if (count((array)$entry->curriculum) <= 0) return '';
        //         $result = '';
        //         foreach($entry->curriculum as $cur):
        //             $result .= $cur.'<br>';
        //         endforeach;
        //         return $result;
        //     }
        // ],$both);

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
            'wrapperAttributes'=>$colMd4,           
        ],$both);
        $this->crud->addField(
            [ // select_from_array
                'name' => 'gender',
                'label' => trans('flexi.gender'),
                'type' => 'select2_from_array',
                'options' => ['ស្រី' => 'ស្រី',  'ប្រុស'=> 'ប្រុស'],
                'allows_null' => true,
                //'default' => 'one',
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
                'wrapperAttributes'=>$colMd4,    
            ],$both);
        $this->crud->addField([ 
            'name' => 'date_of_birth',
            'label' => trans('flexi.date_of_birth'),
            'type' => 'date_picker',
            //'tab' => $tabOne,
            'date_picker_options' => [
            'todayBtn' => true,
            //'format' => 'dd-mm-yyyy',
            'format' => 'yyyy-mm-dd',
                
             ],
            'allows_null' => true,
            //'default' => date('Y-m-d'),
            'wrapperAttributes'=>$colMd4,           
        ],$both);
        $this->crud->addField([ 
            'name' => 'phone',
            'label' => trans('flexi.phone'),
            'type' => 'text',
            //'tab' => $tabOne,
            'wrapperAttributes'=>$colMd6,           
        ],$both);
        $this->crud->addField([ 
            'name' => 'email',
            'label' => trans('flexi.email'),
            'type' => 'text',
            //'tab' => $tabOne,
            'wrapperAttributes'=>$colMd6,           
        ],$both);
            $this->crud->addField([ 
                'name' => 'house_no',
                'label' => trans('flexi.house_no'),
                'type' => 'text',
                //'tab' => $tabOne,
                'wrapperAttributes'=>$colMd6,           
            ],$both);
            $this->crud->addField([ 
                'name' => 'street_no',
                'label' => trans('flexi.street_no'),
                'type' => 'text',
                //'tab' => $tabOne,
                'wrapperAttributes'=>$colMd6,           
            ],$both);
            $this->crud->addField([ 
                'name' => 'address',
                'label' => trans('flexi.address'),
                'type' => 'flexiaddress',
                //'tab' => $tabOne,
                //'wrapperAttributes'=>$colMd4,           
            ],$both);
            
            $this->crud->addField([ 
                'name' => 'curriculum',
                'label' => trans('flexi.curriculum'),
                'type' => 'upload_multiple',
                'upload' => true,
                //'tab' => $tabOne,
                //'disk' => 'uploads',
                //'limit'=> 10,
                //'wrapperAttributes'=>$colMd4,           
            ],$both);
            // $this->crud->addField([ 
            //     'name' => 'profile',
            //     'label' => trans('flexi.profile'),
            //     'type' => 'upload',
            //     'upload' => true,
            //     //'tab' => $tabOne,
            //     'disk' => 'public',
            //     'wrapperAttributes'=>$colMd4,           
            // ],$both);
            $this->crud->addField([ // image
                'name' => "profile",
                'label' => trans('flexi.profile'),
                'type' => 'image' ,
                'upload' => true,
                'crop' => true, // set to true to allow cropping, false to disable
                'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
                // 'disk' => 'public', // in case you need to show images from a different disk
                // 'prefix' => 'storage/', // in case you only store the filename in the database, this text will be prepended to the database value
                //'wrapperAttributes'=>$colMd6, 
                //'tab'=> $tabOne,
    
            ],$both);

        // add asterisk for fields that are required in TeacherRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->orderBy('id','desc');
        $this->crud->denyAccess(['list','create','update','reorder','delete','show']);

        if($user->can('list teachers'))$this->crud->allowAccess('list');
        if($user->can('show teachers'))$this->crud->allowAccess('show');
        if($user->can('create teachers'))$this->crud->allowAccess('create');
        if($user->can('update teachers'))$this->crud->allowAccess('update');
        if($user->can('reorder teachers'))$this->crud->allowAccess('reorder');
        if($user->can('delete teachers'))$this->crud->allowAccess('delete');

        if ($user->hasAnyRole('Teacher')) {
            $getCurrentTeacher = optional($user->userRole);
            $this->crud->addClause('where', 'id', $getCurrentTeacher->type_id);   
        }
        if ($user->hasAnyRole('Student')) {
            $student = $user->userRole()->first();
            
            $class = \App\Models\StudentSession::where('student_id', $student->type_id)->first();
           
            // $subject = \App\Models\AssignSubject::where('class_id', $class->class_id)
            //  ->where('section_id', $class->section_id)->first();
            // //dd($subject);
            // dd($class);

            $teacher = \App\Models\AssignSubject::where('class_id', $class->class_id)->where('section_id', $class->section_id);
            // dd($teacher->first());
            //  ->where('section_id', $class->section_id)
            //  ->where('subject_id', $class->subject_id);

            //  dd($teacher);
            $this->crud->addClause('whereHas', 'assignSubjects', function ($q) use ($class, $teacher) {
                
                if(!empty($class->class_id)) $q->where('class_id', $class->class_id);

                if(!empty($class->section_id) && !empty($class->class_id)) $q->where('section_id', $class->section_id);

                if(!empty($class->teacher_id) && !empty($class->class_id) && !empty($class->section_id)) $q->where('teacher_id', $teacher->teacher_id);
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
            $users->name=$request->name;
            $users->email=$request->email;
            $users->password=bcrypt('1111111111');
            $users->save();

            auth()->user()->find($users->id)->assignRole('Teacher');
        }
        
     //  return $user->fdf_save();

        $createUserTeacher= \App\Models\UserRole::create([
                                                        'user_id'=>$users->id,
                                                        'type_id'=>$this->crud->entry->id,
                                                        'type_role'=>"Teacher",
        ]);

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        //dd($this->crud->getCurrentEntry()->userRole()->first()->user->email);
        // return response()->json($request);
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        
        //update email user
        $this->crud->getCurrentEntry()->userRole()->first()->user->update([ 
                                                                            'name'=>$request->name,
                                                                            'email'=>$request->email
                                                                         ]);
        //endupdate email user

        return $redirect_location;
    }
    public function destroy($id)
    {
        $teacher=$this->crud->getCurrentEntry();
        
        $teachercount=count($teacher->hasAssignsubjects);
        if($teachercount > 0)
        {
            return redirect()->back();
        }
        if($teacher->userRole()->first())
        {
            $teacher->userRole()->first()->user()->delete();
            $teacher->userRole()->delete();
        }
        $redirect_location = parent::destroy($id);
        return $redirect_location;
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

        // $user = \Auth::user();
        // $student = optional($user->userRole);
        //dd($student);


        $class=\App\Models\AssignSubject::where('teacher_id',$id)->get();
    //   dd($class->toArray());
    //   $studentsession=\App\Models\StudentSession::where('class_id',$class)->get();

      // $class=\App\Models\AssignSubject::where('teacher_id',$id)->get();

       //  dd($class[]->class_id);
    
       // dd($class[9]->teacher_id);
     
        
        // $section=\App\Models\AssignSubject::where('teacher_id',$id)->get();
        // dd($getstudentid);
        // $countStudent = \App\Models\StudentSession::where('class_id', $class)->where('section_id',$section)->get();
        //dd($countStudent);







      $class = \App\Models\AssignSubject::where('teacher_id',$id)->get()->groupBy('class.name');
    
    //dd($class);
      // $section = \App\Models\AssignSubject::where('teacher_id',$id)->get();
       //dd($section);
       //    $section = \App\Models\AssignSubject::where('teacher_id',$id)->get();
       //$countStudent = \App\Models\StudentSession::whereIn('class_id', $class)->where('section_id',$section);
       //dd($class);
        // dd($countStudent->get());
        //$class = \App\Models\AssignSubject::where('teacher_id',$id)->pluck('class_id')->unique();
       //  dd($class);
        $countStudent = \App\Models\StudentSession::whereIn('class_id', $class)->get();
       // dd($countStudent);
        // $studentid=\App\Models\Student::findOrFail($id);
     
        //$class = \App\Models\AssignSubject::where('teacher_id', $student->type_id)->first();
         $this->data['getStudent'] = $countStudent;
         $this->data['getclass'] = $class;
        //$this->data['student']=$studentid;
        // $this->data['section']=$section;
   

        // remove preview button from stack:line
        $this->crud->removeButton('show');
        $this->crud->removeButton('delete');

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getShowView(), $this->data);
    }
}
