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
	@if ($crud->hasAccess('list'))
		<a href="{{ url($crud->route) }}" class="hidden-print"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
	@endif

	<!-- Default box -->
	  <div class="box">
	    <div class="box-header with-border">
	    	<span class="pull-right m-l-20 m-r-20 m-t-5"><a href="javascript: window.print();"><i class="fa fa-print"></i></a></span>

          @if ($crud->model->translationEnabled())
			    	<!-- Single button -->
					<div class="btn-group pull-right">
					  <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
					  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
						  	<li><a href="{{ url($crud->route.'/'.$entry->getKey()) }}?locale={{ $key }}">{{ $locale }}</a></li>
					  	@endforeach
					  </ul>
					</div>
					<h3 class="box-title" style="line-height: 30px;">{{ trans('backpack::crud.preview') .' '. $crud->entity_name }}</h3>
				@else
					<h3 class="box-title">{{ trans('backpack::crud.preview') .' '. $crud->entity_name }}</h3>
				@endif
	    </div>
	    <div class="box-body no-padding">
            <div class="container" style="width:600px;margin-top:10px;">
                <div class="card-deck">
                    <div class="card text-center">
                        <center>
                            <div class="card-body">
                                <table style="margin-top:20px">
                                    <tr>
                                        <th style="font-size:26px">{{trans('flexi.name')}} </th>
                                        <th style="font-size:26px; padding-left:10px"> : </th>
                                        <td style="font-size:24px; padding-left:170px">{{$entry->name}}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-size:26px">{{trans('flexi.document_type')}} </th>
                                        <th style="font-size:26px; padding-left:10px"> : </th>
                                        <td style="font-size:24px; padding-left:170px">{{$entry->document_type_id}}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-size:26px">{{trans('flexi.public_date')}} </th>
                                        <th style="font-size:26px; padding-left:10px"> : </th>
                                        <td style="font-size:24px; padding-left:170px">{{$entry->public_date}}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-size:26px">{{trans('flexi.class')}} </th>
                                        <th style="font-size:26px; padding-left:10px"> : </th>
                                        <td style="font-size:24px; padding-left:170px">{{$entry->class_id}}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-size:26px">{{trans('flexi.section')}} </th>
                                        <th style="font-size:26px; padding-left:10px"> : </th>
                                        <td style="font-size:24px; padding-left:170px">{{$entry->section_id}}</td>
                                    </tr>
                                  {{--  <tr>
                                        <th style="font-size:26px">{{trans('flexi.address')}} </th>
                                        <th style="font-size:26px; padding-left:10px"> : </th>
                                        <td style="font-size:24px; padding-left:40px">{{$entry->addressFull->_path_en}}</td>
                                    </tr>
                                    <tr>
                                        <th style="font-size:26px">{{trans('flexi.phone')}} </th>
                                        <th style="font-size:26px; padding-left:10px"> : </th>
                                        <td style="font-size:24px; padding-left:170px">{{$entry->phone}}</td>
                                    </tr> --}}
                                </table>
                            </div>
                            <hr>
                            <h3>{{trans('flexi.File_Document')}}</h3>
                            <hr>
                            @if(isset($entry) && count($entry->file) > 0 )
                               
                                        <a href="{{route('download.index',base64_encode($entry->file))}}" target="_blank">
                                        <img src="{{ asset('storage/'.$entry->file) }}"
                                        style="width:120px;height:120px;"></a>
                          
                            @endif
                        </center>
                    </div>
                </div>
            </div>
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
@endsection
