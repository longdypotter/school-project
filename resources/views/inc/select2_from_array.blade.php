<div class="{{ $wrapperClass ?? 'form-group col-xs-12 col-sm-6 col-md-4' }}">

  <label for="">{{trans('flexi.'.$name)}}
    @if(isset($required))
      <span class="text-danger">*</span>
    @endif
  </label>

  <select class="form-control select2_element" name="{{ $name }}">

    @if(isset($placeholder))
      <option value="">{{ $placeholder != '' ? $placeholder: '-' }}</option>
    @endif

    @foreach($options as $k => $v)

      <option value="{{ $k }}" {{ $k == session('search.'.$name) ? 'selected' : '' }}>{{ $v }}</option>

     @endforeach

    </select>

</div>