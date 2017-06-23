@extends('template.applayout')

@section('app_css')
	@parent
    <!-- Datatables -->
    <link href="{{ asset('controlassets/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('controlassets/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">

    <!-- Chosen -->
    
    <link href="{{ asset('controlassets/vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />

    <!-- PNotify -->
    <!--<link href="{{ asset('controlassets/pnotify/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css" />-->
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
                          
                          <!--<th>RFCs</th>
                          <th>Gigas</th>-->
                          <th>Paquete</th>
                          <th>Cuenta</th>
                          <th>Fecha Venta</th>
                          <th>Fecha Act.</th>
                          <th>Fecha Fin</th>
                          <th>Fecha Cad.</th>
                          <th>En Cuenta</th>
                          <th>Acciones</th>
                          
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($appctas as $appcta)
                        <tr>
                        	<td>{{ $appcta->id }}</td>
                        	<td>{{ $appcta->appcta_app }}</td>
                          <td>{{ $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_nom:'') : ''  }}</td>
                          
                        	<!--<td>{{ $appcta->appcta_rfc }}</td>
                        	<td>{{ $appcta->appcta_gig }}</td>-->
                        	<td>{{ $appcta->package ? $appcta->package->paq_nom : ''  }}</td>
                        	<td>{{ $appcta->account ? $appcta->account->cta_num : ''  }}</td>
                        	<td>{{ $appcta->appcta_f_vent }}</td>
                        	<td>{{ $appcta->appcta_f_act }}</td>
                        	<td>{{ $appcta->appcta_f_fin }}</td>
                        	<td>{{ $appcta->appcta_f_caduc }}</td>
                          <td>{{ $appcta->appcta_estado }}</td>


              					

                            <td class=" last" width="15%">
                                      
                                      
                                      <div class="btn-group">
                                          <div class="btn-group">
                                              <button onclick="location.href = 'appcta/{{$appcta->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#790D4E "><i class="fa fa-edit fa-2x"></i> </button>
                                          </div>





                                          <div class="btn-group">
                                              <button onclick="" data-toggle="dropdown" class="btn btn-xs dropdown-toggle" data-placement="left" title="Más" style=" color:#790D4E "><i class="fa fa-plus-square fa-2x"></i> </button>
                                                <ul role="menu" class="dropdown-menu">
                                                  
                                                  @if ($appcta->appcta_estado == 'Inactiva')
                                                      <li><a onclick="changeAccountState('Activa',{{Auth::user()->id}},{{$appcta->id}})">Activar en Cuenta</a>
                                                      </li>
                                                  @else
                                                      <li><a onclick="changeAccountState('Inactiva',{{Auth::user()->id}},{{$appcta->id}})">Desactivar en Cuenta</a>
                                                      </li>
                                                  @endif

                                                      <li><a id="appmodallink{{$appcta->id}}" onclick="showModal('appsmodal'+{{$appcta->id}})">Añadir Apps</a>
                                                      </li>

                                                </ul>



                                                <div class="modal fade" id="appsmodal{{$appcta->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Añadir Aplicaciones: {{$appcta->appcta_app}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <form>
                                                          <div class="item form-group">
                                                                <div class="col-md-10 col-sm-10 col-xs-12">
                                                                  <select id="roles" name="roles[]" tabindex="2" data-placeholder="Seleccione los permisos ..." name="rolesapp" class="chosen-select form-control" onchange="onSelectAssignApps(this)" multiple="multiple">
                                                                  
                                                                      <!--@foreach($apps as $key => $value)
                                                                        <option value="{{ $key }}" {{$appcta->hasApp($key,true) > 0 ? 'selected':''}}>{{ $value }}</option>
                                                                      @endforeach-->

                                                                      @foreach($apps as $key => $value)
                                                                        @if ($appcta->hasApp($key,true) == 0)
                                                                          <option value="{{ $key }}" >{{ $value }}</option>
                                                                        @endif
                                                                        
                                                                      @endforeach

                                                                  </select>
                                                                </div>
                                                          </div>
                                                        </form>

                                                        <div id="result_failure_rol{{$appcta->id}}"></div>

                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                        <button type="button"  onclick="assignApp({{Auth::user()->id}},{{$appcta->id}});" class="btn btn-primary">Ok</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>


                                          </div>




                                              
                                              <!--{{ Form::open(['route' => ['appcta.destroy', $appcta->id], 'class'=>'pull-right']) }}
                                              {{ Form::hidden('_method', 'DELETE') }}
                                              <button  href="#" class="btn btn-xs" onclick="return confirm('¿Está seguro que quiere eliminar este registro?')" type="submit" data-placement="left" title="Borrar" style=" color:#790D4E "><i class="fa fa-trash fa-2x"></i></button>
                                            {{ Form::close() }}-->

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

    <!-- Chosen -->
  <script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
  <script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
  <script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>

    <!-- PNotify -->
    <!--<script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>-->

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

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

      var selectedapps = [];

      function showModal(modalid) {
          $("#"+modalid).modal('show');
          $("#"+modalid).on('shown.bs.modal', function () {
            $('.chosen-select', this).chosen('destroy').chosen();
          });
        }

        function hideModal(modalid) {
          $("#"+modalid).modal('hide');
        }

      function getSelectValues(select) {
          var result = [];
          var options = select && select.options;
          var opt;

          for (var i=0, iLen=options.length; i<iLen; i++) {
            opt = options[i];

            if (opt.selected) {
              result.push(opt.value || opt.text);
            }
          }
          return result;
        }

      function onSelectAssignApps(element){
        selectedapps = getSelectValues(element);
      }


      function assignApp(user,appctaid){

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
              url: '/assignapps',
              type: 'POST',
              data: {_token: CSRF_TOKEN,selected:selectedapps,user:user,appctaid:appctaid},
              dataType: 'JSON',
              success: function (data) {

                hideModal("appsmodal"+data['app']);
                window.location.href = window.location.href;
                  
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) { 
                  $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
              }
          });       
        }


      function changeAccountState(accstate,user,appctaid){
              $('#loadingmodal').modal('show');
              $.ajax({
                url: '/changestateaccount',
                type: 'POST',
                data: {_token: CSRF_TOKEN,accstate:accstate,user:user,appctaid:appctaid},
                dataType: 'JSON',
                success: function (data) {
                  window.location.href = window.location.href;
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    new PNotify({
                    title: "Notificación",
                    type: "info",
                    text: "Ha ocurrido un error. No se ha podido cambiar el estado en la app Cuenta",
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