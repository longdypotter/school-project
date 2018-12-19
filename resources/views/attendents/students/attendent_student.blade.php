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
  
     <a href="{{route('crud.attendentstudent.index')}}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all  <span>Attachments</span></a>
    <!-- </div> -->
    <br>
	</section>
@endsection

@include('inc.datatable')
@include('inc.select2')

@section('content')
<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header hidden-print with-border row">
          <form action="{{route('searchable')}}" method="post">
            @csrf
           
             
          @hasanyrole('Teacher')
      
        <div class="form-group col-xs-12 col-sm-6 col-md-4 ">
           <label>Class</label>
           <select name="class" class="form-control select2_element col-md-4">
           @foreach($classes as $c)
              <option value="{{$c->class_id}}">{{$c->class->name}}</option>
            @endforeach
           </select>
        </div>

        <div class="form-group col-xs-12 col-sm-6 col-md-4 ">
           <label>Section</label>
           <select name="section" class="form-control select2_element col-md-4">
           @foreach($sections as $c)
              <option value="{{$c->section_id}}">{{$c->section->name}}</option>
            @endforeach
           </select>
        </div>

        <div class="form-group col-xs-12 col-sm-6 col-md-4 ">
           <label>Section</label>
           <select name="subject" class="form-control select2_element col-md-4">
           @foreach($subjects as $c)
              <option value="{{$c->subject_id}}">{{$c->subject->name}}</option>
            @endforeach
           </select>
        </div>
          

         @endhasanyrole
             
         @hasanyrole('Developer|Admin')
         @component('inc.select2_from_array', [
              'name'=>'class', 'options' => $classes, 'placeholder'=>'', 'required' => ''])@endcomponent

            @component('inc.select2_from_array', [
              'name'=>'section', 'options' => $section, 'placeholder'=>'', 'required' => ''])@endcomponent

            @component('inc.select2_from_array', [
              'name'=>'subject', 'options' => $subject, 'placeholder'=>'', 'required' => ''])@endcomponent
        @endhasanyrole
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>{{ trans('flexi.search') }}</button>
            </div>

          </form>
        </div>

      <div class="box-body overflow-hidden no-padding">
          <table id="datatable" class="table  table-hover display nowrap" style="width: 100% !important;">
     
              <tr>
            
                <th>{{ trans('flexi.student')}}</th>
                <th>{{ trans('flexi.class') }}</th>
                <th>{{ trans('flexi.section') }}</th>
                <th>{{ trans('flexi.subject') }}</th>
                <th>{{ trans('flexi.gender') }}</th>
                <th>{{ trans('flexi.date_of_birth') }}</th>
                <th>{{ trans('flexi.attendent')}}</th>
              </tr>
         
            <tbody>
            
              @if(session()->exists('search'))
             
              <form action="{{route('attendentstudent.createattendentstudent')}}" method="post">
              @csrf
              <div class="mailbox-controls">
                    <span class="button-checkbox">
                    <div class="pull-right">
                    <?php
                      $now = (new DateTime('now'))->format('Y-m-d');
                    ?>
                    @foreach($entry as $e)
                    @php

                        $classId = $e->class_id;
                        $sectionId = $e->section_id;
                        $getStudent = \App\Models\StudentSession::where(function ($q) use ($classId,$sectionId) {
                                $q->where('class_id', $classId);
                                $q->where('section_id', $sectionId);
                            })->get();
                    
                    @endphp
                   
                    @foreach($getStudent as $s)
                       <input type="hidden" name="student_id[]" value="{{$s->student_id}}">
                     
                     @endforeach
                  @endforeach
                     <input type="hidden" name="attendent_date" value="{{$now}}">
                    @foreach($entry as $r)
                     <input type="hidden" name="assign_subject_id" value="{{$r->id}}">
                    @endforeach
                    <input type="hidden" name="user_id" value="{{\Auth::user()->id}}">
                     <button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> {{trans('flexi.save_attendance')}} </button></div>
                     </div>
                </div>
            
         
                @foreach($entry as $r)
               
               
                    @php
                        $classId = $r->class_id;
                        $sectionId = $r->section_id;
                        $getStudent = \App\Models\StudentSession::where(function ($q) use ($classId,$sectionId) {
                                $q->where('class_id', $classId);
                                $q->where('section_id', $sectionId);
                            })->get();
                    @endphp
                   
                    @foreach($getStudent as $s)
                    <tr>
                  
                    <?php
                        if($s->students==true)
                        {
                           echo '<td>'.$s->students->english_name.'</td>';
                        }
                        else
                        {
                         echo '<td>'.''.'</td><br>';
                        } 
                    ?>
                                      
                    
                    <td>{{$r->class->name}}</td>
                    <td>{{$r->section->name}}</td>
                    
                 
                    <td>{{$r->subject->name}}</td>
                   
                    <?php
                        if($s->students==true)
                        {
                           echo '<td>'.$s->students->gender.'</td>';
                           echo '<td>'.date_format($s->students->date_of_birth, 'd-m-Y').'</td>';
                        }
                        else
                        {
                         echo '<td>'.''.'</td>';
                         echo '<td>'.''.'</td>';
                        } 
                    ?>
                 
                     <td>
                        <input  type="checkbox" value="{{$s->student_id}}" name="attendent[]" checked > 
                    </td>
                    </tr>
                    @endforeach
                

                @endforeach 
                
              @endif
              </form>
             
          {{--    @include('report.customer.text') --}}

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
