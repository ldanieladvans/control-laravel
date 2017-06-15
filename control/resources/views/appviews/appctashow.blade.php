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
                    <h2>Asignaciones a Clientes</h2>
                    
                    <div class="clearfix"></div>
                  </div>

                  @if (Session::has('message'))
                  <div class="alert alert-success alert-dismissible fade in" role="alert" id="ctams">
                    <button type="button" id="alertmsgcta" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>{{ Session::get('message') }}</strong>
                  </div>
                  @endif

                  <div class="x_content">
                    <button type="button" onclick="location.href = 'appcta/create';" class="btn btn-primary">Agregar</button>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Nombre App</th>
                          <th>Cliente</th>
                          <th>RFCs</th>
                          <th>Gigas</th>
                          <th>Paquete</th>
                          <th>Cuenta</th>
                          <th>Fecha Venta</th>
                          <th>Fecha Act.</th>
                          <th>Fecha Fin</th>
                          <th>Fecha Cad.</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($appctas as $appcta)
                        <tr>
                        	<td>{{ $appcta->id }}</td>
                        	<td>{{ $appcta->appcta_app }}</td>
                          <td>{{ $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_nom:'') : ''  }}</td>
                        	<td>{{ $appcta->appcta_rfc }}</td>
                        	<td>{{ $appcta->appcta_gig }}</td>
                        	<td>{{ $appcta->package ? $appcta->package->paq_nom : ''  }}</td>
                        	<td>{{ $appcta->account ? $appcta->account->cta_num : ''  }}</td>
                        	<td>{{ $appcta->appcta_f_vent }}</td>
                        	<td>{{ $appcta->appcta_f_act }}</td>
                        	<td>{{ $appcta->appcta_f_fin }}</td>
                        	<td>{{ $appcta->appcta_f_caduc }}</td>


              					

                            <td class=" last" width="13%">
                                      
                                      
                                      <div class="btn-group">
                                          <div class="btn-group">
                                              <button onclick="location.href = 'appcta/{{$appcta->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#790D4E "><i class="fa fa-edit fa-2x"></i> </button>
                                          </div>

                                              
                                              {{ Form::open(['route' => ['appcta.destroy', $appcta->id], 'class'=>'pull-right']) }}
                                              {{ Form::hidden('_method', 'DELETE') }}
                                              <button  href="#" class="btn btn-xs" onclick="return confirm('¿Está seguro que quiere eliminar este registro?')" type="submit" data-placement="left" title="Borrar" style=" color:#790D4E "><i class="fa fa-trash fa-2x"></i></button>
                                            {{ Form::close() }}

                                          </div>


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

    <script>
      $( function() {
          $('#alertmsgcta').click(function() {
              console.log('alertmsgcta button clicked');
          });
          
          setTimeout(function() {
              $('#alertmsgcta').trigger('click');
          }, 4e3);
      });
    </script>
@endsection