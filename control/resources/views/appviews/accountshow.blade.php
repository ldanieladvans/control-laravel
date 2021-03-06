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
                    <div class="alert alert-success alert-dismissible fade in" role="alert" id="ctams">
                        <button type="button" id="alertmsgcta" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ Session::get('message') }}</strong>
                    </div>
                @endif

                <div class="x_content">
                    @if(Auth::user()->usrc_admin || Auth::user()->can('create.accounts'))
                        <button type="button" style=" background-color:#053666 " onclick="location.href = 'account/create';" class="btn btn-primary">Agregar</button>
                    @endif
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Número de Cuenta</th>
                                <th>Fecha Activación</th>
                                <th>Cliente</th>
                                <th>Distribuidor</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accounts as $acc)
                                <tr>
                                	<td>{{ $acc->cta_num }}</td>
                                    <td>{{ $acc->cta_fecha }}</td>
                                    <td>{{ $acc->client ?  $acc->client->cliente_nom : '' }}</td>
                                    <td>{{ $acc->distributor ? $acc->distributor->distrib_nom : '' }}</td>
                                	<td>{{ $acc->cta_estado }}</td>
                                    <td class=" last" width="18%">               
                                        @if(Auth::user()->usrc_admin || Auth::user()->can('edit.accounts'))
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button onclick="location.href = 'account/{{$acc->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" ><i class="fa fa-edit fa-2x"></i> </button>
                                                </div>
                                                @if(Auth::user()->usrc_admin || Auth::user()->can('change.state.accounts'))
                                                    @if ($acc->cta_estado == 'Inactiva')
                                                        <button onclick="changeAccountState('Activa',{{Auth::user()->id}},{{$acc->id}})" class="btn btn-xs" data-placement="left" title="Activar Cuenta" ><i class="fa fa-check fa-2x"></i> </button>
                                                    @else
                                                        <button onclick="changeAccountState('Inactiva',{{Auth::user()->id}},{{$acc->id}})" class="btn btn-xs" data-placement="left" title="Desactivar Cuenta" ><i class="fa fa-times fa-2x"></i> </button>
                                                    @endif
                                                @endif

                                                @if(Auth::user()->usrc_admin || Auth::user()->can('see.bit.accounts'))
                                                    <div class="btn-group">
                                                        <button onclick="getBin('{{ $acc->cta_num }}',{{Auth::user()->id}},{{$acc->id}})" class="btn btn-xs" data-placement="left" title="Bitácora" ><i class="fa fa-eye fa-2x"></i> </button>
                                                    </div>
                                                @endif

                                                @if(Auth::user()->usrc_admin || Auth::user()->can('unlock.users.accounts'))
                                                    <div class="btn-group">
                                                        <button onclick="getCtaUsers('{{ $acc->cta_num }}',{{Auth::user()->id}},{{$acc->id}})" class="btn btn-xs" data-placement="left" title="Desbloquear Usuarios" ><i class="fa fa-unlock fa-2x"></i> </button>
                                                    </div>
                                                @endif

                                                <div class="modal fade" id="ctauser{{$acc->cta_num}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Usuarios de cuenta: {{$acc->cta_num}}</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <table id="datatable-responsive{{$acc->cta_num}}" cellspacing="0" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Nombre</th>
                                                                                <th>Correo</th>
                                                                                <th>Bloqueado</th>
                                                                                <th>Acciones</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </form>
                                                                <div id="result_failure_rol{{$acc->cta_num}}"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cleanctausertable('{{$acc->cta_num}}')">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="modal fade" id="binacle{{$acc->cta_num}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Últimas 10 entradas de la bitácora de la cuenta: {{$acc->cta_num}}</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <div class="x_content">
                                                                        <table id="datatable-responsive-bin{{$acc->cta_num}}" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Fecha</th>
                                                                                    <th>Módulo</th>
                                                                                    <th>Ip</th>
                                                                                    <th>Tipo</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </form>
                                                              <div id="result_failure_bin{{$acc->cta_num}}"></div>
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cleanbintable('{{$acc->cta_num}}')">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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

        function unlockUsers(aux_param){
            var res = aux_param.split("$");
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/unblockuser',
                type: 'POST',
                data: {_token: CSRF_TOKEN,userid:res[0],rfc:res[1]},
                dataType: 'JSON',
                success: function (data) {
                    cleanTable('datatable-responsive'+data['rfc']);
                    window.location.href = window.location.href;
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    new PNotify({
                    title: "Notificación",
                    type: "info",
                    text: "Ha ocurrido un error",
                    nonblock: {
                      nonblock: true
                    },
                    addclass: 'dark',
                    styling: 'bootstrap3'
                  });
                }
            });
        }

        function changeAccountState(accstate,user,accid){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var result = confirm("Debe tener en cuenta que un cambio de estado en la cuenta puede implicar creación o bloqueos de las mismas. ¿Está seguro que desea continuar?");
            if(result){
                $('#loadingmodal').modal('show');
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
        }

        function getCtaUsers(rfc,user,accid){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#loadingmodal').modal('show');
            $.ajax({
                url: '/getctausers',
                type: 'POST',
                data: {_token: CSRF_TOKEN,rfc:rfc,user:user,accid:accid},
                dataType: 'JSON',
                success: function (data) {
                    $('#'+data['modalname']).modal('show');
                    $('#loadingmodal').modal('hide');

                    var aux_rfc = String(data['rfc']);

                    data['users'].forEach(function(item){
                        var aux_param = String(item.id)+'$'+aux_rfc;
                        if(item.users_blocked == 1){
                          $('#datatable-responsive'+data['rfc']).find('tbody').append( "<tr><td>"+item.name+"</td><td>"+item.email+"</td><td>Si</td><td><div class='btn-group'><div class='btn-group'><a id='"+data['rfc']+"' onclick='unlockUsers("+'"'+aux_param+'"'+")' class='btn btn-xs' data-placement='left' title='Desbloquear' ><i class='fa fa-unlock fa-3x'></i> </a></div></td></tr>");
                        }else{
                          $('#datatable-responsive'+data['rfc']).find('tbody').append( "<tr><td>"+item.name+"</td><td>"+item.email+"</td><td>No</td><td></td></tr>");
                        }
                    });                   
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    new PNotify({
                    title: "Notificación",
                    type: "info",
                    text: "Ha ocurrido un error",
                    nonblock: {
                      nonblock: true
                    },
                    addclass: 'dark',
                    styling: 'bootstrap3'
                  });
                }
            });      
        }

        function getBin(rfc,user,accid){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#loadingmodal').modal('show');
            $.ajax({
                url: '/getctabin',
                type: 'POST',
                data: {_token: CSRF_TOKEN,rfc:rfc,user:user,accid:accid},
                dataType: 'JSON',
                success: function (data) {
                    var aux_rfc = String(data['rfc']);

                    data['bitentries'].forEach(function(item){
                        var aux_param = String(item.id)+'$'+aux_rfc;
                        $('#datatable-responsive-bin'+data['rfc']).find('tbody').append( "<tr><td>"+item.bitc_fecha+"</td><td>"+item.bitc_modulo+"</td><td>"+item.bitcta_ip+"</td><td>"+item.bitcta_tipo_op+"</td></tr>");
                    });

                  $('#loadingmodal').modal('hide');
                  $('#binacle'+aux_rfc).modal('show');                  
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    new PNotify({
                    title: "Notificación",
                    type: "info",
                    text: "Ha ocurrido un error",
                    nonblock: {
                      nonblock: true
                    },
                    addclass: 'dark',
                    styling: 'bootstrap3'
                  });
                }
            }); 
     
        }

        function cleanctausertable(bdid){
            var table = document.getElementById('datatable-responsive'+bdid);
            var rowCount = table.rows.length;

            while(table.rows.length > 1){
                table.deleteRow(1);
            }
        }

        function cleanbintable(bdid){
            var table = document.getElementById('datatable-responsive-bin'+bdid);
            var rowCount = table.rows.length;
            while(table.rows.length > 1){
                table.deleteRow(1);
            }
        }
    </script>
@endsection