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
                    <h2>Usuarios</h2>
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
                    @if(Auth::user()->usrc_admin || Auth::user()->can('create.users'))
                        <button type="button" style=" background-color:#053666 " onclick="location.href = 'user/create';" class="btn btn-primary">Agregar</button>
                    @endif
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Usuario</th>
                                <th>Correo</th>                          
                                <th>Teléfono</th>
                                <th>Distribuidor Asociado</th>
                                <th>Supervisor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                	<td>{{ $user->name }}</td>
                                	<td>{{ $user->usrc_nick }}</td>
                                	<td>{{ $user->email }}</td>
                                	<td>{{ $user->usrc_tel }}</td>
                                	<td>{{ $user->distributor ? $user->distributor->distrib_nom : '' }}</td>
                                	<td>{{ $user->usrc_super ? 'Si' : 'No' }}</td>
                                    <td class=" last" width="18%">
                                        <div class="btn-group">
                                            @if(Auth::user()->usrc_admin || Auth::user()->can('edit.users'))
                                                <div class="btn-group">
                                                    <button onclick="location.href = 'user/{{$user->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar"><i class="fa fa-edit fa-2x"></i> </button>
                                                </div>
                                            @endif

                                            @if(Auth::user()->usrc_admin || Auth::user()->can('change.password.users'))
                                                <div class="btn-group">
                                                    <button onclick="showModal('passmodal'+{{$user->id}})" class="btn btn-xs" data-placement="left" title="Cambiar contraseña"><i class="fa fa-lock fa-2x"></i> </button>
                                                </div>
                                            @endif

                                            @if(Auth::user()->usrc_admin || Auth::user()->can('assign.roles.users'))
                                                <div class="btn-group">
                                                    <button onclick="showModal('rolesmodal'+{{$user->id}})" class="btn btn-xs" data-placement="left" title="Asignar Roles"><i class="fa fa-group fa-2x"></i> </button>
                                                </div>
                                            @endif

                                            @if(Auth::user()->usrc_admin || Auth::user()->can('assign.perms.users'))
                                                <div class="btn-group">
                                                    <button onclick="showModal('permsmodal'+{{$user->id}})" class="btn btn-xs" data-placement="left" title="Asignar Permisos"><i class="fa fa-thumbs-o-up fa-2x"></i> </button>
                                                </div>
                                            @endif

                                            <div class="modal fade" id="passmodal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Cambio de contraseña: {{$user->name}}</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="form-group">
                                                                    <input placeholder="Contraseña" required="required" type="password" class="form-control" id="password{{$user->id}}" style="width: 500px;">
                                                                </div>
                                                            </form>
                                                            <div id="result_failure{{$user->id}}"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" onclick="cleanPass({{$user->id}});" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="button"  onclick="changePass({{$user->id}});" class="btn btn-primary">Ok</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="rolesmodal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Asignación de roles: {{$user->name}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <form>
                                                            <div class="item form-group">
                                                                <div class="col-md-10 col-sm-10 col-xs-12">
                                                                    <select id="roles" name="roles[]" tabindex="2" data-placeholder="Seleccione los permisos ..." name="rolesapp" class="chosen-select form-control" onchange="onSelectAssignRole(this)" multiple="multiple" style="width: 500px; display: none;">
                                                                        @foreach($roles as $role)
                                                                            <option value="{{ $role->id }}" {{$user->hasRole($role->id) ? 'selected':''}} >{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                          </form>
                                                          <div id="result_failure_rol{{$user->id}}"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="button"  onclick="userAssignRole({{$user->id}});" class="btn btn-primary">Ok</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal fade" id="permsmodal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Asignación de permisos: {{$user->name}}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="item form-group">
                                                                    <div class="col-md-10 col-sm-10 col-xs-12">
                                                                        <select id="permisos" name="permisos[]" tabindex="2" data-placeholder="Seleccione los permisos ..." name="rolesapp" class="chosen-select form-control" onchange="onSelectAssignPerm(this)" multiple="multiple" style="width: 500px; display: none;">
                                                                            @foreach($permissions as $permission)
                                                                                <option value="{{ $permission->id }}" {{$user->customGetUserPerms($permission->id,true) ? 'selected':''}} >{{ $permission->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div id="result_failure_pemr{{$user->id}}"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="button"  onclick="userAssignPerm({{$user->id}});" class="btn btn-primary">Ok</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if(Auth::user()->usrc_admin || Auth::user()->can('delete.users'))
                                                {{ Form::open(['route' => ['user.destroy', $user], 'class'=>'pull-right']) }}
                                                    {{ Form::hidden('_method', 'DELETE') }}
                                                        <button  href="#" class="btn btn-xs" onclick="return confirm('¿Está seguro que quiere eliminar este registro?')" type="submit" data-placement="left" title="Borrar" ><i class="fa fa-trash fa-2x"></i></button>
                                                {{ Form::close() }}
                                            @endif
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
        var selectedrol = [];
        var selectedperm = [];

        function getSelectValues(select){
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

        function onSelectAssignRole(element){
            selectedrol = getSelectValues(element);
        }

        function onSelectAssignPerm(element){
            selectedperm = getSelectValues(element);
        }

        function showModal(modalid) {
            $("#"+modalid).modal('show');
            $("#"+modalid).on('shown.bs.modal', function () {
            $('.chosen-select', this).chosen('destroy').chosen();
                var comparerolesmodal = modalid.search("rolesmodal");
                var comparepermsmodal = modalid.search("permsmodal");
                if(comparerolesmodal >= 0){
                    selectedrol = $('.chosen-select', this).chosen().val() ;
                }
                if(comparepermsmodal >= 0){
                    selectedperm = $('.chosen-select', this).chosen().val() ;
                }
            });
        }

        function hideModal(modalid) {
          $("#"+modalid).modal('hide');
        }

        function changePass(user){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var passid = "password"+user;
            var password = document.getElementById(passid).value;

            hideModal("passmodal"+user);
            $('#loadingmodal').modal('show');

            if(password){
                $.ajax({
                    url: 'user/changepass',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN,password:password,user:user},
                    dataType: 'JSON',
                    success: function (data) {
                        $('#loadingmodal').modal('hide');
                        new PNotify({
                            title: "Notificación",
                            type: "info",
                            text: "La contraseña ha sido cambiada satisfactoriamente",
                            nonblock: {
                                nonblock: true
                            },
                            addclass: 'dark',
                            styling: 'bootstrap3'
                        });
                      document.getElementById('password'+data['user']).value = '';
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                    }
                });
            }else{
              $("#result_failure"+user).html('<p><strong>La contraseña es obligatoria</strong></p>');
            }        
        }

        function userAssignRole(user){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'user/assignroles',
                type: 'POST',
                data: {_token: CSRF_TOKEN,selected:selectedrol,user:user},
                dataType: 'JSON',
                success: function (data) {
                    hideModal("rolesmodal"+data['user']);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                }
            });       
        }

        function userAssignPerm(user){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'user/assignperms',
                type: 'POST',
                data: {_token: CSRF_TOKEN,selected:selectedperm,user:user},
                dataType: 'JSON',
                success: function (data) {
                    hideModal("permsmodal"+data['user']);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                }
            });        
        }


    function cleanPass(userid){
      document.getElementById('password'+userid).value = '';
    }

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