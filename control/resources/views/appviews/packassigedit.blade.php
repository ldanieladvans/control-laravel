@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('controlassets/pnotify/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Animate -->
    <!--<link href="{{ asset('controlassets/animate.css') }}" rel="stylesheet" type="text/css" />-->
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
                {{ Form::open(['route' => ['asigpaq.update', $asigpaq->id], 'class'=>'form-horizontal form-label-left']) }}

                	{{ Form::hidden('_method', 'PUT') }}

                    <div class="item form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12">Distribuidor*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                              <select class="select2_single form-control col-md-7 col-xs-12" id="asigpaq_distrib_id" name="asigpaq_distrib_id" required>
                                <option value="">Seleccione una opción ...</option>
                                @foreach($distributors as $distributor)
                              <option value="{{ $distributor->id }}" {{$asigpaq->asigpaq_distrib_id == $distributor->id ? 'selected':''}}>{{ $distributor->distrib_nom }}</option>
                            @endforeach
                              </select>
                            </div>

                        

                      </div>

                      <div class="item form-group">
                        <label class="control-label col-md-1 col-sm-1 col-xs-12">Paquete*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                              <select class="select2_single form-control col-md-7 col-xs-12" name="asigpaq_paq_id" id="asigpaq_paq_id" required>
                                <option value="">Seleccione una opción ...</option>
                                @foreach($packages as $package)
                              <option value="{{ $package->id }}" {{$asigpaq->asigpaq_paq_id == $package->id ? 'selected':''}}>{{ $package->paq_nom }}</option>
                            @endforeach
                              </select>
                            </div>
                      </div>


	                  



                  	<div class="x_content">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
	                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
	                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Detalle</a>
	                        </li>
	                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Fechas</a>
	                        </li>
	                      </ul>
	                      <div id="myTabContent" class="tab-content">
	                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                        	  <div class="item form-group">                      
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="asigpaq_rfc" class="form-control has-feedback-left" name="asigpaq_rfc" title="Cantidad de RFCs" placeholder="Cantidad RFC *" required="required" type="numberint" value="{{$asigpaq->asigpaq_rfc}}">
                                <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
                              </div>
                            </div>

                            <div class="item form-group">                     
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="asigpaq_gig" class="form-control has-feedback-left" name="asigpaq_gig" placeholder="Cantidad Gigas *" required="required" type="number" title="Almacenamiento en Gigas" value="{{$asigpaq->asigpaq_gig}}">
                                <span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
                              </div>
                            </div>

                        	  
	                        </div>

	                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

	                        	<div class="item form-group">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="asigpaq_f_vent" title="Fecha de Venta o Asignación" class="form-control has-feedback-left" name="asigpaq_f_vent" placeholder="Fecha Venta" required="required" type="date" value="{{$asigpaq->asigpaq_f_vent}}">
			                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
			                      </div>
			                    </div>

			                    <div class="item form-group">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="asigpaq_f_act" title="Fecha de Actualización" class="form-control has-feedback-left" name="asigpaq_f_act" placeholder="Fecha Actualización" required="required" type="date" value="{{$asigpaq->asigpaq_f_act}}">
			                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
			                      </div>
			                    </div>

			                    <div class="item form-group">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="asigpaq_f_fin" title="Fecha de Fin" class="form-control has-feedback-left" name="asigpaq_f_fin" placeholder="Fecha Fin" required="required" type="date" value="{{$asigpaq->asigpaq_f_fin}}">
			                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
			                      </div>
			                    </div>

			                    <div class="item form-group">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="asigpaq_f_caduc" title="Fecha de Caducidad" class="form-control has-feedback-left" name="asigpaq_f_caduc" placeholder="Fecha Caducidad" required="required" type="date" value="{{$asigpaq->asigpaq_f_caduc}}">
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

    <!-- PNotify -->
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

	<!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>

    <script type="text/javascript">

   /*var selectedval = false;
    var selectobj = false;
   
    $('select').on('change', function() {
    	console.log('sd');
	  if(this.name=='appcta_cuenta_id'){
	  	selectobj = this;
	  	selectedval = this.value;
	  	if(this.value==''){
	  		$(this).addClass('errorType');
	  	}else{
	  		$(this).removeClass('errorType');
	  	}
	  }
	  
	});*/

	//$("#appcta_cuenta_id").trigger("change");

  $('#asigpaq_paq_id').change(function(){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


      $.ajax({
          url: '/getgigrfcbypack',
          type: 'POST',
          data: {_token: CSRF_TOKEN,paqid:this.value},
          dataType: 'JSON',
          success: function (data) {
            document.getElementById('asigpaq_rfc').value=data['rfc'];
            document.getElementById('asigpaq_gig').value=data['gig'];
              
          }
      });
  });

	$( "#packassigform" ).submit(function( event ) {
	  
	  event.preventDefault()

	  	/*if($(selectobj).hasClass('errorType')){
	  		new PNotify({
                    title: "Error",
                    type: "error",
                    text: "Debe seleccionar una cuenta",
                    nonblock: {
                      nonblock: true
                    },
                    styling: 'bootstrap3'
                  });
	  	}*/
	  	if(document.getElementById('asigpaq_f_vent').value=='' || document.getElementById('asigpaq_f_act').value=='' || document.getElementById('asigpaq_f_fin').value=='' || document.getElementById('asigpaq_f_caduc').value==''){
	  		new PNotify({
                    title: "Error",
                    type: "error",
                    text: "Todas las fechas son obligatorias. Consulte el Tab Fechas",
                    nonblock: {
                      nonblock: true
                    },

                    styling: 'bootstrap3'
                  });
	  	}
	  	

	});

	</script>


@endsection

