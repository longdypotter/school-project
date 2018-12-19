@foreach($entry->teacher->hasAssignsubjects as $t)
           {{$t->section->name}}<br>
@endforeach