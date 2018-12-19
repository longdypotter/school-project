
@extends('backpack::layout')

    <style>
        div.dataTables_filter {
            text-align: right;
        }
        .pull-right {
            margin-right: 5px !important;
            margin-top: 5px !important;
           
        }
        .box-header {
            color: #444;
            display: block;
            padding: 15px !important;
            position: relative;
        
        }
    
        .overflow-hidden
        {
            overflow:auto;
        }

    </style>

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
	    <small>{{ trans('backpack::crud.all') }} <span>{{ $crud->entity_name_plural }}</span> {{ trans('backpack::crud.in_the_database') }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{route('crud.exam.index')}}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
      <br>
    <!-- <div class="col-md-4"> -->
  
     <a href="{{route('crud.exam.index')}}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all  <span>Exam</span></a>
    
    <!-- </div> -->
    <br>
    
                        
    
	</section>
@endsection

@include('inc.datatable')

@section('content')



<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
      <div class="box-header hidden-print with-border row">


          <div  class=" col-xs-12 col-sm-4 col-md-3" >
                <b>{{trans('flexi.name')}}:</b>&nbsp&nbsp  <span > {{optional($getexam)->name}} </span><br>
                <b>{{trans('flexi.exam_date')}}:</b>&nbsp&nbsp <span >{{ date('d-m-Y', strtotime($getexam->exam_date)) }}</span><br>
                <b>{{trans('flexi.teacher')}}:</b>&nbsp&nbsp  <span >{{optional($getexam->teacher)->name}}</span><br>
          </div>
          
          <div  class=" col-xs-12 col-sm-4 col-md-4">
                <b>{{trans('flexi.class')}}:</b>&nbsp&nbsp<span> {{$getexamfirst->assignsubject->class->name}}  </span><br>
                <b>{{trans('flexi.section')}}:</b>&nbsp&nbsp <span> {{$getexamfirst->assignsubject->section->name}}  </span><br>
                <b>{{trans('flexi.section')}}:</b>&nbsp&nbsp <span> {{$getexamfirst->assignsubject->subject->name}}  </span><br>
              
          </div>
          
       {{-- 
       <!-- <div class="form-group col-xs-12 col-sm-6 col-md-1 ">
           <label>{{trans('flexi.name')}}</label>
           <input type="text" name="name" class="form-control  col-md-3" value="{{optional($getexam)->name}}">
        </div>

        <div class="form-group col-xs-12 col-sm-6 col-md-2 ">
           <label>{{trans('flexi.exam_date')}}</label>
           <input type="text" name="exam_date" value="{{ date('d-m-Y', strtotime($getexam->exam_date)) }}" class="form-control  col-md-2">
        </div>
        <div class="form-group col-xs-12 col-sm-6 col-md-2 ">
           <label>{{trans('flexi.teacher')}}</label>
           <input type="text" name="teacher_id" value="{{optional($getexam->teacher)->name}}" class="form-control  col-md-2">
        </div>

         <div class="form-group col-xs-12 col-sm-6 col-md-2 ">
           <label>{{trans('flexi.class')}}</label>
           <input type="text" name="class_id"   @foreach($getstudent as $exam) value="{{$exam->classes->name}}" @endforeach class="form-control select2_element col-md-2">
        </div>

        <div class="form-group col-xs-12 col-sm-6 col-md-2 ">
           <label>{{trans('flexi.section')}}</label>
           <input type="text" name="section_id" class="form-control  col-md-3" @foreach($getstudent as $exam) value="{{$exam->sections->name}}" @endforeach>
        </div>
        
      
        @php
            $getsubject='';
        @endphp
        @foreach($getstudent as $exam)
            @php
                $getclassid=$exam->class_id;
                $getsectionid=$exam->section_id;
                $getsubject=\App\Models\StudentSession::where('class_id',$getclassid)->where('section_id',$getsectionid)->first();
            @endphp
             
        @endforeach

            
                @php
                    $assignsubject=\App\Models\AssignSubject::where(function($q) use($getsubject){
                        $q->where('class_id',optional($getsubject)->class_id);
                        $q->where('section_id',optional($getsubject)->section_id);
                    })->first();
                    dd($assignsubject->subject_id);
                @endphp
         
        @if($assignsubject)
          <div class="form-group col-xs-12 col-sm-6 col-md-3 ">
           <label>{{trans('flexi.subject')}}</label>
           <input type="text" name="subject_id" class="form-control  col-md-3" value="{{$assignsubject->subject->name}}">
        </div>
       @else
       <div class="form-group col-xs-12 col-sm-6 col-md-3 ">
           <label>{{trans('flexi.subject')}}</label>
           <input type="text" name="subject_id" class="form-control  col-md-3" value="">
        </div>
        @endif -->
        --}}


        </div>

   
   <div class="box-body overflow-hidden no-padding">
        <form action="{{route('crud.studentexam.store')}}" method="post">
            @csrf
                <div class="pull-right">
                @php

                @endphp
                    
                    <button type="submit"  class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> {{trans('flexi.save_student_exam')}} </button>        
                </div>
              
          <table id="datatable" class="table table-striped table-hover display nowrap " style="width: 100% !important">
         
            <thead>
          
            <tr>
                <th>#</th>
                {{--<th>{{ trans('flexi.name') }}</th>--}}
                {{--<th>{{ trans('flexi.exam_date') }}</th>--}}
                <th>{{ trans('flexi.student') }}</th>
                <th>{{ trans('flexi.gender') }}</th>
                <th>{{ trans('flexi.date_of_birth') }}</th>
                <th>{{ trans('flexi.phone')}}</th>
                <th>{{ trans('flexi.email')}}</th>
                {{--<th>{{ trans('flexi.teacher') }}</th>--}}
                {{--<th>{{ trans('flexi.class') }}</th>--}}
                {{--<th>{{ trans('flexi.section') }}</th>--}}
                {{--<th>{{ trans('flexi.subject') }}</th>--}}
                <th>{{ trans('flexi.mark') }}</th>
              
            </tr>

            </thead>
             
            <tbody>
            @php
                $count=1;
              @endphp
                  
                    @foreach($getstudent as $key=>$exam)
                        <tr>
                        <td>{{$count++}}</td>
                        {{--<td>{{$getexam->name}}</td>--}}
                        {{--<td>{{$getexam->exam_date}}</td>--}}
                        <td>{{$exam->students->english_name}}</td>
                        <td>{{$exam->students->gender}}</td>
                        <td>{{date('d-m-Y', strtotime($exam->students->date_of_birth))}}</td>
                        <td>{{$exam->students->phone}}</td>
                        <td>{{$exam->students->email}}</td>
                        {{--<td>{{$getexam->teacher->name}}</td>--}}
                        {{--<td>{{$getexam->assignsubject->class->name}</td>--}}
                        {{--<td>{{$getexam->assignsubject->section->name}}</td>--}}
                        {{--<td>{{$getexam->assignsubject->subject->name}}</td>--}}

                        @forelse($exam->students->studentexam as $i)

                            <td><input type="text" name="txtmark[]"    value="{{ old('txtmark')[$key] ?? $exam->students->studentexam[0]->mark }}"  class="custom-select {{!empty($errors->first('txtmark.'.$key)) ? 'border-red' : ''}}"> </td>
                         
                            <td><input type="hidden" name="id[]" value="{{$i->id}}"></td>

                            <td><input type="hidden" name="student_id[]" value="{{$exam->student_id}}"></td>
                            <td><input type="hidden" name="exam_id" value="{{$getexam->id}}" ></td>
                        
                            <td><input type="hidden" name="user_id" value="{{Auth::user()->id}}"></td>
                      
                        @empty

                            <td><input type="text" name="mark[]"    value="{{ old('mark')[$key] ?? '' }}"  class="custom-select {{!empty($errors->first('mark.'.$key)) ? 'border-red' : ''}}"><td>
                           
                            <td><input type="hidden" name="student_id[]" value="{{$exam->student_id}}"></td>
                            <td><input type="hidden" name="exam_id" value="{{$getexam->id}}" ></td>
                        
                            <td><input type="hidden" name="user_id" value="{{Auth::user()->id}}"></td>

                        @endforelse
        
                   
                        </tr>
                 
                       
                    @endforeach

            </tbody>
            
          </table>
          </form>
          </div>
   

      </div>
    </div>
  </div>

@endsection
@push('after_styles')
<style>
.border-red {
    border: 1px solid red;
}
</style>
@endpush