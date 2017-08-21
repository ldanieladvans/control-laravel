@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- Select 2 -->
    <link href="{{ asset('controlassets/vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
    <style>
	    .errorType {
	        border-color: #F00 !important;
	    }
	</style>
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Editar Asignación a Distribuidor</h2>
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
                    {{ Form::open(['route' => ['asigpaq.update', $asigpaq->id], 'class'=>'form-horizontal form-label-left']) }}
                	   {{ Form::hidden('_method', 'PUT') }}

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Distribuidor*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" id="asigpaq_distrib_id" name="asigpaq_distrib_id" disabled>
                                    <option value="">Seleccione una opción ...</option>
                                    @foreach($distributors as $distributor)
                                        <option value="{{ $distributor->id }}" {{$asigpaq->asigpaq_distrib_id == $distributor->id ? 'selected':''}}>{{ $distributor->distrib_nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                  	    <div class="x_content">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
    	                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        	                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Detalles</a>
        	                        </li>
    	                        </ul>
    	                        <div id="myTabContent" class="tab-content">
        	                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                	    <div class="item form-group">                      
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="asigpaq_rfc" class="form-control has-feedback-left" name="asigpaq_rfc" title="Cantidad de Soluciones" placeholder="Cantidad Soluciones *" data-validate-minmax="1,999999" required="required" type="numberint" value="{{$asigpaq->asigpaq_rfc}}" >
                                                <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>

                                        <div class="item form-group">                     
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="asigpaq_gig" class="form-control has-feedback-left" name="asigpaq_gig" placeholder="Cantidad Megas *" data-validate-minmax="1,999999" required="required" type="number" title="Almacenamiento en Megas" value="{{$asigpaq->asigpaq_gig}}" >
                                                <span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>

                                        <div class="item form-group">                     
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="asigpaq_f_vent" title="Fecha de Venta o Asignación" class="form-control has-feedback-left" name="asigpaq_f_vent" placeholder="Fecha Venta" disabled type="date" value="{{$asigpaq->asigpaq_f_vent}}">
                                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>

                                        <div class="item form-group" hidden>                     
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="asigpaq_f_act" title="Fecha de Actualización" class="form-control has-feedback-left" name="asigpaq_f_act" placeholder="Fecha Actualización" disabled type="date" value="{{$asigpaq->asigpaq_f_act}}">
                                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                            </div>
                                        </div>

                                        <div class="item form-group">                     
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="asigpaq_f_fin" title="Fecha de Fin" class="form-control has-feedback-left" name="asigpaq_f_fin" placeholder="Fecha Fin" type="date" value="{{$asigpaq->asigpaq_f_fin}}">
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
                                <button id="cancel" type="button" onclick="location.href = '/account/asigpaq';" class="btn btn-info">Cancelar</button>
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
    <!-- Select 2 -->
    <script src="{{ asset('controlassets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript">
	    
        console.log(document.getElementById('asigpaq_f_vent').value);

        Date.prototype.addDays = function(days) {
          var dat = new Date(this.valueOf());
          dat.setDate(dat.getDate() + days);
          return dat;
        }

        var inidate = new Date((document.getElementById('asigpaq_f_vent').value).replace('-','/'));
        inidate = inidate.addDays(1);

        var month = inidate.getMonth() + 1;
        if(month<10){
            month = '0'+month;
        }
        var day = inidate.getDate();
        if(day<10){
            day = '0'+day;
        }
        var year = inidate.getFullYear();

        val_date_ini = [year, month, day].join('-');

        console.log(val_date_ini);

        document.getElementById('asigpaq_f_fin').min = val_date_ini;

        $( "#packassigform" ).submit(function( event ) {
	        event.preventDefault();
	    });

        $("#asigpaq_distrib_id").select2({
            placeholder: "Selecciona el distribuidor",
            allowClear: true
        });
	</script>
@endsection

