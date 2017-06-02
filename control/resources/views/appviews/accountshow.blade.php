@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Datatables -->
    <link href="{{ asset('controlassets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cuentas</h2>
                    
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
                    <button type="button" onclick="location.href = 'account/create';" class="btn btn-primary">Agregar</button>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Número de Cuenta</th>
                          <th>Servidor</th>
                          <th>Fecha</th>
                          <th>Base de Datos</th>
                          <th>Cliente</th>
                          <th>Distribuidor</th>
                          <th>Estado</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($accounts as $acc)
                        <tr>
                        	<td>{{ $acc->id }}</td>
                        	<td>{{ $acc->cta_num }}</td>
                        	<td>{{ $acc->cta_nomservd }}</td>
                        	<td>{{ $acc->cta_fecha }}</td>
                        	<td>{{ $acc->cta_nom_bd }}</td>
                          <td>{{ $acc->client ?  $acc->client->cliente_nom : '' }}</td>
                          <td>{{ $acc->distributor ? $acc->distributor->distrib_nom : '' }}</td>
                        	<td>{{ $acc->cta_estado }}</td>

                          <td class=" last" width="20%">
                                      
                                    <button href="#" class="btn btn-info btn-xs" type="button"><i class="fa fa-pencil"></i> Editar </button>

                                      {{ Form::open(['route' => ['account.destroy', $acc], 'class'=>'pull-right']) }}
                                      {{ Form::hidden('_method', 'DELETE') }}
                                      <button onclick="return confirm('¿Está seguro que quiere eliminar esta cuenta?')" class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> Eliminar </button>
                                    <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-sm btn-xs right" type="button" aria-expanded="false">Más <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                              <li><a href="#">Action</a>
                                              </li>
                                              <li><a href="#">Another action</a>
                                              </li>
                                              <li><a href="#">Something else here</a>
                                              </li>
                                              <li><a href="#">Separated link</a>
                                              </li>
                                            </ul>
                                         </div>

                                      {{ Form::close() }}

                                  </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
    </div>
</div>
@endsection

@section('app_js') 
	@parent
    <!-- Datatables -->
    <script src="{{ asset('controlassets/vendors/datatables.net/js/jquery.dataTables.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('controlassets/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
@endsection