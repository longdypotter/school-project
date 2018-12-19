@include('inc.select2')
@hasanyrole('Admin|Developer')
@php
$getsection=\App\Models\AssignSubject::groupBy('section_id')->get();

@endphp

<label>{{trans('flexi.section')}}</label>
<select class="form-control" name="section_id">
<option value=" ">-</option>
@foreach($getsection as $e)

<option value="{{$e->section_id}}" {{ old('section_id') == $e->section_id ? 'selected' : '' }}>{{$e->section->name}}</option>

@endforeach
</select>
@endhasanyrole


@hasanyrole('Teacher')
@php
$user=\Auth::user()->userRole()->first();

$getsection=\App\Models\AssignSubject::where('teacher_id',$user->type_id)->groupBy('section_id')->get();

@endphp

<label>{{trans('flexi.section')}}</label>
<select class="form-control" name="section_id">
    <option value="">-</option>
@foreach($getsection as $section)
    <option value="{{$section->section_id}}" {{ old('section_id') == $section->section_id ? 'selected' : '' }}>{{$section->section->name}}</option>
@endforeach

</select>
@endhasanyrole
