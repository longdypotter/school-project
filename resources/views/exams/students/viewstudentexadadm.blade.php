@extends('backpack::layout')

<style>
    div.dataTables_filter {
    text-align: right;
    }
    .pull-right {
    margin-right: 5px !important;  
    }
    .box-header {
    color: #444;
    display: block;
    padding: 15px !important;
    position: relative;

    }
    .box{
        padding-bottom: 20px !important;
    }
    .overflow-hidden
        {
            overflow:hidden;
        }
    #btnprint{
        
        float:right;
        margin-top: 80px;
         margin-right: 10px;
    }
    @media print {
        #btnprint {
                display: none !important;
        }
    }
    .box {
    border-top: 0px solid #d2d6de !important;
}
@media print {
.footer,
    #non-printable {
        display: none !important;
    }
}
    /* .table>thead>tr>th {
        border-bottom: 2px solid #f1f5f8 !important;
    }
    .table>tbody+tbody {
        border-top: 2px solid #f1f5f8 !important;
    } */
</style>

@section('header')
<section class="content-header">
<h1>
  <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
  <small>{{ trans('backpack::crud.all') }} <span>{{ $crud->entity_name_plural }}</span> {{ trans('backpack::crud.in_the_database') }}.</small>
</h1>
<ol class="breadcrumb">
  <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
  <li><a href="{{backpack_url('index')}}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
  <li class="active">{{ trans('backpack::crud.list') }}</li>
</ol>
  <br>
<!-- <div class="col-md-4"> -->

 <a href="{{route('crud.exam.index')}}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all  <span>Exam</span></a>
<!-- </div> -->
<br>
</section>
@endsection


@include('inc.datatableprint')
@include('inc.select2')
@section('content')



<!-- Default box -->
<div class="row">
<!-- THE ACTUAL CONTENT -->


<div class="box">
  <br>
    @if($getexam)
 
    <div class="box-body overflow-hidden no-padding " style="margin-left:10px">
  
            <div  class=" col-xs-4 col-sm-4 col-md-2" style="padding-left:8px">
                <b>{{trans('flexi.name')}}:</b>&nbsp&nbsp<span >{{$getstudent->exam->name}} </span><br>
                <b>{{trans('flexi.exam_date')}}:</b>&nbsp&nbsp<span >{{ date('d-m-Y', strtotime($getstudent->exam->exam_date)) }} </span><br>
                <b>{{trans('flexi.teacher')}}:</b>&nbsp&nbsp<span >{{$getstudent->exam->teacher->name}}</span><br>
            </div>
            <div  class=" col-xs-6 col-sm-4 col-md-4">
                <b>{{trans('flexi.class')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->class->name}}</span><br>
                <b>{{trans('flexi.section')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->section->name}} </span><br>
                <b>{{trans('flexi.subject')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->subject->name}} </span><br>
            </div>
        


      <table class="table table-striped table-hover display nowrap">
     <thead>
      <tr>

         <th scope="col">{{ trans('flexi.student') }}</th>
         <th scope="col">{{ trans('flexi.gender') }}</th>
         <th scope="col">{{ trans('flexi.date_of_birth') }}</th>
         <th scope="col">{{ trans('flexi.phone')}}</th>
      
          <th scope="col">{{ trans('flexi.mark') }}</th>
        
          {{--<th>{{ trans('flexi.name') }}</th>--}}
          {{--<th>{{ trans('flexi.exam_date') }}</th>--}}
          
          {{--<th>{{ trans('flexi.teacher') }}</th>--}}
          {{--<th>{{ trans('flexi.class') }}</th>--}}
          {{--<th>{{ trans('flexi.section') }}</th>--}}
          {{--<th>{{ trans('flexi.subject') }}</th>--}}

      </tr>
      </thead>

     
       
    
      
              <tbody>
              
              @foreach($getexam as $key=>$exam)
                  <tr>
                  
                  <td>{{$exam->student->english_name}}</td>
                  <td>{{$exam->student->gender}}</td>
                  <td>{{date('d-m-Y', strtotime($exam->student->date_of_birth))}}</td>
                  <td>{{$exam->student->phone}}</td>
             
                  <td>{{$exam->mark}}</td>

                  {{-- <td><input type="text" name="txtmark[]" value="{{$exam->mark}}">  <input type="hidden" name="id[]" value="{{$exam->id}}"></td>--}}
                
                  {{--<td>{{$exam->exam->name}}</td>--}}
                  {{--<td>{{$exam->exam->exam_date}}</td>--}}
                  
                  {{--<td>{{$exam->exam->teacher->name}}</td>--}}
                  {{--<td>{{$exam->exam->assignsubject->class->name}}</td>--}}
                  {{--<td>{{$exam->exam->assignsubject->section->name}}</td>--}}
                  {{--<td>{{$exam->exam->assignsubject->subject->name}}</td>--}}
                  
                  </tr>
              
              @endforeach
              
             
      </tbody>
               
           
    
    
    
        
        
      </table>
    </div>

     {{-- </form> --}}
    </div>
    
    @else
        <h3 style="text-align:center">No Have Student Mark</h3>
    @endif
  
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

