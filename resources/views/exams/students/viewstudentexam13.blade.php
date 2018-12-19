@extends('backpack::layout')
<style>
    @media print {
        #btnprint{
            display: none;
        }
    }
    #btnprint{
        
        float:right;
        margin-top: 10px !important;
        margin-right:10px;
    }
    
down vote
@media print {
    .footer,
    #btnprint {
        display: none !important;
    }
    #btnprint {
        display: block;
    }
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
	    <li><a href="{{backpack_url('report/student-info')}}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>

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
      

        <div class="box-body overflow-hidden no-padding">
          <table class="table table-striped table-hover display nowrap" style="width: 100% !important;">
         
     
          <div  class=" col-xs-4 col-sm-4 col-md-2 box-header" >
                <b>{{trans('flexi.name')}}:</b>&nbsp&nbsp<span >{{$getstudent->exam->name}} </span><br>
                <b>{{trans('flexi.exam_date')}}:</b>&nbsp&nbsp<span >{{ date('d-m-Y', strtotime($getstudent->exam->exam_date)) }} </span><br>
                <b>{{trans('flexi.teacher')}}:</b>&nbsp&nbsp<span >{{$getstudent->exam->teacher->name}}</span><br>
            </div>
            <div  class=" col-xs-6 col-sm-4 col-md-4 box-header">
                <b>{{trans('flexi.class')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->class->name}}</span><br>
                <b>{{trans('flexi.section')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->section->name}} </span><br>
                <b>{{trans('flexi.subject')}}:</b>&nbsp&nbsp<span>{{$getstudent->exam->assignsubject->subject->name}} </span><br>
            </div>
            
     
            <thead>
            <tr>
                <th scope="col">{{ trans('flexi.student') }}</th>
                <th scope="col">{{ trans('flexi.gender') }}</th>
                <th scope="col">{{ trans('flexi.date_of_birth') }}</th>
                <th scope="col">{{ trans('flexi.phone')}}</th>

                <th scope="col">{{ trans('flexi.mark') }}</th>

            </tr>

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
                    <button id="btnprint" onclick="window.print()" class="btn btn-primary"><i class="fa fa-print"></i>{{trans('flexi.print')}}</button> 
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
