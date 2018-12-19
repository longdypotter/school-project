
<div class="form-group col-xs-12 col-sm-6 col-md-4">
        <label for="">{{trans('flexi.teacher')}}</label>
        <select class="form-control select2_ajax_element" name="teacher_id">
        @if(session('search.teacher_id') != '')
            @php $is_teacher = \App\Models\Teacher::find(session('search.teacher_id')); @endphp
            <option value="{{ $is_teacher->id }}" selected>{{ $is_teacher->name }}</option>
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
      url: "{{route('api.teacher')}}",
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
              text: item["name"],
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