@extends('backpack::layout')

@section('content-header')


	<section class="content-header">
	  <h1>
        <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
        <small>{{ ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name }}.</small>
      </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
	    <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
	    <li class="active">{{ trans('backpack::crud.preview') }}</li>
	  </ol>
	</section>
@endsection


@section('content')
                                <!--header-->
                            
                                @include('students.header')
                                        
                                <!--header-->

                                <div class="tab-content">
                              
                                <!--tab1,2-->
                                
                                @include('students.showpersonal')
                                
                                <!--tab1,2-->

                                <!--tab3-->
                               
                                @include('students.createhealth')
                                
                                <!--tab3--> 
                      
                                <!--tab4-->
                                
                                @include('students.createtestresult')
                                
                                <!--tab4-->

                                <!--tab5-->
                                
                                @include('students.createcriminal')
                                
                                <!--tab5--> 

                                <!--tab6-->
                                
                                 @include('students.createdocument')
                                
                                <!--tab6-->

                                <!--tab7-->
                                
                                @include('students.class')
                                
                                <!--tab7-->

                                 <!--tab8-->
                                
                                 @include('students.createfollowup')
                                
                                <!--tab8-->   
                                
                                <!--tab9-->
                                
                                @include('graduatestudents.creategraduatestudentfollowup')
                                
                                <!--tab9-->    

                            </div>
        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> 
</div>

@endsection


@section('after_styles')
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
	<link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/show.css') }}">
@endsection

@section('after_scripts')
	<script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
	<script src="{{ asset('vendor/backpack/crud/js/show.js') }}"></script>
    

<!--Document-->    
    <script>

    Vue.filter('splitUrl', function (val, index) {
        return val.split('/')[index];
    });
    Vue.filter('preview',function(val){
         return URL.createObjectURL(val);
    });
    Vue.filter('strLimit',function(val,limit){
        if(val.length>limit){
            return val.substring(0,limit)+ '[...]';
            }
            return val;
    });
    Vue.filter('upperCase',function(val){
         return val.toUpperCase();
    });
        var server = {};
            var appOne = new Vue({
            el: '#app_one',
            data: function() {
                return{
                    message: 'Hello Vue!',
                    enableCreate: false,
                    form: {},
                    document:[],
                    errors: {
                        message:'',
                        errors:{}
                    },
                    files:[],
                    url: '{{asset('')}}',
                
                }
            },
            computed:{

                    errorname:function(){
                        if(Object.prototype.hasOwnProperty.call(this.errors,'name')){
                            return true;
                        }
                        return false;
                    },
                    errortype:function(){
                        if(Object.prototype.hasOwnProperty.call(this.errors,'type')){
                            return true;
                        }
                        return false;
                    },
            
            },
            methods:{
            
                deleteFile: function (id,index) {
                    var isConfirm = confirm("are you sure to delete.");
                    if (isConfirm) {
                        axios.delete(`${this.url}/api/document/deletefile/${id}`)
                    .then(res => {
                        this._alert({text: 'Success delete file.'});
                        console.log(this.document);
                        this.document.splice(index,1);
                    })
                    .catch(e => {
                        this._alert({type:'danger',text: 'Something went wrong.'});
                    });
                    }
                    
                },
                _alert:function({type='',text})
                {
                            new PNotify({
                                text:text,
                                type:type || 'success',
                                icon:false
                            });
                },
                onLoaddocument:function()
                        {
                            axios.get('{{url('/')}}/api/document/{{$entry->id}}')
                            .then(res=>{
                                this.document=res.data;
                               // console.log(this.student);
                            })
                            .catch(e=>{
                                console.log(e);
                            });
                        },
                createfromdoc:function(){

                this.enableCreate = !this.enableCreate;
                },

               createDocument:function()
                        {
                            
                            var form=this.$refs.refdocument;
                            var formdata=new FormData(form);
                            var files=this.files;
                            if(files.length >0)
                            {
                                for(var i=0;i<files.length;i++)
                                {
                                    formdata.append('url[]',files[i]);
                                }
                            }
                            formdata.append('student_id', {{$entry->id}});
                            axios.post('{{url('/')}}/api/document',formdata)
                            .then(res=>{
                                    console.log(res.data);
                                    this.files = [];
                                    this.document.push(res.data);
                                    this._alert({text:"Save"});
                                    this.form={};
                                    this.errors={};
                                        
                                    this.$refs.addFile.value = '';
              
                            })
                            .catch(e=>
                            {
                                console.log(e);
                                if(e.response.status === 422){
                                this.errors = e.response.data.errors;
                                }
                            });
                           
                        
                        },
                cancelform:function(){
                    this.enableCreate=false;
                    this.form={};
                    this.files = [];
                    this.errors={};
                },
                addfile:function(event){
                     var getfile=event.target.files;
                     if(getfile.length > 0)
                     {
                         for(var i=0;i<getfile.length;i++)
                         {
                             this.files.push(getfile[i]);
                             //console.log(this.files[i]);    
                             //console.log(this.files);
                         }
                     }
         
                 },
                 removImage:function(i)
                {
                    console.log(this.files);
                    this.files.splice(i,1);
                },
                clickFile:function()
                {
                    this.$refs.addFile.click();
                },
            },
            created:function(){
                
                this.onLoaddocument();
            },

    });
            
    </script>
