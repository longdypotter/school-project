
@if(isset($entry) && !empty($entry->attendent_date))
    {{date('d-m-Y', strtotime($entry->attendent_date))}}
@endif