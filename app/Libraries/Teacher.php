<?php
namespace App\Libraries;

use App\Models\Teacher as TeacherMod;
use App\Libraries\Searchable as SearchableLib;

class Teacher{
    // public static function _getCustomerByID($arr){
    //      $teachers = \App\Models\Teacher::whereIn('id',$arr)->get();
         
        
    //      $data = [];

    //     foreach($teachers as $index => $teacher){
        
           
    //         $data[] = [
    //             'name'=>$teacher->name,
    //             'gender' => $teacher->gender,
    //             'phone' => $teacher->phone,
    //             //'link'=>route('crud.teacher.show',$teacher->id ),
    //             'iteration'=> $index+1,               
    //             'id'=>$teacher->id,
    //         ];
    //     }
        
    //     return $data;       
    // }

    //*** Reaksmey
    protected static function _collection()
    {
        $teacher = session('search.teacher_id');
        $session = session('search.session');
        $class = session('search.class');
        $section= session('search.section');
        $subject= session('search.subject');
        $gender=session('search.gender');

        $result = TeacherMod::orderBy('created_at', 'desc');
        //dd($result);
        
        $studentsession=\App\Models\StudentSession::where('session_id',$session);
        $getstudentsessionclass=$studentsession->pluck('class_id')->unique();
        $getstudentsessionsection=$studentsession->pluck('section_id')->unique();
       
     
        if(!empty($teacher)) $result->where('id',$teacher);
        if(!empty($gender)) $result->where('gender',$gender);
       
        if (!empty($class)) $result->whereHas('hasAssignsubjects',function($q) use($class){
            $q->where('class_id',$class);
        });
            // if (!empty($dates['start'])) $q->whereBetween('disbursement_date', [$dates['start'], $dates['end']]);
       
        if(!empty($section)) $result->whereHas('hasAssignsubjects',function($q) use($section){
            $q->where('section_id',$section);
        });
        if(!empty($subject)) $result->whereHas('hasAssignsubjects',function($q) use($subject){
            $q->where('subject_id',$subject);
        });
        if(!empty($session)) $result->whereHas('hasAssignsubjects',function($q) use($getstudentsessionclass,$getstudentsessionsection){
            $q->whereIn('class_id',$getstudentsessionclass);
            $q->whereIn('section_id',$getstudentsessionsection);
 
        });

        return $result;
    }
    public static function getReportTeachertBy()
    {
       
        // $dates = \App\Libraries\Searchable::getSearchDateRange();

        $result = self::_collection();

        // if (!empty($dates['start'])) $result->where('class_id', $class);

        return $result;
    }


}