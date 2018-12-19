@foreach($entry->teacher->hasAssignsubjects as $t)
           {{$t->class->name}}<br>
@endforeach