@extends('backpack::layout')

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

@include('inc.datatable')
@include('inc.select2')

@section('content')
<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header hidden-print with-border row">
          <form action="{{ route('searchable') }}" method="post">
            @csrf

            @include('inc.select2_ajax_student')

            @component('inc.select2_from_array', [
              'name'=>'session', 'options' => $session, 'placeholder'=>''])@endcomponent
            
            @component('inc.select2_from_array', [
              'name'=>'class', 'options' => $classes, 'placeholder'=>''])@endcomponent

            @component('inc.select2_from_array', [
              'name'=>'section', 'options' => $section, 'placeholder'=>''])@endcomponent
            
            @component('inc.select2_from_array', [
              'name'=>'subject', 'options' => $subject, 'placeholder'=>''])@endcomponent

         

            <div class="{{ $wrapperClass ?? 'form-group col-xs-12 col-sm-6 col-md-4' }}">
              <label>Gender</label><br>
              <select class="form-control select2_element" name="gender">
                  <option value=''>-</option>
                  <option value="ប្រុស"​​ <?php if(session('search.gender')=='ប្រុស'){echo 'selected';} ?> >ប្រុស</option>
                  <option value="ស្រី"  <?php if(session('search.gender')=='ស្រី'){echo 'selected';} ?>  >ស្រី</option>
              </select>
            </div>
            
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>{{ trans('flexi.search') }}</button>
            </div>

          </form>
        </div>

        <div class="box-body overflow-hidden no-padding">
          <table id="datatable" class="table table-striped table-hover display nowrap" style="width: 100% !important;">
            <thead>
              <tr>
                <th>{{ trans('flexi.student') }}</th>
                <th>{{ trans('flexi.session') }}</th>
                <th>{{ trans('flexi.class') }}</th>
                <th>{{ trans('flexi.section') }}</th>
                <th>{{ trans('flexi.subject') }}</th>
                <th>{{ trans('flexi.gender') }}</th>
                <th>{{ trans('flexi.date_of_birth') }}</th>
                {{-- <th>{{ trans('flexi.add_by') }}</th> --}}
                <th>{{ trans('flexi.phone') }}</th>
              </tr>
            </thead>
            <tbody>
     
              @if(session()->exists('search'))
                @foreach($entry->cursor() as $r)

                  @if(!empty(session('search.subject')))
                    @include('reports.students.subject_table')
                  @else
                    @include('reports.students.default_table')
                  @endif

                @endforeach
              @endif
              {{-- @include('report.customer.text') --}}

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
