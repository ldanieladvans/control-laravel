@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- Datetime -->
    <link href="{{ asset('controlassets/vendors/datetime/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Nueva Aplicación</h2>
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
                    <form class="form-horizontal form-label-left" action="{{ route('apps.store') }}" method='POST' id='appscreate'>
            	       {{ csrf_field() }}

                        <div class="item form-group">                     
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="name" class="form-control has-feedback-left" title="Nombre de la Aplicación" name="name" placeholder="Nombre de la Aplicación *" required="required" type="text">
                                <span class="fa fa-suitcase form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">                     
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="code" class="form-control has-feedback-left" title="Código" name="code" placeholder="Código *" required="required" type="text">
                                <span class="fa fa-key form-control-feedback left" aria-hidden="true" data-validate-words="1"></span>
                            </div>
                        </div>

                        <div class="item form-group">                     
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="trial_days" class="form-control has-feedback-left" name="trial_days" title="Días de Prueba" placeholder="Días de Prueba *" type="numberint" value='30'>
                                <span class="fa fa-ticket form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">                     
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="base_price" class="form-control has-feedback-left" name="base_price" placeholder="Precio Base *" type="number" title="Precio Base" value='0'>
                                <span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="cancel" type="button" onclick="location.href = '/config/apps';" class="btn btn-info">Cancelar</button>
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

