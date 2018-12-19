<?php

namespace App\libraries;
use App\Libraries\Searchable as SearchableLib;

use Illuminate\Database\Eloquent\Model;

class StudentExam 
{
    protected static function _collection()
    {
        
      
        $class = session('search.class');
      
        $section= session('search.section');

        $subject= session('search.subject');
       
        $exam = session('search.exam_id');

        $exam_date = session('search.exam_date');
        //dd($exam);
       // $result = \App\Models\StudentSession::where('class_id',$class)->where('section_id',$section)->get();
       //studentsession
            // $result=\App\Models\StudentSession::where(function($q) use($class,$section){
            //             $q->where('class_id',$class);
            //             $q->where('section_id',$section);
            // })->get();
       //endstudentsession
       $result=\App\Models\Exam::where(function($q) use($exam,$exam_date)
       {
           $q->where('name',$exam);
           $q->where('exam_date',$exam_date);
       })
       ->whereHas('assignsubject',function($q) use($subject,$class,$section){
            $q->where('class_id',$class);
            $q->where('section_id',$section);
            $q->where('subject_id',$subject);
            
        })->get();
        // $result=\App\Models\Exam::whereHas('assignsubject',function($q) use($subject,$class,$section){
        //      $q->where('class_id',$class);
        //      $q->where('section_id',$section);
        //      $q->where('subject_id',$subject);
             
        //  })->get();
        return $result;
}
        
    public static function studentexam()
    {
       
        // $dates = \App\Libraries\Searchable::getSearchDateRange();
      
         $result = self::_collection();
       
        return $result;
    }
}
