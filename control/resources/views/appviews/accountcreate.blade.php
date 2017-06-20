@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- Datetime -->
    <link href="{{ asset('controlassets/vendors/datetime/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">

    <!-- Chosen -->
    
    <link href="{{ asset('controlassets/vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Nueva Cuenta</h2>
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

                <form class="form-horizontal form-label-left" novalidate action="{{ route('account.store') }}" method='POST'>

                	{{ csrf_field() }}

                  <!--<div class="item form-group">                     
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="cta_nomservd" title="Identificador del servidor" class="form-control has-feedback-left" name="cta_nomservd" placeholder="Identificador del servidor *" required="required" type="text">
                        <span class="fa fa-info form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>-->


                  <div class="item form-group">                     
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="cta_num" title="RFC" class="form-control has-feedback-left" name="cta_num" placeholder="Número de Cuenta / RFC *" type="number">
                        <span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>

                  <!--<div class="item form-group">                     
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="cta_fecha" title="Fecha" class="form-control has-feedback-left" name="cta_fecha" placeholder="Fecha" required="required" type="date">
                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>

                  <div class="item form-group">                     
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="cta_nom_bd" title="Nombre Base de Datos" class="form-control has-feedback-left" name="cta_nom_bd" placeholder="Nombre Base de Datos *" required="required" type="text">
                        <span class="fa fa-laptop form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>-->

                  <div class="item form-group">                     
                      <div class="col-md-9 col-sm-9 col-xs-12">
                        <input id="cta_estado" title="Estado" class="form-control has-feedback-left" name="cta_estado" placeholder="Estado *" required="required" type="text" readonly="readonly" value="Inactiva">
                        <span class="fa fa-certificate form-control-feedback left" aria-hidden="true"></span>
                      </div>
                    </div>


                  <div class="x_content">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                          <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Cliente - Distribuidor</a>
                          </li>
                        </ul>

                        <div id="myTabContent" class="tab-content">

                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            <div class="item form-group">
                              <label class="control-label col-md-1 col-sm-1 col-xs-12">Cliente*</label>
                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                    <select class="select2_single form-control col-md-7 col-xs-12" name="cta_cliente_id" required>
                                      <option value="">Seleccione una opción ...</option>
                                      @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->cliente_nom }}</option>
                                      @endforeach
                                    </select>
                                  </div>

                              

                            </div>

                            <div class="item form-group">
                              <label class="control-label col-md-1 col-sm-1 col-xs-12">Distribuidor*</label>
                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                    <select class="select2_single form-control col-md-7 col-xs-12" name="cta_distrib_id" required>
                                      <option value="">Seleccione una opción ...</option>
                                      @foreach($distributors as $distributor)
                                        <option value="{{ $distributor->id }}">{{ $distributor->distrib_nom }}</option>
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
                    <div class="col-md-6 col-md-offset-3">
                      <button id="cancel" type="button" onclick="location.href = '/account/account';" class="btn btn-info">Cancelar</button>
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

    <!-- Chosen -->
  <script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
  <script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
  <script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

    <!-- validator -->
    <script src="{{ asset('controlassets/vendors/validator/control.validator.js') }}"></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>

    <!-- Date Time -->
    <script type="text/javascript" src="{{ asset('controlassets/vendors/datetime/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
	<script type="text/javascript" src="{{ asset('controlassets/vendors/datetime/js/locales/bootstrap-datetimepicker.es.js') }}" charset="UTF-8"></script>

	<script type="text/javascript">

	    $('.form_datetime').datetimepicker({
	        language:  'es',
	        weekStart: 1,
	        todayBtn:  1,
			autoclose: 1,
			todayHighlight: 1,
			startView: 2,
			forceParse: 0,
	        showMeridian: 1
	    });
	</script>

@endsection

