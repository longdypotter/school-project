@php
                    $findSubject = \App\Models\AssignSubject::where(function ($q) use ($r) {
                      $q->where('class_id', $r->studentsession->class_id);
                      $q->where('section_id', $r->studentsession->section_id);
                    })->first();
                  @endphp
                  @if($findSubject && optional($findSubject)->subject_id == session('search.subject'))
                  <tr>
                    <td>{{ $r->english_name }}</td>
                    <td>{{ $r->studentsession->sessions->session}}</td>
                    <td>{{ $r->studentsession->classes->name}}</td>
                    <td>{{ $r->studentsession->sections->name}}</td>
                            @php
                                $classId = $r->studentsession->class_id;
              
                                $sectionId = $r->studentsession->section_id;
                                $getStudentSession = \App\Models\StudentSession::where('class_id', $classId)->where('section_id', $sectionId)->first();

                            @endphp

                           
                            @php
                                $getSubject = \App\Models\AssignSubject::where(function ($q) use ($getStudentSession) {
                                    $q->where('class_id', $getStudentSession->class_id);
                                    $q->where('section_id', $getStudentSession->section_id);
                                    })->first();                              
                            @endphp
                          
                            <?php
                                if($getSubject==true)
                                {
                                  echo '<td>'.$getSubject->subject->name.'</td>';
                                }
                                else
                                {
                                  echo '<td>'.''.'</td>';
                                }                    
                            ?>
                           
                   
                    <td>{{$r->gender}}</td> 
                    <td>{{$r->date_of_birth->format('d/m/Y')}}</td>
                    <td>{{$r->phone}}</td>  
                  </tr>
                  @endif