                      
                      <style>
                        .title{
                            width:50px;
                        }
                        .description{
                            width:20px;
                        }

                      </style>
                      
                      
                      
                       <div class="tab-pane" id="graduatestudentfollowup">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div id="id_gradiatestudentfollowup">
                                                <table class="table">
                                                    <thead>
                                                        <th class="col-md-3">{{trans('flexi.title')}}</th>
                                                        <th class="col-md-3">{{trans('flexi.description')}}</th>
                                                        <th class="col-md-3">{{trans('flexi.quality')}}</th>
                                                        @hasanyrole('Developer|Admin')
                                                        <th class="col-md-3">{{trans('flexi.file')}}
                                                        @endhasanyrole
                                                    </thead>
                                                    <tbody> 
                                                    <tr v-for="(s,i) in followup">
                                                        <td >@{{s.title}}</td>

                                                        
                                                        <td >@{{s.description}}</td>
                                                        <td>@{{s.quality}}</td>
                                                        @hasanyrole('Developer|Admin')
                                                        <td>
                                                        <div class="btn-group" >
                                                    
                                                        <a  v-if="s.files" :href="`${url}/admin/download-file/studentfollowup/${s.id}`" class="btn btn-xs btn-default" target="_blank"  style="margin-right:5px">
                                                                <i class="fa fa-download"></i>
                                                                {{trans('flexi.download')}}
                                                        </a>
                                                       
                                                        <button class="btn btn-xs btn-default" @click.prevent="deleteFile(s.id,i)"  style="float: right;display:inline-block">
                                                                <i class="fa fa-trash"></i>
                                                                {{trans('flexi.delete')}}
                                                            </button>

                                                            </div>

                                                        </td>
                                                        @endhasanyrole

                                                    </tr>   
                                                </tbody>
                                            </table>
                  
                                             <div v-if="enableCreate">
                                                <form  method="POST" @submit.prevent="createfollowup" ref="reffollowup" enctype="multipart/form-data">
                                               
                                                    <div class="form-row">

                                                        <div class="form-group col-md-6 col-xs-4">
                                                            <label>{{trans('flexi.title')}}</label>
                                                            <input type="text" class="form-control" name="title" v-model="form.title">
                                                            <div v-if="errortitle">
                                                                <p style="color:red">@{{errors.title[0]}}</p>
                                                            </div>
                                                        </div>

                                                      
                                                         <div class="form-group col-md-6 col-xs-4">
                                                            <label for="">{{trans('flexi.quality')}}</label>
                                                            <!-- <input type="text" class="form-control" name="quality" v-model="form.quality" > -->
                                                            <select name="quality" v-model="form.quality" class="form-control">
                                                            @foreach($student_followup_types as $v)
                                                                <option value="{{$v}}">{{$v}}</option>
                                                            @endforeach
                                                        </select>
                                                            <div v-if="errorquality">
                                                                <p style="color:red">@{{errors.quality[0]}}</p>
                                                            </div>
                                                        </div>



                                                        <div class="form-group col-md-6 col-xs-4">
                                                            <label >{{trans('flexi.description')}}</label>
                                                            <textarea class="form-control" name="description" cols="30" rows="4"  v-model="form.description" wrap="hard" ></textarea>
                                                            <div v-if="errordescription">
                                                                <p style="color:red">@{{errors.description[0]}}</p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-7 col-xs-6">
                                                            <label for="inputZip">{{trans('flexi.file')}}</label>
                                                            <input type="file" class="form-control" name="files" @change="addfile" name="fake[]" ref="addFile" multiple style="display:none"><br>
                                                            <a class="btn btn-info" @click="clickFile">Choose File</a>
                                                            <br>

                                                            <div v-for="(f,i) in files">
                                                                <div class="col-md-7">@{{f.name | strLimit(25)}}</div>
                                                                <div class="col-md-3"><a class='btn btn-xs btn-danger btn-lg' @click="removImage(i)"><i class="fa fa-trash"></i></a><br></div>     
                                                            </div>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div>
                                                    &nbsp &nbsp <button type="submit" v-if="enableCreate" class="btn btn-primary"> {{trans('flexi.save')}}</button>
                                                    <a @click="cancelform" v-if="enableCreate" class="btn btn-danger"> {{trans('flexi.cancel')}}</a>
                                                    </div>
                                                    
                                                </form>                                                                                                                              
                                            </div>
                                            @hasanyrole('Developer|Admin')
                                            &nbsp &nbsp<a v-if="!enableCreate" class="btn btn-primary" @click="createfromfollowup"><i class="fa fa-plus"></i> &nbsp {{trans('flexi.add_new_document')}}</a>
                                            @endhasanyrole
                                            </div>
                                        </div>
                                    </div>
                                </div>
                         