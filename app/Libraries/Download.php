<?php

namespace App\Libraries;
use ZipArchive;

class Download
{
    public static function downloadAsZip(
        $downloadFiles,
        $zipName = 'download',
        $absolutePath = ''
    ) {
        $getPath     = $absolutePath != '' ? $absolutePath : storage_path('app/public');

        $public_dir  = public_path();
        // Zip File Name
        $zipFileName = str_slug($zipName, '-').'.zip';
        // Create ZipArchive Obj
        $zip = new ZipArchive;

        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            // Add File in ZipArchive
            foreach($downloadFiles as $k => $v):
                $filePath = $getPath.'/'. $v;
                $name = explode('/', $v);
                if (file_exists($filePath)) $zip->addFile($filePath, end($name));
               
            endforeach;
            // Close ZipArchive     
            $zip->close();
        }
        // Set Header
        $headers   = ['Content-Type' => 'application/octet-stream'];
        $pathToZip = $public_dir.'/'.$zipFileName;
        // Create Download Response
        if(file_exists($pathToZip)){
            return response()->download($pathToZip,$zipFileName,$headers)->deleteFileAfterSend(true);
        }
    }
}