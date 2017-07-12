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
                    <button type="button" style=" background-color:#053666 " onclick="location.href = 'appcta/create';" class="btn btn-primary">Agregar</button>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre App</th>
                                <th>Cliente</th>
                                <th>Paquete</th>
                                <th>Cuenta</th>
                                <th>Gigas</th>
                                <th>RFCs</th>
                                <th>Aplicaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appctas as $appcta)
                                <tr>
                            	    <td>{{ $appcta->appcta_app }}</td>
                                    <td>{{ $appcta->account ? ($appcta->account->client ? $appcta->account->client->cliente_nom:'') : ''  }}</td>
                        	        <td>{{ $appcta->package ? $appcta->package->paq_nom : ''  }}</td>
                            	    <td>{{ $appcta->account ? $appcta->account->cta_num : ''  }}</td>
                                    <td>{{ $appcta->appcta_gig }}</td>
                                    <td>{{ $appcta->appcta_rfc }}</td>
                        	        <td>
                                    @foreach($appcta->apps as $apploop)
                                        @if ($loop->last)
                                            {{ $apploop->app_nom }} <br />
                                        @else
                                            {{ $apploop->app_nom }}, <br />
                                        @endif
                                    @endforeach 
                                    </td>
                                    <td class=" last" width="15%">
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button onclick="location.href = 'appcta/{{$appcta->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" ><i class="fa fa-edit fa-2x"></i> </button>
                                            </div>

                                            <div class="btn-group">
                                                <button onclick="showModal('appsmodal'+{{$appcta->id}})" class="btn btn-xs" data-placement="left" title="Añadir Apps" ><i class="fa fa-plus-square-o fa-2x"></i> </button>
                                            </div>

                                            <div class="btn-group">
                                                <button onclick="showModal('appsmodalquit'+{{$appcta->id}})" class="btn btn-xs" data-placement="left" title="Quitar Apps" ><i class="fa fa-minus-square-o fa-2x"></i> </button>
                                            </div>

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
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <select id="roles" name="roles[]" tabindex="2" data-placeholder="Seleccione los permisos ..." name="rolesapp" class="chosen-select form-control" onchange="onSelectAssignApps(this)" multiple="multiple" style="width: 500px; display: none;">
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

                                            <div class="modal fade" id="appsmodalquit{{$appcta->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Aplicaciones de cuenta {{$appcta->appcta_app}} a eliminar</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="item form-group">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <select id="roles" name="roles[]" tabindex="2" data-placeholder="Seleccione los permisos ..." name="rolesapp" class="chosen-select form-control" onchange="onSelectQuitApps(this)" multiple="multiple" style="width: 500px; display: none;">
                                                                            @foreach($apps as $key => $value)
                                                                                @if ($appcta->hasApp($key,true) > 0)
                                                                                    <option value="{{ $key }}" >{{ $value }}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        <div id="result_failure_rol_quit{{$appcta->id}}"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="button"  onclick="quitApp({{Auth::user()->id}},{{$appcta->id}});" class="btn btn-primary">Ok</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <script src="{{ asset('controlassets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('controlassets/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- Chosen -->
    <script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
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
        var quitapps = [];

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

        function onSelectQuitApps(element){
            quitapps = getSelectValues(element);
        }

        function assignApp(user,appctaid){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/assignapps',
                type: 'POST',
                data: {_token: CSRF_TOKEN,selected:selectedapps,user:user,appctaid:appctaid},
                dataType: 'JSON',
                success: function (data){
                    hideModal("appsmodal"+data['app']);
                    window.location.href = window.location.href; 
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                }
            });       
        }

        function quitApp(user,appctaid){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/quitapps',
                type: 'POST',
                data: {_token: CSRF_TOKEN,selected:quitapps,user:user,appctaid:appctaid},
                dataType: 'JSON',
                success: function (data){
                    hideModal("appsmodalquit"+data['app']);
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