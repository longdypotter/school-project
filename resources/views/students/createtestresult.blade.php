
                                 <!-- .tabs4 -->
                                 <div class="tab-pane" id="testresult">
                                    <div class="steamline">
                                        <div class="sl-item">
                                            <div id="test_result">
                                        
                                                <table class="table">
                                                    <thead>
                                                        <th class="col-md-5">{{trans('flexi.title')}}</th>
                                                        <th class="col-md-4">{{trans('flexi.description')}}</th>
                                                        @hasanyrole('Developer|Admin')
                                                        <th class="col-md-3">{{trans('flexi.file')}}
                                                        @endhasanyrole
                                                    </thead>
                                                    <tbody> 
                                                    <tr v-for="(s,i) in testresult">
                                                        <td>@{{s.title}}</td>

                                                        <td>@{{s.description}}</td>
                                                
                                                        <!-- <td style="width:150px"> 
                                                 
                                                   
                                                            <a :href="`${url}/admin/download-file/result/${s.id}`" class="btn btn-xs btn-default" target="_blank" style="float:left">
                                                                <i class="fa fa-download"></i>
                                                                {{trans('flexi.download')}}
                                                            </a>
                                                            
                                                        

                                                           <button class="btn btn-xs btn-default" @click.prevent="deleteFile(s.id,i)"  style="float: right;display:inline-block">
                                                                <i class="fa fa-trash"></i>
                                                                {{trans('flexi.delete')}}
                                                            </button>
                                                       
                                                     
                                                        </td> -->


                                                        <td>
                                                        @hasanyrole('Developer|Admin')
                                                            <div class="btn-group" >

                                                            <a v-if="s.file" :href="`${url}/admin/download-file/result/${s.id}`" class="btn btn-xs btn-default" style="margin-right:5px" target="_blank" >
                                                                <i class="fa fa-download"></i>
                                                                {{trans('flexi.download')}}
                                                            </a>

                                                            <button class="btn btn-xs btn-default" @click.prevent="deleteFile(s.id,i)">
                                                                <i class="fa fa-trash"></i>
                                                                {{trans('flexi.delete')}}
                                                            </button>
                                                                <!-- <button type="button" class="btn btn-default btn-sm " data-toggle="dropdown" aria-expanded="false">
                                                                    Action <span class="caret"></span>
                                                                </button> -->
                                                                <!-- <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                                                                    <li>
                                                                        <a href="#" onclick="showAjaxModal('http://creativeitem.com/demo/ekattor/index.php/modal/popup/modal_admin_edit/1')">
                                                                            <i class="entypo-pencil"></i> Edit</a>
                                                                    </li>
                                                                    <li class="divider"></li>

                                                                    <li>
                                                                        <a href="#" onclick="confirm_modal('http://creativeitem.com/demo/ekattor/index.php/admin/admin/delete/1');">
                                                                            <i class="entypo-trash"></i>Delete </a>
                                                                    </li>
                                                                </ul> -->

                                                                 </div>
                                                            @endhasanyrole

                                                            </td>


                                                    </tr>   
                                                </tbody>
                                            </table>
                  
                                             <div v-if="enableCreate">
                                                <form  method="POST"  @submit.prevent="createtestresult" ref="reftestresult" enctype="multipart/form-data">
                                               
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
                                                            <textarea name="description" id="" cols="30" rows="4" v-model="form.description"  class="form-control" ></textarea>
                                                            <div v-if="errordescription">
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
                                            &nbsp &nbsp<a v-if="!enableCreate" class="btn btn-primary" @click="createfromdoc"><i class="fa fa-plus"></i> &nbsp {{trans('flexi.add_new_document')}}</a>
                                            @endhasanyrole

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tabs4 -->