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
                <h2>Nueva Noticia</h2>
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
                {{ Form::open(['route' => ['news.update', $news->id], 'class'=>'form-horizontal form-label-left']) }}

                	{{ Form::hidden('_method', 'PUT') }}

						
						<div class="item form-group">
		                    <div class="col-md-9 col-sm-9 col-xs-12">
		                      <input id="tittle" class="form-control has-feedback-left" name="tittle" placeholder="Titulo *" required="required" type="text" value="{{ $news->tittle }}">
		                      <span class="fa fa-newspaper-o form-control-feedback left" aria-hidden="true"></span>
		                      @if ($errors->has('tittle'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tittle') }}</strong>
                                    </span>
                                @endif
		                    </div>
	                    </div>

	                      <div class="item form-group">	                    
		                    <div class="col-md-9 col-sm-9 col-xs-12">
		                      <input id="pdate" class="form-control has-feedback-left" name="pdate" placeholder="Fecha *" required="required" type="date" autocomplete="off" value="{{ $news->pdate }}">
		                      <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
		                      @if ($errors->has('pdate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pdate') }}</strong>
                                    </span>
                                @endif
		                    </div>
		                  </div>

		                  <div class="item form-group">	                    
		                    <div class="col-md-9 col-sm-9 col-xs-12">
		                      <input id="description" class="form-control has-feedback-left" name="description" placeholder="Descripción *" type="textarea" autocomplete="off" required="required" value="{{ $news->description }}">
		                      <span class="fa fa-comment-o form-control-feedback left" aria-hidden="true"></span>
		                      @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
		                    </div>
		                  </div>

                      <div class="item form-group">                     
                        <div class="col-md-9 col-sm-9 col-xs-12">
                          <input id="nlink" class="form-control has-feedback-left" name="nlink" placeholder="Liga " type="url"  autocomplete="off" value="{{ $news->nlink }}">
                          <span class="fa fa-mail-forward form-control-feedback left" aria-hidden="true"></span>
                          @if ($errors->has('nlink'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nlink') }}</strong>
                                    </span>
                                @endif
                        </div>
                      </div>

		                  <div class="item form-group">
		                  	<label class="control-label col-md-1 col-sm-1 col-xs-12">Activo: </label>	                    
		                    <div class="col-md-9 col-sm-9 col-xs-12">
		                    	<p></p>
	                        Si:
	                        <input type="radio" class="flat" name="nactivo" id="nactivosi" value="1" {{$news->nactivo == 1 ? 'checked':''}} /> No:
	                        <input type="radio" class="flat" name="nactivo" id="nactivono" value="0" {{$news->nactivo == 0 ? 'checked':''}}/>
		                    </div>
		                  </div>


					</td>
					</tr>
					</table>

                	

					<div class="col-md-12 col-sm-12 col-xs-12">
						</br>
						</br>
					</div>
                    

                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                          <button id="cancel" type="button" onclick="location.href = '/exts/news';" class="btn btn-info">Cancelar</button>
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

