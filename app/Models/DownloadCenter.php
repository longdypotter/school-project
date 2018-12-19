<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class DownloadCenter extends Model
{
    use CrudTrait;

    // public static function boot()
    // {
    //     parent::boot();
    //     static::deleting(function($obj) {
    //         \Storage::disk('uploads')->delete($obj->file);
    //     });
    // }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            if (count((array)$obj->file)) {
                foreach ($obj->file as $file_path) {
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

    protected $table = 'download_centers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
                        'name',
                        'public_date',
                        'description',
                        'class_id',
                        'section_id',
                        'subject_id',
                        'file',
                        'document_type_id',
                        'user_id'
    ];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'file' => 'array'
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function downloadButton ()
    {
        return '<a href="'.route('download.downloadCenter', $this->id).'" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-download"></i>'.trans('flexi.download').'</a>';
        // return '<a href="'.route('download.file', $this->id).'" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-download"></i>'.trans('flexi.download').'</a>';
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function class(){
        return $this->belongsTo('App\Models\Classes');
    }
    public function section(){
        return $this->belongsTo('App\Models\Section');
    }
    public function subject(){
        return $this->belongsTo('App\Models\Subject');
    }
    public function documentType(){
        return $this->belongsTo('App\Models\DocumentType');
    }

    public function user(){
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
    // public function setFileAttribute($value)
    // {
    //     $attribute_name = "file";
    //     $disk = "uploads";
    //     $destination_path = "File_Download/".date('Ym');
    //     $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    // }
    public function setFileAttribute($value)
    {
        $attribute_name = "file";
        $disk = "uploads";
        $destination_path = "File_Download/".date('Ym');
        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
