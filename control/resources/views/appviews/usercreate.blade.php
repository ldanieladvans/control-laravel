@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- File Input -->
    <link href="{{ asset('controlassets/vendors/bootstrap-fileinput-master/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- Chosen -->
    <link href="{{ asset('controlassets/vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select 2 -->
    <link href="{{ asset('controlassets/vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
    <style>
	.kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
	    margin: 0;
	    padding: 0;
	    border: none;
	    box-shadow: none;
	    text-align: center;
	}
	.kv-avatar .file-input {
	    display: table-cell;
	    max-width: 220px;
	}
	.kv-reqd {
	    color: red;
	    font-family: monospace;
	    font-weight: normal;
	}
	</style>
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
	                <h2>Nuevo Usuario</h2>
	                <ul class="nav navbar-right panel_toolbox">
	                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	                </ul>
	                <div class="clearfix"></div>
                </div>
              	@if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
	                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
	                    </button>
	                    <strong>{{ Session::get('message') }}</strong>
                    </div>
              	@endif

                <div class="x_content">
                	<form id="usercreateform" class="form-horizontal form-label-left" novalidate action="{{ route('user.store') }}" method='POST' enctype="multipart/form-data">
                		{{ csrf_field() }}

	                	<div id="invimg">
	                		<img id='imageiddef' src="{{asset('default_avatar_male.jpg')}}">
	                		<img id='imageid' src="{{asset('default_avatar_male.jpg')}}">
	                		<input id="deleted_pic" name="deleted_pic" type="text" value="0">
	                	</div>

	                	<table border="0" class="col-md-12 col-sm-12 col-xs-12">
							<tr>
								<td width="25%">
									<div class="row">
								        <div class="col-md-3 col-sm-3 col-xs-12">
								            <div class="kv-avatar center-block text-center" style="width:200px">
								                <input id="avatar-2" value="{{asset('default_avatar_male.jpg')}}" name="usrc_pic" type="file" class="file-loading">
								            </div>
								        </div>
				            		</div>
								</td>
								<td>
									<div class="item form-group">
					                    <div class="col-md-9 col-sm-9 col-xs-12">
					                        <input id="name" class="form-control has-feedback-left" name="name" placeholder="Nombre del Usuario *" required="required" type="text">
					                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					                        @if ($errors->has('name'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('name') }}</strong>
			                                    </span>
			                                @endif
					                    </div>
				                    </div>
				                    <div class="item form-group">	                    
					                    <div class="col-md-9 col-sm-9 col-xs-12">
					                        <input id="usrc_nick" class="form-control has-feedback-left" name="usrc_nick" placeholder="Usuario *" required="required" type="text" data-validate-words="1" value="" autocomplete="off">
					                        <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
					                        @if ($errors->has('usrc_nick'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('usrc_nick') }}</strong>
			                                    </span>
			                                @endif
					                    </div>
					                </div>
					                <div class="item form-group">	                    
					                    <div class="col-md-9 col-sm-9 col-xs-12">
					                        <input id="password" class="form-control has-feedback-left" value="" name="password" placeholder="Contraseña *" required="required" type="password" data-validate-words="1" autocomplete="off">
					                        <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
					                        @if ($errors->has('password'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('password') }}</strong>
			                                    </span>
			                                @endif
					                    </div>
					                </div>
					                <div class="item form-group">	                    
					                    <div class="col-md-9 col-sm-9 col-xs-12">
					                      	<input id="password-confirm" class="form-control has-feedback-left" value="" name="password_confirmation" placeholder="Confirmar Contraseña *" required="required" type="password" data-validate-words="1" autocomplete="off">
					                      	<span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
					                    </div>
					                </div>
					                 <div class="item form-group">	                    
					                    <div class="col-md-9 col-sm-9 col-xs-12">
					                      	<input id="email" class="form-control has-feedback-left" name="email" placeholder="Correo *" required="required" type="email">
					                      	<span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
					                      	@if ($errors->has('email'))
			                                    <span class="help-block">
			                                        <strong>{{ $errors->first('email') }}</strong>
			                                    </span>
			                                @endif
					                    </div>
				                     </div>

				                     <div class="item form-group">	                    
					                    <div class="col-md-9 col-sm-9 col-xs-12">
					                        <input id="usrc_tel" class="form-control has-feedback-left" name="usrc_tel" placeholder="Teléfono *" type="tel">
					                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
					                    </div>
				                    </div>
								</td>
							</tr>
						</table>

						<div class="col-md-12 col-sm-12 col-xs-12">
							</br>
							</br>
						</div>
                    
		                <div class="item form-group">
		                <label class="control-label col-md-1 col-sm-1 col-xs-12">Supervisor: </label>
	                        <div class="col-md-1 col-sm-1 col-xs-12">
		                        <p></p>
		                        Si:
		                        <input type="radio" class="flat" name="usrc_super" id="usrc_super1" value="1"  /> No:
		                        <input type="radio" class="flat" name="usrc_super" id="usrc_super0" value="0" checked/>
	                        </div>

	                        <label class="control-label col-md-1 col-sm-1 col-xs-12">Tipo de Usuario: </label>
		                    <div class="col-md-2 col-sm-2 col-xs-12">
		                        <select class="js-example-basic-single js-states form-control" name="usrc_type" id="usrc_type" required>
			                        <option value="app" selected>Aplicación</option>
			                        <option value="api">Servicio</option>
		                        </select>
		                  	</div>

			                <label class="control-label col-md-2 col-sm-2 col-xs-12">Distribuidor Asociado: </label>
		                    <div class="col-md-2 col-sm-2 col-xs-12">
		                        <select class="js-example-basic-single js-states form-control" name="usrc_distrib_id" id="usrc_distrib_id" required>
			                        <option value="">Seleccione una opción ...</option>
			                        @foreach($distributors as $distributor)
		                            	<option value="{{ $distributor->id }}">{{ $distributor->distrib_nom }}</option>
		                            @endforeach
		                        </select>
		                  	</div>
			            </div>


                  	  	<div class="x_content" id="usrctabcontainer">
                      		<div class="" role="tabpanel" data-example-id="togglable-tabs">
			                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Roles y Permisos</a>
			                        </li>
			                    </ul>

			                    <div id="myTabContent" class="tab-content">
			                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
										<div class="item form-group">
							                <div class="col-md-10 col-sm-10 col-xs-12">
							                    <select id="roles" name="roles[]" tabindex="1" data-placeholder="Seleccione los roles ..." class="js-example-basic-multiple" onchange="onSelectUserCreate(this)" multiple="multiple" style="width: 100%; display: none;">
							                        @foreach($roles as $role)
														<option value="{{ $role->id }}">{{ $role->name }}</option>
													@endforeach
							                    </select>
							                </div>
							            </div>

							            <div class="item form-group">
						                    <div class="col-md-10 col-sm-10 col-xs-12">
						                        <select id="permisos" name="permisos[]" tabindex="2" data-placeholder="Seleccione los permisos ..." class="js-example-basic-multiple" multiple="multiple" style="width: 100%; display: none;">
													@foreach($permissions as $permission)
						                            	<option value="{{ $permission->id }}">{{ $permission->name }}</option>
						                            @endforeach
						                      </select>
						                  	</div>
							            </div>
			                        </div>
			                    </div>
	                        </div>
                	    </div>

                        <div class="ln_solid"></div>
	                    <div class="form-group">
	                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
	                            <button id="cancel" type="button" onclick="location.href = '/security/user';" class="btn btn-info">Cancelar</button>
	                            <button type="reset" class="btn btn-primary">Borrar Datos</button>
	                  		    <button id="send" type="submit" class="btn btn-success">Guardar</button>
	                        </div>
	                    </div>
                    </form>
                </div>
            </div>
         </div>
    </div>
