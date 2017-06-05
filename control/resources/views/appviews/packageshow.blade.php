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
                    <h2>Paquetes</h2>
                    
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
                    <button type="button" onclick="location.href = 'package/create';" class="btn btn-primary">Agregar</button>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Nombre</th>
                          <th>Gigas</th>
                          <th>RFCs</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($packages as $pack)
                        <tr>
                        	<td>{{ $pack->id }}</td>
                        	<td>{{ $pack->paq_nom }}</td>
                        	<td>{{ $pack->paq_gig }}</td>
                        	<td>{{ $pack->paq_rfc }}</td>


              					<td class=" last" width="15%">
                                  <div>
                                    <div class="btn-group">  
                                      <a data-placement="left" title="Editar" href="{{ route('package.edit', $pack) }}" class="btn btn-info btn-xs" type="button"><i class="fa fa-edit fa-2x"></i></a>
                                    </div>

                                    <div class="btn-group">
                                        <p></p>
                                      {{ Form::open(['route' => ['package.destroy', $pack], 'class'=>'pull-right']) }}
                                      {{ Form::hidden('_method', 'DELETE') }}
                                      <button data-placement="left" title="Eliminar" onclick="return confirm('¿Está seguro que quiere eliminar esta cuenta?')" class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash fa-2x"></i></button>
                                      {{ Form::close() }}
                                    </div>
                                      
                                    <div class="btn-group">
                                        <button data-placement="left" title="Más" data-toggle="dropdown" class="fa fa-plus-square fa-2x btn btn-success dropdown-toggle btn-sm btn-xs right" type="button" aria-expanded="false"><span class="caret"></span>
                                        </button>
                                        <ul role="menu" class="dropdown-menu">
                                          <li><a href="#">Action</a>
                                          </li>
                                          <li><a href="#">Another action</a>
                                          </li>
                                          <li><a href="#">Something else here</a>
                                          </li>
                                          <li><a href="#">Separated link</a>
                                          </li>
                                        </ul>
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