<!--Document-->


<!--TestResult-->
<script>

    Vue.filter('splitUrl', function (val, index) {
        return val.split('/')[index];
    });
    Vue.filter('preview',function(val){
        return URL.createObjectURL(val);
    });
    Vue.filter('strLimit',function(val,limit){
        if(val.length>limit){
            return val.substring(0,limit)+ '[...]';
            }
            return val;
    });
    Vue.filter('upperCase',function(val){
        return val.toUpperCase();
    });
    var server = {};
        var appOne = new Vue({
        el: '#test_result',
        data: function() {
            return{
                enableCreate: false,
                form: {},
                testresult: [],
                files:[],
                errors: {
                        message:'',
                        errors:{}
                    },
                url: '{{asset('')}}',
            
            }
        },
        computed:{

                errortitle:function(){
                    if(Object.prototype.hasOwnProperty.call(this.errors,'title')){
                        return true;
                    }
                    return false;
                },
                errordescription:function(){
                    if(Object.prototype.hasOwnProperty.call(this.errors,'description')){
                        return true;
                    }
                    return false;
                },

        },
        methods:{

            deleteFile: function (id,index) {
                    var isConfirm = confirm("are you sure to delete.");
                    if (isConfirm) {
                        axios.delete(`${this.url}/api/testresult/deletefile/${id}`)
                    .then(res => {
                        this._alert({text: 'Success delete file.'});
                        console.log(this.testresult);
                        this.testresult.splice(index,1);
                    })
                    .catch(e => {
                        this._alert({type:'danger',text: 'Something went wrong.'});
                    });
                    }
                    
                },

            _alert:function({type="",text}){
                new PNotify({
                            text:text,
                            type:type || 'success',
                            icon:false
                });
            },
           
            onLoadResult:function()
                        {
                            axios.get('{{url('/')}}/api/testresult/{{$entry->id}}')
                            .then(res=>{
                                this.testresult=res.data;
                               
                            })
                            .catch(e=>{
                                console.log(e);
                            });
                        },
            createfromdoc:function(){

            this.enableCreate = !this.enableCreate;
            },

           createtestresult:function()
                    {
                        
                        var form=this.$refs.reftestresult;
                        var formdata=new FormData(form);
                        var files=this.files;
                        if(files.length >0)
                        {
                            for(var i=0;i<files.length;i++)
                            {
                                formdata.append('file[]',files[i]);
                            }
                        }
                        formdata.append('student_id', {{$entry->id}});
                        formdata.append('type','TestResult');
                        axios.post('{{url('/')}}/api/testresult',formdata)
                        .then(res=>{
                                this.testresult.push(res.data);
                                this.files = [];
                                this._alert({text:"Save"});
                                this.form={};
                                this.errors={};
                                this.$refs.addFile.value = '';
                        })
                        .catch(e=>
                        {
                            console.log(e);
                            if(e.response.status === 422){
                            this.errors = e.response.data.errors;
                            }
                        });
                       
                    
                    },
            cancelform:function(){
                this.enableCreate=false;
                this.form={};
                this.files = [];
                this.errors={};
            },
            addfile:function(event){
                 var getfile=event.target.files;
                 if(getfile.length > 0)
                 {
                     for(var i=0;i<getfile.length;i++)
                     {
                         this.files.push(getfile[i]);
                         //console.log(this.files[i]);    
                         //console.log(this.files);
                     }
                 }
     
             },
             removImage:function(i)
            {
                console.log(this.files);
                this.files.splice(i,1);
            },
            clickFile:function()
            {
                this.$refs.addFile.click();
            },
        },
        created:function(){
            
            this.onLoadResult();
        },

});
        
</script>
<!--TestResult-->



