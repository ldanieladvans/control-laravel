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


@endsection

@section('app_content')
<div class="container">
	
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Nuevo Cliente</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
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



                <!--<form class="form-horizontal form-label-left input_mask">-->
                <form class="form-horizontal form-label-left" novalidate action="{{ route('client.store') }}" method='POST' enctype="multipart/form-data">

                	  {{ csrf_field() }}

                      <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="cliente_nom" class="form-control has-feedback-left" name="cliente_nom" placeholder="Nombre del Cliente *" required="required" type="text">
	                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="cliente_correo" class="form-control has-feedback-left" name="cliente_correo" placeholder="Correo *" required="required" type="email">
	                      <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="cliente_tel" class="form-control has-feedback-left" name="cliente_tel" placeholder="Teléfono *" required="required" type="tel">
	                      <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group {{ $errors->has('cliente_rfc') ? 'bad' : '' }}">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="cliente_rfc" class="form-control has-feedback-left" name="cliente_rfc" placeholder="RFC *" required="required" type="text"  value="{{ old('cliente_rfc') }}" data-validate-rfc="1">
	                      <span class="fa fa-institution form-control-feedback left" aria-hidden="true"></span>

	                    </div>
	                    
	                   <div class="col-md-3 col-sm-3 col-xs-12">
                            <span style="float: left; color: red;" id="span_cliente_rfc" {{$errors->has('cliente_rfc') ? '' : 'hidden'}}>
                                {{ $errors->first('cliente_rfc') }}
                            </span>
                        </div>

	                  </div>

	                  <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="cliente_nac" class="form-control has-feedback-left" name="cliente_nac" placeholder="Nacionalidad" type="text">
	                      <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">
		                <label class="control-label col-md-1 col-sm-1 col-xs-12">Tipo: </label>
		                    <div class="col-md-3 col-sm-3 col-xs-12">
		                      <select class="select2_single form-control col-md-7 col-xs-12" name="cliente_tipo">
		                        <option value="">Seleccione una opción ...</option>
		                        <option value="moral">Moral</option>
                            	<option value="fisica">Física</option>
		                      </select>
		                  	</div>

	                  	<!--<label class="control-label col-md-1 col-sm-1 col-xs-12">Género: </label>
	                      <div class="col-md-3 col-sm-3 col-xs-12">
	                       <p></p>
	                        M:
	                        <input type="radio" class="flat" name="gender" id="genderM" value="M" checked="" required /> F:
	                        <input type="radio" class="flat" name="gender" id="genderF" value="F" />
	                      </div>-->
		              </div>


                  	<div class="x_content">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
	                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
	                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Domicilio</a>
	                        </li>
	                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Referencia</a>
	                        </li>
	                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="cert-tab" data-toggle="tab" aria-expanded="false">Vigencia Certificado</a>
	                        </li>
	                      </ul>
	                      <div id="myTabContent" class="tab-content">

	                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                        	  <div id="switch_new_dom">
                        	  	<label class="control-label col-md-2 col-sm-2 col-xs-12">Nuevo Domicilio ?: </label>
		                        <div class="col-md-7 col-sm-7 col-xs-12">
		                          <div class="">
		                            <label>
		                              <input type="checkbox" id="checkdom" name="checkdom" onchange="toggleCheckbox(this)" class="js-switch" checked="checked" />
		                            </label>
		                          </div>
		                          
		                        </div>
                        	  </div>

                        	  </br>
                        	  </br>

                        	  <div id="dom_exits_data" hidden>
                        	  	<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
			                        <label class="control-label col-md-1 col-sm-1 col-xs-12">Domicilio: </label>
			                        <div class="col-md-11 col-sm-11 col-xs-12">
			                          <select class="form-control" name="cliente_dom_id">
			                            <option value="null">Seleccione ...</option>
			                            @foreach($domiciles as $domicile)
			                            	<option value="{{ $domicile->id }}">{{ $domicile->dom_calle }} - {{ $domicile->dom_col }} - {{ $domicile->dom_numetx ? $domicile->dom_numetx : $domicile->dom_numint }}</option>
			                            @endforeach
			                          </select>
			                        </div>
			                      </div>
                        	  </div>

                        	  <div id="dom_new_data">

                        	  		<div class="item form-group">

                        	  		<div class="col-md-6 col-sm-6 col-xs-12 form-group ">
					                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Estado: </label>
					                        <div class="col-md-8 col-sm-8 col-xs-12">
					                          <select class="form-control" name="dom_estado" id="dom_estado">
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

				                        <div class="col-md-6 col-sm-6 col-xs-6 form-group ">
					                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Municipio: </label>
					                        <div class="col-md-8 col-sm-8 col-xs-12">
					                          <select class="form-control" name="dom_munic" id="dom_munic">
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
				                    <div class="col-md-9 col-sm-9 col-xs-12">
				                      <input id="dom_calle" class="form-control has-feedback-left" name="dom_calle" placeholder="Calle" required type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>

				                    <div class="col-md-3 col-sm-3 col-xs-12">
					                      <input id="dom_cp" class="form-control has-feedback-left" name="dom_cp" placeholder="Código Postal" required type="text">
					                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
					                    </div>
				                  </div>

				                  <div class="item form-group">	                    
				                    <div class="col-md-5 col-sm-5 col-xs-12">
				                      <input id="dom_numext" class="form-control has-feedback-left" name="dom_numext" placeholder="# Ext" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>

				                    <div class="col-md-4 col-sm-4 col-xs-12">
				                      <input id="dom_numint" class="form-control has-feedback-left" name="dom_numint" placeholder="# Int" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>
				                  </div>

			                  	  <div class="item form-group">	                    
				                    <div class="col-md-5 col-sm-5 col-xs-12">
				                      <input id="dom_col" class="form-control has-feedback-left" name="dom_col" placeholder="Colonia" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>

				                    <div class="col-md-4 col-sm-4 col-xs-12">
				                      <input id="dom_ciudad" class="form-control has-feedback-left" name="dom_ciudad" placeholder="Ciudad" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>

				                    <!--<div class="col-md-3 col-sm-3 col-xs-12">
				                      <input id="dom_munic" class="form-control has-feedback-left" name="dom_munic" placeholder="Municipio" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>-->
				                  </div>



			                      <!--<div class="item form-group">

				                      <div class="col-md-5 col-sm-5 col-xs-12 form-group ">
				                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Estado: </label>
				                        <div class="col-md-10 col-sm-10 col-xs-12">
				                          <select class="form-control" name="dom_estado">
				                            <option value="null">Seleccione ...</option>
				                            <option value="ags">Aguascalientes</option>
				                            <option value="bc">Baja California</option>
				                            <option value="bcs">Baja California Sur</option>

				                            <option value="camp">Campeche</option>
				                            <option value="chis">Chiapas</option>
				                            <option value="chih">Chihuahua</option>

				                            <option value="cdmx">Ciudad de México</option>
				                            <option value="coah">Coahuila de Zaragoza</option>
				                            <option value="col">Colima</option>

				                            <option value="dgo">Durango</option>
				                            <option value="gto">Guanajuato</option>
				                            <option value="gro">Guerrero</option>

				                            <option value="hgo">Hidalgo</option>
				                            <option value="jal">Jalisco</option>
				                            <option value="mex">México</option>

				                            <option value="mich">Michoacan de Ocampo</option>
				                            <option value="mor">Morelos</option>
				                            <option value="nay">Nayarit</option>

				                            <option value="nl">Nuevo León</option>
				                            <option value="oax">Oaxaca</option>
				                            <option value="pue">Puebla</option>

				                            <option value="qro">Querétaro de Arteaga</option>
				                            <option value="qr">Quintana Roo</option>
				                            <option value="slp">San Luis Potosí</option>

				                            <option value="sin">Sinaloa</option>
				                            <option value="son">Sonora</option>
				                            <option value="tab">Tabasco</option>

				                            <option value="tamps">Tamaulipas</option>
				                            <option value="tlax">Tlaxcala</option>
				                            <option value="ver">Veracruz de Ignacio de la Llave</option>

				                            <option value="yuc">Yucatán</option>
				                            <option value="zac">Zacatecas</option>
				                            
				                          </select>
				                        </div>
				                      </div>

				                      <div class="col-md-4 col-sm-4 col-xs-12 form-group ">
				                        <label class="control-label col-md-2 col-sm-2 col-xs-12">País: </label>
				                        <div class="col-md-10 col-sm-10 col-xs-12">
				                          <select class="form-control" name="dom_pais">
				                            <option value="null">Seleccione ...</option>
				                            <option value="MX" selected>México</option>
				                          </select>
				                        </div>
				                      </div>
			                      </div>-->

	                      		</div>
	                        </div>

	                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

	                          <div id="switch_new_refer">
                        	  	<label class="control-label col-md-2 col-sm-2 col-xs-12">Nueva Referencia ?: </label>
		                        <div class="col-md-7 col-sm-7 col-xs-12">
		                          <div class="">
		                            <label>
		                              <input type="checkbox" id="checkrefer" name="checkrefer" onchange="toggleCheckboxRefer(this)" class="js-switch" checked="checked" />
		                            </label>
		                          </div>
		                          
		                        </div>
                        	  </div>

                        	  </br>
                        	  </br>

                        	  <div id="refer_exits_data" hidden>
                        	  	<div class="col-md-12 col-sm-12 col-xs-12 form-group ">
			                        <label class="control-label col-md-1 col-sm-1 col-xs-12">Referencia: </label>
			                        <div class="col-md-11 col-sm-11 col-xs-12">
			                          <select class="form-control" name="cliente_refer_id">
			                            <option value="null">Seleccione ...</option>
			                            @foreach($references as $reference)
			                            	<option value="{{ $reference->id }}">{{ $reference->refer_nom }} - {{ $reference->refer_rfc }}</option>
			                            @endforeach
			                          </select>
			                        </div>
			                      </div>
                        	  </div>

                        	  
                        	  <div id="refer_new_data">
	                        	  <div class="item form-group">	                    
				                    <div class="col-md-9 col-sm-9 col-xs-12">
				                      <input id="refer_nom" class="form-control has-feedback-left" name="refer_nom" placeholder="Nombre" required type="text">
				                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
				                    </div>
				                  </div>

		                          <div class="item form-group">	                    
				                    <div class="col-md-9 col-sm-9 col-xs-12">
				                      <input id="refer_rfc" class="form-control has-feedback-left" name="refer_rfc" placeholder="RFC" type="text" data-validate-words="1">
				                      <span class="fa fa-institution form-control-feedback left" aria-hidden="true"></span>
				                    </div>
				                  </div>
			                  </div>

	                        </div>


	                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">

	                        	<div class="item form-group">	                    
				                    <div class="col-md-9 col-sm-9 col-xs-12">
				                      <input id="client_cert" class="form-control has-feedback-left" name="client_cert" placeholder="Certificado del Cliente " type="file" accept=".cer" title="Certificado con extensión .cer">
				                      <span class="fa fa-lock form-control-feedback left" aria-hidden="true"></span>
				                    </div>
				                  </div>

				                  <div class="item form-group">	                    
				                    <div class="col-md-9 col-sm-9 col-xs-12">
				                      <input id="cert_f_ini" class="form-control has-feedback-left" name="cliente_correo" placeholder="Fecha Inicio Certificado" type="date" disabled title="Fecha Inicio Certificado">
				                      <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
				                    </div>
				                  </div>

				                  <div class="item form-group">	                    
				                    <div class="col-md-9 col-sm-9 col-xs-12">
				                      <input id="cert_f_fin" class="form-control has-feedback-left" name="cliente_tel" placeholder="Fecha Fin Certificado"  type="date" disabled title="Fecha Fin Certificado">
				                      <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
				                    </div>
				                  </div>

	                        </div>

	                      </div>
	                    </div>
                	</div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button id="cancel" type="button" onclick="location.href = '/directory/client';" class="btn btn-info">Cancelar</button>
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

    <script type="text/javascript">

    	var dom_estado_serv = '';
    	var dom_munic_serv = '';
    	var dom_cp_serv = '';

    	$("#cliente_rfc").on('change', function(){
    		document.getElementById("span_cliente_rfc").setAttribute('hidden','1');
    	});

    	/*$("#dom_cp").on('blur', function(){
    		dom_cp_serv = this.value;
    		var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    		dom_munic_serv = this.value;

    		  if(this.value!=''){
    		  	  $('#loadingmodal').modal('show');
	              $.ajax({
	                url: '/getcpdata',
	                type: 'POST',
	                data: {_token: CSRF_TOKEN,dommunicserv:dom_munic_serv,domcpserv:dom_cp_serv},
	                dataType: 'JSON',
	                success: function (data) {
                	  $('#loadingmodal').modal('hide');
	                  
	                    
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
    	});*/

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

		function toggleCheckboxRefer(element){
		   element.checked = !element.checked;
		   if (element.checked){
	   			$("#refer_new_data").show();
	   			$("#refer_exits_data").hide();
	   			document.getElementById("refer_nom").required = true;
		   }else{
		   		$("#refer_new_data").hide();
		   		$("#refer_exits_data").show();
		   		document.getElementById("refer_nom").required = false;
		   }
		   
		 }

		 $("#dom_estado").on('change', function(){
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
	                url: '/getmunic',
	                type: 'POST',
	                data: {_token: CSRF_TOKEN,domstate:this.value},
	                dataType: 'JSON',
	                success: function (data) {
                	  $('#loadingmodal').modal('hide');
	                  
	                  

	                  data['munics'].forEach(function(item){
	                  	$('#dom_munic').append($('<option>', {
						    value: item.m_code,
						    text: item.m_description
						}));
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

    		dom_munic_serv = this.value;

    		  if(this.value!=''){
    		  	  $('#loadingmodal').modal('show');
	              $.ajax({
	                url: '/getcpdata',
	                type: 'POST',
	                data: {_token: CSRF_TOKEN,dommunicserv:dom_munic_serv,domcpserv:dom_cp_serv},
	                dataType: 'JSON',
	                success: function (data) {
                	  $('#loadingmodal').modal('hide');

	                  data['tabledata'].forEach(function(item){

	                      /*$('#datatable-responsive').find('tbody').append( "<tr><td id='d_codigo"+item.id+"'>"+item.d_codigo+"</td><td id='d_estado"+item.id+"'>"+item.d_estado+"</td><td id='d_ciudad"+item.id+"'>"+item.d_ciudad+"</td><td id='d_asenta"+item.id+"'>"+item.d_asenta+"</td><td id='d_tipo_asenta"+item.id+"'>"+item.d_tipo_asenta+"</td><td><div class='btn-group'><div class='btn-group'><a id='accbtn"+item.id+"' onclick='unlockUsers("+'"'+item.id+'"'+")' class='btn btn-xs' data-placement='left' title='Seleccionar' ><i class='fa fa-unlock fa-2x'></i> </a></div></td></tr>");*/
	                    

	                  });

	                  $('#datatable-responsive').dataTable().fnDestroy();

	                  $('#datatable-responsive').DataTable( {
				        data: [['1','2','3','4','5','']],


				    } );
	                    
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



		 
		 
		 

	</script>


@endsection

