<?php
namespace App\Libraries;

use App\Models\AttendentStudent as AttendentStudentMod;
// use App\Models\StudentSession as StudentSessionMod;
use App\Libraries\Searchable as SearchableLib;
use App\Models\StudentSession as StudentSessionMode;

class AttendentStudent{
   

    //*** Reaksmey
    protected static function _collection()
    {
        $class = session('search.class');
      
        $section= session('search.section');

        $subject= session('search.subject');
       
       // $result = \App\Models\StudentSession::where('class_id',$class)->where('section_id',$section)->get();
       //studentsession
            // $result=\App\Models\StudentSession::where(function($q) use($class,$section){
            //             $q->where('class_id',$class);
            //             $q->where('section_id',$section);
            // })->get();
       //endstudentsession
       $result=\App\Models\AssignSubject::where(function($q) use($subject,$class,$section){
        $q->where('class_id',$class);
        $q->where('section_id',$section);
        $q->where('subject_id',$subject);
       
        })->get();
        
        return $result;
}
        
    public static function getReportAttendentStudentBy()
    {
       
        // $dates = \App\Libraries\Searchable::getSearchDateRange();

         $result = self::_collection();
        return $result;
    }

  
}