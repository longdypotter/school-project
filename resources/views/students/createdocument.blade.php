
                                <!-- .tabs3 -->
                                <div class="tab-pane" id="settings">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div id="app_one">
                                        
                                                <table class="table">
                                                    <thead>
                                                        <th class="col-md-5">{{trans('flexi.name')}}</th>
                                                        <th class="col-md-4">{{trans('flexi.type')}}</th>
                                                        @hasanyrole('Developer|Admin')
                                                        <th class="col-md-3">{{trans('flexi.url')}}
                                                        @endhasanyrole
                                                    </thead>
                                                    <tbody> 
                                                    <tr v-for="(s,i) in document">
                                                        <td>@{{s.name}}</td>
                                                        <td>@{{s.type}}</td>

                                                        <td>
                                                     @hasanyrole('Developer|Admin')
                                                        <div class="btn-group" >
                                                                <a v-if="s.url" :href="`${url}/admin/download-file/document/${s.id}`" class="btn btn-xs btn-default" target="_blank"  style="margin-right:5px">
                                                                            <i class="fa fa-download"></i>
                                                                            {{trans('flexi.download')}}
                                                                    </a>

                                                                    <button class="btn btn-xs btn-default" @click.prevent="deleteFile(s.id,i)"  style="float: right;display:inline-block">
                                                                            <i class="fa fa-trash"></i>
                                                                            {{trans('flexi.delete')}}
                                                                        </button>
                                                        </div>
                                                    @endhasanyrole

                                                        </td>



                                                
                                                        <!-- <td style="width:150px"> 
                                                           
                                                            <a :href="`${url}/admin/download-file/document/${s.id}`" class="btn btn-xs btn-default" target="_blank" style="float:left">
                                                                <i class="fa fa-download"></i>
                                                                {{trans('flexi.download')}}
                                                            </a>                                                            
                                                            <a  :href="`${url}/admin/download-file/document/${fi}`" class="btn btn-xs btn-default" target="_blank" style="float:left">
                                                                <i class="fa fa-download"></i>
                                                                {{trans('flexi.download')}}
                                                            </a> -->

                                                           <!-- <button class="btn btn-xs btn-default" @click.prevent="deleteFile(s.id,i)"  style="float: right;display:inline-block">
                                                                <i class="fa fa-trash"></i>
                                                                {{trans('flexi.delete')}}
                                                            </button>
                                                     
                                                        </td> -->

                                                    </tr>   
                                                </tbody>
                                            </table>
                  
                                             <div v-if="enableCreate">
                                                <form  method="POST"  @submit.prevent="createDocument" ref="refdocument" enctype="multipart/form-data">
                                               
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-xs-4">
                                                            <label for="inputCity">{{trans('flexi.name')}}</label>
                                                            <input type="text" class="form-control" name="name" v-model="form.name" >
                                                            <div v-if="errorname">
                                                                <div style="color:red">@{{errors.name[0]}}</div>
                                                            </div>
                                                        </div>
                                                        

                                                        <div class="form-group col-md-6 col-xs-4">
                                                        <label for="">{{trans('flexi.type')}}</label>
                                                        <!-- <input type="text"  class="form-control" name="type" v-model="form.type"> -->
                                                        <select name="type" v-model="form.type" class="form-control">
                                                            @foreach($type_options as $v)
                                                                <option value="{{$v}}">{{$v}}</option>
                                                            @endforeach
                                                        </select>
                                                            <div v-if="errortype">
                                                                <div style="color:red">@{{errors.type[0]}}</div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group col-md-6 col-xs-6">
                                                            <label for="inputZip">{{trans('flexi.url')}}</label>
                                                            <input type="file" class="form-control" name="url" @change="addfile" name="fake[]" ref="addFile" multiple style="display:none"><br>
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
                                            &nbsp &nbsp<a v-if="!enableCreate" class="btn btn-primary" @click="createfromdoc"><i class="fa fa-plus"></i> &nbsp {{trans('flexi.add_new_document')}}</a>
                                            @endhasanyrole

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tabs3 -->