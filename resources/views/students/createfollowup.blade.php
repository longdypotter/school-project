            <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
                                 <!-- .tabs4 -->
                                 <div class="tab-pane" id="followup">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div id="id_followup">
                                        
                                                <table class="table">
                                                    <thead>
                                                        <th class="col-md-3">{{trans('flexi.title')}}</th>
                                                        <th class="col-md-3">{{trans('flexi.type')}}</th>
                                                        <th class="col-md-3">{{trans('flexi.date')}}</th>
                                                        <th class="col-md-3">{{trans('flexi.description')}}</th>
                                                        @hasanyrole('Developer|Admin')
                                                        <th class="col-md-3">{{trans('flexi.file')}}
                                                        @endhasanyrole
                                                    
                                                    </thead>
                                                    <tbody> 
                                                    <tr v-for="(f,i) in followup">
                                                        <td>@{{f.title}}</td>
                                                        <td>@{{f.type}}</td>
                                                        <td>@{{f.date}}</td>
                                                        <td>@{{f.description}}</td>
                                                        @hasanyrole('Developer|Admin')
                                                        <td>                                                       
                                                            <div class="btn-group" >

                                                            <a v-if="f.files" :href="`${url}/admin/download-file/followup/${f.id}`" class="btn btn-xs btn-default" style="margin-right:5px" target="_blank" >
                                                                <i class="fa fa-download"></i>
                                                                {{trans('flexi.download')}}
                                                            </a>

                                                            <button class="btn btn-xs btn-default" @click.prevent="deleteFile(f.id,i)">
                                                                <i class="fa fa-trash" ></i>
                                                                {{trans('flexi.delete')}}
                                                            </button>
                                                              </div>                                              
                                                        </td>
                                                        @endhasanyrole

                                                    </tr>
                                                    </tbody>
                                            </table>
                  
                                            <div v-if="enableCreate">
                                                <form  method="POST"  @submit.prevent="createfollowup" ref="reffollowup" enctype="multipart/form-data">
                                               
                                                    <div class="form-row">
                                                    
                                                        <div class="form-group col-md-6 col-xs-4">
                                                            <label for="inputCity">{{trans('flexi.title')}}</label>
                                                            <input type="text" class="form-control" name="title" v-model="form.name" >
                                                            <div v-if="errortitle">
                                                                <div style="color:red">@{{errors.title[0]}}</div>
                                                            </div>
                                                            
                                                    </div>
                                                        <?php
                                                        $followup_types=\App\Models\FollowupType::pluck('name','id');
                                                        ?>
                                                        <div class="form-group col-md-6 col-xs-4">
                                                            <label for="inputCity">{{trans('flexi.type')}}</label>
                                                            <select name="type" v-model="form.type" class="form-control">
                                                            @foreach($followup_types as $v)
                                                                <option value="{{$v}}">{{$v}}</option>
                                                            @endforeach
                                                            </select>
                                                            <div v-if="errortype">
                                                                <div style="color:red">@{{errors.type[0]}}</div>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="form-group col-md-6 col-xs-4">
                                                            <label for="inputCity">{{trans('flexi.date')}}</label>
                                                            <input type="date" name="date" v-model='myDate' class="form-control" readonly>
                                                            
                                                        </div>

                                                        <div class="form-group col-md-12 col-xs-4">
                                                            <label for="">{{trans('flexi.description')}}</label>
                                                            <!-- <input type="text"  class="form-control" name="description" v-model="form.description"> -->
                                                            <textarea name="description" id="" cols="30" rows="4" v-model="form.description"  class="form-control" ></textarea>
                                                            <div v-if="errordes">
                                                                <div style="color:red">@{{errors.description[0]}}</div>
                                                            </div>
                                                        </div>
                                                     
                                                        
                                                        <div class="form-group col-md-7 col-xs-6">
                                                            <label for="inputZip">{{trans('flexi.file')}}</label>
                                                            <input type="file" class="form-control" name="file" @change="addfile" name="fake[]" ref="addFile" multiple style="display:none"><br>
                                                            <a class="btn btn-info" @click="clickFile">Choose File</a>
                                                    
                                                            <br>
                                                            
                                                            <div v-for="(f,i) in files">
                                                                <div class="col-md-9">@{{f.name | strLimit(25)}}</div>
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
                                <!-- /.tabs4 -->