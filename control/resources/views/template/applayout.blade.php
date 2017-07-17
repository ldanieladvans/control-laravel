@extends('template.apptemplate')

@section('app_title','Control App')

@section('app_css')
	@parent
    <!-- iCheck -->
    <link href="{{ asset('controlassets/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">	
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('controlassets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('controlassets/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- Animate -->
    <link href="{{ asset('controlassets/animate.css') }}" rel="stylesheet" type="text/css" />
    <!-- Mask -->
    <link href="{{ asset('controlassets/jquery-loadmask-master/jquery.loadmask.css') }}" rel="stylesheet" type="text/css" />
    <!-- PNotify -->
    <link href="{{ asset('controlassets/pnotify/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css" />
    

    <style type="text/css">

    thead tr {
		  color:#FFFFFF ; 
		  background-color:#053666 ;
	  }

  td.last button {
		  color:#053666 ; 
		  background-color:#FFFFFF ;
	  }

    	.lmask {
		  position: absolute;
		  height: 100%;
		  width: 100%; 
		  background-color: #000;
		  bottom: 0;
		  left: 0;
		  right: 0;
		  top: 0;
		  z-index: 9999;;
		  opacity: 0.4;
		  &.fixed {
		    position: fixed;
		  }
		  &:before {
		    content: '';
		    background-color: rgba(0,0,0,0);
		    border: 5px solid rgba(0,183,229,0.9);
		    opacity: .9;
		    border-right: 5px solid rgba(0,0,0,0);
		    border-left: 5px solid rgba(0,0,0,0);
		    border-radius: 50px;
		    box-shadow: 0 0 35px #2187e7;
		    width: 50px;
		    height: 50px;
		    -moz-animation: spinPulse 1s infinite ease-in-out;
		    -webkit-animation: spinPulse 1s infinite linear;

		    margin: -25px 0 0 -25px;
		    position: absolute;
		    top: 50%;
		    left: 50%;
		  }
		  &:after {
		    content: '';
		    background-color: rgba(0,0,0,0);
		    border: 5px solid rgba(0,183,229,0.9);
		    opacity: .9;
		    border-left: 5px solid rgba(0,0,0,0);
		    border-right: 5px solid rgba(0,0,0,0);
		    border-radius: 50px;
		    box-shadow: 0 0 15px #2187e7;
		    width: 30px;
		    height: 30px;
		    -moz-animation: spinoffPulse 1s infinite linear;
		    -webkit-animation: spinoffPulse 1s infinite linear;

		    margin: -15px 0 0 -15px;
		    position: absolute;
		    top: 50%;
		    left: 50%;
		  }
		}

		@-moz-keyframes spinPulse {
		  0% {
		    -moz-transform:rotate(160deg);
		    opacity: 0;
		    box-shadow: 0 0 1px #2187e7;
		  }
		  50% {
		    -moz-transform: rotate(145deg);
		    opacity: 1;
		  }
		  100% {
		    -moz-transform: rotate(-320deg);
		    opacity: 0;
		  }
		}
		@-moz-keyframes spinoffPulse {
		  0% {
		    -moz-transform: rotate(0deg);
		  }
		  100% {
		    -moz-transform: rotate(360deg);
		  }
		}
		@-webkit-keyframes spinPulse {
		  0% {
		    -webkit-transform: rotate(160deg);
		    opacity: 0;
		    box-shadow: 0 0 1px #2187e7;
		  }
		  50% {
		    -webkit-transform: rotate(145deg);
		    opacity: 1;
		  }
		  100% {
		    -webkit-transform: rotate(-320deg);
		    opacity: 0;
		  }
		}
		@-webkit-keyframes spinoffPulse {
		  0% {
		    -webkit-transform: rotate(0deg);
		  }
		  100% {
		    -webkit-transform: rotate(360deg);
		  }
		}
    </style>
@endsection

@section('app_body')
	<body class="nav-md" style="background-color: #072542 ">
		<div class="container body">
			<div class="main_container" style="background-color: #072542 ">


			    <!-- Modal -->
			    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true" id="loadingmodal">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Prosesando ...</h4>
                        </div>

                      </div>
                    </div>
                  </div>

				
				@section('app_left_menu')
		            <div class="col-md-3 left_col" style="background-color: #072542 ">
					    <div class="left_col scroll-view" style="background-color: #072542 ">
					      <div class="navbar nav_title" style="border: 0; background-color: #072542;">
					      	<a href="{{ route('home') }}" class="site_title"><img height="60px" src="{{asset('logo_advans.png')}}"><span>{{ config('app.name') }}</span></a>
					      </div>
					      <div class="clearfix"></div>
					      <!-- menu profile quick info -->
					      <div class="profile clearfix">
					        
					        <div class="profile_info">
					          <span>Hola</span>
					          <h2><strong>{{ Auth::user()->name }}</strong></h2>
					        </div>
					      </div>
					      <!-- /menu profile quick info -->
					      <br />
					      <!-- sidebar menu -->
					      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
					        <div class="menu_section">
					          <h3>Menus</h3>
					          <ul class="nav side-menu">
					            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> <strong>INICIO</strong> </span></a>
					              
					            </li>
					            <li><a><i class="fa fa-group"></i> <strong>DIRECTORIO</strong> <span class="fa fa-chevron-down"></span></a>
					              <ul class="nav child_menu">
					              	<li><a href="{{ route('distributor.index') }}"><strong>DISTRIBUIDORES</strong></a></li>
					                <li><a href="{{ route('client.index') }}"><strong>CLIENTES</strong></a></li>
					                
					              </ul>
					            </li>
					            <li><a><i class="fa fa-exchange"></i> <strong>ASIGNACIONES</strong> <span class="fa fa-chevron-down"></span></a>
					            	<ul class="nav child_menu">
					            		<li><a href="{{ route('asigpaq.index') }}"><strong>ASIGNACIÓN DISTRIBUIDORES</strong></a></li>
						            	<li><a href="{{ route('account.index') }}"><strong>CUENTAS</strong></a></li>
						            	
						                <li><a href="{{ route('appcta.index') }}"><strong>DETALLES CUENTAS</strong></a></li>
					                </ul>
					            </li>

					            <li><a><i class="fa fa-gears"></i> <strong>CONFIGURACIÓN</strong> <span class="fa fa-chevron-down"></span></a>
					              <ul class="nav child_menu">
					                <li><a href="{{ route('apps.index') }}"><strong>APLICACIONES</strong></a></li>
					              </ul>
					            </li>

					            <li><a><i class="fa fa-unlock-alt"></i> <strong>SEGURIDAD</strong> <span class="fa fa-chevron-down"></span></a>
					              <ul class="nav child_menu">
					                <li><a href="{{ route('user.index') }}"><strong>USUARIOS</strong></a></li>
					                <li><a href="{{ route('role.index') }}"><strong>ROLES</strong></a></li>
					                <li><a href="{{ route('permission.index') }}"><strong>PERMISOS</strong></a></li>
					                <li><a href="{{ route('binnacle.index') }}"><strong>BITÁCORA</strong></a></li>
					              </ul>
					            </li>

					            <li><a><i class="fa fa-newspaper-o"></i> <strong>SERV. EXTERNOS</strong> <span class="fa fa-chevron-down"></span></a>
					              <ul class="nav child_menu">
					                <li><a href="{{ route('news.index') }}"><strong>NOTICIAS</strong></a></li>
					              </ul>
					            </li>
					           
					          </ul>
					        </div>

					        

					      </div>
					      <!-- /sidebar menu -->
					      <!-- /menu footer buttons -->
					      <!--<div class="sidebar-footer hidden-small">
					        
					      </div>-->
					      <!-- /menu footer buttons -->
					    </div>
					  </div>
		        @show

				@section('app_top_navigation')
					<!-- top navigation -->
				        <div class="top_nav">
				          <div class="nav_menu">
				            <nav>
				              <div class="nav toggle">
				                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
				              </div>

				              <ul class="nav navbar-nav navbar-right">
				                <li class="">
				                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				                    <img src="{{ Auth::user()->usrc_pic ? asset('storage/'.Auth::user()->usrc_pic) : asset('default_avatar_male.jpg')}}" alt="">{{ Auth::user()->name }}
				                    <span class=" fa fa-angle-down"></span>
				                  </a>
				                  <ul class="dropdown-menu dropdown-usermenu pull-right">
				                    <li><a href="{{ route('user.edit',Auth::user()->id) }}"> Perfil</a></li>
				                    @if (Auth::guest())
			                            <li><a href="{{ route('login') }}">Login</a></li>
			                            <li><a href="{{ route('register') }}">Register</a></li>
			                        @else
			                            <li class="dropdown">
			                                    <li>
			                                        <a href="{{ route('logout') }}"
			                                            onclick="event.preventDefault();
			                                                     document.getElementById('logout-form').submit();">
			                                            Salir
			                                        </a>

			                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			                                            {{ csrf_field() }}
			                                        </form>
			                                    </li>
			                            </li>
			                        @endif
				                  </ul>
				                </li>

				                
				              </ul>
				            </nav>
				          </div>
				        </div>
				    <!-- /top navigation -->
				@show

				
					<!-- page content -->
				        <div class="right_col" role="main">
				 			@yield('app_content')
				        </div>
				    <!-- /page content -->
				<footer></footer>


			</div>

		</div>

		@section('app_js')
            <!-- jQuery -->
		    <script src="{{ asset('controlassets/vendors/jquery/dist/jquery.min.js') }}"></script>
		    <!-- Bootstrap -->
		    <script src="{{ asset('controlassets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		    <!-- FastClick -->
		    <script src="{{ asset('controlassets/vendors/fastclick/lib/fastclick.js') }}"></script>
		    <!-- NProgress -->
		    <script src="{{ asset('controlassets/vendors/nprogress/nprogress.js') }}"></script>
		    <!-- iCheck -->
		    <script src="{{ asset('controlassets/vendors/iCheck/icheck.min.js') }}"></script>
		    
		    <script src="{{ asset('controlassets/jquery.babypaunch.spinner.min.js') }}"></script>

		    <!-- PNotify -->
		    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.js') }}"></script>
		    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
		    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

		    <script type="text/javascript">
		    	var message, tests, checkField, validate, mark, unmark, field, minmax, defaults,
			        validateWords, lengthRange, lengthLimit, pattern, alertTxt, data,
			        email_illegalChars = /[\(\)\<\>\,\;\:\\\/\"\[\]]/,
			        email_filter = /^.+@.+\..{2,6}$/;

			    function isInt(value) {
			        return !isNaN(value) && (function(x) { return (x | 0) === x; })(parseFloat(value))
			    }


			    testsNoMsg = {
			        sameAsPlaceholder : function(a){
			            return $.fn.placeholder && a.attr('placeholder') !== undefined && data.val == a.prop('placeholder');
			        },
			        hasValue : function(a){
			            if( !a ){
			                return false;
			            }
			            return true;
			        },
			        linked : function(a,b){
			            if( b != a ){
			                return false;
			            }
			            return true;
			        },
			        email : function(a){
			            if ( !email_filter.test( a ) || a.match( email_illegalChars ) ){
			                return false;
			            }
			            return true;
			        },

			        text : function(a, skip){
			            console.log(validateWords);
			            if( validateWords ){
			                var words = a.split(' ');
			                // iterrate on all the words
			                var wordsLength = function(len){
			                    for( var w = words.length; w--; )
			                        if( words[w].length < len )
			                            return false;
			                    return true;
			                };

			                if( words.length < validateWords || !wordsLength(2) ){
			                    return false;
			                }
			                return true;
			            }
			            if( !skip && lengthRange && a.length < lengthRange[0] ){
			                return false;
			            }
			            if( lengthRange && lengthRange[1] && a.length > lengthRange[1] ){
			                return false;
			            }
			            if( lengthLimit && lengthLimit.length ){
			                while( lengthLimit.length ){
			                    if( lengthLimit.pop() == a.length ){
			                        return false;
			                    }
			                }
			            }

			            if( pattern ){
			                var regex, jsRegex;
			                switch( pattern ){
			                    case 'alphanumeric' :
			                        regex = /^[a-zA-Z0-9]+$/i;
			                        break;
			                    case 'numeric' :
			                        regex = /^[0-9]+$/i;
			                        break;
			                    case 'phone' :
			                        regex = /^\+?([0-9]|[-|' '])+$/i;
			                        break;
			                    default :
			                        regex = pattern;
			                }
			                try{
			                    jsRegex = new RegExp(regex).test(a);
			                    if( a && !jsRegex )
			                        return false;
			                }
			                catch(err){
			                    console.log(err, field, 'regex is invalid');
			                    return false;
			                }
			            }

			            return true;
			        },
			        number : function(a){
			            if( isNaN(parseFloat(a)) && !isFinite(a) ){
			                return false;
			            }
			            else if( lengthRange && a.length < lengthRange[0] ){
			                return false;
			            }
			            else if( lengthRange && lengthRange[1] && a.length > lengthRange[1] ){
			                return false;
			            }
			            else if( minmax[0] && (a|0) < minmax[0] ){
			                return false;
			            }
			            else if( minmax[1] && (a|0) > minmax[1] ){
			                return false;
			            }
			            return true;
			        },
			        numberint : function(a){
			            if( isNaN(parseFloat(a)) && !isFinite(a) ){
			                return false;
			            }
			            else if(!isInt(a)){
			                return false;
			            }
			            else if( lengthRange && a.length < lengthRange[0] ){
			                return false;
			            }
			            else if( lengthRange && lengthRange[1] && a.length > lengthRange[1] ){
			                return false;
			            }
			            else if( minmax[0] && (a|0) < minmax[0] ){
			                return false;
			            }
			            else if( minmax[1] && (a|0) > minmax[1] ){
			                return false;
			            }
			            return true;
			        },
			        date : function(a){
			            var day, A = a.split(/[-./]/g), i;
			            if( field[0].valueAsNumber )
			                return true;

			            for( i = A.length; i--; ){
			                if( isNaN(parseFloat(a)) && !isFinite(a) )
			                    return false;
			            }
			            try{
			                day = new Date(A[2], A[1]-1, A[0]);
			                if( day.getMonth()+1 == A[1] && day.getDate() == A[0] )
			                    return day;
			                return false;
			            }
			            catch(er){
			                console.log('date test: ', err);
			                return false;
			            }
			        },
			        url : function(a){
			            function testUrl(url){
			                return /^(https?:\/\/)?([\w\d\-_]+\.+[A-Za-z]{2,})+\/?/.test( url );
			            }
			            if( !testUrl( a ) ){
			                return false;
			            }
			            return true;
			        },
			        hidden : function(a){
			            if( lengthRange && a.length < lengthRange[0] ){
			                return false;
			            }
			            if( pattern ){
			                var regex;
			                if( pattern == 'alphanumeric' ){
			                    regex = /^[a-z0-9]+$/i;
			                    if( !regex.test(a) ){
			                        return false;
			                    }
			                }
			            }
			            return true;
			        },
			        select : function(a){
			            if( !tests.hasValue(a) ){
			                return false;
			            }
			            return true;
			        }
			    };


			    function prepareFieldDataNoMsg(el){
			        field = $(el);

			        field.data( 'valid', true );                
			        field.data( 'type', field.attr('type') );   
			        pattern = field.attr('pattern');
			    }

			    function testByTypeNoMsg(type, value){
			        if( type == 'tel' )
			            pattern = pattern || 'phone';

			        if( !type || type == 'password' || type == 'tel' || type == 'search' || type == 'file' )
			            type = 'text';


			        return testsNoMsg[type] ? testsNoMsg[type](value, true) : true;
			    }

			   function checkFieldNoMsg(tabfields){
			        if( this.type !='hidden' && $(this).is(':hidden') )
			            return true;

			        
			        prepareFieldDataNoMsg(this);

			        field.data( 'val', field[0].value.replace(/^\s+|\s+$/g, "") );  // cache the value of the field and trim it
			        data = field.data();

			        if( field[0].nodeName.toLowerCase() === "select" ){
			            data.type = 'select';
			        }
			        else if( field[0].nodeName.toLowerCase() === "textarea" ){
			            data.type = 'text';
			        }

			        validateWords   = data['validateWords'] || 0;
			        lengthRange     = data['validateLengthRange'] ? (data['validateLengthRange']+'').split(',') : [1];
			        lengthLimit     = data['validateLength'] ? (data['validateLength']+'').split(',') : false;
			        minmax          = data['validateMinmax'] ? (data['validateMinmax']+'').split(',') : '';


			        data.valid = testsNoMsg.hasValue(data.val);



			        if( field.hasClass('optional') && !data.valid )
			            data.valid = true;

			        if( field[0].type === "checkbox" ){
			            data.valid = field[0].checked;
			        }

			        else if( data.valid ){


			            if( testsNoMsg.sameAsPlaceholder(field) ){
			                data.valid = false;

			            }

			            else if( data.valid || data.type == 'select' ){

			                data.valid = testByTypeNoMsg(data.type, data.val);
			            }



			        }
			        if( data.valid ){

			            submit = true;
			        }
			        else{
			            submit = false;
			        }

			        

			        return data.valid;
			    }


			    function validateTabsField(tabfields,empty_fields){
			    	
			    	tabfields.each(function(){
			    		if(document.getElementById(this).required && document.getElementById(this).value == ''){
			    			empty_fields = 0;
			    		}
			    		console.log('entro');
				    });
			    }


			    function validateNoMsgForm(formid,tabfields=[]){
			    	submit = false;
			    	submit_aux = false;
				    fieldsToCheck = $( "#"+formid ).find(':input').filter('[required=required], .required, .optional').not('[disabled=disabled]');
				    fieldsToCheck.each(function(){
				        submit_aux = submit_aux * checkFieldNoMsg.apply(this);
				    });

			     	var empty_fields = 1;
				    for(var tbl=0;tbl<tabfields.length;tbl++){
				    	if(document.getElementById(tabfields[tbl]).required && document.getElementById(tabfields[tbl]).value == ''){
				    		empty_fields = 0;
				    	}
				    }
				    
				    if(submit_aux==0 || $('#'+formid)[0].checkValidity()==false){
				      submit = false;
				      event.preventDefault();
				      
				      new PNotify({
	                    title: "Error",
	                    type: "error",
	                    text: "Los campos marcados en rojo son requeridos que debe llenar.",
	                    nonblock: {
	                      nonblock: true
	                    },

	                    styling: 'bootstrap3'
	                  });
				    }else{
				      $('#loadingmodal').modal('show');
				      submit = true;
				    }
				    return submit;  
			    }



			    function cleanTable(bdid){
		            var table = document.getElementById(bdid);
		               var rowCount = table.rows.length;

		            while(table.rows.length > 1) {

		              table.deleteRow(1);
		            }

		        }
		    </script>
        @show
	</body>
@endsection