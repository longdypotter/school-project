<?php

namespace App;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;

use Backpack\CRUD\CrudTrait; // <------------------------------- this one
use Spatie\Permission\Traits\HasRoles;// <---------------------- and this one

class User extends Authenticatable
{
    use Notifiable;

    use CrudTrait; // <----- this
    use HasRoles; // <------ and this

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('uploads')->delete($obj->profile);
        });
    }

    protected $fillable = [
        'name', 'email', 'password','profile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function userRole()
    {
        return $this->hasOne('App\Models\UserRole', 'user_id');
    }

    public function scopeUserRoleType($query, $type)
    {
        return $query->userRole->where('type_role', $type);
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->email}";
    }

    public function userProfile()
    {
        $profile = !empty($this->profile) ? asset($this->profile) : 'https://www.gravatar.com/avatar/bee93837c35f0d5d981ddba5f32a6a6b.jpg?s=80&d=mm&r=g';
        return $profile;
    }
    public function setProfileAttribute($value)
    {
        $attribute_name = "profile";
        $disk = "uploads";
        $destination_path = "Profile/".date('Ym');

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
        }

    }

    // public function setProfileAttribute($value)
    // {
    //     $attribute_name = 'profile';
    //     $disk = "upload";
    //     $destination_path = 'uploads/'.date('Ym');


    //     // if the image was erased
    //     if ($value==null) {
           
    //         \App\Libraries\Upload::clearSingleThumbnail($disk, $this->{$attribute_name});
    //         // set null in the database column
    //         $this->attributes[$attribute_name] = null;
    //     }

    //     // if a base64 was sent, store it in the db
    //     if (starts_with($value, 'data:image'))
    //     {
    //         // Custom add Prevent when update image, old image not remove
    //         \App\Libraries\Upload::clearSingleThumbnail($disk, $this->{$attribute_name});

    //         // 0. Make the image
    //         $image = \Image::make($value);
    //         // 1. Generate a filename.
    //         $filename = md5($value.time()).'.jpg';

    //         // 2. Store the image on disk.
    //         \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());

    //         // Create Thumbnail Size
    //         \App\Libraries\Upload::thumbnail($image, $disk, $destination_path.'/'.$filename);

    //         // 3. Save the path to the database
    //         $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
    //     } 

    // }














}
