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
                    <button type="button" onclick="location.href = 'user/create';" class="btn btn-primary">Agregar</button>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
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
                        	<td>{{ $user->id }}</td>
                        	<td>{{ $user->name }}</td>
                        	<td>{{ $user->usrc_nick }}</td>
                        	<td>{{ $user->email }}</td>
                        	<td>{{ $user->usrc_tel }}</td>
                        	<td>{{ $user->distributor ? $user->distributor->distrib_nom : '' }}</td>
                        	<td>{{ $user->usrc_super }}</td>


              					

                            <td class=" last" width="13%">
                                      
                                      
                                      <div class="btn-group">
                                          <div class="btn-group">
                                              <button onclick="location.href = 'user/{{$user->id}}/edit';" class="btn btn-xs" data-placement="left" title="Editar" style=" color:#790D4E "><i class="fa fa-edit fa-2x"></i> </button>
                                          </div>

                                        <div class="btn-group">
                                              <button onclick="" data-toggle="dropdown" class="btn btn-xs dropdown-toggle" data-placement="left" title="Más" style=" color:#790D4E "><i class="fa fa-plus-square fa-2x"></i> </button>
                                                <ul role="menu" class="dropdown-menu">
                                                  <li><a id="passmodallink{{$user->id}}" onclick="showModal({{$user->id}})">Cambiar contraseña</a>
                                                  </li>
                                                </ul>

                                                <!--<div id="passmodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                      






                                                    </div>
                                                  </div>
                                                </div>-->



                                               <div class="modal fade" id="passmodal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Cambio de contraseña: {{$user->name}}</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <form>
                                                        <div class="form-group">
                                                          <input placeholder="Contraseña" required="required" type="password" class="form-control" id="password{{$user->id}}">
                                                        </div>
                                                      </form>

                                                      <div id="result_failure{{$user->id}}"></div>

                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                      <button type="button"  onclick="changePass({{$user->id}});" class="btn btn-primary">Ok</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>







                                          </div>

                                              
                                              {{ Form::open(['route' => ['user.destroy', $user], 'class'=>'pull-right']) }}
                                              {{ Form::hidden('_method', 'DELETE') }}
                                              <button  href="#" class="btn btn-xs" onclick="return confirm('¿Está seguro que quiere eliminar este registro?')" type="submit" data-placement="left" title="Borrar" style=" color:#790D4E "><i class="fa fa-trash fa-2x"></i></button>
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
    <!-- FastClick -->
    <script src="{{ asset('controlassets/vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>

    <script>

        function showModal(user) {
          var modalid = "passmodal"+user;
          $("#"+modalid).modal('show');
        }

        function hideModal(user) {
          var modalid = "passmodal"+user;
          $("#"+modalid).modal('hide');
        }


        function changePass(user){

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var passid = "password"+user;

            var password = document.getElementById(passid).value;



            if(password){
              $.ajax({
                url: 'user/changepass',
                type: 'POST',
                data: {_token: CSRF_TOKEN,password:password,user:user},
                dataType: 'JSON',
                success: function (data) {

                  //console.log(data);
                  hideModal(data['user']);
                    
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    //alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    $("#result_failure"+user).html('<p><strong>Ocurrió un error: '+errorThrown+'</strong></p>');
                }
            });
            }else{
              $("#result_failure"+user).html('<p><strong>La contraseña es obligatoria</strong></p>');
              
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