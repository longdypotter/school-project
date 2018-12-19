<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Attachment extends Model
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

    protected $table = 'attachments';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['user_id','title','type','date','description','files'];
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
          return '<a href="'.route('download.attachment', $this->id).'" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-download"></i>'.trans('flexi.download').'</a>';
    }
    public function setFilesAttribute($value)
    {
        $attribute_name = "files";
        $disk = "uploads";
        $destination_path = "Attachment/Files/".date('Ym');;
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function user(){
        return $this->belongsTo('\App\User');
    }
    public function attachmenttype(){
        return $this->belongsTo('\App\Models\AttachmentType','type');
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
