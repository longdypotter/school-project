
@section('after_styles')
<!-- DATA TABLES -->
<link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css"> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">


{{-- <link rel="stylesheet" href="{{ asset('js/table/table.css') }}"> --}}

{{-- <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}"> --}}

<!-- CRUD LIST CONTENT - crud_list_styles stack -->
<style>
.dt-buttons {
  padding: 0 15px;
  width: 100%;
  text-align: right;
}
.dt-buttons .dt-button {
  padding: 6px 15px;
  background: #605ca8 !important;
  color: #fff;
}
@media print {
    h1 {
        font-size: 25pt;
        margin-left:5px;
    }
}

.dt-buttons .dt-button:hover {background: #4e48b5 !important;}
.dt-buttons .dt-button.buttons-columnVisibility.active{ background: #0d0a3e !important;}
.dt-buttons .dt-button.buttons-columnVisibility{padding: 0 15px;}

</style>
@stack('crud_list_styles')
@endsection

@push('after_scripts')
{{-- <script src="{{ asset('js/table/bootstrap-table.js') }}"></script> --}}

<script>

  var table = $('#datatable').DataTable({
    fixedHeader: true,
    // processing: true,
    // serverSide: true,
    // scrollY: '50vh',
 
    scrollX: true,
    paging: false,
    searching: false,
    ordering: false,
    // responsive: false,
    info: false,
    language: {
      emptyTable: '{{ trans('flexi.empty') }}'
    },
    dom: 'Bfrtip',
      buttons: [
        // 'copy',
        // {
        //   extend: 'copy',
        //   exportOptions: { columns: ':visible' }
        // },
        // 'csv',
        // {
        //   extend: 'csv',
        //   exportOptions: { columns: ':visible' }
        // },
        // 'excel',
        // {
        //   extend: 'excel',
        //   exportOptions: { columns: ':visible' }
        // },
        // 'pdf',
        // {
        //   extend: 'pdf',
        //   exportOptions: { columns: ':visible' }
        // },
        // 'print',
        {
          extend: 'print',
          text:      '<i class="fa fa-print"></i>{{trans('flexi.print')}}',
          exportOptions: { columns: ':visible' },
          customize: function ( win ) {
                    $(win.document.body).find('table')
                        .css( 'font-size', '10pt' )
                        .before(
                          
                '<div class="row">'+
             
                '<div class="col-md-12" style="padding-left:10px;">'+

                    '<div  class="col-xs-4 col-sm-4 col-md-2 font">'+
                        '<b>'+'{{trans('flexi.name')}}:</b>&nbsp&nbsp<span ><?php if($getstudent) echo $getstudent->exam->name ?></span><br>'+
                        '<b>'+'{{trans('flexi.exam_date')}}:</b>&nbsp&nbsp<span ><?php if($getstudent) echo date('d-m-Y', strtotime($getstudent->exam->exam_date)) ?></span><br>'+
                        '<b>'+'{{trans('flexi.teacher')}}:</b>&nbsp&nbsp<span ><?php if($getstudent) echo $getstudent->exam->teacher->name ?></span><br>'+
                    '</div>'+
                    
                    '<div  class="col-xs-6 col-sm-4 col-md-4 font">'+
                        '<b>'+'{{trans('flexi.class')}}:</b>&nbsp&nbsp<span ><?php if($getstudent) echo $getstudent->exam->assignsubject->class->name ?></span><br>'+
                        '<b>'+'{{trans('flexi.section')}}:</b>&nbsp&nbsp<span ><?php if($getstudent) echo $getstudent->exam->assignsubject->section->name ?></span><br>'+
                        '<b>'+'{{trans('flexi.subject')}}:</b>&nbsp&nbsp<span ><?php if($getstudent) echo $getstudent->exam->assignsubject->subject->name ?></span><br>'+
                    '</div>'+

                '</div>'+
                '</div>'
                           
                        );
 
                    // $(win.document.body).find( 'table' )
                    //     .addClass( 'compact' )
                    //     .css( 'font-size', 'inherit' );
                }
        },
        //'colvis'
    ],
        // columnDefs: [ {
        //     targets: -1,
        //     visible: false
        // } ]
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

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>

{{-- <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!--Excel-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> <!--PDF-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script> <!--colvis-->

<!-- CRUD LIST CONTENT - crud_list_scripts stack -->
@stack('crud_list_scripts')
@endsection