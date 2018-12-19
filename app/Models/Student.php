<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    use CrudTrait;
    use Notifiable;
    
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('uploads')->delete($obj->profile);
        });
    }

    
    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'students';
    // protected $primaryKey = 'id'; 
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
                        'khmer_name',
                        'english_name',
                        'gender',
                        'ethnicity',
                        'nationality',
                        'date_of_birth',
                        'place_of_birth',
                        'status',
                        'occupation',
                        'education',
                        'health',
                        'house_no',
                        'street_no',
                        'address',
                        'father_name',
                        'father_occupation',
                        'mother_name',
                        'mother_occupation',
                        'parent_house_no',
                        'parent_street_no',
                        'parent_address',
                        'guardian_name',
                        'guardian_occupation',
                        'guardian_house_no',
                        'guardian_street_no',
                        'guardian_address',
                        'guardian_phone',
                        'phone',
                        'father_phone',
                        'mather_phone',
                        'profile',
                        'email',
                        'student_status'
                        ];
    // protected $hidden = [];


    protected $dates = [
        'date_of_birth',
    ];
    public function setProfileAttribute($value)
    {
        $attribute_name = "profile";
        $disk = "uploads";
        $destination_path = "students/profiles";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            if ($this->{$attribute_name} != '') {
                \Storage::disk($disk)->delete($this->{$attribute_name});
            }
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        };
    }


    


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    // public function files()
    // {
    //     return $this->belongsTo('App\Models\File');
    // }

 
    public function file()
    {
        return $this->hasMany('App\Models\File', 'student_id');
    }
    public function testresult()
    {
        return $this->hasMany('App\Models\Result', 'student_id')->where('type','TestResult');
    }

    public function criminalresult()
    {
        return $this->hasMany('App\Models\Result', 'student_id')->where('type','criminal');
    }
    public function healths(){

        return $this->hasMany('App\Models\Health','student_id');
    }
    public function studentfollowups()
    {
        return $this->hasMany('App\Models\StudentFollowup','student_id');
    }

    public function classes()
    {
        return $this->belongsTo('App\Models\Classes','class_id');
    }
    public function sections()
    {
        return $this->belongsTo('App\Models\Section');
    }
    
    public function sessions()
    {
        return $this->belongsTo('App\Models\Session');
    }
    
    public function studentsession()
    {
        return $this->hasOne('App\Models\StudentSession');
    }

    public function studentsessions()
    {
        return $this->hasMany('App\Models\StudentSession');
    }
  
    public function addressFull()
    {
        return $this->belongsTo('App\Address', 'address', '_code');        
    }
    public function parentaddressFull()
    {
        return $this->belongsTo('App\Address', 'parent_address', '_code');        
    }
    public function guardianaddressFull()
    {
        return $this->belongsTo('App\Address', 'guardian_address', '_code');        
    }
    public function filetypes()
    {
        return $this->belongsTo('App\Models\FileType');
    }

    public function userRole()
    {
        return $this->hasOne('App\Models\UserRole','type_id')->where('type_role','Student');
    }

    public function scopeUserRoleType($query, $type)
    {
        return $query->userRole->where('type_role', $type);
    }
    public function followup()
    {
        return $this->hasMany('\App\Models\Followup');
    }
    // public function healths()
    // {
    //     return $this->hasMany('\App\Models\Health')->orderBy('student_id','desc')->first();
    // }
    public function studentexam(){
        return $this->hasMany('\App\Models\StudentExam');
    }
    
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

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

    public function getDateOfBirthFmAttribute()
    {
         return $this->date_of_birth->format('d-m-Y');
        
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
