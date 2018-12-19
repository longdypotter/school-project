<label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

        <input
            type="text"
            name="{{ $field['name'] }}"
            value="{{ isset($entry->sessions) ? optional($entry->sessions)->session: '' }}"
            @include('crud::inc.field_attributes')
        >
      
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif