@extends('backpack::layout')

<style>
 div.dataTables_filter {
    text-align: right;
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

@include('inc.datatablesearch')
@include('inc.select2')

@section('content')



<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
 
    <div class="box">
        <div class="box-header hidden-print with-border row">
          
          <div  class=" col-xs-12 col-sm-4 col-md-3" >
                <b>{{trans('flexi.teacher')}}:</b>&nbsp&nbsp  <span > {{$attendentdate->first()->assignsubject()->first()->teacher()->first()->name}} </span><br>
                <b>{{trans('flexi.class')}}:</b>&nbsp&nbsp <span >{{$attendentdate->first()->studentsessions()->first()->classes()->first()->name}}</span><br>
                <b>{{trans('flexi.section')}}:</b>&nbsp&nbsp  <span >{{$attendentdate->first()->studentsessions()->first()->sections()->first()->name}}</span><br>
          </div>
          @php
                        $classId = $attendentdate->first()->studentsessions()->first()->class_id;
                        $sectionId = $attendentdate->first()->studentsessions()->first()->section_id;
                        
                    @endphp
    
                        @php
                        $getSubject = \App\Models\AssignSubject::where(function ($q) use ($classId,$sectionId) {
                                $q->where('class_id', $classId);
                                $q->where('section_id', $sectionId);
                            })->first();
                            @endphp
          <div  class=" col-xs-12 col-sm-4 col-md-4">
                <b>{{trans('flexi.subject')}}:</b>&nbsp&nbsp<span> {{$getSubject->subject->name}}  </span><br>
                <b>{{trans('flexi.session')}}:</b>&nbsp&nbsp <span> {{$attendentdate->first()->studentsessions()->first()->sessions()->first()->session}}  </span><br>
              
          </div>
       
        </div>
     
      
        <div class="box-body overflow-hidden no-padding">
          <table id="datatable" class="table table-striped table-hover display nowrap" style="width: 100% !important;">
        
            <thead>
            <tr>
                  {{--  <th>{{trans('flexi.teacher')}}</th> --}}
                    <th scope="col">{{trans('flexi.name')}}</th>
                  {{--  <th scope="col">{{trans('flexi.session')}}</th> --}}
                  {{--  <th scope="col">{{trans('flexi.class')}}</th> --}}
                  {{--  <th scope="col">{{trans('flexi.section')}}</th> --}}
                  {{--  <th scope="col">{{trans('flexi.subject')}}</th> --}}
                    <th scope="col">{{trans('flexi.gender')}}</th>
                    <th scope="col">{{trans('flexi.phone')}}</th>
                    <th scope="col">{{trans('flexi.status')}}</th>
                    </tr>
            </thead>
            <tbody>
     
            @foreach($attendentdate as $att)
                  @if($att->status=='Absent')
                    <tr style="background:#db6969">
                  {{--  <td>{{$att->assignsubject->teacher->name}}</td> --}}
                    <td scope="row">{{$att->student->english_name}}</td>
                    {{-- <td>{{$att->studentsessions->sessions->session}}</td> --}}
                    {{--  <td>{{$att->studentsessions->classes->name}}</td> --}} 
                    {{-- <td>{{$att->studentsessions->sections->name}}</td> --}}
                    @php
                        $classId = $att->studentsessions->class_id;
                        $sectionId = $att->studentsessions->section_id;
                        
                    @endphp

                        @php
                        $getSubject = \App\Models\AssignSubject::where(function ($q) use ($classId,$sectionId) {
                                $q->where('class_id', $classId);
                                $q->where('section_id', $sectionId);
                            })->first();
                            @endphp
                    {{-- <td>{{$getSubject->subject->name}}</td> --}}
                    <td>{{$att->student->gender}}</td>
                    <td>{{$att->student->phone}}</td>
                    <td>{{$att->status}}</td>
                    </tr>
                  


                   @else

                    <tr>
                  {{--  <td>{{$att->assignsubject->teacher->name}}</td> --}}
                    <td scope="row">{{$att->student->english_name}}</td>
                    {{-- <td>{{$att->studentsessions->sessions->session}}</td> --}}
                    {{--  <td>{{$att->studentsessions->classes->name}}</td> --}} 
                    {{-- <td>{{$att->studentsessions->sections->name}}</td> --}}
                    @php
                        $classId = $att->studentsessions->class_id;
                        $sectionId = $att->studentsessions->section_id;
                        
                    @endphp

                        @php
                        $getSubject = \App\Models\AssignSubject::where(function ($q) use ($classId,$sectionId) {
                                $q->where('class_id', $classId);
                                $q->where('section_id', $sectionId);
                            })->first();
                            @endphp
                    {{-- <td>{{$getSubject->subject->name}}</td> --}}
                    <td>{{$att->student->gender}}</td>
                    <td>{{$att->student->phone}}</td>
                    <td>{{$att->status}}</td>
                    </tr>
                   @endif
                  @endforeach
                    
                
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
