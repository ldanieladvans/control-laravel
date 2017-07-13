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
					<h2>Nuevo Rol</h2>
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
					<form id="rolecreateform" class="form-horizontal form-label-left" novalidate action="{{ route('role.store') }}" method='POST'>
						{{ csrf_field() }}
						<div class="item form-group">
							<div class="col-md-9 col-sm-9 col-xs-12">
								<input id="name" class="form-control has-feedback-left" name="name" placeholder="Nombre *" required="required" type="text">
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
								<input id="slug" class="form-control has-feedback-left" name="slug" placeholder="Código *" required="required" type="text" data-validate-words="1" value="" autocomplete="off">
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
								<input id="description" class="form-control has-feedback-left" name="description" placeholder="Descripción *" type="textarea" value="" autocomplete="off">
								<span class="fa fa-user-plus form-control-feedback left" aria-hidden="true"></span>
								@if ($errors->has('description'))
								<span class="help-block">
									<strong>{{ $errors->first('description') }}</strong>
								</span>
								@endif
							</div>
						</div>

					</div>

					<div class="x_content">
						<div class="" role="tabpanel" data-example-id="togglable-tabs">
							<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
								<li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Permisos</a>
								</li>
							</ul>

							<div id="myTabContent" class="tab-content">
								<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
									<div class="item form-group">
										<div class="col-md-10 col-sm-10 col-xs-12">
											<select id="permisos" name="permisos[]" tabindex="2" data-placeholder="Seleccione los permisos ..." name="rolesapp" class="chosen-select form-control" multiple="multiple">
												@foreach($permissions as $permission)
												<option value="{{ $permission->id }}">{{ $permission->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="ln_solid"></div>
					<div class="form-group">
						<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
							<button id="cancel" type="button" onclick="location.href = '/security/role';" class="btn btn-info">Cancelar</button>
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

