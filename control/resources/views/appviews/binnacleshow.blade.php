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
                            <h2>Bitácora</h2>

                            <div class="clearfix"></div>
                          </div>
                          <br/>

                          <div class="x_content">

                            <table id="datatable-buttons" class="table table-striped table-bordered">
                              <thead>
                                <tr>
                                  <th>Id</th>
		                          <th>Usuario</th>
		                          <th>Fecha</th>
		                          <th>Tipo Operación</th>
		                          <th>Ip</th>
		                          <th>Navegador</th>
		                          <th>Modulo</th>
		                          <th>Mensaje</th>
		                          <th>Datos</th>

                                </tr>
                              </thead>


                              <tbody>
                                  @foreach ($binnacles as $binnacle)
                                <tr>
									<td>{{ $binnacle->id }}</td>
		                        	<td>{{ $binnacle->user ? $binnacle->user->name : ''  }}</td>
		                        	<td>{{ $binnacle->bitc_fecha }}</td>
		                        	<td>{{ $binnacle->bitc_tipo_op }}</td>
		                        	<td>{{ $binnacle->bitc_ip }}</td>
		                        	<td>{{ $binnacle->bitc_naveg }}</td>
		                        	<td>{{ $binnacle->bitc_modulo }}</td>
		                        	<td>{{ $binnacle->bitc_msj }}</td>
		                        	<td>{{ $binnacle->bitc_dat }}</td>


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
               <script src="{{ asset('controlassets/vendors/iCheck/icheck.min.js') }}"></script>
            <script src="{{ asset('controlassets/vendors/datatables.net/js/jquery.dataTables.js') }}"></script>

            <script src="{{ asset('controlassets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
            <script src="{{ asset('controlassets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ asset('controlassets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
            <!--<script src="{{ asset('controlassets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
            <script src="{{ asset('controlassets/vendors/jszip/dist/jszip.min.js') }}"></script>
            <script src="{{ asset('controlassets/vendors/pdfmake/build/pdfmake.min.js') }}"></script>
            <script src="{{ asset('controlassets/vendors/pdfmake/build/vfs_fonts.js') }}"></script>-->
            <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>


@endsection