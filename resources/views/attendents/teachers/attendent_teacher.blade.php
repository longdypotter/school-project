@extends('backpack::layout')
<style>
.mailbox-controls {
    padding: 0px;
    /* padding-bottom: 10px; */
}
.pull-right {
    float: right;
   
}
.btn-primary {
    background-color: #727272;
    border-color: #525252;
    transition: .3s;
}
.skin-blue .main-header .logo, .dropdown-menu>li>a, .btn-default, .sidebar a, .btn-default, .sidebar a, .btn, .btn {
    position: relative;
    overflow: hidden;
}
.box-header {
    color: #444;
    display: block;
    padding: 5px;
    position: relative;
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
	    <li><a href="{{  backpack_url('attendentstudent') }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
    <br>
    <!-- <div class="col-md-4"> -->
  
     <a href="{{route('crud.attendentteacher.index')}}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all  <span>Attachments</span></a>
    <!-- </div> -->
    <br>
	</section>
@endsection


@section('content')
<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header hidden-print with-border row">
         
        </div>

      <div class="box-body overflow-hidden no-padding">
          <table id="datatable" class="table  table-hover display nowrap" style="width: 100% !important;">
     
              <tr>
            
                <th>{{ trans('flexi.teacher')}}</th>
                <!-- <th>{{ trans('flexi.session')}}</th> -->
                <th>{{ trans('flexi.class') }}</th>
                <th>{{ trans('flexi.section') }}</th>
                <th>{{ trans('flexi.subject') }}</th>
                <th>{{ trans('flexi.gender') }}</th>
                <th>{{ trans('flexi.date_of_birth') }}</th>
                <th>{{ trans('flexi.attendent')}}</th>
              </tr>
         
            <tbody>
            
            
             
              <form action="{{route('crud.attendentteacher.store')}}" method="post">
              @csrf
              <div class="mailbox-controls" >
                    <span class="button-checkbox">
                    <div class="pull-right">
                    <?php
                      $now = (new DateTime('now'))->format('d-m-Y');
                    ?>
                    
                    @foreach($teacher as $t)
                    <input type="hidden" name="teacher_id[]" value="{{$t->id}}">
                     @endforeach
                     
                     <input type="hidden" name="attendent_date" value="{{$now}}">
                     <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                     <button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> {{trans('flexi.save_attendance')}} </button></div>
                     
                     </div>

                </div>
                
                @foreach($teacher as $t)
              
              <tr>
                  <td>{{ $t->name }}</td>

           
             {{-- td @foreach($t->hasAssignsubjects as $a)
                  @php
                          $classId = $a->class_id;
                          $sectionId=$a->section_id;
                          $teacherid=$a->teacher_id;
                          $getassignsubject = \App\Models\AssignSubject::where('class_id', $classId)->where('section_id', $sectionId)->get();
                          

                      @endphp
                 
                      @foreach($getassignsubject as $ss) 
                      @php
                      
                          $getsession = \App\Models\StudentSession::where(function ($q) use ($ss) {
                              $q->where('class_id', $ss->class_id);
                              $q->where('section_id', $ss->section_id);
                              })->get();  
                                              
                      @endphp
                 
                          @php
                          $arr = array();
                          
                            foreach ($getsession as $session):
                              
                                $arr[] = $session->sessions;
                                
                            endforeach;
                             $unique_data = array_unique($arr); 
                            
                           @endphp
                          @foreach($unique_data as $val) 
                              {{$val->session}}<br>
                            @endforeach
                    
                            
                      
                      @endforeach 
               
                      @endforeach
                      td --}}
                    
     
                  <td>
                  @foreach($t->hasAssignsubjects as $cla)
                    
                  {{$cla->class->name}}<br>

                  @endforeach
                  </td>

                  <td>
                  @foreach($t->hasAssignsubjects as $cla)
                    
                  {{$cla->section->name}}<br>

                  @endforeach
                  </td>

                   <td>
                  @foreach($t->hasAssignsubjects as $cla)
                    
                  {{$cla->subject->name}}<br>

                  @endforeach
                  </td>

                  <td>{{$t->gender}}</td>
                  <td>{{date('d-m-Y', strtotime($t->date_of_birth))}}</td>
                  <td>
                        <input  type="checkbox" value="{{$t->id}}" name="attendent[]" checked> 
                    </td>
               
            @endforeach
           
              </form>
      
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
