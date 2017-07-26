@extends('template.applayout')

@section('app_css')
@parent
<!-- Switchery -->
<link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
<!-- Custom Theme Style -->
<link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
<!-- File Input -->
<link href="{{ asset('controlassets/vendors/bootstrap-fileinput-master/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css" />
<!-- Chosen -->
<link href="{{ asset('controlassets/vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
<style>
   .kv-avatar .krajee-default.file-preview-frame,.kv-avatar .krajee-default.file-preview-frame:hover {
       margin: 0;
       padding: 0;
       border: none;
       box-shadow: none;
       text-align: center;
   }
   .kv-avatar .file-input {
       display: table-cell;
       max-width: 220px;
   }
   .kv-reqd {
       color: red;
       font-family: monospace;
       font-weight: normal;
   }
</style>
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Nueva Entrada Art. 69</h2>
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
                    <form id="newscreateform" class="form-horizontal form-label-left" action="{{ route('arts.store') }}" method='POST'>
                        {{ csrf_field() }}
                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="rfc" class="form-control has-feedback-left" name="rfc" placeholder="RFC *" required="required" type="text" title="RFC">
                                <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('rfc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rfc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="contribuyente" class="form-control has-feedback-left" name="contribuyente" placeholder="Contribuyente *" required="required" type="text" title="Contribuyente">
                                <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('contribuyente'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('contribuyente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="tipo" class="form-control has-feedback-left" name="tipo" placeholder="Tipo *" required="required" type="text" title="Tipo">
                                <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('tipo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tipo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="oficio" class="form-control has-feedback-left" name="oficio" placeholder="Oficio *" required="required" type="text" title="Oficio">
                                <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('oficio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('oficio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="item form-group">	                    
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="fecha_sat" class="form-control has-feedback-left" name="fecha_sat" placeholder="Fecha SAT*" title="Fecha SAT" required="required" type="date" >
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('fecha_sat'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fecha_sat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="item form-group">	                    
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="fecha_dof" class="form-control has-feedback-left" name="fecha_dof" placeholder="Fecha DOF*" title="Fecha DOF" required="required" type="date" >
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('fecha_dof'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('fecha_dof') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="url_anexo" class="form-control has-feedback-left" name="url_anexo" placeholder="URL Anexo *" type="url" title="URL Anexo">
                                <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('url_anexo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url_anexo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="item form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input id="url_oficio" class="form-control has-feedback-left" name="url_oficio" placeholder="URL Oficio *" type="url" title="URL Oficio">
                                <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
                                @if ($errors->has('url_oficio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('url_oficio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                              <button id="cancel" type="button" onclick="location.href = '/exts/arts';" class="btn btn-info">Cancelar</button>
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
    <!-- File Input -->
    <script src="{{ asset('controlassets/vendors/bootstrap-fileinput-master/js/fileinput.js') }}" type="text/javascript"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
    <!-- Chosen -->
    <script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    </script>
@endsection

