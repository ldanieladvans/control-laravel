@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- Datatables -->
    <link href="{{ asset('controlassets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <!-- Select 2 -->
    <link href="{{ asset('controlassets/vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
	            <div class="x_title">
	                <h2>Editar Distribuidor</h2>
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
                	{{ Form::open(['route' => ['distributor.update', $distributor], 'class'=>'form-horizontal form-label-left']) }}
                		{{ Form::hidden('_method', 'PUT') }}
	                        <div class="item form-group">	                    
			                    <div class="col-md-9 col-sm-9 col-xs-12">
			                    	<input id="distrib_nom" class="form-control has-feedback-left" name="distrib_nom" placeholder="Nombre del Distribuidor *" required="required" type="text" value="{{ $distributor->distrib_nom }}" title="Nombre del Distribuidor">
			                    	<span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
			                    </div>
		                    </div>

		                    <div class="item form-group {{ $errors->has('distrib_rfc') ? 'bad' : '' }}">	                    
			                    <div class="col-md-9 col-sm-9 col-xs-12">
				                    <input id="distrib_rfc" class="form-control has-feedback-left" name="distrib_rfc" placeholder="RFC *" required="required" type="text" data-validate-words="1" value="{{ $distributor->distrib_rfc }}" title="RFC">
				                    <span class="fa fa-institution form-control-feedback left" aria-hidden="true"></span>
			                    </div>
			                    <div class="col-md-3 col-sm-3 col-xs-12">
		                            <span style="float: left; color: red;" id="span_distrib_rfc" {{$errors->has('distrib_rfc') ? '' : 'hidden'}}>
		                                {{ $errors->first('distrib_rfc') }}
		                            </span>
		                        </div>
		                    </div>

	                  	    <div class="item form-group">
			                    <div class="col-md-9 col-sm-9 col-xs-12">
				                    <input type="number" id="distrib_limitgig" name="distrib_limitgig" placeholder="Límite Gigas" data-validate-minmax="1,10000000000" class="form-control has-feedback-left" value="{{ $distributor->distrib_limitgig }}" title="Límite Gigas">
				                    <span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
			                    </div>
		                    </div>

		                    <div class="item form-group">
			                    <div class="col-md-9 col-sm-9 col-xs-12">
			                    	<input type="numberint" id="distrib_limitrfc" name="distrib_limitrfc" placeholder="Límite RFCs" data-validate-minmax="1,10000000000" class="form-control has-feedback-left" value="{{ $distributor->distrib_limitrfc }}" title="Límite RFCs">
			                    	<span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
			                    </div>
		                    </div>

		                    <div class="item form-group">	                    
			                    <div class="col-md-9 col-sm-9 col-xs-12">
				                    <input id="distrib_tel" class="form-control has-feedback-left" name="distrib_tel" placeholder="Teléfono *" required="required" type="tel" value="{{ $distributor->distrib_tel }}" title="Teléfono">
				                    <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
			                    </div>
		                    </div>

		                    <div class="item form-group">	                    
			                    <div class="col-md-9 col-sm-9 col-xs-12">
				                    <input id="distrib_correo" class="form-control has-feedback-left" name="distrib_correo" placeholder="Correo *" required="required" type="email" value="{{ $distributor->distrib_correo }}" title="Correo">
				                    <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
			                    </div>
		                    </div>

		                    <div class="item form-group">	                    
			                    <div class="col-md-9 col-sm-9 col-xs-12">
				                    <input id="distrib_nac" class="form-control has-feedback-left" name="distrib_nac" placeholder="Nacionalidad" type="text" value="{{ $distributor->distrib_nac }}" title="Nacionalidad">
				                    <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
			                    </div>
		                    </div>

		                    <div class="item form-group">
			                  	<label class="control-label col-md-1 col-sm-1 col-xs-12">Supervisor: </label>
			                    <div class="col-md-3 col-sm-3 col-xs-12">
			                        <p></p>
			                        Si:
			                        <input type="radio" class="flat" name="distrib_sup" id="supervisor1" value="1" {{$distributor->distrib_sup == true ? 'checked':''}}/> No:
			                        <input type="radio" class="flat" name="distrib_sup" id="supervisor0" value="0" {{$distributor->distrib_sup == false ? 'checked':''}}/>
			                    </div>
			                </div>

	                  	<div class="x_content">
	                      	<div class="" role="tabpanel" data-example-id="togglable-tabs">
		                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
			                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Domicilio</a>
			                        </li>
		                        </ul>

		                        <div id="myTabContent" class="tab-content">
			                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
		                        	    <div id="switch_new_dom">
			                        	  	<label class="control-label col-md-2 col-sm-2 col-xs-12">Nuevo Domicilio ?: </label>
					                        <div class="col-md-7 col-sm-7 col-xs-12">
					                            <div class="">
						                            <label>
						                            	<input type="checkbox" id="checkdom" name="checkdom" onchange="toggleCheckbox(this)" class="js-switch" {{$distributor->distrib_dom_id ? '':'checked'}} />
						                            </label>
					                            </div>
					                        </div>
		                        	    </div>

		                        	    </br>
		                        	    </br>

		                        	    <div id="dom_exits_data" {{$distributor->distrib_dom_id ? '':'hidden'}}>
			                        	  	<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
						                        <label class="control-label col-md-1 col-sm-1 col-xs-12">Domicilio: </label>
						                        <div class="col-md-11 col-sm-11 col-xs-12">
						                            <select class="js-example-basic-single js-states form-control" name="distrib_dom_id" id="distrib_dom_id" style="width: 100%; display: none;">
							                            <option value="">Seleccione ...</option>
							                            @foreach($domiciles as $domicile)
							                            	<option value="{{ $domicile->id }}" {{$distributor->distrib_dom_id == $domicile->id ? 'selected':''}}>{{ $domicile->dom_numext }} - {{ $domicile->dom_cp }} - {{ $domicile->dom_estado }} - {{ $domicile->dom_ciudad }} - {{ $domicile->dom_col }} - {{ $domicile->dom_pais }}</option>
							                            @endforeach
						                            </select>
						                        </div>
						                    </div>
		                        	    </div>

		                        	    <div id="dom_new_data" {{$distributor->distrib_dom_id ? 'hidden':''}}>
		                        	    	<div class="col-md-2 col-sm-2 col-xs-12">
						                        <input id="dom_search_cp" class="form-control has-feedback-left" name="dom_search_cp" placeholder="Buscar C.P." type="text" title="Buscar Código Postal">
						                        <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
						                    </div>

			                    	  		<div class="item form-group">
			                        	  		<div class="col-md-5 col-sm-5 col-xs-12 form-group ">
							                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Estado: </label>
							                        <div class="col-md-10 col-sm-10 col-xs-12">
								                        <select class="js-example-basic-single js-states form-control" name="dom_estado_aux" id="dom_estado_aux" style="width: 100%; display: none;">
								                            <option value="">Seleccione ...</option>
								                            <option value="AGU">Aguascalientes</option>
								                            <option value="BCN">Baja California</option>
								                            <option value="BCS">Baja California Sur</option>
								                            <option value="CAM">Campeche</option>
								                            <option value="CHP">Chiapas</option>
								                            <option value="CHH">Chihuahua</option>
								                            <option value="CMX">Ciudad de México</option>
								                            <option value="COA">Coahuila de Zaragoza</option>
								                            <option value="COL">Colima</option>
								                            <option value="DUR">Durango</option>
								                            <option value="GUA">Guanajuato</option>
								                            <option value="GRO">Guerrero</option>
								                            <option value="HID">Hidalgo</option>
								                            <option value="JAL">Jalisco</option>
								                            <option value="MEX">México</option>
								                            <option value="MIC">Michoacan de Ocampo</option>
								                            <option value="MOR">Morelos</option>
								                            <option value="NAY">Nayarit</option>
								                            <option value="NLE">Nuevo León</option>
								                            <option value="OAX">Oaxaca</option>
								                            <option value="PUE">Puebla</option>
								                            <option value="QUE">Querétaro de Arteaga</option>
								                            <option value="ROO">Quintana Roo</option>
								                            <option value="SLP">San Luis Potosí</option>
								                            <option value="SIN">Sinaloa</option>
								                            <option value="SON">Sonora</option>
								                            <option value="TAB">Tabasco</option>
								                            <option value="TAM">Tamaulipas</option>
								                            <option value="TLA">Tlaxcala</option>
								                            <option value="VER">Veracruz de Ignacio de la Llave</option>
								                            <option value="YUC">Yucatán</option>
								                            <option value="ZAC">Zacatecas</option>
								                        </select>
							                        </div>
							                    </div>

						                        <div class="col-md-5 col-sm-5 col-xs-12 form-group ">
							                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Municipio: </label>
							                        <div class="col-md-10 col-sm-10 col-xs-12">
							                            <select class="js-example-basic-single js-states form-control" name="dom_munic" id="dom_munic" style="width: 100%; display: none;">
							                            	<option value="">Seleccione ...</option>
							                            </select>
							                        </div>
						                        </div>

						                    </div>

						                    <div class="item form-group">	                    
							                    <div class="col-md-12 col-sm-12 col-xs-12">
							                    	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
			                                            <thead>
				                                            <tr>
				                                                <th align="left">Código Postal</th>
				                                                <th align="left">Estado</th>
				                                                <th align="left">Ciudad</th>
				                                                <th align="left">Asentamiento</th>
				                                                <th align="left">Tipo Asentamiento</th>
				                                                <th align="right">Seleccione</th>
				                                            </tr>
			                                            </thead>
			                                            <tbody>
			                                            </tbody>
			                                        </table>
							                    </div>
						                    </div>

				                            <div class="item form-group">
				                            	<div class="col-md-4 col-sm-4 col-xs-12 form-group ">
							                        <div class="col-md-12 col-sm-12 col-xs-12">
							                          	<select class="js-example-basic-single js-states form-control" name="dom_country" id="dom_country" style="width: 100%; display: none;">
							                            	<option value="">Seleccione ...</option>
							                            	@foreach($countries as $country)
								                            	<option value="{{ $country->c_char_code }}" {{ $country->c_char_code == 'MEX' ? 'selected' : '' }}>{{ $country->c_name_es }}</option>
								                            @endforeach
							                          	</select>
							                        </div>
						                        </div>							   

							                    <div class="col-md-4 col-sm-4 col-xs-12">
							                        <input id="dom_estado" class="form-control has-feedback-left" name="dom_estado" placeholder="Estado" required type="text">
							                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							                    </div>

							                    <div class="col-md-4 col-sm-4 col-xs-12">
							                        <input id="dom_ciudad" class="form-control has-feedback-left" name="dom_ciudad" placeholder="Ciudad" type="text">
							                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							                    </div>							                    
						                    </div>

						                    <div class="item form-group">
						                    	<div class="col-md-4 col-sm-4 col-xs-12">
							                    	<input id="dom_cp" class="form-control has-feedback-left" name="dom_cp" placeholder="Código Postal" required type="text">
							                    	<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							                    </div>

							                    <div class="col-md-4 col-sm-4 col-xs-12">
							                        <input id="dom_col" class="form-control has-feedback-left" name="dom_col" placeholder="Asentamiento" type="text">
							                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							                    </div>

							                  	<div class="col-md-4 col-sm-4 col-xs-12">
							                    	<input id="dom_calle" class="form-control has-feedback-left" name="dom_calle" placeholder="Calle" required type="text">
							                    	<span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							                    </div>
						                    </div>

					                  		<div class="item form-group">
						                  	  	<div class="col-md-6 col-sm-6 col-xs-12">
							                        <input id="dom_numext" class="form-control has-feedback-left" name="dom_numext" placeholder="# Ext" type="text">
							                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							                    </div>

							                    <div class="col-md-6 col-sm-6 col-xs-12">
							                        <input id="dom_numint" class="form-control has-feedback-left" name="dom_numint" placeholder="# Int" type="text">
							                        <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
							                    </div>					                  
						                    </div>
			                      		</div>
			                        </div>
		                        </div>
		                    </div>
	                	</div>

	                    <div class="ln_solid"></div>

	                    <div class="form-group">
	                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
	                        	<button id="cancel" type="button" onclick="location.href = '/directory/distributor';" class="btn btn-info">Cancelar</button>
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
    <!-- Datatables -->
    <script src="{{ asset('controlassets/vendors/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <!-- Select 2 -->
    <script src="{{ asset('controlassets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript">
    	var dom_estado_serv = '';
    	var dom_munic_serv = '';
    	var dom_cp_serv = '';
    	var dom_munic_text = '';
    	var dtobj = null;

    	$("#dom_country").select2({
		  	placeholder: "Selecciona el país",
		  	allowClear: true
		});

		$("#dom_estado_aux").select2({
		  	placeholder: "Selecciona el estado",
		  	allowClear: true
		});

		$("#dom_munic").select2({
		  	placeholder: "Selecciona el municipio",
		  	allowClear: true
		});

		$("#distrib_dom_id").select2({
		  	placeholder: "Selecciona el domicilio",
		  	allowClear: true
		});

		document.getElementById('dom_search_cp').onkeypress = function(e){
		    if (!e) e = window.event;
		    var keyCode = e.keyCode || e.which;
		    if (keyCode == '13'){
		    	$('#loadingmodal').modal('show');
		    	if(this.value!=''){
		    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		    		$.ajax({
		                url: '/getcpdata',
	                	type: 'POST',
	                	data: {_token: CSRF_TOKEN,dommunicserv:dom_munic_serv,domestadoserv:dom_estado_serv,cp:document.getElementById("dom_search_cp").value},
		                dataType: 'JSON',
		                success: function (data) {
		                	
	                	    $('#loadingmodal').modal('hide');

		                    var dataTablevalues = [];
		                    var table_counter = 0;

		                    data['tabledata'].forEach(function(item){
		                        dataTablevalues.push([item.d_codigo,item.d_estado,item.d_ciudad,item.d_asenta,item.d_tipo_asenta,"<div class='btn-group'><div class='btn-group'><a id='accbtn"+item.id+"' onclick='getRowData("+table_counter+")' class='btn btn-xs' data-placement='left' title='Seleccionar' ><i class='fa fa-check fa-2x'></i> </a></div>"]);
		                        table_counter ++;
		                    });

		                    $('#datatable-responsive').dataTable().fnDestroy();
		                    dtobj = $('#datatable-responsive').DataTable( {
					        	data: dataTablevalues,
					        });
		                },
		                error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                    new PNotify({
		                    title: "Notificación",
		                    type: "info",
		                    text: "Ha ocurrido un error",
		                    nonblock: {
		                      nonblock: true
		                    },
		                    addclass: 'dark',
		                    styling: 'bootstrap3'
		                  });
		                }
		            });
		    	}
		    }

		}

    	$("#distrib_rfc").on('change', function(){
			document.getElementById("span_distrib_rfc").setAttribute('hidden','1');
    	});

		function toggleCheckbox(element){
		    element.checked = !element.checked;
		    if (element.checked){
	   			$("#dom_new_data").show();
	   			$("#dom_exits_data").hide();
	   			document.getElementById("dom_calle").required = true;
		    }else{
		   		$("#dom_new_data").hide();
		   		$("#dom_exits_data").show();
		   		document.getElementById("dom_calle").required = false;
		    }
		}

		$("#dom_estado_aux").on('change', function(){
			var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			dom_estado_serv = this.value;

    		$("#dom_munic option").each(function() {
				$(this).remove();
			});

			$('#dom_munic').append($('<option>', {
			    value: '',
			    text: 'Seleccione ...'
			}));

    		if(this.value!=''){
    		  	$('#loadingmodal').modal('show');
	            $.ajax({
	                url: '/getcpdata',
	                type: 'POST',
	                data: {_token: CSRF_TOKEN,domestadoserv:this.value,cp:document.getElementById("dom_search_cp").value,dommunicserv:dom_munic_serv},
	                dataType: 'JSON',
	                success: function (data) {
                	    $('#loadingmodal').modal('hide');
	                  
	                    data['munics'].forEach(function(item){
		                  	$('#dom_munic').append($('<option>', {
							    value: item.m_code,
							    text: item.m_description
							}));
	                    });

	                    var dataTablevalues = [];
	                    var table_counter = 0;

	                    data['tabledata'].forEach(function(item){
	                        /*$('#datatable-responsive').find('tbody').append( "<tr><td id='d_codigo"+item.id+"'>"+item.d_codigo+"</td><td id='d_estado"+item.id+"'>"+item.d_estado+"</td><td id='d_ciudad"+item.id+"'>"+item.d_ciudad+"</td><td id='d_asenta"+item.id+"'>"+item.d_asenta+"</td><td id='d_tipo_asenta"+item.id+"'>"+item.d_tipo_asenta+"</td><td><div class='btn-group'><div class='btn-group'><a id='accbtn"+item.id+"' onclick='unlockUsers("+'"'+item.id+'"'+")' class='btn btn-xs' data-placement='left' title='Seleccionar' ><i class='fa fa-unlock fa-2x'></i> </a></div></td></tr>");*/
	                        dataTablevalues.push([item.d_codigo,item.d_estado,item.d_ciudad,item.d_asenta,item.d_tipo_asenta,"<div class='btn-group'><div class='btn-group'><a id='accbtn"+item.id+"' onclick='getRowData("+table_counter+")' class='btn btn-xs' data-placement='left' title='Seleccionar' ><i class='fa fa-check fa-2x'></i> </a></div>"]);
	                        table_counter ++;
	                    });

	                    $('#datatable-responsive').dataTable().fnDestroy();
	                    dtobj = $('#datatable-responsive').DataTable( {
				        	data: dataTablevalues,
				    	});
	                },
	                error: function(XMLHttpRequest, textStatus, errorThrown) { 
	                    new PNotify({
	                    title: "Notificación",
	                    type: "info",
	                    text: "Ha ocurrido un error",
	                    nonblock: {
	                      nonblock: true
	                    },
	                    addclass: 'dark',
	                    styling: 'bootstrap3'
	                  });
	                }
	            });
    		}       
    	});


		$("#dom_munic").on('change', function(){
    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    		var table = document.getElementById('datatable-responsive');
	        var rowCount = table.rows.length;

	        while(table.rows.length > 1){
	        	table.deleteRow(1);
	        }

    		dom_munic_serv = this.value;
    		dom_munic_text = this.text;

    		if(this.value!=''){
    		  	$('#loadingmodal').modal('show');
	            $.ajax({
	                url: '/getcpdata',
	                type: 'POST',
	                data: {_token: CSRF_TOKEN,dommunicserv:dom_munic_serv,domcpserv:dom_cp_serv,domestadoserv:dom_estado_serv,cp:document.getElementById("dom_search_cp").value},
	                dataType: 'JSON',
	                success: function (data) {
                	    $('#loadingmodal').modal('hide');

	                    var dataTablevalues = [];
	                    var table_counter = 0;

	                    data['tabledata'].forEach(function(item){
	                        /*$('#datatable-responsive').find('tbody').append( "<tr><td id='d_codigo"+item.id+"'>"+item.d_codigo+"</td><td id='d_estado"+item.id+"'>"+item.d_estado+"</td><td id='d_ciudad"+item.id+"'>"+item.d_ciudad+"</td><td id='d_asenta"+item.id+"'>"+item.d_asenta+"</td><td id='d_tipo_asenta"+item.id+"'>"+item.d_tipo_asenta+"</td><td><div class='btn-group'><div class='btn-group'><a id='accbtn"+item.id+"' onclick='unlockUsers("+'"'+item.id+'"'+")' class='btn btn-xs' data-placement='left' title='Seleccionar' ><i class='fa fa-unlock fa-2x'></i> </a></div></td></tr>");*/
	                        dataTablevalues.push([item.d_codigo,item.d_estado,item.d_ciudad,item.d_asenta,item.d_tipo_asenta,"<div class='btn-group'><div class='btn-group'><a id='accbtn"+item.id+"' onclick='getRowData("+table_counter+")' class='btn btn-xs' data-placement='left' title='Seleccionar' ><i class='fa fa-check fa-2x'></i> </a></div>"]);
	                        table_counter ++;
	                    });

	                    $('#datatable-responsive').dataTable().fnDestroy();
	                    dtobj = $('#datatable-responsive').DataTable( {
				        	data: dataTablevalues,
				        });
	                },
	                error: function(XMLHttpRequest, textStatus, errorThrown) { 
	                    new PNotify({
	                    title: "Notificación",
	                    type: "info",
	                    text: "Ha ocurrido un error",
	                    nonblock: {
	                      nonblock: true
	                    },
	                    addclass: 'dark',
	                    styling: 'bootstrap3'
	                  });
	                }
	            });
    		}    
    	});

	    function getRowData(table_counter){
	    	var rowdata = [];
	    	if(dtobj){
	    		rowdata = dtobj.row(table_counter).data();
				document.getElementById('dom_cp').value = rowdata[0];
				document.getElementById('dom_col').value = rowdata[3];
				if(rowdata[2]!=''){
					document.getElementById('dom_ciudad').value = rowdata[2];
				}else{
					document.getElementById('dom_ciudad').value = $('#dom_munic option:selected').text();
				}
				document.getElementById('dom_estado').value = rowdata[1];
			}
	    } 
	</script>
@endsection

