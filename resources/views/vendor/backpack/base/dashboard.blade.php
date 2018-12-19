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
  
  
    @hasanyrole('Teacher|Developer|Admin')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$student}}</h3>
              <p>{{trans('flexi.student')}}</p>
            </div>
            <div class="icon">
            <i class="fa fa-user"></i>
            </div>
            <a href="{{route('crud.student.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      @endhasanyrole

      @hasanyrole('Developer|Admin')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$graduatestudent}}</h3>
              <p>{{trans('flexi.graduate_student')}}</p>
            </div>
            <div class="icon">
            <i class="fa fa-graduation-cap"></i>
            </div>
            <a href="{{route('crud.graduatestudent.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      @endhasanyrole

        
        @hasanyrole('Developer|Admin')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$teacher}}</h3>
              <p>{{trans('flexi.teacher')}}</p>
            </div>
            <div class="icon">
            <i class="fa fa-user-md"></i>
            </div>
            <a href="{{route('crud.teacher.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      @endhasanyrole

      @hasanyrole('Developer|Admin')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$classes}}</h3>
              <p>{{trans('flexi.class')}}</p>
            </div>
            <div class="icon">
              <i class="fa fa-home"></i>
            </div>
            <a href="{{route('crud.class.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endhasanyrole

  @hasanyrole('Developer|Admin')

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$subject}}</h3>
              <p>{{trans('flexi.subject')}}</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="{{route('crud.subject.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

  @endhasanyrole

        @hasanyrole('Developer|Admin')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$section}}</h3>
              <p>{{trans('flexi.section')}}</p>
            </div>
            <div class="icon">
              <i class="fa fa-clock-o"></i>
            </div>
            <a href="{{route('crud.section.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        @endhasanyrole

</div>
@endsection