<!--Criminal-->
<script>

    Vue.filter('splitUrl', function (val, index) {
        return val.split('/')[index];
    });
    Vue.filter('preview',function(val){
        return URL.createObjectURL(val);
    });
    Vue.filter('strLimit',function(val,limit){
        if(val.length>limit){
            return val.substring(0,limit)+ '[...]';
            }
            return val;
    });
    Vue.filter('upperCase',function(val){
        return val.toUpperCase();
    });
 var server = {};
    var appOne = new Vue({
    el: '#id_criminal',
    data: function() {
        return{
            enableCreate: false,
            form: {},
            criminal: [],
            files:[],
            errors: {
                        message:'',
                        errors:{}
                    },
            url:'{{asset('')}}',
        
        }
    },
    computed:{

                errortitle:function(){
                    if(Object.prototype.hasOwnProperty.call(this.errors,'title')){
                        return true;
                    }
                    return false;
                },
                errordescription:function(){
                    if(Object.prototype.hasOwnProperty.call(this.errors,'description')){
                        return true;
                    }
                    return false;
                },


        },
    methods:{
        deleteFile: function (id,index) {
                    var isConfirm = confirm("are you sure to delete.");
                    if (isConfirm) {
                        axios.delete(`${this.url}/api/criminal/deletefile/${id}`)
                    .then(res => {
                        this._alert({text: 'Success delete file.'});
                        console.log(this.criminal);
                        this.criminal.splice(index,1);
                    })
                    .catch(e => {
                        this._alert({type:'danger',text: 'Something went wrong.'});
                    });
                    }
                    
                },
                _alert:function({type='',text})
                {
                            new PNotify({
                                text:text,
                                type:type || 'success',
                                icon:false
                            });
                },
        onLoadCriminal:function()
                    {
                        axios.get('{{url('/')}}/api/criminal/{{$entry->id}}')
                        .then(res=>{
                            this.criminal=res.data;
                           
                        })
                        .catch(e=>{
                            console.log(e);
                        });
                    },
        createfromcriminal:function(){

        this.enableCreate = !this.enableCreate;
        },

       createcriminal:function()
                {
                    
                    var form=this.$refs.refcriminal;
                    var formdata=new FormData(form);
                    var files=this.files;
                    if(files.length >0)
                    {
                        for(var i=0;i<files.length;i++)
                        {
                            formdata.append('file[]',files[i]);
                        }
                    }
                    formdata.append('student_id', {{$entry->id}});
                    formdata.append('type','criminal');
                    axios.post('{{url('/')}}/api/criminal',formdata)
                    .then(res=>{
                            this.criminal.push(res.data);
                            this.files = [];
                            this._alert({text:"Save"});
                            this.form={};
                            this.errors={};
                            this.$refs.addFile.value = '';
                    })
                    .catch(e=>
                    {
                        console.log(e);
                        if(e.response.status === 422){
                        this.errors = e.response.data.errors;
                        }
                    });
                   
                
                },
        cancelform:function(){
            this.enableCreate=false;
            this.form={};
            this.files = [];
            this.errors={};
        },
        addfile:function(event){
             var getfile=event.target.files;
             if(getfile.length > 0)
             {
                 for(var i=0;i<getfile.length;i++)
                 {
                     this.files.push(getfile[i]);
                 }
             }
 
         },
         removImage:function(i)
        {
            console.log(this.files);
            this.files.splice(i,1);
        },
        clickFile:function()
        {
            this.$refs.addFile.click();
        },
    },
    created:function(){
        
        this.onLoadCriminal();
    },

});
    
</script>
<!--endCriminal-->

