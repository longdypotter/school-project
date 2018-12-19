<!-- text input -->
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

        <input
            type="text"
            name="{{ $field['name'] }}"
            value="{{ isset($entry) ? optional($entry->students)->english_name: '' }}"
            @include('crud::inc.field_attributes')
        >
      
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
   