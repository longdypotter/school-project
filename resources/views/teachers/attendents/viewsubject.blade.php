@foreach($entry->teacher->hasAssignsubjects as $t)
           {{$t->subject->name}}<br>
@endforeach