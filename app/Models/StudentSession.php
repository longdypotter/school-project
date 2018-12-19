<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class StudentSession extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'student_sessions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['session_id','student_id','class_id','section_id','route_id','is_active'];
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
    public function filetypes()
    {
        return $this->belongsTo('App\Models\FileType','filetype_id');
    }
    public function sessions()
    {
        return $this->belongsTo('App\Models\Session','session_id');
    }
    public function classes()
    {
        return $this->belongsTo('App\Models\Classes', 'class_id');
    }
  
    public function sections()
    {
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function students()
    {
            return $this->belongsTo('App\Models\Student','student_id');
    }
    public function attendentstudent()
    {
        return $this->hasMany('\App\Models\AttendentStudent','student_id');
    } 
    public function studentexams()
    {
        return $this->belongsTo('\App\Models\StudentExam','student_id');
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
