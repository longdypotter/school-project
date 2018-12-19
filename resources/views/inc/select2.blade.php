

@push('after_styles')

  <link href="{{ asset('vendor/adminlte/bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

  <style>
    .select2-container{ width: 100% !important; }
  </style>

@endpush

@push('after_scripts')

<script src="{{ asset('vendor/adminlte/bower_components/select2/dist/js/select2.min.js') }}"></script>
<script>

  $('.select2_element').select2({
    theme: "bootstrap",
    allowClear: true,
  }).on('select2:unselecting', function(e) {
    $(this).val('').trigger('change');
    e.preventDefault();
  });

</script>
@endpush