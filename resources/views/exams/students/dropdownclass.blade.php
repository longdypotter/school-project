
@hasanyrole('Admin|Developer')

        @php
        $getclass=\App\Models\AssignSubject::groupBy('class_id')->get();

        @endphp

        <label>{{trans('flexi.class')}}</label>
        <select class="form-control" name="class_id">
        <option value=" ">-</option>
        @foreach($getclass as $e)

        <option value="{{$e->class_id}}" {{ old('class_id') == $e->class_id ? 'selected' : '' }}>{{$e->class->name}}</option>

        @endforeach
        </select>

@endhasanyrole



@hasanyrole('Teacher')

        @php
        $user=\Auth::user()->userRole()->first();

        $getclass=\App\Models\AssignSubject::where('teacher_id',$user->type_id)->groupBy('class_id')->get();

        @endphp

        <label>{{trans('flexi.class')}}</label>
        <select class="form-control" name="class_id">
            <option value="">-</option>
        @foreach($getclass as $class)
            <option value="{{$class->class_id}}" {{ old('class_id') == $class->class_id ? 'selected' : '' }}>{{$class->class->name}}</option>
        @endforeach

        </select>

@endhasanyrole


