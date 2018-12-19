                                <!-- .tabs 1 -->
                                <div class="tab-pane active" id="home">
                                    <div class="steamline">
                                        <div class="sl-item">
                                        <table class="table">
                                            <thead>
                                                <td class="col-md-4"><b>{{trans('flexi.khmer_name')}}</td>
                                                <td class="col-md-11">{{$entry->khmer_name}}</td>
                                                
                                            </thead>
                                                <tbody>
                                                       
                                                        <tr>
                                                            <td class="text-bold">{{trans('flexi.gender')}}</td>
                                                            <td>{{$entry->gender}}</td>
                                                        </tr>

                                                            <tr>
                                                            <td class="text-bold">{{trans('flexi.ethnicity')}}</td>
                                                            <td>{{$entry->ethnicity}}</td>
                                                        </tr>
                                                            <tr>
                                                            <td class="text-bold">{{trans('flexi.nationality')}}</td>
                                                            <td>{{$entry->nationality}}</td>
                                                        </tr>
                                                        </tr>
                                                            <tr>
                                                            <td class="text-bold">{{trans('flexi.date_of_birth')}}</td>
                                                            <td>{{$entry->date_of_birth_fm}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold">{{trans('flexi.place_of_birth')}}</td>
                                                            <td> {{$entry->place_of_birth}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-bold">{{trans('flexi.status')}}</td>
                                                            <td>{{$entry->status}}</td>
                                                        </tr>

                                                        </tr>

                                                    </tr>
                                                        <tr>
                                                        <td class="text-bold">{{trans('flexi.occupation')}}</td>
                                                        <td>{{$entry->occupation}}</td>
                                                    </tr>
                                                    </tr>
                                                        <tr>
                                                        <td class="text-bold">{{trans('flexi.education')}}</td>
                                                        <td>{{$entry->education}}</td>
                                                    </tr>

                                        
                                                    <!-- <tr>
                                                        <td class="text-bold">{{trans('flexi.phone')}}</td>
                                                        <td>{{$entry->phone}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-bold">{{trans('flexi.email')}}</td>
                                                        <td>{{$entry->email}}</td>
                                                    </tr> -->
                                                    <tr>
                                                        <td class="text-bold">{{trans('flexi.health')}}</td>
                                                        <td>{{$entry->health}}</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="text-bold">{{trans('flexi.student_status')}}</td>
                                                        <td>{{$entry->student_status}}</td>
                                                    </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tabs1 -->
                                
                                <!-- .tabs2 -->
                                <div class="tab-pane" id="profile">
                                <div class="steamline">
                                        <div class="sl-item">
                                        <table class="table">
                                            <thead> 
                                                    <td class="col-md-4"><b>{{trans('flexi.father_name')}}</td>
                                                    <td class="col-md-11">{{$entry->father_name}}</td>
                                            </thead>
                                                <tbody>
                                               
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.father_occupation')}}</td>
                                                    <td>{{$entry->father_occupation}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.father_phone')}}</td>
                                                    <td>{{$entry->father_phone}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.mother_name')}}</td>
                                                    <td>{{$entry->mother_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.mother_occupation')}}</td>
                                                    <td>{{$entry->mother_occupation}}</td>
                                                </tr>
                                              
                                               
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.mother_phone')}}</td>
                                                    <td>{{$entry->mather_phone}}</td>
                                                </tr>

                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.address')}}</td>
                                                    <td>#{{$entry->parent_house_no}}, St: {{$entry->parent_street_no}}, {{optional($entry->parentaddressFull)->getFullAddressAttribute()}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.guardian_name')}}</td>
                                                    <td>{{$entry->guardian_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.guardian_occupation')}}</td>
                                                    <td>{{$entry->guardian_occupation}}</td>
                                                </tr>
                                               
                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.guardian_phone')}}</td>
                                                    <td>{{$entry->guardian_phone}}</td>
                                                </tr>

                                                <tr>
                                                    <td class="text-bold">{{trans('flexi.address')}}</td>
                                                    <td>#{{$entry->guardian_house_no}}, St: {{$entry->guardian_street_no}}, {{optional($entry->guardianaddressFull)->getFullAddressAttribute()}}</td>
                                                </tr>
                                                
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                       
                                </div>
                                <!-- /.tabs2 -->

                                