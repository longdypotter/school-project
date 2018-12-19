<div class="{{ $wrapperClass ?? 'form-group col-xs-12 col-sm-6 col-md-4' }}">
  <label for="">{{ trans('flexi.'.$name) }}</label>
  <input type="text" class="form-control" name="{{ $name }}" value="{{session('search.'.$name) }}" autocomplete="{{ isset($autocomplete) ? 'on' : 'off' }}">
</div>