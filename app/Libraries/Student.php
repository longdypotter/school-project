<?php
namespace App\Libraries;

use App\Models\Student as StudentMod;
use App\Libraries\Searchable as SearchableLib;

class Student{
    // public static function _getCustomerByID($arr){
    //      $students = \App\Models\Student::whereIn('id',$arr)->get();
         
        
    //      $data = [];

    //     foreach($students as $index => $student){
        
           
    //         $data[] = [
  
    //             'english_name'=>$student->english_name,
    //             'khmer_name' => $student->khmer_name,
    //             'gender' => $student->gender,
    //             'phone' => $student->phone,
    //             'link'=>route('crud.customer.show',$student->id ),
    //             'iteration'=> $index+1,               
    //             'id'=>$students->id,
               
    //         ];
    //     }
        
    //     return $data;       
    // }

    //*** Reaksmey
    protected static function _collection()
    {
        $student = session('search.student_id');
        $session = session('search.session');
        $class = session('search.class');
        $section= session('search.section');
        $subject= session('search.subject');
        $gender= session('search.gender');

        $result = StudentMod::orderBy('created_at', 'desc');
        $assignsubject=\App\Models\AssignSubject::where('subject_id', $subject);
        // $getAssignAll = $assignsubject->pluck('section_id', 'class_id');
        $getAssignClass = $assignsubject->pluck('class_id')->unique();
        $getAssignSection = $assignsubject->pluck('section_id')->unique();
        // dd($getAssignAll);

        $studentsession=\App\Models\StudentSession::get();
        // $classid=$assignsubject->class_id;
        // $sectionid=$assignsubject->section_id;
      
      
        
        if(!empty($gender)) $result->where('gender',$gender);
        if(!empty($student)) $result->where('id',$student);
        


        // if(!empty($subject) && empty($class) && empty($section)) $result->whereHas('studentsessions',function($q) use($session, $class,$subject){
        //     $q->where('session_id',$subject);
        //    $q->where('class_id', $subject);
        // });
        
        // if(!empty($subject)) $result->whereHas('studentsessions',function($q) use( $class,$subject,$section){
        //     $q->where('section_id',$subject) $q->where('class_id', $subject);
        // })->get();
        if(!empty($subject)) $result->whereHas('studentsessions', function($q) use($subject, $getAssignClass, $getAssignSection){
            // foreach($getAssignAll as $k => $v):
            //     // dd($k);
            //     // $q->where(function ($qq) use ($k, $v) {
            //         $q->where('class_id', $k);
            //         $q->where('section_id', $v);
            //     // });
            // endforeach;
            $q->whereIn('class_id',$getAssignClass);
            $q->whereIn('section_id',$getAssignSection);
        });

        if(!empty($session)) $result->whereHas('studentsessions',function($q) use($session){
            $q->where('session_id',$session);
        });
        if (!empty($class)) $result->whereHas('studentsessions', function ($q) use ($class) {
            $q->where('class_id', $class);
            // if (!empty($dates['start'])) $q->whereBetween('disbursement_date', [$dates['start'], $dates['end']]);
        });
        if(!empty($section)) $result->whereHas('studentsessions',function($q) use($section){
            $q->where('section_id',$section);
        });

        //subject
     
           
            
            // $q->where('section_id',$subject);
            // $q->where('class_id',$subject);
            // $q->where('section_id',$subject);
        

        //endsubject


        // if(!empty($subject)) $assignsubject->where(function($q) use($subject){
        //     $q->where('subject_id',$subject);
            
        // });
       
      
        
        return $result;
    }
    public static function getReportStudentBy()
    {
       
        // $dates = \App\Libraries\Searchable::getSearchDateRange();

        $result = self::_collection();
      
       
        // if (!empty($dates['start'])) $result->where('class_id', $class);

        return $result;
    }

    // public static function getReportCustomerLiability()
    // {
    //     // return 'hi';
    //     $class = session('search.classes');
    //     // $co = session('search.co');
    //     // $branch = session('search.branch');
    //     $student = session('search.student_id');
    //     $dates = \App\Libraries\Searchable::getSearchDateRange();
        
    //     // $customers = new CustomerMod;
    //     // $result = CustomerMod::with

    //     //     $result->whereHas('studentsession.classes', function ($q) use ($dates, $currency) {
    //     //         $q->where('name', $currency);
    //     //         if (!empty($dates['start'])) $q->whereBetween('disbursement_date', [$dates['start'], $dates['end']]);
    //     //     });
    //         $result = CustomerMod::orderBy('created_at', 'desc');

    //         $result->whereHas('studentsessions', function ($q) use ($dates, $class) {
    //             $q->where('class_id', $class);
    //             // if (!empty($dates['start'])) $q->whereBetween('disbursement_date', [$dates['start'], $dates['end']]);

    //         });
    //     // $result->whereHas('schedules', function ($q) use ($dates) {
    //     //     $q->whereColumn( 'interest', '>', 'interest_paid')
    //     //     ->orWhereColumn('principle', '>', 'principle_paid')
    //     //     ->orWhereColumn('penalty', '>', 'penalty_paid')
    //     //     ->orWhereColumn('fee', '>', 'fee_paid')
    //     //     ->orWhereColumn('extra', '>', 'extra_paid');
    //     // });
    //     // if (!empty($co)) $result->where('co_id', $co);
    //     // if (!empty($student)) $result->where('id', $student);
    //     // if (!empty($branch)) $result->where('branch_id', $branch);

    //     return $result;
    // }
    //*** Reaksmey End

    // public static function getAllCustomer(){
    //     $result = CustomerMod::all()->count();
    //     return $result;
    // }
}