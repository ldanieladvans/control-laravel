@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <!--<link href="{{ asset('controlassets/pnotify/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css" />-->
    <!-- Chosen -->    
    <link href="{{ asset('controlassets/vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
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
                <h2>Nueva Asignación a Cliente</h2>
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
                <form id="packassigform" class="form-horizontal form-label-left" novalidate action="{{ route('appcta.store') }}" method='POST'>

                	  {{ csrf_field() }}

                    <div class="item form-group">	                    
	                    <div class="col-md-9 col-sm-9 col-xs-12">
	                      <input id="appcta_app" class="form-control has-feedback-left" title="Identificador de la asignación" name="appcta_app" placeholder="Identificador de la asignación *" required="required" type="text">
	                      <span class="fa fa-laptop form-control-feedback left" aria-hidden="true"></span>
	                    </div>
	                  </div>

	                  <div class="item form-group">
                              <label class="control-label col-md-1 col-sm-1 col-xs-12">Cuenta*</label>
                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                    <select class="select2_single form-control col-md-7 col-xs-12" id="appcta_cuenta_id" name="appcta_cuenta_id" required>
                                      <option value="">Seleccione una opción ...</option>
                                      @foreach($accounts as $account)
                                    <option value="{{ $account->id }}">{{ $account->cta_num }}</option>
                                  @endforeach
                                    </select>
                                  </div>

                              

                            </div>

                            <div class="item form-group">
                              <label class="control-label col-md-1 col-sm-1 col-xs-12">Paquete*</label>
                                  <div class="col-md-8 col-sm-8 col-xs-12">
                                    <select class="select2_single form-control col-md-7 col-xs-12" name="appcta_paq_id" id="appcta_paq_id" required disabled="disabled">
                                      <option value="">Seleccione una opción ...</option>
                                      @foreach($packages as $package)
                                    <option value="{{ $package->id }}">{{ $package->paq_nom }}</option>
                                  @endforeach
                                    </select>
                                  </div>
                            </div>



                  	<div class="x_content">
                      <div class="" role="tabpanel" data-example-id="togglable-tabs">
	                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
	                        <li role="presentation" id="li_content1" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Detalles</a>
	                        </li>
	                        <!--<li role="presentation" id="li_content2" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Detalle</a>
	                        </li>-->
                          <li role="presentation" id="li_content3" class=""><a href="#tab_content3" role="tab" id="date-tab" data-toggle="tab" aria-expanded="false">Fechas</a>
                          </li>
	                      </ul>

	                      <div id="myTabContent" class="tab-content">


                          <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                            <div class="item form-group" id="group_appcta_rfc">                     
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="appcta_rfc" class="form-control has-feedback-left" name="appcta_rfc" title="Cantidad de RFCs" placeholder="Cantidad RFC *" required="required" type="numberint">
                                <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
                              </div>
                            </div>

                            <div class="item form-group" id="group_appcta_gig">                     
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="appcta_gig" class="form-control has-feedback-left" name="appcta_gig" placeholder="Cantidad Gigas *" required="required" type="number" title="Almacenamiento en Gigas">
                                <span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
                              </div>
                            </div>

                            <div class="item form-group">
                                  <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select id="apps" name="apps[]" tabindex="2" data-placeholder="Seleccione las aplicaciones ..." class="select form-control" multiple="multiple" required>
                                          <option value=""></option>
                                          @foreach($apps as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                          @endforeach

                                    </select>
                                  </div>
                            </div>

                            
                          </div>


	                        <!--<div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab">

                            <div class="item form-group" id="group_appcta_rfc">                     
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="appcta_rfc" class="form-control has-feedback-left" name="appcta_rfc" title="Cantidad de RFCs" placeholder="Cantidad RFC *" required="required" type="numberint" disabled="disabled">
                                <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
                              </div>
                            </div>

                            <div class="item form-group" id="group_appcta_gig">                     
                              <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="appcta_gig" class="form-control has-feedback-left" name="appcta_gig" placeholder="Cantidad Gigas *" required="required" type="number" title="Almacenamiento en Gigas" disabled="disabled">
                                <span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
                              </div>
                            </div>

                        	  

                        	  
	                        </div>-->



                          



	                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">

	                        	<div class="item form-group" id="group_appcta_f_vent">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="appcta_f_vent" title="Fecha de Venta o Asignación" class="form-control has-feedback-left" name="appcta_f_vent" placeholder="Fecha Venta" required="required" type="date" disabled>
			                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
			                      </div>
			                    </div>

			                    <div class="item form-group" id="group_appcta_f_act">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="appcta_f_act" title="Fecha de Activación" class="form-control has-feedback-left" name="appcta_f_act" placeholder="Fecha Activación" required="required" type="date" disabled>
			                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
			                      </div>
			                    </div>

			                    <div class="item form-group" id="group_appcta_f_fin">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="appcta_f_fin" title="Fecha de Fin" class="form-control has-feedback-left" name="appcta_f_fin" placeholder="Fecha Fin" required="required" type="date">
			                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
			                      </div>
			                    </div>

			                    <div class="item form-group" id="group_appcta_f_caduc">                     
			                      <div class="col-md-9 col-sm-9 col-xs-12">
			                        <input id="appcta_f_caduc" title="Fecha de Caducidad" class="form-control has-feedback-left" name="appcta_f_caduc" placeholder="Fecha Caducidad" required="required" type="date">
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
                          <button id="cancel" type="button" onclick="location.href = '/account/appcta';" class="btn btn-info">Cancelar</button>
                          <button type="reset" class="btn btn-primary">Borrar Datos</button>
                  		    <!--<button id="send" onclick="onSendClick()" type="button" class="btn btn-success">Guardar</button>-->
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

    <!-- PNotify -->
    <!--<script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>-->

      <!-- Chosen -->
    <script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

	<!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>

    <script type="text/javascript">



  $('.chosen-select', this).chosen('destroy').chosen();

  var cta_aux = false;
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $('#appcta_cuenta_id').change(function(){
    if(this.value == ""){
      
      cta_aux = false;     
    }else{
      $("#appcta_paq_id").removeAttr('disabled');
      $("#appcta_rfc").removeAttr('disabled');
      $("#appcta_gig").removeAttr('disabled');
      cta_aux = this.value;
    }
    $("#appcta_paq_id").val("");
    $("#appcta_rfc").val(""); 
    $("#appcta_gig").val("");

  });

  $('#appcta_paq_id').change(function(){
      if(this.value!=""){
        $.ajax({
          url: '/getgigrfcbypack',
          type: 'POST',
          data: {_token: CSRF_TOKEN,paqid:this.value,accid:cta_aux},
          dataType: 'JSON',
          success: function (data) {
            document.getElementById('appcta_rfc').value=data['rfc'];
            document.getElementById('appcta_gig').value=data['gig'];
            document.getElementById('appcta_rfc').setAttribute("data-validate-minmax", "0,"+data['rfc']);
            document.getElementById('appcta_gig').setAttribute("data-validate-minmax", "0,"+data['gig']);
          }
      });
      }else{
        document.getElementById('appcta_rfc').value='';
        document.getElementById('appcta_gig').value='';
      }
      
  });


  function activaTab(tab){
    $('.nav-tabs a[href="#' + tab + '"]').tab('show');
  }

  
  function activeBeforeSubmit(){
    var tabid = false;
    tabsInForm = $( "#packassigform").find('.tab-pane');
    tabsInForm.each(function(){
        tabid = this.id;
        var activate_tab = false;
        fieldsInTab = $( "#"+this.id).find(':input').filter('[required=required], .required, .optional').not('[disabled=disabled]');
          fieldsInTab.each(function(){
            if(this.required && this.value == ''){
                  activate_tab = true;
                  return;
                }
        });

          if(activate_tab==true){
              return;
            }

    });



    if(tabid!=false){
      activaTab(tabid);
    }

  }



  var nocall = true;

  /*function onSendClick(){
    var form_validity = $("#packassigform")[0].checkValidity();
    if(form_validity==false){
      $("#appcta_app").value = '';
      activeBeforeSubmit();
      validateNoMsgForm('packassigform',[],event);
    }else{
      $("#packassigform").submit();
    }
    
  }*/

	$( "#packassigform" ).submit(function( event ) {
    event.preventDefault();
    if($('#packassigform')[0].checkValidity()==true){
      $('#loadingmodal').modal('show');
    }
  });

	</script>


@endsection

