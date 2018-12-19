<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class AssignSubject extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'assign_subjects';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
                            'class_section_id',
                            'class_id',
                            'section_id',
                            'teacher_id',
                            'subject_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
        public function class()
        {
            return $this->belongsTo('\App\Models\Classes','class_id');
        }
        public function section()
        {
            return $this->belongsTo('\App\Models\Section','section_id');
        }
        public function teacher()
        {
            return $this->belongsTo('\App\Models\Teacher','teacher_id');
        }
        public function subject()
        {
            return $this->belongsTo('\App\Models\Subject');
        }
        public function studentsession(){
            return $this->belongsTo('\App\Models\StudentSession','student_id');
        }
        public function userRole()
        {
            return $this->hasOne('App\Models\UserRole', 'user_id');
        }
        public function exam()
        {
            return $this->hasMany('App\Models\Exam','assign_subject_id');
        }
       
     

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
