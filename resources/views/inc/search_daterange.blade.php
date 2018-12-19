<div class="form-group col-xs-12 col-sm-6 col-md-4">
  <label for="">{{ trans('flexi.date') }}</label>
  <div class="input-group">
    <input type="text" name="datetimes" class="form-control" id="daterange" autocomplete="off"/>
    <div class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </div>
  </div>
</div>

@push('after_styles')

<link rel="stylesheet" href="{{ asset('/vendor/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">

@endpush

@push('after_scripts')

<script src="{{ asset('/vendor/adminlte/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('/vendor/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script>
    $(function () {
      $('input[name="datetimes"]').daterangepicker({
        timePicker: false,
        autoUpdateInput: false,
        // minDate: new Date(),
        locale: {
          format: 'DD/MM/YYYY',
        }
      });

      @if(session()->exists('search') && session()->exists('search.datetimes'))
        @php $dates = explode(' - ', session('search.datetimes')); @endphp
        @if($dates[0] != '' && $dates[1] != '')
          $('#daterange').daterangepicker({ startDate: '{{ $dates[0] }}', endDate: '{{ $dates[1] }}' });
        @endif
      @endif
     
      $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
      });
  
      $('input[name="datetimes"]').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });
    });
  </script>
@endpush