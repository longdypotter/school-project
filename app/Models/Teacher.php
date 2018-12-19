<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Teacher extends Model
{
    use CrudTrait;


    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('uploads')->delete($obj->profile);
        });
        static::deleting(function($obj) {
            if (count((array)$obj->curriculum)) {
                foreach ($obj->curriculum as $file_path) {
                    \Storage::disk('uploads')->delete($file_path);
                }
            }
        });
    }




    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'teachers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
                            'name',
                            'date_of_birth',
                            'gender',
                            'house_no',
                            'street_no',
                            'address',
                            'phone',
                            'email',
                            'profile',
                            'curriculum',
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'curriculum' => 'array'
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function addressFull(){
        return $this->belongsTo('App\Address', 'address', '_code');
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function hasAssignsubjects(){
        return $this->hasMany('App\Models\AssignSubject');
    }

    public function assignSubjects(){
        return $this->hasMany('App\Models\AssignSubject', 'teacher_id');
    }
    public function userRole()
    {
        return $this->hasOne('App\Models\UserRole','type_id')->where('type_role','Teacher');
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
    // public function setProfileAttribute($value)
    // {
    //     $attribute_name = "profile";
    //     $disk = "public";
    //     $destination_path = "uploads/".date('Ym');
    //     $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    // }
    public function setProfileAttribute($value)
    {
        $attribute_name = "profile";
        $disk = "uploads";
        $destination_path = "Teacher/profile/".date('Ym');

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
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }
    public function setCurriculumAttribute($value)
    {
        $attribute_name = "curriculum";
        $disk = "uploads";
        $destination_path = "Teacher/Curriculum/".date('Ym');;
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
    public function getDateOfBirthFmAttribute()
    {
         return $this->date_of_birth->format('d-m-Y');
        
    }
}
