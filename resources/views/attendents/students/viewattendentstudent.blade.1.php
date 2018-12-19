@extends('backpack::layout')

<style>
    .spacer
    {
        padding-top:30px;
    }
</style>

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('Attendent Student') }}<small>{{ trans('Attendent Students in the database') }}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ backpack_url('attendentstudent') }}">{{ trans('flexi.attendent_student')}}</a></li>
        <li class="active">{{ trans('flexi.list') }}</li>
      </ol>
      <br>
      <!-- <div class="col-md-4"> -->
  
     <a href="{{route('crud.attendentstudent.index')}}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all  <span>Attachments</span></a>
    <!-- </div> -->
    </section>


    









    
@endsection



@section('content')



    skfskjf




<br>
<br>
<div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
     
            <table class="table table-striped">
                <thead>
                    <tr>
                    <th>{{trans('flexi.teacher')}}</th>
                    <th scope="col">{{trans('flexi.name')}}</th>
                    <th scope="col">{{trans('flexi.session')}}</th>
                    <th scope="col">{{trans('flexi.class')}}</th>
                    <th scope="col">{{trans('flexi.section')}}</th>
                    <th scope="col">{{trans('flexi.subject')}}</th>
                    <th scope="col">{{trans('flexi.gender')}}</th>
                    <th scope="col">{{trans('flexi.phone')}}</th>
                    <th scope="col">{{trans('flexi.status')}}</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($attendentdate as $att)
                    <tr>
                    <td>{{$att->assignsubject->teacher->name}}</td>
                    <td scope="row">{{$att->student->english_name}}</td>
                    <td>{{$att->studentsessions->sessions->session}}</td>
                    <td>{{$att->studentsessions->classes->name}}</td>
                    <td>{{$att->studentsessions->sections->name}}</td>
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
                    <td>{{$getSubject->subject->name}}</td>
                    <td>{{$att->student->gender}}</td>
                    <td>{{$att->student->phone}}</td>
                    <td>{{$att->status}}</td>
                    </tr>
                    @endforeach
                    
                
                </tbody>
                </table>
            </div>
        </div>
    
</div>
@endsection