<!--Health-->
<script>

    Vue.filter('strLimit',function(val,limit){
        if(val.length>limit){
            return val.substring(0,limit)+ '[...]';
            }
            return val;
    });

 var server = {};
    var appOne = new Vue({
    el: '#id_health',
    data: function() {
        return{
            enableCreate: false,
            form: {},
            health: [],
            files:[],
            errors: {
                        message:'',
                        errors:{}
                    },
            url:'{{asset('')}}',

        
        }
    },
 
    computed:{
        errortitle:function(){
            if(Object.prototype.hasOwnProperty.call(this.errors,'title')){
                return true;
            }
                return false;
        },
        errordescription:function(){
            if(Object.prototype.hasOwnProperty.call(this.errors,'description')){
                return true;
            }
                return false;
        },
        errortype:function(){
            if(Object.prototype.hasOwnProperty.call(this.errors,'type')){
                return true;
            }
                return false;
        },
 
   
    },
 

    methods:{
        deleteFile: function (id,index) {
                    var isConfirm = confirm("are you sure to delete.");
                    if (isConfirm) {
                        axios.delete(`${this.url}/api/health/deletefile/${id}`)
                    .then(res => {
                        this._alert({text: 'Success delete file.'});
                        console.log(this.criminal);
                        this.health.splice(index,1);
                    })
                    .catch(e => {
                        this._alert({type:'danger',text: 'Something went wrong.'});
                    });
                    }
                    
                },
                _alert:function({type='',text})
                {
                            new PNotify({
                                text:text,
                                type:type || 'success',
                                icon:false
                            });
                },
        onLoadhealth:function()
                    {
                        axios.get('{{url('/')}}/api/health/{{$entry->id}}')
                        .then(res=>{
                            this.health=res.data;
                           
                        })
                        .catch(e=>{
                            console.log(e);
                        });
                    },
        createfromhealth:function(){

        this.enableCreate = !this.enableCreate;
        },

       createhealth:function()
                {
                    
                    var form=this.$refs.refhealth;
                    var formdata=new FormData(form);
                    var files=this.files;
                    if(files.length >0)
                    {
                        for(var i=0;i<files.length;i++)
                        {
                            formdata.append('files[]',files[i]);
                        }
                    }
                    formdata.append('student_id', {{$entry->id}});
                    axios.post('{{url('/')}}/api/health',formdata)
                    .then(res=>{
                            this.health.push(res.data);
                            this.files = [];
                            this._alert({text:"Save"});
                            this.form={};
                            this.errors={};
                            this.$refs.addFile.value = '';
                    })
                    .catch(e=>
                    {
                        console.log(e);
                        if(e.response.status === 422){
                        this.errors = e.response.data.errors;
                        }
                    });
                   
                
                },
        cancelform:function(){
            this.enableCreate=false;
            this.form={};
            this.files = [];
            this.errors={};
        },
        addfile:function(event){
             var getfile=event.target.files;
             if(getfile.length > 0)
             {
                 for(var i=0;i<getfile.length;i++)
                 {
                     this.files.push(getfile[i]);
                 }
             }
 
         },
         removImage:function(i)
        {
            console.log(this.files);
            this.files.splice(i,1);
        },
        clickFile:function()
        {
            this.$refs.addFile.click();
        },
    },
    created:function(){
        
        this.onLoadhealth();
    },

});
    
</script>
<!--endhealt-->

<!--studentfollowup-->
<script>
  
    var follow=new Vue({
            el:'#id_followup',
            data:function(){
                return{
                    enableCreate:false,
                    form:{},
                    followup:[],
                    files:[],
                    myDate : new Date().toISOString().slice(0,10),
                    errors: {
                        message:'',
                        errors:{}
                    },
                    url:'{{asset('')}}',
                }
            },

            computed:{
                        errortitle:function(){
                            if(Object.prototype.hasOwnProperty.call(this.errors,'title')){
                                return true;
                            }
                                return false;
                        },
                        errordes:function(){
                            if(Object.prototype.hasOwnProperty.call(this.errors,'description')){
                                return true;
                            }
                                return false;
                        },
                        errortype:function(){
                            if(Object.prototype.hasOwnProperty.call(this.errors,'type')){
                                return true;
                            }
                                return false;
                        },
            },
            methods:{

                    deleteFile:function (id,index) {
                    var isConfirm = confirm("are you sure to delete.");
                    if(isConfirm) {
                        axios.delete(`${this.url}/api/followup/deletefile/${id}`)
                    .then(res => {
                        this._alert({text: 'Success delete file.'});
                        this.followup.splice(index,1);
                    })
                    .catch(e => {
                        this._alert({type:'danger',text: 'Something went wrong.'});
                    });
                    }
                    
                },

                onloadfollowup:function(){
                    axios.get('{{url('/')}}/api/followup/{{$entry->id}}')
                    .then(res=>{
                        this.followup=res.data;
                        console.log(this.followup);
                    })
                    .catch(e=>{
                        console.log(e);
                    });
                },

               
                _alert:function({type='',text}){
                    new PNotify({
                        text:text,
                        type:type || 'success',
                        icon:false
                    });
                },
                createfromfollowup:function(){
                    this.enableCreate =!this.enableCreate;
                },
                clickFile:function(){
                    this.$refs.addFile.click();
                },
                addfile:function(event){
                    var getfile=event.target.files;
                    if(getfile.length > 0){
                        for(var i=0;i<getfile.length;i++){
                            this.files.push(getfile[i]);
                        }
                    
                    }
                },
                removImage:function(i){
                    this.files.splice(i,1);
                },
                cancelform:function(){
                    this.enableCreate=false;
                    this.form={};
                    this.files = [];
                    this.errors={};
                },
                createfollowup:function(){
                    var form=this.$refs.reffollowup;
                  //  console.log(form);
                    var formdata=new FormData(form);
                    var file=this.files;
                    if(file.length > 0)
                    {
                        for(var i=0;i<file.length;i++){
                            formdata.append('files[]',file[i]);
                        }
                    }
                    formdata.append('student_id',{{$entry->id}});
                    axios.post('{{url('/')}}/api/followup',formdata)
                    .then(res=>{
                       this.followup.push(res.data);
                       this.files = [];
                       this._alert({text:"Save"});
                       this.form={};
                       this.errors={};
                       this.$refs.addFile.value = '';
                       console.log(this.followup);
                    })
                    .catch(e=>{
                        console.log(e);
                        if(e.response.status === 422){
                        this.errors = e.response.data.errors;
                        }
                    });
                },
            },
            created:function(){
                this.onloadfollowup();
            },
    });


