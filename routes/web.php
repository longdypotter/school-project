<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect('admin');
});
Route::post('searchable', 'SearchableController@index')->name('searchable');
Route::get('prnpriview','PrintController@prnpriview')->name('print.prnpripiew');