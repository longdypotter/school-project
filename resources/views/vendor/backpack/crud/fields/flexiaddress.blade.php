
<!-- field_type_name -->
<div @include('crud::inc.field_wrapper_attributes') >

    <div class="row" id="address-{{ $field['name'] }}">
        <div class="col-sm-3">
            <label>{{trans('flexi.city')}}</label>
            <select class="form-control" @change="cityChange" v-model="frm.city" :disabled="JSON.stringify(cities).length==2">
                <option v-for="(val, text) in cities" :value="val">@{{text}}</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label>{{trans('flexi.district')}}</label>
            <select class="form-control" @change="districChange"  v-model="frm.distric" :disabled="JSON.stringify(districs).length==2">
                <option v-for="(val, text) in districs" :value="val">@{{text}}</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label>{{trans('flexi.commune')}}</label>
            <select class="form-control" @change="communeChange"  v-model="frm.commune" :disabled="JSON.stringify(communes).length==2">
                <option v-for="(val, text) in communes" :value="val">@{{text}}</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label>{{trans('flexi.village')}}</label>
            <select class="form-control" @change="villageChange" v-model="frm.village" :disabled="JSON.stringify(villages).length==2">
                <option v-for="(val, text) in villages" :value="val">@{{text}}</option>
            </select>
        </div>
        <input type="hidden" v-model="hidden" name="{{ $field['name'] }}">
        
    </div>
    
    
   

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


  {{-- FIELD EXTRA CSS  --}}
  {{-- push things in the after_styles section --}}

      @push('crud_fields_styles')
          <!-- no styles -->
      @endpush


  {{-- FIELD EXTRA JS --}}
  {{-- push things in the after_scripts section --}}

      @push('crud_fields_scripts')
       
        <script>
            var appAddress = new Vue({
                el: '#address-{{ $field['name'] }}',
                data: {
                    cities:{},
                    districs:{},
                    communes:{},
                    villages:{},
                    frm:{},
                    hidden:"{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
                },
                methods:{
                    cityChange:function(){
                        var me = this;
                        this.hidden = this.frm.city;
                        this.getData(this.frm.city).then(function(response){
                            me.districs = response.data;   
                            me.communes={};                             
                            me.villages={};                             
                        });  
                    },
                    districChange:function(){
                        var me = this;
                        this.hidden = this.frm.distric;
                        this.getData(this.frm.distric).then(function(response){
                            me.communes = response.data;                                                    
                            me.villages={};                             
                        });  
                    },
                    communeChange:function(){
                        var me = this;
                        this.hidden = this.frm.commune;
                        this.getData(this.frm.commune).then(function(response){
                            me.villages = response.data;                                
                        });  
                    },
                    villageChange:function(){           
                        this.hidden = this.frm.village;                       
                    },
                    getData:function(code=''){
                        if(code)
                            return axios.get('{{route("address.get")}}/'+code)
                        else
                            return axios.get('{{route("address.get")}}')
                    }

                },
                created(){
                    var me = this;
                    this.getData().then(function(response){
                       me.cities = response.data;
                        
                    });
                    if(this.hidden.length>1){
                        var str = this.hidden;
                        var take = 2;
                        var i = 1;

                        do {
                            var res = str.substring(0, take*i);
                            if(i==1){
                                this.frm.city=res
                            }
                            if(i==2){
                                this.cityChange();
                                this.frm.distric=res
                            }
                            if(i==3){
                                this.districChange();
                                this.frm.commune=res
                            }
                            if(i==4){
                                this.communeChange();
                                this.frm.village=res
                                this.villageChange();
                            }
                            i++;
                           
                        } while (res!=str);
                    }        
                }
            });
        </script>
      
      @endpush


{{-- Note: most of the times you'll want to use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load CSS/JS once, even though there are multiple instances of it. --}}