<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use App\Models\DownloadloadCenter;

class DownloadController extends Controller
{
    // public function index($pathToFile){
    //     $file = base64_decode($pathToFile);
    //     $disk = \Storage::disk('uploads');
    //     if (!$disk->exists($file)) {
    //         abort(404);
    //     }
    //     return response()->download(public_path($file));
    // }
    // public function show($pathToFile){
    //     $file = base64_decode($pathToFile);
    //     $disk = \Storage::disk('uploads');
    //     if (!$disk->exists($file)) {
    //         abort(404);
    //     }
    //     return response()->download(public_path($file));
    // }

    public function index($pathToFile)
    {
        // dd(public_path());
        $download = \App\Models\Teacher::findOrFail($pathToFile);
        return \App\Libraries\Download::downloadAsZip($download->curriculum,$download->name,public_path());
    }

    public function downloadCenter($pathToFile)
    {
        //return "helll";
        // dd(public_path());
        $download = \App\Models\DownloadCenter::findOrFail($pathToFile);
        return \App\Libraries\Download::downloadAsZip($download->file,$download->name,public_path());
    }
    public function downloaddoc($pathToFile)
    {
        //return "helll";
        // dd(public_path());
        $download = \App\Models\File::findOrFail($pathToFile);
        return \App\Libraries\Download::downloadAsZip($download->url,$download->name,public_path());
    }
    public function downloadresult($pathToFile)
    {
        //return "helll";
        // dd(public_path());
        $download = \App\Models\Result::findOrFail($pathToFile);
        return \App\Libraries\Download::downloadAsZip($download->file,$download->title,public_path());
    }
    public function downloadcriminal($pathToFile)
    {
        $download = \App\Models\Result::findOrFail($pathToFile);
        return \App\Libraries\Download::downloadAsZip($download->file,$download->title,public_path());
    }
    public function downloadhealth($pathToFile)
    {
        $download = \App\Models\Health::findOrFail($pathToFile);
        return \App\Libraries\Download::downloadAsZip($download->files,$download->title,public_path());
    }
   public function downloadstudentfollowup($pathToFile){
    $download = \App\Models\StudentFollowup::findOrFail($pathToFile);
    return \App\Libraries\Download::downloadAsZip($download->files,$download->title,public_path());
   }
   public function downloadattachment($pathToFile){
    $download = \App\Models\Attachment::findOrFail($pathToFile);
    return \App\Libraries\Download::downloadAsZip($download->files,$download->title,public_path());
   }
   public function downloadfollowup($pathToFile){
    $download = \App\Models\Followup::findOrFail($pathToFile);
    return \App\Libraries\Download::downloadAsZip($download->files,$download->title,public_path());
   }
}
