@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Datatables -->
    <link href="{{ asset('controlassets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <!-- PNotify -->
    <link href="{{ asset('controlassets/pnotify/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Animate -->
    <link href="{{ asset('controlassets/animate.css') }}" rel="stylesheet" type="text/css" />
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
                  <div class="alert alert-success alert-dismissible fade in" role="alert" id="ctams">
                    <button type="button" id="alertmsgcta" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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


                          <td class=" last" width="13%">
                                      
                                      
                                      <div class="btn-group">
                                          <div class="btn-group">
                                              <button onclick="location.href = 'account/{{$acc->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#790D4E "><i class="fa fa-edit fa-2x"></i> </button>
                                          </div>

                                        <div class="btn-group">
                                              <button onclick="" data-toggle="dropdown" class="btn btn-xs dropdown-toggle" data-placement="left" title="Más" style=" color:#790D4E "><i class="fa fa-plus-square fa-2x"></i> </button>
                                                <ul role="menu" class="dropdown-menu">
                                                  @if ($acc->cta_estado == 'Inactiva')
                                                      <li><a onclick="changeAccountState('Activa',{{Auth::user()->id}},{{$acc->id}})">Activar Cuenta</a>
                                                      </li>
                                                  @else
                                                      <li><a onclick="changeAccountState('Inactiva',{{Auth::user()->id}},{{$acc->id}})">Inactivar Cuenta</a>
                                                      </li>
                                                  @endif

                                                </ul>
                                          </div>

                                              
                                              {{ Form::open(['route' => ['account.destroy', $acc], 'class'=>'pull-right']) }}
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
    <!-- PNotify -->
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
    <!--<script src="{{ asset('controlassets/pnotify/pnotify.custom.min.js') }}"></script>-->

    <script>
      $( function() {
          $('#alertmsgcta').click(function() {
              console.log('alertmsgcta button clicked');
          });
          
          setTimeout(function() {
              $('#alertmsgcta').trigger('click');
          }, 4e3);
      });

      function changeAccountState(accstate,user,accid){

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

              $.ajax({
                url: 'account/changeAccState',
                type: 'POST',
                data: {_token: CSRF_TOKEN,accstate:accstate,user:user,accid:accid},
                dataType: 'JSON',
                success: function (data) {
                  window.location.href = window.location.href;
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    new PNotify({
                    title: "Notificación",
                    type: "info",
                    text: "Ha ocurrido un error. No se ha podido cambiar el estado de la cuenta",
                    nonblock: {
                      nonblock: true
                    },
                    addclass: 'dark',
                    styling: 'bootstrap3'
                  });
                }
            });       
        }
    </script>
@endsection