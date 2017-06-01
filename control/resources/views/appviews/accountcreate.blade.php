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
                <h2>Nueva Cuenta</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">

                <form class="form-horizontal form-label-left" novalidate action="{{ route('account.store') }}" method='POST'>

                	{{ csrf_field() }}

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cta_nomservd">Servidor <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="cta_nomservd" class="form-control col-md-7 col-xs-12" data-validate-words="1" name="cta_nomservd" placeholder="Identificador del servidor" required="required" type="text">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cta_num">Número de Cuenta <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" id="cta_num" name="cta_num" required="required" data-validate-minmax="1,10000000000" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label for="cta_fecha" class="control-label col-md-3 col-sm-3 col-xs-12">Fecha <span class="required">*</span></label>
	                <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="cta_fecha" type="date" name="cta_fecha" class="optional datetime-picker form-control col-md-7 col-xs-12">
                    </div>
					<br/>

                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cta_nom_bd">Nombre Base de Datos <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="cta_nom_bd" class="form-control col-md-7 col-xs-12" data-validate-words="1" name="cta_nom_bd" required="required" type="text">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cta_estado">Estado <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="cta_estado" name="cta_estado" readonly="readonly" data-validate-words="1" required="required" value="Borrador" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>


                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
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

