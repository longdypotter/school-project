
<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->

@hasanyrole('Developer|Admin|Teacher')
<li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
@endhasanyrole

@if(Auth::user()->can('list students'))
  @hasanyrole('Student')
    <li><a href="{{ backpack_url('student') }}/{{Auth::user()->userRole()->first()->type_id }}"><i class="fa fa-user"></i> <span>{{trans('flexi.profile')}}</span></a></li>
  @else
    <li><a href="{{ backpack_url('student') }}"><i class="fa fa-user"></i> <span>{{trans('flexi.student')}}</span></a></li>
  @endhasanyrole
@endif

@if(Auth::user()->can('list studentsessions'))
<li><a href="{{ backpack_url('studentsession') }}"><i class="fa fa-calendar"></i> <span>{{trans('flexi.student_session')}}</span></a></li>
@endif

@if(Auth::user()->can('list graduatestudents'))
<li><a href="{{ backpack_url('graduatestudent') }}"><i class="fa fa-graduation-cap"></i> <span>{{ trans('flexi.graduate_student') }}</span></a></li>
@endif

@if(Auth::user()->can('list assignsubjects'))
<li><a href="{{ backpack_url('assignsubject')}}"><i class="fa fa-clipboard"></i> <span>{{trans('flexi.assign_subject')}}</span></a></li>
@endif

@if(Auth::user()->can('list subjects'))
<li><a href="{{ backpack_url('subject')}}"><i class="fa fa-book"></i> <span>{{trans('flexi.subject')}}</span></a></li>
@endif

@if(Auth::user()->can('list sessions'))
<li><a href="{{ backpack_url('session') }}"><i class="fa fa-clock-o"></i> <span>{{trans('flexi.session')}}</span></a></li>
@endif

@if(Auth::user()->can('list classes'))
<li><a href="{{ backpack_url('class') }}"><i class="fa fa-home"></i> <span>{{trans('flexi.class')}}</span></a></li>
@endif

@if(Auth::user()->can('list sections'))
<li><a href="{{ backpack_url('section') }}"><i class="fa fa-clock-o"></i> <span>{{trans('flexi.section')}}</span></a></li>
@endif

@if(Auth::user()->can('list teachers'))
  @hasanyrole('Teacher')
  <li><a href="{{ backpack_url('teacher')}}/{{Auth::user()->userRole()->first()->type_id}}"><i class="fa fa-user-md"></i> <span>{{trans('flexi.profile')}}</span></a></li>
  @else
  <li><a href="{{ backpack_url('teacher') }}"><i class="fa fa-user-md"></i> <span>{{trans('flexi.teacher')}}</span></a></li>
  @endhasanyrole
@endif

@if(Auth::user()->can('list downloadcenters'))
<li><a href="{{ backpack_url('downloadcenter') }}"><i class="fa fa-download"></i> <span>{{trans('flexi.download_center')}}</span></a></li>
@endif
<li class="treeview">
  <a href="#"><i class="fa fa-calendar-check-o"></i> <span>{{trans('flexi.attendent')}}</span> <i class="fa fa-angle-left pull-right"></i></a>

      <ul class="treeview-menu">
        @if(Auth::user()->can('list attendentstudents'))
          <li><a href="{{ backpack_url('attendentstudent') }}"><i class="fa fa-user"></i> <span>{{trans('flexi.student_attendent')}}</span></a></li>
        @endif

        {{-- @if(Auth::user()->can('list attendentstudents'))
          <li><a href="{{ backpack_url('attendentteacher') }}"><i class="fa fa-user-md"></i> <span>{{trans('flexi.teacher_attendent')}}</span></a></li>
        @endif
        --}}
      </ul>
</li>
@if(Auth::user()->can('list attachments'))
<li><a href="{{ backpack_url('attachment') }}"><i class="fa fa-paperclip"></i> <span>{{trans('flexi.attachment')}}</span></a></li>
@endif


 <li><a href="{{ backpack_url('exam') }}"><i class="fa fa-map-o"></i> <span>{{trans('flexi.exam')}}</span></a></li>

   
   

@hasanyrole('Developer|Admin')

<li class="treeview">
    <a href="#"><i class="fa fa-line-chart"></i> <span>{{trans('flexi.report')}}</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">

    </span></a></li>
    <li><a href="{{ backpack_url('report/student-info') }}"><i class="fa  fa-user"></i> <span>{{trans('flexi.reportstudent')}}</span></a></li>

    </span></a></li>
    <li><a href="{{ backpack_url('report/teacher-info') }}"><i class="fa  fa-user-md"></i> <span>{{trans('flexi.reportteacher')}}</span></a></li>
  
    </ul>
  </li>

 
<li class="treeview">
    <a href="#"><i class="fa fa-gears"></i> <span>{{trans('flexi.setting')}}</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
    <li><a href="{{ backpack_url('attachmenttype') }}"><i class="fa  fa-paperclip"></i> <span>{{trans('flexi.attachment_type')}}</span></a></li>

    <li><a href="{{ backpack_url('followuptype') }}"><i class="fa fa-list-ol"></i> <span>{{trans('flexi.followup_type')}}</span></a></li>
   
    <li><a href="{{ backpack_url('studentfollowuptype') }}"><i class="fa fa-list-ol"></i> <span>{{trans('flexi.student_followup_type')}}</span></a></li>
    <li><a href="{{ backpack_url('healthtype') }}"><i class="fa  fa-medkit"></i> <span>{{trans('flexi.health_type')}}</span></a></li>
  
      @if(Auth::user()->can('list documenttypes'))
        <li><a href="{{ backpack_url('documenttype') }}"><i class="fa  fa-file-text-o"></i> <span>{{trans('flexi.document_type')}}</span></a></li>
      @endif
      @if(Auth::user()->can('list filetypes'))
        <li><a href="{{ backpack_url('filetype') }}"><i class="fa fa-file"></i> <span>{{trans('flexi.file_type')}}</span></a></li>
      @endif

      <li>
        <a href='{{ url(config('backpack.base.route_prefix', 'admin') . '/setting') }}'>
          <i class='fa fa-cog'></i>
          <span>Settings</span>
        </a>
      </li>
    </ul>
  </li>
  
<li><a href='{{ url(config('backpack.base.route_prefix', 'admin').'/backup') }}'><i class='fa fa-hdd-o'></i> <span>Backups</span></a></li>
<li><a href='{{ url(config('backpack.base.route_prefix', 'admin').'/log') }}'><i class='fa fa-terminal'></i> <span>Logs</span></a></li>



<!-- Users, Roles Permissions -->
<li class="treeview">
    <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
      <li><a href="{{ backpack_url('user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="{{ backpack_url('role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
      <li><a href="{{ backpack_url('permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
    </ul>
  </li>
  @endhasanyrole