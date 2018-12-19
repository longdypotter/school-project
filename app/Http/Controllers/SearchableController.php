<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchableController extends Controller
{
    //
    public function index(Request $request)
    {
        //dd('hi');
        // $dates = explode(' - ', $request->datetimes);
        // dd($dates);
        // dd($request->except(['_token']));
        $setSession = $request->except([
            '_token',
            'register'
        ]);

        // session([$request->register => $setSession]);

        // return redirect()->back();
        return redirect()->back()->with('search', $setSession);

    }
}
