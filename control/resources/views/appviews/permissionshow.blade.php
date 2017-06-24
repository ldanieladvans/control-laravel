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
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <!--<th>Id</th>-->
                          <th>Nombre</th>
                          <th>Código</th>
                          <th>Descripción</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>


                      <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                        	<!--<td>{{ $permission->id }}</td>-->
                        	<td>{{ $permission->name }}</td>
                        	<td>{{ $permission->slug }}</td>
                        	<td>{{ $permission->description }}</td>


                          <td class=" last" width="13%">
                                      
                                      
                                      <div class="btn-group">

                                        <div class="btn-group">
                                              <button onclick="location.href = 'permission/{{$permission->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" ><i class="fa fa-edit fa-3x"></i> </button>
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