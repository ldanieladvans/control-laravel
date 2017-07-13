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
                    <h2>Roles</h2>
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
                    <button type="button" style=" background-color:#053666 " onclick="location.href = 'role/create';" class="btn btn-primary">Agregar</button>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Código</th>
                                <th>Acciones</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $rol)
                                <tr>
                        	        <td>{{ $rol->name }}</td>
                        	        <td>{{ $rol->slug }}</td>
                                    <td class=" last" width="15%">
                                        <div class="btn-group">
                                            <div class="btn-group">
                                                <button onclick="location.href = 'role/{{$rol->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar"><i class="fa fa-edit fa-2x"></i> </button>
                                            </div>

                                            <div class="btn-group">
                                                <button  onclick="showModal({{$rol->id}})" class="btn btn-xs" data-placement="left" title="Asignar Permisos"><i class="fa fa-thumbs-o-up fa-2x"></i> </button>
                                            </div>

                                            <div class="modal fade" id="permsmodal{{$rol->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel">Asignación de permisos: {{$rol->name}}</h5>
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
                                                                                <option value="{{ $permission->id }}" {{Auth::user()->customGetRolePerms($rol->id,$permission->id,true) > 0 ? 'selected':''}} >{{ $permission->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div id="result_failure{{$rol->id}}"></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            <button type="button"  onclick="assignPerm({{$rol->id}});" class="btn btn-primary">Ok</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ Form::open(['route' => ['role.destroy', $rol->id], 'class'=>'pull-right']) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                <button  href="#" class="btn btn-xs" onclick="return confirm('¿Está seguro que quiere eliminar este registro?')" type="submit" data-placement="left" title="Borrar" ><i class="fa fa-trash fa-2x"></i></button>
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
    <!-- Chosen -->
    <script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        var selected = [];

        function showModal(rol) {
            var modalid = "permsmodal"+rol;
            $("#"+modalid).modal('show');
            $("#"+modalid).on('shown.bs.modal', function () {
                $('.chosen-select', this).chosen('destroy').chosen();
            });
        }

        function hideModal(rol) {
            var modalid = "permsmodal"+rol;
            $("#"+modalid).modal('hide');
        }

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

        function onSelectAssignPerm(element){
            selected = getSelectValues(element);
        }

        function assignPerm(rol){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            if(selected){
                $.ajax({
                    url: 'role/assignPerm ',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN,selected:selected,rol:rol},
                    dataType: 'JSON',
                    success: function (data) {
                        hideModal(data['rol']);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        $("#result_failure"+rol).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                    }
                });
            }else{
              $("#result_failure"+user).html('<p><strong>sss</strong></p>');
            }   
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