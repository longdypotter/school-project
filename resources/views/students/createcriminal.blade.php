
                                 <!-- .tabs5 -->
                                 <div class="tab-pane" id="criminal">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div id="id_criminal">
                                        
                                                <table class="table">
                                                    <thead>
                                                        <th class="col-md-5">{{trans('flexi.title')}}</th>
                                                        <th class="col-md-4">{{trans('flexi.description')}}</th>
                                                        @hasanyrole('Developer|Admin')
                                                        <th class="col-md-3">{{trans('flexi.file')}}
                                                        @endhasanyrole
                                                    </thead>
                                                    <tbody> 
                                                    <tr v-for="(s,i) in criminal">
                                                        <td>@{{s.title}}</td>

                                                        <td>@{{s.description}}</td>
                            
                                                        <td>
                                                        @hasanyrole('Developer|Admin')
                                                            <div class="btn-group" >

                                                                    <a v-if="s.file" :href="`${url}/admin/download-file/criminal/${s.id}`" class="btn btn-xs btn-default" target="_blank" style="margin-right:5px">
                                                                        <i class="fa fa-download"></i>
                                                                        {{trans('flexi.download')}}
                                                                    </a>

                                                                    <button class="btn btn-xs btn-default" @click.prevent="deleteFile(s.id,i)">
                                                                        <i class="fa fa-trash"></i>
                                                                        {{trans('flexi.delete')}}
                                                                    </button>
                                                        
                                                            </div>
                                                        @endhasanyrole

                                                            </td>


                                                        </td>
                                                    </tr>   
                                                </tbody>
                                            </table>
                  
                                             <div v-if="enableCreate">
                                                <form  method="POST"  @submit.prevent="createcriminal" ref="refcriminal" enctype="multipart/form-data">
                                               
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12 col-xs-4">
                                                            <label for="inputCity">{{trans('flexi.title')}}</label>
                                                            <input type="text" class="form-control" name="title" v-model="form.name" >
                                                            <div v-if="errortitle">
                                                                <div style="color:red">@{{errors.title[0]}}</div>
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="form-group col-md-6 col-xs-4">
                                                            <label for="">{{trans('flexi.description')}}</label>
                                                            <!-- <input type="text"  class="form-control" name="description" v-model="form.description"> -->
                                                            <textarea name="description" id="" cols="30" rows="4" v-model="form.description"  class="form-control" wrap="hard"></textarea>
                                                            <div v-if="errordescription">
                                                                <div style="color:red">@{{errors.description[0]}}</div>
                                                            </div>
                                                        </div>
                                                      

                                                        <div class="form-group col-md-7 col-xs-4">
                                                            <label for="inputZip">{{trans('flexi.file')}}</label>
                                                            <input type="file" class="form-control" name="file" @change="addfile" name="fake[]" ref="addFile" multiple style="display:none"><br>
                                                            <a class="btn btn-info" @click="clickFile">Choose File</a>
                                                            <div v-if="errorfile">
                                                                <div style="color:red" >@{{errors.file[0]}}</div>
                                                            </div>
                                                    
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
                                            &nbsp &nbsp<a v-if="!enableCreate" class="btn btn-primary" @click="createfromcriminal"><i class="fa fa-plus"></i> &nbsp {{trans('flexi.add_new_document')}}</a>
                                            @endhasanyrole
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tabs5 -->