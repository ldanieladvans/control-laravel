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
                <h2>Editar Cuenta</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  
                </ul>
                <div class="clearfix"></div>
              </div>

              <div class="x_content">

                {{ Form::open(['route' => ['package.update', $package], 'class'=>'form-horizontal form-label-left']) }}

                	{{ Form::hidden('_method', 'PUT') }}


            	  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paq_nom">Nombre <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="paq_nom" class="form-control col-md-7 col-xs-12" name="paq_nom" placeholder="Nombre del Paquete" required="required" type="text" value="{{ $package->paq_nom }}">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paq_gig">Cantidad de Gigas <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="number" id="paq_gig" name="paq_gig" required="required" data-validate-minmax="1,10000000000" class="form-control col-md-7 col-xs-12" value="{{ $package->paq_gig }}">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="paq_rfc">Cantidad de RFCs <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="numberint" id="paq_rfc" name="paq_rfc" required="required" data-validate-minmax="1,10000000000" class="form-control col-md-7 col-xs-12" value="{{ $package->paq_rfc }}">
                    </div>
                  </div>


                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                      <!--<button type="reset" class="btn btn-primary">Borrar Datos</button>-->                                                                                                                   <button id="send" type="submit" class="btn btn-success">Guardar</button>
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

