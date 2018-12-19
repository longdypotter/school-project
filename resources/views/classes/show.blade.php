@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url() }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('Information Class') }}</div>
                </div>

                <div class="box-body">
                    <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                        <table class="table-striped">
                            
                            <tr>
                                <td>Name =</td>
                                <td>{{$entry->name}}</td>
                            </tr>
                            
                            <tr>
                                <td>Section</td>
                            
                                    @foreach($entry->sections as $s)
                                       <td>{{$s->name}}</td>
                                    @endforeach
                            </tr>

                            <tr>
                                <td><a href="{{route('crud.class.edit',$entry->id)}}">Edit</a></td>
                            </tr>

                        </table>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                       
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

@endsection