</div>
@endsection

@section('app_js') 
	@parent
    <!-- validator -->
    <script src="{{ asset('controlassets/vendors/validator/control.validator.js') }}"></script>
    <!-- Date Time -->
    <script type="text/javascript" src="{{ asset('controlassets/vendors/datetime/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
	<script type="text/javascript" src="{{ asset('controlassets/vendors/datetime/js/locales/bootstrap-datetimepicker.es.js') }}" charset="UTF-8"></script>
	<!-- Switchery -->
    <script src="{{ asset('controlassets/vendors/switchery/dist/switchery.min.js') }}"></script>
    <!-- File Input -->
    <script src="{{ asset('controlassets/vendors/bootstrap-fileinput-master/js/fileinput.js') }}" type="text/javascript"></script>
	<!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
    <!-- Chosen -->
	<script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
	<script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
	<!-- Select 2 -->
    <script src="{{ asset('controlassets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript">

    	$("#usrc_distrib_id").select2({
		  	placeholder: "Selecciona el dictribuidor asociado",
		  	allowClear: true
		});

		$("#roles").select2({
            placeholder: "Selecciona los roles",
            allowClear: true
        });
        
        $("#permisos").select2({
            placeholder: "Selecciona los permisos",
            allowClear: true
        });

    	function getSelectValues(select){
		    var result = [];
		    var options = select && select.options;
		    var opt;
		    for (var i=0, iLen=options.length; i<iLen; i++){
		    	opt = options[i];
		    	if (opt.selected) {
		      		result.push(opt.value || opt.text);
		    	}
		    }
		    return result;
		}
		 
		function onSelectUserCreate(element){
		 	var selected = getSelectValues(element);		 	
		 	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		 	$.ajax({
			    url: 'permsbyroles',
			    type: 'POST',
			    data: {_token: CSRF_TOKEN,selected:selected},
			    dataType: 'JSON',
			    success: function (data) {
			    	var roles = [];
			    	var perms = document.getElementById('permisos').options;
			    	data['roles'].forEach(function(entry) {
			    		roles.push(entry);
					    for(var i=0;i<perms.length;i++){
					    	if(String(perms[i].value)==String(entry)){
				    			perms[i].selected=true;
					    	}
					    }
					});
			    	$('#permisos').trigger("chosen:updated");
			    }
			});
		}

		var imgdiv = document.getElementById("invimg");
		var form = document.getElementById("usercreateform");
		form.reset();
		imgdiv.style.display='none';

		$("#avatar-2").fileinput({
		    overwriteInitial: true,
		    maxFileSize: 1500,
		    showClose: true,
		    showCaption: false,
		    showUpload: false,
		    showBrowse: true,
		    browseOnZoneClick: true,
		    removeLabel: '',
		    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
		    removeTitle: 'Cancel or reset changes',
		    elErrorContainer: '#kv-avatar-errors-2',
		    msgErrorClass: 'alert alert-block alert-danger',
		    defaultPreviewContent: "<img src={{asset('default_avatar_male.jpg')}} alt='Your Avatar' style='width:160px'><h6 class='text-muted'>Click to select</h6>",
		    layoutTemplates: {main2: '{preview} {remove} {browse}'},
		    browseLabel: 'Foto Usuario',
		    allowedFileExtensions: ["jpg", "png", "gif"]
		});

		$('#usrc_type').change(function(){
            if(this.value=="api"){
                document.getElementById('usrctabcontainer').setAttribute('hidden',true);
            }else{
              document.getElementById('usrctabcontainer').removeAttribute('hidden');
            }
        });
	</script>
@endsection

