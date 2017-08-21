@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- Datetime -->
    <link href="{{ asset('controlassets/vendors/datetime/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">
    <!-- Chosen -->
    <link href="{{ asset('controlassets/vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select 2 -->
    <link href="{{ asset('controlassets/vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Nueva Cuenta</h2>
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
                    <form class="form-horizontal form-label-left" novalidate action="{{ route('account.store') }}" method='POST'>
                	   {{ csrf_field() }}

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Cliente*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_cliente_id" id="cta_cliente_id" required>
                                    <option value="">Seleccione una opción ...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->cliente_nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Número</label>                     
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cta_num" title="RFC" class="form-control has-feedback-left" name="cta_num" placeholder="Número de Cuenta / RFC *" type="text" readonly="readonly">
                                <span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Distribuidor*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_distrib_id" id="cta_distrib_id" required>
                                    <option value="">Seleccione una opción ...</option>
                                    @foreach($distributors as $distributor)
                                        <option value="{{ $distributor->id }}">{{ $distributor->distrib_nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Tipo de Cuenta*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_type" id="cta_type" required>
                                    <option value="">Seleccione una opción ...</option>
                                    <option value="single" selected>1 RFC</option>
                                    <option value="multi">Múltiple RFCs</option>
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Estado</label>                     
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cta_estado" title="Estado" class="form-control has-feedback-left" name="cta_estado" placeholder="Estado *" required="required" type="text" readonly="readonly" value="Inactiva">
                                <span class="fa fa-certificate form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Fecha Activación</label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input id="cta_fecha" title="Fecha" class="form-control has-feedback-left" name="cta_fecha" placeholder="Fecha" type="date" disabled>
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Periodicidad: </label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_periodicity" id="cta_periodicity" required>
                                    <option value="3" selected>Trimestral</option>
                                    <option value="6" >Semestral</option>
                                    <option value="12" >Anual</option>
                                </select>
                            </div>
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Recursivo: </label>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_recursive" id="cta_recursive">
                                    <option value="1" selected>Si</option>
                                    <option value="0" >No</option>
                                </select>
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
    <!-- Select 2 -->
    <script src="{{ asset('controlassets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('controlassets/vendors/switchery/dist/switchery.min.js') }}"></script>
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

        $("#cta_cliente_id").select2({
            placeholder: "Selecciona el cliente",
            allowClear: true
        });

        $("#cta_distrib_id").select2({
            placeholder: "Selecciona el distribuidor",
            allowClear: true
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#cta_cliente_id').change(function(){
            if(this.value!=""){
                $.ajax({
                    url: '/getclientrfc',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN,clientid:this.value},
                    dataType: 'JSON',
                    success: function (data) {
                      document.getElementById('cta_num').value=data['rfc'];
                    }
                });
            }else{
              document.getElementById('cta_num').value='';
            }
        });
	</script>
@endsection