</script>

<!--studentfollowup-->



<!--endgradutestudentfollowup-->
<script>
    


    var graduatestudentfollow=new Vue({
            el:'#id_gradiatestudentfollowup',
            data:function(){
                return{
                    enableCreate:false,
                    form:{},
                    followup:[],
                    files:[],
                    errors: {
                        message:'',
                        errors:{}
                    },
                    url:'{{asset('')}}',
                }
            },

            computed:{
                        errortitle:function(){
                            if(Object.prototype.hasOwnProperty.call(this.errors,'title')){
                                return true;
                            }
                                return false;
                        },
                        errordescription:function(){
                            if(Object.prototype.hasOwnProperty.call(this.errors,'description')){
                                return true;
                            }
                                return false;
                        },
                        errorquality:function(){
                            if(Object.prototype.hasOwnProperty.call(this.errors,'quality')){
                                return true;
                            }
                                return false;
                        },
            },
            methods:{

            //    deleteFile:function(i,index){
            //        var isconfig=config("are you sure to delete.");
            //        if(isconfig){
            //        axios.delete('{{url('/')}}/api/followup/deletefile/'+i)
            //        .then(res=>{
            //         this._alert({text: 'Success delete file.'});
            //            this.followup.splice(index,1);
                       
            //        })
            //        .catch(e=>{
            //         this._alert({type:'danger',text: 'Something went wrong.'});
            //        });
            //     }
            //    },

                    deleteFile:function (id,index) {
                    var isConfirm = confirm("are you sure to delete.");
                    if(isConfirm) {
                        axios.delete(`${this.url}/api/graduatestudentfollowup/deletefile/${id}`)
                    .then(res => {
                        this._alert({text: 'Success delete file.'});
                        this.followup.splice(index,1);
                    })
                    .catch(e => {
                        this._alert({type:'danger',text: 'Something went wrong.'});
                    });
                    }
                    
                },

                onloadfollowup:function(){
                    axios.get('{{url('/')}}/api/graduatestudentfollowup/{{$entry->id}}')
                    .then(res=>{
                        this.followup=res.data;
                        console.log(this.followup);
                    })
                    .catch(e=>{
                        console.log(e);
                    });
                },

               
                _alert:function({type='',text}){
                    new PNotify({
                        text:text,
                        type:type || 'success',
                        icon:false
                    });
                },
                createfromfollowup:function(){
                    this.enableCreate =!this.enableCreate;
                },
                clickFile:function(){
                    this.$refs.addFile.click();
                },
                addfile:function(event){
                    var getfile=event.target.files;
                    if(getfile.length > 0){
                        for(var i=0;i<getfile.length;i++){
                            this.files.push(getfile[i]);
                        }
                    
                    }
                },
                removImage:function(i){
                    this.files.splice(i,1);
                },
                cancelform:function(){
                    this.enableCreate=false;
                    this.form={};
                    this.files = [];
                    this.errors={};
                },
                createfollowup:function(){
                    var form=this.$refs.reffollowup;
                  //  console.log(form);
                    var formdata=new FormData(form);
                    var file=this.files;
                    if(file.length > 0)
                    {
                        for(var i=0;i<file.length;i++){
                            formdata.append('files[]',file[i]);
                        }
                    }
                    formdata.append('student_id',{{$entry->id}});
                    axios.post('{{url('/')}}/api/graduatestudentfollowup',formdata)
                    .then(res=>{
                       this.followup.push(res.data);
                       this.files = [];
                       this._alert({text:"Save"});
                       this.form={};
                       this.errors={};
                       this.$refs.addFile.value = '';
                       console.log(this.followup);
                    })
                    .catch(e=>{
                        console.log(e);
                        if(e.response.status === 422){
                        this.errors = e.response.data.errors;
                        }
                    });
                },
            },
            created:function(){
                this.onloadfollowup();
            },
    });


</script>

<!--endgradutestudentfollowup-->





@endsection


