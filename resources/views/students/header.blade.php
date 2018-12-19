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
	@endif -->
    
        <div style="margin-top:15px" class="container-fluid">
        <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="box">
                    <img  alt="user" src="{{asset($entry->profile)}}" style="width:100%;">
                        <div class="white-box">
                            
                           <div class="user-btm-box">
                               <!-- .row -->
                               <div class="row text-center m-t-10">
                                   
                                   <div class="col-md-6 b-r">
                                       <strong>{{trans('flexi.name')}}</strong>
                                       <p>{{$entry->english_name}}</p>
                                   </div>

                                   <div class="col-md-6"><strong>{{trans('flexi.phone')}}</strong>
                                       <p>{{$entry->phone}}</p>
                                   </div>
                               </div>
                               <!-- /.row -->
                               
                               <!-- .row -->
                               <!-- /.row -->
                               <hr>
                               <!-- .row -->
                               <div class="row text-center m-t-12">
                                   <div class="col-md-12"><strong>{{trans('flexi.email')}}</strong>
                                       <p>{{$entry->email}}</p>
                                   </div>
                                  
                               </div>
                               <!-- /.row -->
                             

                                 <hr>
                                 <div class="row text-center m-t-10">
                                   <div class="col-md-4 b-r"><strong>{{trans('flexi.session')}}</strong>
                                       <p>{{optional($entry->studentsession->sessions)->session}}</p>
                                   </div>
                                   <div class="col-md-4  b-r"><strong>{{trans('flexi.class')}}</strong>
                                       <p>{{optional($entry->studentsession->classes)->name}}</p>
                                   </div>
                                   <div class="col-md-4"><strong>{{trans('flexi.section')}}</strong>
                                       <p>{{optional($entry->studentsession->sections)->name}}</p>
                                    
                                    </div>
                               <!-- .row -->
                                    <br>
                               <hr>
                                <hr>

                                <div class="row text-center col-md-12 col-xs-12">
                                   <div class="col-md-12"><strong>{{trans('flexi.address')}}</strong>
                                       <p >#{{$entry->house_no}}, St:{{$entry->street_no}}, {{optional($entry->addressFull)->getFullAddressAttribute()}}</p>
                                   </div>
                               </div>
                             
                               </div>
                        </div>
                    </div>
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
                                    <a href="#" data-target="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">{{trans('flexi.family')}}</span> </a>
                                </li>
                              
                                <li class="tab">
                                    <a href="#" data-target="#health" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa  fa-medkit"></i></span> <span class="hidden-xs">{{trans('flexi.health')}}</span> </a>
                                </li>
                               
                                 <li class="tab">
                                    <a href="#" data-target="#class" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">{{trans('flexi.class')}}</span> </a>
                                </li>
                                
                                <li class="tab">
                                    <a href="#" data-target="#testresult" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa  fa-sticky-note-o"></i></span> <span class="hidden-xs">{{trans('flexi.pre_test_result')}}</span> </a>
                                </li>

                                <li class="tab">
                                    <a href="#" data-target="#criminal" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-child"></i></span> <span class="hidden-xs">{{trans('flexi.criminal')}}</span> </a>
                                </li>

                                <li class="tab">
                                    <a href="#" data-target="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa  fa-sticky-note-o"></i></span> <span class="hidden-xs">{{trans('flexi.document')}}</span> </a>
                                </li>

                                <li class="tab">
                                    <a href="#" data-target="#followup" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-ol"></i></span> <span class="hidden-xs">{{trans('flexi.followup')}}</span> </a>
                                </li>

                                 <li class="tab">
                                    <a href="#" data-target="#graduatestudentfollowup" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-ol"></i></span> <span class="hidden-xs">{{trans('flexi.graduate_student_followup')}}</span> </a>
                                </li>             
                             
                                
                            </ul>
                           