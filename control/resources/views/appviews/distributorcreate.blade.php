@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Nuevo Distribuidor</h2>
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
                <form class="form-horizontal form-label-left" novalidate action="{{ route('distributor.store') }}" method='POST'>

                	  {{ csrf_field() }}

                      <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="distrib_nom" class="form-control has-feedback-left" name="distrib_nom" placeholder="Nombre del Distribuidor *" required="required" type="text">
	                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="distrib_rfc" class="form-control has-feedback-left" name="distrib_rfc" placeholder="RFC *" required="required" type="text" data-validate-words="1">
	                      <span class="fa fa-institution form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

                  	  <div class="item form-group">
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input type="number" id="distrib_limitgig" name="distrib_limitgig" placeholder="Límite Gigas" data-validate-minmax="1,10000000000" class="form-control has-feedback-left">
	                      <span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input type="numberint" id="distrib_limitrfc" name="distrib_limitrfc" placeholder="Límite RFCs" data-validate-minmax="1,10000000000" class="form-control has-feedback-left">
	                      <span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="distrib_tel" class="form-control has-feedback-left" name="distrib_tel" placeholder="Teléfono *" required="required" type="tel">
	                      <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="distrib_correo" class="form-control has-feedback-left" name="distrib_correo" placeholder="Correo *" required="required" type="email">
	                      <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="distrib_nac" class="form-control has-feedback-left" name="distrib_nac" placeholder="Nacionalidad" type="text">
	                      <span class="fa fa-globe form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">
	                  	<label class="control-label col-md-1 col-sm-1 col-xs-12">Supervisor: </label>
	                      <div class="col-md-3 col-sm-3 col-xs-12">
	                       <p></p>
	                        Si:
	                        <input type="radio" class="flat" name="distrib_sup" id="supervisor1" value="1" /> No:
	                        <input type="radio" class="flat" name="distrib_sup" id="supervisor0" value="0" checked/>
	                      </div>
		              </div>


                  	<div class="x_content">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
	                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
	                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Domicilio</a>
	                        </li>
	                        <!--<li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Referencia</a>
	                        </li>-->
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
			                          <select class="form-control" name="distrib_dom_id">
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
				                    <div class="col-md-9 col-sm-9 col-xs-12">
				                      <input id="dom_calle" class="form-control has-feedback-left" name="dom_calle" placeholder="Calle" required type="text">
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
				                    <div class="col-md-3 col-sm-3 col-xs-12">
				                      <input id="dom_col" class="form-control has-feedback-left" name="dom_col" placeholder="Colonia" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>

				                    <div class="col-md-3 col-sm-3 col-xs-12">
				                      <input id="dom_ciudad" class="form-control has-feedback-left" name="dom_ciudad" placeholder="Ciudad" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>

				                    <div class="col-md-3 col-sm-3 col-xs-12">
				                      <input id="dom_munic" class="form-control has-feedback-left" name="dom_munic" placeholder="Municipio" type="text">
				                      <span class="fa fa-home form-control-feedback left" aria-hidden="true"></span>
				                    </div>
				                  </div>



			                      <div class="item form-group">
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
			                      </div>

	                      		</div>
	                        </div>


	                      </div>
	                    </div>
                	</div>

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
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

    <script type="text/javascript">

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


	</script>


@endsection

