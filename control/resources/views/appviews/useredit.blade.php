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
	                <h2>Editar Usuario</h2>
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

                <div class="btn-group">
                    <button onclick="showModal('passmodal-profile')" class="btn btn-info" data-placement="left" title="Cambiar contraseña">Cambiar Contraseña</button>

                    <div class="modal fade" id="passmodal-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Cambio de contraseña: {{$user->name}}</h5>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="form-group">
                                            <input placeholder="Contraseña" required="required" type="password" class="form-control" id="password{{$user->id}}" style="width: 500px;">
                                        </div>
                                    </form>
                                    <div id="result_failure{{$user->id}}"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="cleanPass({{$user->id}});" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="button"  onclick="changePass({{$user->id}});" class="btn btn-primary">Ok</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

              	<div class="x_content">
                	{{ Form::open(['route' => ['user.update', $user], 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal form-label-left']) }}
                		{{ Form::hidden('_method', 'PUT') }}


                		<table border="0" class="col-md-12 col-sm-12 col-xs-12">
							<tr>
								<td width="20%">
									<div class="row">
								        <div class="col-md-2 col-sm-2 col-xs-2">
					                		<div id="imgcontainer" class="file-preview-frame">
						                		<img id='imageiddef' src="{{asset('default_avatar_male.jpg')}}" hidden>
						                		<img id="blah" alt="your image" width="150" height="150" src="{{$user->usrc_pic ? asset('storage/'.$user->usrc_pic) : asset('default_avatar_male.jpg')}}" />
						                		<input type="hidden" name="checkpic" id="checkpic" value="{{$user->usrc_pic ? 1 : 0}}">
						                		<button id="cleanpic" type="button" onclick="cleanFunc();"  class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
						                	</div>
						                	
					                	</div>
				            		</div>
								</td>
								<td>
									<div class="item form-group">
					                    <div class="col-md-9 col-sm-9 col-xs-12">
					                        <input id="name" class="form-control has-feedback-left" name="name" placeholder="Nombre del Usuario *" required="required" type="text" value="{{$user->name}}">
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
					                        <input id="usrc_nick" class="form-control has-feedback-left" name="usrc_nick" placeholder="Usuario *" required="required" type="text" data-validate-words="1" value="{{$user->usrc_nick}}" autocomplete="off">
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
					                        <input id="email" class="form-control has-feedback-left" name="email" placeholder="Correo *" required="required" type="email" value="{{$user->email}}">
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
					                        <input id="usrc_tel" class="form-control has-feedback-left" name="usrc_tel" placeholder="Teléfono *" type="tel" value="{{$user->usrc_tel}}">
					                        <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
					                    </div>
			                        </div>
					    		</td>
							</tr>
							<tr>
								<td>
									<div id="fileinputcontainer" class="col-md-6 col-sm-6 col-xs-6">
			                			<input id="usrc_pic" name="usrc_pic" style='position:absolute;z-index:2;top:0;' type="file"/>
			                		</div>
								</td>
								<td></td>
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
		                        <input type="radio" class="flat" name="usrc_super" id="usrc_super1" value="1" {{$user->usrc_super == '1' ? 'checked':''}} /> No:
		                        <input type="radio" class="flat" name="usrc_super" id="usrc_super0" value="0" {{$user->usrc_super == '0' ? 'checked':''}}/>
		                    </div>

		                    <label class="control-label col-md-1 col-sm-1 col-xs-12">Tipo de Usuario: </label>
		                    <div class="col-md-2 col-sm-2 col-xs-12">
		                        <select class="js-example-basic-single js-states form-control" name="usrc_type" id="usrc_type" disabled>
			                        <option value="app" {{$user->usrc_type=='app' ? 'selected' : ''}}>Aplicación</option>
			                        <option value="api" {{$user->usrc_type=='api' ? 'selected' : ''}}>Servicio</option>
		                        </select>
		                  	</div>

			                <label class="control-label col-md-2 col-sm-2 col-xs-12">Distribuidor Asociado: </label>
		                    <div class="col-md-2 col-sm-2 col-xs-12">
			                    <select class="js-example-basic-single js-states form-control" name="usrc_distrib_id" id="usrc_distrib_id" required>
			                        <option value="">Seleccione una opción ...</option>
			                        @foreach($distributors as $distributor)
		                            	<option value="{{ $distributor->id }}" {{$distributor->id == $user->usrc_distrib_id ? 'selected':''}} >{{ $distributor->distrib_nom }}</option>
		                            @endforeach
			                    </select>
			                </div>
			            </div>

                  	    @if(Auth::user()->usrc_admin || Auth::user()->can('assign.roles.users') || Auth::user()->can('assign.perms.users'))
	                  	    <div class="x_content">
	                        	<div class="" role="tabpanel" data-example-id="togglable-tabs">
				                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
				                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Roles y Permisos</a>
				                        </li>
				                    </ul>

		                      		<div id="myTabContent" class="tab-content">
										<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
											
											@if(Auth::user()->usrc_admin || Auth::user()->can('assign.roles.users'))
												<div class="item form-group">
									                <div class="col-md-10 col-sm-10 col-xs-12">
									                    <select id="roles" name="roles[]" tabindex="1" data-placeholder="Seleccione los roles ..." name="rolesapp" class="js-example-basic-multiple" onchange="onSelectUserCreate(this)" multiple="multiple" style="width: 100%; display: none;">
									                        @foreach($roles as $role)
																<option value="{{ $role->id }}" {{$user->hasRole($role->id) ? 'selected':''}} >{{ $role->name }}</option>
															@endforeach
									                    </select>
									                </div>
									            </div>
								            @endif

								            @if(Auth::user()->usrc_admin || Auth::user()->can('assign.perms.users'))
									            <div class="item form-group">
									                <div class="col-md-10 col-sm-10 col-xs-12">
									                    <select id="permisos" name="permisos[]" tabindex="2" data-placeholder="Seleccione los permisos ..." class="js-example-basic-multiple" multiple="multiple" style="width: 100%; display: none;">
															@foreach($permissions as $permission)
								                            	<option value="{{ $permission->id }}" {{$user->customGetUserPerms($permission->id,true) ? 'selected':''}} >{{ $permission->name }}</option>
								                            @endforeach
									                    </select>
									                </div>
									            </div>
								            @endif
		                        		</div>
		                      		</div>
		                    	</div>
	            			</div>
            			@endif

                      	<div class="ln_solid"></div>
                     	<div class="form-group">
                        	<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          		<button id="cancel" type="button" onclick="location.href = '/security/user';" class="btn btn-info">Cancelar</button>
                  		  		<button id="send" type="submit" class="btn btn-success">Guardar</button>
                        	</div>
              			</div>
                    {{ Form::close() }}
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
	<!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
    <!-- Chosen -->
	<script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
	<script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
	<!-- Select 2 -->
    <script src="{{ asset('controlassets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript">

    	function showModal(modalid) {
            $("#"+modalid).modal('show');
            $("#"+modalid).on('shown.bs.modal', function () {
            $('.chosen-select', this).chosen('destroy').chosen();
                var comparerolesmodal = modalid.search("rolesmodal");
                var comparepermsmodal = modalid.search("permsmodal");
                if(comparerolesmodal >= 0){
                    selectedrol = $('.chosen-select', this).chosen().val() ;
                }
                if(comparepermsmodal >= 0){
                    selectedperm = $('.chosen-select', this).chosen().val() ;
                }
            });
        }

        function hideModal(modalid) {
          $("#"+modalid).modal('hide');
        }

        function changePass(user){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var passid = "password"+user;
            var password = document.getElementById(passid).value;

            hideModal("passmodal-profile");
            $('#loadingmodal').modal('show');

            if(password){
                $.ajax({
                    url: '/security/user/changepass',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN,password:password,user:user},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#loadingmodal').modal('hide');
                        new PNotify({
                            title: "Notificación",
                            type: "info",
                            text: "La contraseña ha sido cambiada satisfactoriamente",
                            nonblock: {
                                nonblock: true
                            },
                            addclass: 'dark',
                            styling: 'bootstrap3'
                        });
                      document.getElementById('password'+data['user']).value = '';
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                    }
                });
            }else{
              $("#result_failure"+user).html('<p><strong>La contraseña es obligatoria</strong></p>');
            }        
        }

        function cleanPass(userid){
	      document.getElementById('password'+userid).value = '';
	    }

    	function cleanFunc(){
			$("#blah").attr("src", document.getElementById('imageiddef').src);
			$("#usrc_pic").val('');
			document.getElementById('checkpic').value = 0;
    	}


    	$("#usrc_pic").on('change', function () {

		     var countFiles = $(this)[0].files.length;
		     console.log();
		     var imgPath = $(this)[0].value;
		     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();


		     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
		         if (typeof (FileReader) != "undefined") {
		             for (var i = 0; i < countFiles; i++) {

		                 var reader = new FileReader();
		                 reader.onload = function (e) {
		                     $("#blah").attr("src", e.target.result);
		                 }
		                 reader.readAsDataURL($(this)[0].files[i]);
		                 document.getElementById('checkpic').value = 1;
		             }

		         } else {
		             alert("This browser does not support FileReader.");
		         }
		     } else {
		         alert("Pls select only images");
		     }
		 });

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
		    	if (opt.selected){
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
			    success: function (data){
			    	console.log(data);
			    	var roles = [];
			    	var perms = document.getElementById('permisos').options;
			    	data['roles'].forEach(function(entry){
			    		roles.push(entry);
					    for(var i=0;i<perms.length;i++){
					    	if(String(perms[i].value)==String(entry)){
				    			perms[i].selected=true;
					    	}
					    }
					    $("#permisos").select2({
				            placeholder: "Selecciona los permisos",
				            allowClear: true
				        });
					});
			    	$('#permisos').trigger("chosen:updated");
			    }
			});
		}

	</script>
@endsection

