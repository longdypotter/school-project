<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Address;
class AddressController extends Controller
{
    public function get($code='')
    {
        return Address::where('_code','Like',"${code}__")->orderBy('_name_en')->get()->pluck('_code','_name_en');   
    }
}
