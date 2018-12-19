@include('inc.select2')
@hasanyrole('Admin|Developer')
@php
$getsubject=\App\Models\AssignSubject::groupBy('subject_id')->get();

@endphp

<label>{{trans('flexi.subject')}}</label>
<select class="form-control" name="subject_id">
<option value=" ">-</option>
@foreach($getsubject as $e)

<option value="{{$e->subject_id}}" {{ old('subject_id') == $e->subject_id ? 'selected' : '' }}>{{$e->subject->name}}</option>

@endforeach
</select>
@endhasanyrole


@hasanyrole('Teacher')
@php
$user=\Auth::user()->userRole()->first();

$getsubject=\App\Models\AssignSubject::where('teacher_id',$user->type_id)->groupBy('subject_id')->get();

@endphp

<label>{{trans('flexi.subject')}}</label>
<select class="form-control" name="subject_id">
    <option value="">-</option>
@foreach($getsubject as $subject)
    <option value="{{$subject->subject_id}}" {{ old('subject_id') == $subject->subject_id ? 'selected' : '' }}>{{$subject->subject->name}}</option>
@endforeach

</select>
@endhasanyrole