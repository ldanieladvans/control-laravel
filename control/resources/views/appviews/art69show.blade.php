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
                    <h2>Entradas Art. 69</h2>
                    <div class="clearfix"></div>
                </div>

                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade in" role="alert" id="ctams">
                        <button type="button" id="alertmsgcta" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ Session::get('message') }}</strong>
                    </div>
                @endif

                <!--<div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12"></div>
                    <div class="col-md-4 col-sm-4 col-xs-12"></div>
                    <div class="col-md-4 col-sm-4 col-xs-12" align="right"><button type="button" style=" background-color:#053666;" onclick="showImportModal();" class="btn btn-primary">Importar</button></div>
                </div>-->

                <div class="x_content">
                    @if(Auth::user()->usrc_admin)
                        <button type="button" style=" background-color:#053666 " onclick="location.href = 'arts/create';" class="btn btn-primary">Agregar</button>
                    @endif
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>RFC</th>
                                <th>Contribuyente</th>
                                <th>Tipo</th>
                                <th>Oficio</th>
                                <th>Fecha SAT</th>
                                <th>Fecha DOF</th>
                                <th>URL Oficio</th>
                                <th>URL Anexo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="modal fade" id="importart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action='/importart' method='POST' enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Importar Art. 69</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                      <form>
                                        <div class="item form-group">
                                            
                                                <div class="col-md-10 col-sm-10 col-xs-12">
                                                    <input type='file' id='impfile' accept=".xls,.xlsx" required>
                                                </div>

                                        </div>
                                      
                                      <div id="import_failure"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="submit"  class="btn btn-primary">Ok</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
        $('#loadingmodal').modal('show');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/getart',
            type: 'POST',
            data: {_token: CSRF_TOKEN},
            dataType: 'JSON',
            success: function (data) {
                var dataTablevalues = [];
                var table_counter = 0;

                data['tabledata'].forEach(function(item){
                    dataTablevalues.push([item.rfc,item.contribuyente,item.tipo,item.oficio,item.fecha_sat,item.fecha_dof,"<a target='_blank' href='"+item.url_oficio+"'>"+item.url_oficio+"</a>","<a target='_blank' href='"+item.url_anexo+"'>"+item.url_anexo+"</a>","<div class='btn-group'><button onclick='location.href = editArt("+item.id+")' class='btn btn-xs' data-placement='left' title='Editar'><i class='fa fa-edit fa-2x'></i></button></div><div class='btn-group'><button onclick='deleteEntry("+item.id+")' class='btn btn-xs' data-placement='left' title='Borrar'><i class='fa fa-trash fa-2x'></i></button></div>"]);
                    table_counter ++;
                });

                $('#datatable-responsive').dataTable().fnDestroy();
                dtobj = $('#datatable-responsive').DataTable( {
                    data: dataTablevalues,
                });
                $('#loadingmodal').modal('hide');
 
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
               new PNotify({
                    title: "Notificación",
                    type: "info",
                    text: "Ocurrio un error",
                    nonblock: {
                        nonblock: true
                    },
                    addclass: 'dark',
                    styling: 'bootstrap3'
                });
            }
        });

        function editArt(id){
            return window.location.href+"/"+id+"/edit";
        }

        function deleteEntry(id){
            var result = confirm("¿Está seguro que desea borrar este registro?");
            if(result){
                $('#loadingmodal').modal('show');
                $.ajax({
                    url: '/destroyajax',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN,id:id},
                    dataType: 'JSON',
                    success: function (data) {
                       window.location.href = window.location.href;
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                       new PNotify({
                            title: "Notificación",
                            type: "info",
                            text: "Ocurrio un error",
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

        function showImportModal(){
            $('#importart').modal('show');
        }

        function importArts(){
            console.log(document.getElementById('impfile').value);
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