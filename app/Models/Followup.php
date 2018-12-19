<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Followup extends Model
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
    protected $table = 'followups';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['student_id','user_id','title','type','description','date','files'];
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
    public function downloadButton()
    {
          return '<a href="'.route('download.downloadfollowup', $this->id).'" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-download"></i>'.trans('flexi.download').'</a>';
    }
    
    public function setFilesAttribute($value)
    {
        $attribute_name = "files";
        $disk = "uploads";
        $destination_path = "students/Followup/Files/".date('Ym');;
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
 
    public function followuptype()
    {
        return $this->belongsTo('\App\Models\FollowupType','type');
    }
    public function user()
    {
        return $this->belongsTo('\App\User');
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
