<div class="tab-pane" id="class">
        <div class="steamline">
                <div class="sl-item">
                <table class="table">
                    <thead>
                        <th class="col-md-3">{{trans('flexi.class')}}</th>
                        <th class="col-md-3">{{trans('flexi.section')}}</th>
                        <th class="col-md-3" >{{trans('flexi.teacher')}}</th>
                        <th class="col-md-3" >{{trans('flexi.subject')}}</th>
                    </thead>
                    <tbody> 
                        <tr>
                        <td>{{optional($entry->studentsession->classes)->name}}</td>
                        <td>{{optional($entry->studentsession->sections)->name}}</td>
                        
                            @foreach($getteacher as $t)
                            <!-- <td>{{$t->class->name}}</td>
                            <td>{{$t->section->name}}</td> -->
                            <td>{{optional($t->teacher)->name}}</td>
                            <td>{{optional($t->subject)->name}}</td>
                            @endforeach

                        </tr>   
                        </tbody>
                    </table>
                </div>
        </div>
</div>
