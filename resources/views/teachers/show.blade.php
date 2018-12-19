@extends('backpack::layout')

@section('content-header')


	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
        <small>{{ ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name }}.</small>
      </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.preview') }}</li>
	  </ol>
	</section>
@endsection


@section('content')
<style>
        .customtab li.active a, .customtab li.active a:hover, .customtab li.active a:focus {
            border-bottom: 2px solid #2cabe3;
            color: #2cabe3;
        }
        .customtab li.active a, .customtab li.active a:focus, .customtab li.active a:hover {
            background: #ffffff;
            border: 0px;
            border-bottom: 2px solid #2cabe3;
            margin-bottom: -1px;
            color: #2cabe3;
        }
        .white-box {
            background: #ffffff;
            padding: 25px;
            margin-bottom: 30px;
        }
        .tab-content {
            margin-top: 30px;
        }
        .tab-pane {
            margin-top: -15px;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 10px 8px;
        }
        .b-r {
            border-right: 1px solid rgba(120, 130, 140, 0.13);
        }
</style>
	<!-- @if ($crud->hasAccess('list'))
		<a href="{{ url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
	@endif
    -->
        <div style="margin-top:15px" class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="box">
                    @if(isset($entry) && isset($entry->profile) > 0 )
                                <img src="{{ asset($entry->profile) }}" width="100%" alt="user"
                            >
                            @endif
                        <div class="white-box">
                           
                            <!-- <div class="user-btm-box"> -->
                            <!-- .row -->
                            <div class="row text-center m-t-10">
                                <div class="col-md-6 b-r"><strong>{{trans('flexi.name')}}</strong>
                                    <p>{{$entry->name}}</p>
                                </div>
                                <div class="col-md-6"><strong>{{trans('flexi.phone')}}</strong>
                                    <p>{{$entry->phone}}</p>
                                </div>
                            </div>
                            <!-- /.row -->
                            <hr>
                            <div class="row text-center m-t-10">
                                <div class="col-md-12"><strong>{{trans('flexi.email')}}</strong>
                                    <p>{{$entry->email}}</p>
                                </div>
                            </div>

                            <!-- /.row -->
                            
                            <!-- .row -->
                            <div class="row text-center m-t-10">
                                <!-- <div class="col-md-6 b-r"><strong>{{trans('flexi.email')}}</strong>
                                    <p>{{$entry->email}}</p>
                                </div> -->
                                <!-- <div class="col-md-6"><strong>{{trans('flexi.phone')}}</strong>
                                    <p>{{$entry->phone}}</p>
                                </div> -->
                            </div>
                            <hr>
                            <!-- /.row -->
                            
                            <!-- .row -->
                            <div class="row text-center m-t-10">
                                <div class="col-md-12"><strong>{{trans('flexi.address')}}</strong>
                                    <p>#{{$entry->house_no}}, St:{{$entry->street_no}}, {{$entry->addressFull->getFullAddressAttribute()}}</p>
                                </div>
                            </div>
                        </div>
                    <!-- </div> -->
                </div>
                </div>

            <div class="col-md-8 col-xs-12">
                    <div class="box">
                        <div class="white-box">
                        
                                <ul class="nav nav-tabs tabs customtab">
                                <li class="active tab">
                                    <a href="#" data-target="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">{{trans('flexi.personal')}}</span> </a>
                                </li>
                                <li class="tab">
                                    <a href="#" data-target="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-file-text"></i></span> <span class="hidden-xs">{{trans('flexi.curriculum')}}</span> </a>
                                </li>
                                <!-- <li class="tab">
                                    <a href="#" data-target="#class" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">{{trans('flexi.class')}}</span> </a>
                                </li> -->
                                <!-- <li class="tab">
                                    <a href="#" data-target="#student" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">{{trans('flexi.student')}}</span> </a>
                                </li> -->

                                 <li class="tab">
                                    <a href="#" data-target="#classstudent" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">{{trans('flexi.class')}}</span> </a>
                                </li>

                            </ul>
                            <!-- /.tabs -->
                            <div class="tab-content">
                                <!-- .tabs 1 -->
                                <div class="tab-pane active" id="home">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <table class="table">
                                                <thead>
                                                        <td class="col-md-3 text-bold">{{trans('flexi.gender')}}</td>
                                                        <td class="col-md-9">{{$entry->gender}}</td>
                                                </thead>
                                                <tbody>
                                                    <!-- <tr>
                                                        <td class="col-md-6">{{trans('flexi.gander')}}</td>
                                                        
                                                        <td class="col-md-6">{{$entry->gender}}</td>
                                                    </tr> -->
                                                    <tr>
                                                        <td class="text-bold">{{trans('flexi.date_of_birth')}}</td>
                                                        <td>{{$entry->date_of_birth}}</td>
                                                    </tr>

                                                    <!-- <tr>
                                                        <td>{{trans('flexi.phone')}}</td>
                                                        <td>{{$entry->phone}} </td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('flexi.email')}}</td>
                                                        <td><a href="#">{{$entry->email}}</a></td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('flexi.address')}}</td>
                                                        <td>{{$entry->house_no}}/ {{$entry->street_no}}/ {{$entry->addressFull->_path_en}}</td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tabs1 -->
                                <!-- .tabs2 -->
                                <div class="tab-pane" id="profile">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{trans('flexi.title')}}</th>
                                                        <th class="text-left">{{trans('flexi.url')}}</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>  
                                                <?php $number = 1 ?>  
                                                    @if(isset($entry) && count($entry->curriculum) > 0 )
                                                        <!-- <h3 style=" 
                                                                    border-style: solid;
                                                                    border-color: rgb(201, 76, 76);    
                                                                    height: 60px;
                                                                    padding-top: 12px;
                                                                    color:red">
                                                            <b>{{trans('flexi.Document_File')}}</b>
                                                        </h3>
                                                        <hr> -->
                                                        <!-- @foreach($entry->curriculum as $cur)
                                                            <a href="{{route('download.index',base64_encode($cur))}}" target="_blank">
                                                            <img src="{{ asset($cur) }}"
                                                            style="width:50px;height:50px;"></a><br><br>
                                                        @endforeach    -->
                                                    <div class="row" >
                                                        <tr>
                                                            <td class="col-md-7">
                                                                @foreach($entry->curriculum as $cur)
                                                                    {{trans('flexi.column')}} {{$number++}} <br>
                                                                 @endforeach
                                                            </td>
                                                            
                                                            <td class="col-md-5 text-left">
                                                                <a href="{{route('download.index',$entry->id)}}" class="btn btn-xs btn-default" target="_blank">
                                                                        <i class="fa fa-download"></i>
                                                                        {{trans('flexi.download')}}
                                                                </a><br>
                                                            </td>  
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tabs2 -->
                                 <!-- tabs3 Class-->
                                <!-- <div class="tab-pane " id="class">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <table class="table">
                                                <thead>
                                                    <th>{{trans('flexi.class')}}</th>
                                                    <th>{{trans('flexi.section')}}</th>
                                                    <th>{{trans('flexi.subject')}}</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($entry->assignSubjects as $teacher)
                                                        <tr>
                                                            <td>
                                                                {{optional($teacher->class)->name}} 
                                                            </td>
                                                            <td>
                                                                {{optional($teacher->section)->name}}
                                                            </td>
                                                            <td>
                                                                {{optional($teacher->subject)->name}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- /.tabs3 -->


                                 <!-- tabs4 Student-->
                                 <!-- <div class="tab-pane" id="student">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <table class="table">
                                                <thead>
                                                    <th class="col-md-4">{{trans('flexi.name')}}</th>
                                                    <th class="col-md-4">{{trans('flexi.class')}}</th>
                                                    <th class="col-md-4">{{trans('flexi.section')}}</th>
                                                     <th class="col-md-3">{{trans('flexi.subject')}}</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($getStudent as $student)
                                                    
                                                        <tr>
                                                            <td>
                                                                {{optional($student->students)->english_name}} 
                                                            </td>
                                                            <td>
                                                                {{optional($student->classes)->name}} 
                                                            </td>
                                                            <td>
                                                                {{optional($student->sections)->name}}
                                                            </td>
                                                             <td>
                                                                {{optional($teacher->subject)->name}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> -->
                                
                                <!-- /.tabs4 -->

                                <!--/.tabs5 -->
                                    <div class="tab-pane" id="classstudent">
                                        <div class="steamline">
                                            <div class="sl-item">
                                                <div id="appshow">
                                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                    @foreach($getclass as $key=>$c)
                                                    <div class="panel panel-default">

                                                        <div class="panel-heading cursor-pointer" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" data-target="#{{str_slug($key, '-')}}">
                                                        <h4 class="panel-title">
                                                            <a role="button" href="#/" aria-expanded="true" aria-controls="collapseOne">
                                                            {{$key}}
                                                            </a>
                                                        </h4>
                                                        </div>

                                                        <div id="{{str_slug($key, '-')}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">
                                                        <table class="table">
                                                        <div>                  
                                                            <thead>
                                                                <th class="col-md-3">{{trans('flexi.name')}}</th>
                                                                <th class="col-md-3">{{trans('flexi.section')}}</th>
                                                                <th class="col-md-3">{{trans('flexi.subject')}}</th>
                                                                <th class="col-md-3">Action</th>

                                                            </thead>
                                                        
                                                        </div>
                                                            <tbody > 
                                                            @php
                                                                $classId = $c->pluck('class_id')->unique();
                                                                $sectionId = $c->pluck('section_id');
                                                                $getStudentSession = \App\Models\StudentSession::whereIn('class_id', $classId)->whereIn('section_id', $sectionId)->get();
                                                            @endphp

                                                            @foreach($getStudentSession as $s) 
                                                            @php
                                                                $getSubject = \App\Models\AssignSubject::where(function ($q) use ($s) {
                                                                    $q->where('class_id', $s->class_id);
                                                                    $q->where('section_id', $s->section_id);
                                                                })->first();
                                                            @endphp

                                                                <tr>
                                                                    <td>{{$s->students->english_name}}</td>
                                                                    <td>{{$s->sections->name}}</td>
                                                                    <td>{{optional($getSubject->subject)->name}}</td>
                                                                    <th><a href="{{route('crud.student.show',optional($s->students)->id)}}" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-eye"></i>Perview</a></th>
                                                                </tr>
                                                                @endforeach
                                                            </tbody> 
                                                            </table> 
                                                            </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                        </div>                                  
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                <!--/.tabs5-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- end row -->
    </div> 
</div>
@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">

@endsection
@section('after_scripts')
	<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
	<script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>

    <script>
            var appshow=new Vue({
                el:'#appshow',
                data:function(){
                    return{
                       enableclass:false,
                    }
                },
                methods:{
                    enable:function(){
                        this.enableclass =!this.enableclass;  
                    }
                }
            })


    </script>
@endsection