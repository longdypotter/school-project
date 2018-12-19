<style>

    .dataTables_filter { margin-right: 10px !important;
                               margin-top: 10px !important;}
</style>
@section('after_styles')
<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css"> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css"> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"> --}}


{{-- <link rel="stylesheet" href="{{ asset('js/table/table.css') }}"> --}}

{{-- <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}"> --}}

<!-- CRUD LIST CONTENT - crud_list_styles stack -->
@stack('crud_list_styles')
@endsection

@push('after_scripts')
{{-- <script src="{{ asset('js/table/bootstrap-table.js') }}"></script> --}}

<script>
  var table = $('#datatable').DataTable({
    // fixedHeader: true,
    // processing: true,
    // serverSide: true,
    // scrollY: '50vh',
    scrollX: true,
    paging: false,
    searching: true,
    ordering: false,
    // responsive: false,
    info: false,
    language: {
      emptyTable: '{{ trans('flexi.empty') }}'
    },
    // dom: 'Bfrtip',
    //   buttons: [
    //     'copy',
    //     'csv',
    //     'excel',
    //     // 'pdf',
    //     'print'
    // ]
  });
  </script>

@endpush
@section('after_scripts')
{{-- @include('crud::inc.datatables_logic') --}}

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
{{-- <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script> --}}

{{-- <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script> --}}

{{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script> --}}

{{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> --}}

<!-- CRUD LIST CONTENT - crud_list_scripts stack -->
@stack('crud_list_scripts')
@endsection