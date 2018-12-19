
<div class="form-group col-xs-12 col-sm-6 col-md-4">
        <label for="">{{trans('flexi.student')}}</label>
        <select class="form-control select2_ajax_element" name="student_id">
        @if(session('search.student_id') != '')
            @php $is_student = \App\Models\Student::find(session('search.student_id')); @endphp
            <option value="{{ $is_student->id }}" selected>{{ $is_student->english_name }}</option>
          @endif
        </select>
      </div>
@push('after_scripts')
<script>

  $('.select2_ajax_element').select2({
    theme: 'bootstrap',
    allowClear: true,
    // multiple: true,
    placeholder: "",
    minimumInputLength: "1",
    ajax: {
      url: "{{route('api.student')}}",
      dataType: 'json',
      uietMillis: 250,
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page
        };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        return {
          results: $.map(data.data, function (item) {
            return {
              text: item["english_name"],
              id: item["id"]
            }
          }),
          more: data.current_page < data.last_page
        };
      },
      cache: true
    },
  });

</script>
@endpush