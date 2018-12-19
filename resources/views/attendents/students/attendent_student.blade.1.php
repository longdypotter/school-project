@extends('backpack::layout')
<style>
.mailbox-controls {
    padding: 0px;
    /* padding-bottom: 10px; */
}
.pull-right {
    float: right!important;
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
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
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
   
            @component('inc.select2_from_array', [
              'name'=>'class', 'options' => $classes, 'placeholder'=>'', 'required' => ''])
            @endcomponent
             
            @component('inc.select2_from_array', [
              'name'=>'section', 'options' => $section, 'placeholder'=>'', 'required' => ''])@endcomponent
        
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>{{ trans('flexi.search') }}</button>
            </div>

          </form>
        </div>

      <div class="box-body overflow-hidden no-padding">
          <table id="datatable" class="table table-striped table-hover display nowrap" style="width: 100% !important;">
           
              <tr>
                <th>{{ trans('flexi.student')}}</th>
                <th>{{ trans('flexi.class') }}</th>
                <th>{{ trans('flexi.session') }}</th>
                <th>{{ trans('flexi.gender') }}</th>
                <th>{{ trans('flexi.date_of_birth') }}</th>
                <th>{{ trans('flexi.attendent')}}</th>
              </tr>
       
            <tbody>
            
              @if(session()->exists('search') && !empty(session('search.class')) && !empty(session('search.section')))
             
              <form action="{{route('attendentstudent.createattendentstudent')}}" method="post">
              @csrf
              <div class="mailbox-controls">
                    <span class="button-checkbox">
                    <div class="pull-right">
                    <?php
                    $now = (new DateTime('now'))->format('Y-m-d');
                    
                    ?>

                     <input type="hidden" name="attendent_date" value="{{$now}}">
                     <button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> {{trans('flexi.save_attendance')}} </button></div>
                     </div>
                </div>
            
             
                @foreach($entry as $r)
                <tr>
                    <td>{{$r->students->english_name}}</td>
                    <td>{{$r->classes->name}}</td>
                    <td>{{$r->sections->name}}</td>
                    <td>{{$r->students->gender}}</td>
                    <td>{{date_format($r->students->date_of_birth, 'd-m-Y') }}</td>
                    <td><input  type="checkbox" value="{{$r->student_id}}" name="attendent[]"></td>
                 </tr>



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
