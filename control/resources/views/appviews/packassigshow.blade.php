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
                    <h2>Asignaciones a Distribuidores</h2>
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
                    @if(Auth::user()->usrc_admin || Auth::user()->can('create.assigs'))
                        <button type="button" style=" background-color:#053666 " onclick="location.href = 'asigpaq/create';" class="btn btn-primary">Agregar</button>
                    @endif
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Distribuidor</th>
                                <th>Soluciones</th>
                                <th>Megas</th>
                                <th>Fecha Venta</th>
                                <th>Fecha Act.</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asigpaqs as $asigpaq)
                                <tr>
                                    <td>{{ $asigpaq->distributor ? $asigpaq->distributor->distrib_nom : ''  }}</td>
                                    <td>{{ $asigpaq->asigpaq_rfc }}</td>
                                    <td>{{ $asigpaq->asigpaq_gig }}</td>                        
                                    <td>{{ $asigpaq->asigpaq_f_vent }}</td>
                                    <td>{{ $asigpaq->asigpaq_f_act }}</td>
                                    <td class=" last" width="13%">
                                        <div class="btn-group">
                                            @if(Auth::user()->usrc_admin || Auth::user()->can('edit.assigs'))
                                                <div class="btn-group">
                                                    <button onclick="location.href = 'asigpaq/{{$asigpaq->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" ><i class="fa fa-edit fa-2x"></i> </button>
                                                </div>
                                            @endif

                                            @if(Auth::user()->usrc_admin || Auth::user()->can('delete.assigs'))
                                                {{ Form::open(['route' => ['asigpaq.destroy', $asigpaq->id], 'class'=>'pull-right']) }}
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