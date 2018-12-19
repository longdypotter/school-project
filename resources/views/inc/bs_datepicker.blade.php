

@push('after_styles')

  <link rel="stylesheet" href="{{ asset('vendor/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.42/css/bootstrap-datetimepicker.min.css" />

@endpush

@push('after_scripts')

  <script src="{{ asset('vendor/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('vendor/adminlte/bower_components/moment/moment.js') }}"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.datetimepicker/4.17.42/js/bootstrap-datetimepicker.min.js"></script>
@endpush