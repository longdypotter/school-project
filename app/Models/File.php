<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class File extends Model
{
    use CrudTrait;



    // public static function boot()
    // {
    //     parent::boot();
    //     static::deleting(function($obj) {
    //         \Storage::disk('public')->delete($obj->url);
    //     });
    // }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            if (count((array)$obj->url)) {
                foreach ($obj->url as $file_path) {
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

    protected $table = 'files';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['student_id','type','name','url'];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
        'url' => 'array'
   ];


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
    public function setUrlAttribute($value)
    {
        $attribute_name = "url";
        $disk = "uploads";
        $destination_path = "students/url/".date('Ym');
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
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
