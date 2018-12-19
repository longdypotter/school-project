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
    padding: 15px !important;
    position: relative;
   
}
.row {
    margin-right: -15px;
    margin-left: -15px;
}

.pull-right {
    margin-right: 3px !important;
}
.box
{
    margin:10px;
}
.box-body
{
    overflow:auto !important;
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
	    <li><a href="{{  backpack_url('studentexam') }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
    <br>
    <!-- <div class="col-md-4"> -->
  
     <a href="{{route('crud.studentexam.index')}}" class="hidden-print"><i class="fa fa-angle-double-left"></i> Back to all  <span>StudentExam</span></a>
    <!-- </div> -->
    <br>
	</section>
@endsection
@include('inc.select2')

@section('content')
<!-- Default box -->
  <div class="row">
    <!-- THE ACTUAL CONTENT -->
    <div class="col-md-12">
      <div class="box">
        <div class="box-header hidden-print with-border row">


        <div id="studentexam">
   
                <form action="{{route('searchable')}}" method="post">
                    @csrf
        
                <div class="form-group col-xs-12 col-sm-6 col-md-4 ">
                <label>{{trans('flexi.name')}}</label>
                <select name="exam_id" class="form-control col-md-4" @change="nametoexamdate">
                        <option value="-">-</option>
                        @foreach($examname as $e)
                        <option  value="{{$e}}" >{{$e}}</option>
                        @endforeach
                </select>
                </div>
                <div class="form-group col-xs-12 col-sm-6 col-md-4 ">
                <label>{{trans('flexi.exam_date')}}</label>
                <select id="exam_date" name="exam_date" class="form-control col-md-4" @change="examdatetoclass">
                        <option value="-">-</option>
                        <option v-for="examdate in nametoexam_date" :value="examdate"  >@{{examdate}}</option>
                </select>
                </div>

                <div class="form-group col-xs-12 col-sm-6 col-md-4 ">
                <label>{{trans('flexi.class')}}</label>
                <select name="class" @change="classchange"  class="form-control col-md-4" >
                        <option value="-">-</option>
                        <option v-for="e in exam_datetoclass" :value="e.id">@{{e.name}}</option>
                </select>
                </div>
            
                <div  class="form-group col-xs-12 col-sm-6 col-md-4 ">
                <label>{{trans('flexi.section')}}</label>
                <select  name="section" class="form-control col-md-4"  @change="sectionchange" >
                        <option value="-">-</option>
                            <option  v-for="s in classtosection" :value="s.id">@{{s.name}}</option>  
                        </select>
                </div>
           
            
                <div class="form-group col-xs-12 col-sm-6 col-md-4 "> 
                <label>{{trans('flexi.subject')}}</label>
                <select id="subject" name="subject"  class="form-control col-md-4">
                        <option value="-">-</option>
                        <option v-for="sc in classsectiontosubject" :value= "sc.id" >@{{sc.name}}</option>
                                
                </select>
                </div>
                    

                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>{{ trans('flexi.search') }}</button>
                </div>

          </form>

          </div>
    

      <div class="box-body">
          <table id="datatable" class="table  table-hover display nowrap" style="width: 100% !important">
     
              <tr>
            
                <th>{{ trans('flexi.name') }}</th>
                <th>{{ trans('flexi.exam_date') }}</th>
                <th>{{ trans('flexi.teacher') }}</th>
                <th>{{ trans('flexi.student') }}</th>
                <th>{{ trans('flexi.class') }}</th>
                <th>{{ trans('flexi.section') }}</th>
                <th>{{ trans('flexi.subject') }}</th>
                <th>{{ trans('flexi.mark') }}</th>

              </tr>
         
            <tbody>
            
            @if(session()->exists('search'))
      

            <form action="{{route('crud.studentexam.store')}}" method="post">
            @csrf
            <div class="mailbox-controls">
                    <span class="button-checkbox">
                    <div class="pull-right">
                
                    <button type="submit" name="search" value="saveattendence" class="btn btn-primary btn-sm pull-right checkbox-toggle"><i class="fa fa-save"></i> {{trans('flexi.save_student_exam')}} </button></div>
                    </div>
                </div>

     
            @foreach($entry as $r) 

                @php
                    $classId = $r->assignsubject->class_id;
                    $sectionId = $r->assignsubject->section_id;
                    $getAssignSubject = \App\Models\AssignSubject::where('class_id', $classId)->where('section_id', $sectionId)->first();

                @endphp
                @php
                    $getStudent = \App\Models\StudentSession::where(function ($q) use ($getAssignSubject) {
                        $q->where('class_id', $getAssignSubject->class_id);
                        $q->where('section_id', $getAssignSubject->section_id);
                        })->get();                              
                @endphp
                
                
                @foreach($getStudent as $s)

                    <tr>
                    <td>{{$r->name}}</td>
                    <td>{{$r->exam_date}}</td>
                    <td>{{$r->teacher->name}}</td>
                    <td>{{$s->students->english_name}} </td>
                    <td>{{$r->assignsubject->class->name}} </td>
                    <td>{{$r->assignsubject->section->name}} </td>
                    <td>{{$r->assignsubject->subject->name}} </td>
                    <td><input type="text" name="mark[]"></td>
                    <td><input type="hidden" name="student_id[]" value="{{$s->student_id}}"></td>
                    <td><input type="hidden" name="exam_id" value="{{$r->id}}"></td>
                    <td><input type="hidden" name="user_id" value="{{Auth::user()->id}}"></td>
                    </tr>

                @endforeach
                    
                   
              
        @endforeach
            
        </form>
      
        @endif
        
        </div>
        </tbody>
        </table>
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
    <script>
            var exam= new Vue({
                el:'#studentexam',
                data:function(){
                    return{

                        class_id: '',
                        name:'',
                        exam_date:'',
                        nametoexam_date:[],
                        exam_datetoclass:[],
                        classtosection:[],
                        classsectiontosubject:[],
                        btnDisable: true,
                    }
                },
                methods:{
                    nametoexamdate:function(e){
                        this.nametoexam_date=[];
                        this.exam_datetoclass=[];
                        this.classtosection=[];
                        this.classsectiontosubject=[];
                        this.name=e.target.value;
                        axios.get('{{ route('get.nametoexamdate') }}?name=' + e.target.value)
                        .then(res=>{
                            console.log(res.data);
                            this.nametoexam_date=res.data;
                            
                            console.log(res.data);
                        })
                        .catch(e=>{
                            console.log('error');
                        });
                    },

                    examdatetoclass:function(e){
                        // console.log('hi');
                        this.exam_datetoclass=[];
                        this.classtosection=[];
                        this.classsectiontosubject=[];
                        this.exam_date=e.target.value;
                        axios.get('{{route('get.examdatetoclass') }}?examdate=' + e.target.value  + '&name=' + this.name)
                        .then(res=>{
                            console.log(res.data);
                            this.exam_datetoclass=res.data;
                        })
                        .catch(e=>{

                        });
                    },
                    classchange:function(e){
                        //console.log(e.target.value);
                        this.classtosection=[];
                        this.classsectiontosubject=[];
                        this.class_id = e.target.value;
                       
                         axios.get('{{url('/')}}/api/studentexam?class='+e.target.value + '&name=' + this.name + '&exam_date=' + this.exam_date)
                         .then(res=>{

                             //  console.log(res.data);
                     
                               this.classtosection=res.data;
                             
                               console.log(this.classtosection);
                              
                         })
                         .catch(e=>{
                             console.log('error');
                         });
                    },
                    sectionchange:function(e)
                    {
                        this.classsectiontosubject=[];
                        this.section_id=e.target.value;
                        axios.get('{{ route('get.section') }}?section_id=' + e.target.value + '&class_id=' + this.class_id)
                        .then(res=>{
                            this.classsectiontosubject=res.data;
                            console.log(this.classsectiontosubject);
                        })
                        .catch(e=>{
                            console.log('error');
                        });
                    }
                },
            });


    </script>

@endsection