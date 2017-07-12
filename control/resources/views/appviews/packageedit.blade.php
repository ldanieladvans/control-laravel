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
                    <h2>Editar Paquete</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    {{ Form::open(['route' => ['package.update', $package], 'class'=>'form-horizontal form-label-left']) }}
                	    {{ Form::hidden('_method', 'PUT') }}

                        <div class="item form-group">                     
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="paq_nom" class="form-control has-feedback-left" title="Nombre del Paquete" name="paq_nom" placeholder="Nombre del Paquete *" required="required" type="text" value="{{ $package->paq_nom }}">
                                <span class="fa fa-suitcase form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">                     
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="paq_rfc" class="form-control has-feedback-left" name="paq_rfc" title="Cantidad de RFCs" placeholder="Cantidad RFC *" required="required" type="numberint" value="{{ $package->paq_rfc }}">
                                <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">                     
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="paq_gig" class="form-control has-feedback-left" name="paq_gig" placeholder="Cantidad Gigas *" required="required" type="number" title="Almacenamiento en Gigas" value="{{ $package->paq_gig }}">
                                <span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="cancel" type="button" onclick="location.href = '/config/package';" class="btn btn-info">Cancelar</button>                                                                           
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
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
@endsection

