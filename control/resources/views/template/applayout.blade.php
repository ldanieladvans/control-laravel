@extends('template.apptemplate')

@section('app_title','Control App')

@section('app_css')
	@parent
    <!-- iCheck -->
    <link href="{{ asset('controlassets/vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">	
    <!-- bootstrap-progressbar -->
    <link href="{{ asset('controlassets/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('controlassets/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
@endsection

@section('app_body')
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				
				@section('app_left_menu')
		            <div class="col-md-3 left_col">
					    <div class="left_col scroll-view">
					      <div class="navbar nav_title" style="border: 0;">
					      	<a href="{{ route('home') }}" class="site_title"><img height="60px" src="{{asset('logo_advans.png')}}"><span>{{ config('app.name') }}</span></a>
					      </div>
					      <div class="clearfix"></div>
					      <!-- menu profile quick info -->
					      <div class="profile clearfix">
					        
					        <div class="profile_info">
					          <span>Hola</span>
					          <h2><strong>{{ Auth::user()->name }}</strong></h2>
					        </div>
					      </div>
					      <!-- /menu profile quick info -->
					      <br />
					      <!-- sidebar menu -->
					      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
					        <div class="menu_section">
					          <h3>Menus</h3>
					          <ul class="nav side-menu">
					            <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> <strong>INICIO</strong> </span></a>
					              
					            </li>
					            <li><a><i class="fa fa-group"></i> <strong>DIRECTORIO</strong> <span class="fa fa-chevron-down"></span></a>
					              <ul class="nav child_menu">
					                <li><a href="{{ route('client.index') }}"><strong>CLIENTES</strong></a></li>
					                <li><a href="{{ route('distributor.index') }}"><strong>DISTRIBUIDORES</strong></a></li>
					              </ul>
					            </li>
					            <li><a><i class="fa fa-exchange"></i> <strong>ASIGNACIONES</strong> <span class="fa fa-chevron-down"></span></a>
					            	<ul class="nav child_menu">
						            	<li><a href="{{ route('account.index') }}"><strong>CUENTAS</strong></a></li>
						            	<li><a href="{{ route('asigpaq.index') }}"><strong>ASIGNACIÓN DISTRIBUIDORES</strong></a></li>
						                <li><a href="{{ route('appcta.index') }}"><strong>ASIGNACIÓN CLIENTES</strong></a></li>
					                </ul>
					            </li>
					            


					            <li><a><i class="fa fa-gears"></i> <strong>CONFIGURACIÓN</strong> <span class="fa fa-chevron-down"></span></a>
					              <ul class="nav child_menu">
					                <li><a href="{{ route('package.index') }}"><strong>PAQUETES</strong></a></li>
					              </ul>
					            </li>
					            <li><a><i class="fa fa-unlock-alt"></i> <strong>SEGURIDAD</strong> <span class="fa fa-chevron-down"></span></a>
					              <ul class="nav child_menu">
					                <li><a href="{{ route('user.index') }}"><strong>USUARIOS</strong></a></li>
					                <li><a href="{{ route('role.index') }}"><strong>ROLES</strong></a></li>
					                <li><a href="{{ route('permission.index') }}"><strong>PERMISOS</strong></a></li>
					                <li><a href="{{ route('binnacle.index') }}"><strong>BITÁCORA</strong></a></li>
					              </ul>
					            </li>
					           
					          </ul>
					        </div>

					        

					      </div>
					      <!-- /sidebar menu -->
					      <!-- /menu footer buttons -->
					      <div class="sidebar-footer hidden-small">
					        
					      </div>
					      <!-- /menu footer buttons -->
					    </div>
					  </div>
		        @show

				@section('app_top_navigation')
					<!-- top navigation -->
				        <div class="top_nav">
				          <div class="nav_menu">
				            <nav>
				              <div class="nav toggle">
				                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
				              </div>

				              <ul class="nav navbar-nav navbar-right">
				                <li class="">
				                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				                    <img src="{{ Auth::user()->usrc_pic ? asset('storage/'.Auth::user()->usrc_pic) : asset('default_avatar_male.jpg')}}" alt="">{{ Auth::user()->name }}
				                    <span class=" fa fa-angle-down"></span>
				                  </a>
				                  <ul class="dropdown-menu dropdown-usermenu pull-right">
				                    <li><a href="{{ route('user.edit',Auth::user()->id) }}"> Perfil</a></li>
				                    @if (Auth::guest())
			                            <li><a href="{{ route('login') }}">Login</a></li>
			                            <li><a href="{{ route('register') }}">Register</a></li>
			                        @else
			                            <li class="dropdown">
			                                    <li>
			                                        <a href="{{ route('logout') }}"
			                                            onclick="event.preventDefault();
			                                                     document.getElementById('logout-form').submit();">
			                                            Salir
			                                        </a>

			                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
			                                            {{ csrf_field() }}
			                                        </form>
			                                    </li>
			                            </li>
			                        @endif
				                  </ul>
				                </li>

				                
				              </ul>
				            </nav>
				          </div>
				        </div>
				    <!-- /top navigation -->
				@show

				
					<!-- page content -->
				        <div class="right_col" role="main">
				 			@yield('app_content')
				        </div>
				    <!-- /page content -->
				<footer></footer>


			</div>

		</div>

		@section('app_js')
            <!-- jQuery -->
		    <script src="{{ asset('controlassets/vendors/jquery/dist/jquery.min.js') }}"></script>
		    <!-- Bootstrap -->
		    <script src="{{ asset('controlassets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		    <!-- FastClick -->
		    <script src="{{ asset('controlassets/vendors/fastclick/lib/fastclick.js') }}"></script>
		    <!-- NProgress -->
		    <script src="{{ asset('controlassets/vendors/nprogress/nprogress.js') }}"></script>
		    <!-- iCheck -->
		    <script src="{{ asset('controlassets/vendors/iCheck/icheck.min.js') }}"></script>
        @show
	</body>
@endsection