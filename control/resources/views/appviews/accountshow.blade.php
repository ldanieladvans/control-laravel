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
                        	<td>{{ $acc->cta_estado }}</td>
                          <td></td>
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
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
@endsection