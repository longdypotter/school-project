<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'kh_address';

    public function getFullAddressAttribute()
    {
       return implode(', ',array_reverse(explode('/',$this->_path_en))) ;
    }

    public function getCityAttribute()
    {
       list($city)  = explode('/',$this->_path_en);
       return $city;
    }

    public function getFullAddressKhAttribute()
    {
        return trim(implode(' ',array_reverse(explode('/',$this->_path_kh)))) ;
    }
}
