
@hasanyrole('Admin|Developer')
@php
$entry=\App\Models\AssignSubject::groupBy('teacher_id')->get();

@endphp

<label>Teacher</label>
<select class="form-control" name="teacher_id">
<option value=" ">-</option>
@foreach($entry as $e)

<option value="{{$e->teacher_id}}" {{ old('teacher_id') == $e->teacher_id ? 'selected' : '' }}>{{$e->teacher->name}}</option>

@endforeach
</select>
@endhasanyrole



@hasanyrole('Teacher')
@php
$user=\Auth::user()->userRole()->first();

$entry=\App\Models\AssignSubject::where('teacher_id',$user->type_id)->groupBy('teacher_id')->get();

@endphp

<label>{{trans('flexi.teacher')}}</label>
<select class="form-control" name="teacher_id">

@foreach($entry as $teacher)

<option value="{{$teacher->teacher_id}}" {{ old('teacher_id') == $teacher->teacher_id ? 'selected' : '' }}>{{$teacher->teacher->name}}</option>

@endforeach
</select>
@endhasanyrole