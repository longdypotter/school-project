@extends('backpack::layout')
<style>
    div.dt-buttons {
    margin-top: 10px !important;
    }
    .box{
        padding-bottom: 15px !important;
        padding-left:10px !important;
        padding-right:10px !important;
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
      <a href="{{route('crud.exam.index')}}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all  <span>Exam</span></a>
      <br>
	</section>
@endsection

@include('inc.datatableprint')
@include('inc.select2')

@section('content')
<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
      @if($getexam)
        <div class="box-header hidden-print with-border row">

            <div  class=" col-xs-4 col-sm-4 col-md-3 box-header" >
                <b>{{trans('flexi.name')}}:</b>&nbsp&nbsp<span >{{$getstudent->exam->name}} </span><br>
                <b>{{trans('flexi.exam_date')}}:</b>&nbsp&nbsp<span >{{ date('d-m-Y', strtotime($getstudent->exam->exam_date)) }} </span><br>
                <b>{{trans('flexi.teacher')}}:</b>&nbsp&nbsp<span >{{$getstudent->exam->teacher->name}}</span><br>
            </div>
            <div  class=" col-xs-6 col-sm-4 col-md-4 box-header">
                <b>{{trans('flexi.class')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->class->name}}</span><br>
                <b>{{trans('flexi.section')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->section->name}} </span><br>
                <b>{{trans('flexi.subject')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->subject->name}} </span><br>
            </div>
        </div>

        <div class="box-body overflow-hidden no-padding">
          <table id="datatable" class="table table-striped table-hover display nowrap" style="width: 100% !important;">
         
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('flexi.student') }}</th>
                <th>{{ trans('flexi.gender') }}</th>
                <th>{{ trans('flexi.date_of_birth') }}</th>
                <th>{{ trans('flexi.phone')}}</th>
                <th>{{ trans('flexi.email') }}</th>
                <th>{{ trans('flexi.mark') }}</th>

            </tr>
              @php
                $count=1;
              @endphp
              <tbody>
                 @foreach($getexam as $key=>$exam)
                  <tr>
                    <td>{{$count++}}</td>
                    <td>{{$exam->student->english_name}}</td>
                    <td>{{$exam->student->gender}}</td>
                    <td>{{date('d-m-Y', strtotime($exam->student->date_of_birth))}}</td>
                    <td>{{$exam->student->phone}}</td>
                    <td>{{$exam->student->email}}</td>
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
                    <!-- <button id="btnprint" onclick="window.print()" class="btn btn-primary"><i class="fa fa-print"></i>{{trans('flexi.print')}}</button>  -->
              </tbody>
          </table>
        </div>
        @else
        <h3 style="text-align:center">No Have Student Mark</h3>
    @endif
      </div>
  
    </div>
  </div>

@endsection
