<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Health extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            if (count((array)$obj->files)) {
                foreach ($obj->files as $file_path) {
                    \Storage::disk('uploads')->delete($file_path);
                }
            }
        });
    }

    protected $table = 'healths';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['student_id','title','description','type','files'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'files' => 'array'
    ];
    /*
    
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function setFilesAttribute($value)
    {
        $attribute_name = "files";
        $disk = "uploads";
        $destination_path = "students/Health/".date('Ym');
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
