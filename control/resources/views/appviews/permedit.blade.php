@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">

@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Actualizar Permiso</h2>
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
                {{ Form::open(['route' => ['permission.update', $permission->id], 'class'=>'form-horizontal form-label-left']) }}

                	{{ Form::hidden('_method', 'PUT') }}

						
						<div class="item form-group">
		                    <div class="col-md-9 col-sm-9 col-xs-12">
		                      <input id="name" class="form-control has-feedback-left" name="name" placeholder="Nombre *" required="required" type="text" value="{{$permission->name}}">
		                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
		                      @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
		                    </div>
	                    </div>

	                      <div class="item form-group">	                    
		                    <div class="col-md-9 col-sm-9 col-xs-12">
		                      <input id="slug" class="form-control has-feedback-left" name="slug" placeholder="Código *" required="required" type="text" data-validate-words="1" autocomplete="off" value="{{$permission->slug}}" disabled>
		                      <span class="fa fa-universal-access form-control-feedback left" aria-hidden="true"></span>
		                      @if ($errors->has('slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
		                    </div>
		                  </div>

		                  <div class="item form-group">	                    
		                    <div class="col-md-9 col-sm-9 col-xs-12">
		                      <input id="description" class="form-control has-feedback-left" name="description" placeholder="Descripción *" type="textarea" autocomplete="off" value="{{$permission->description}}">
		                      <span class="fa fa-user-plus form-control-feedback left" aria-hidden="true"></span>
		                      @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
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
                          <button type="reset" class="btn btn-primary">Borrar Datos</button>
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


    <script type="text/javascript">


	</script>


@endsection

