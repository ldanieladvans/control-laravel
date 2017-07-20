@extends('template.applayout')


@section('app_css')
    <!-- Bootstrap -->
    <link href="{{ asset('controlassets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('controlassets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('controlassets/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('controlassets/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.min.css') }}" rel="stylesheet">
@endsection


@section('app_content')
    
          <div class="">
            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">

                <div class="tile-stats">

                  <div class="icon"></br><i class="fa fa-users"></i></div>
                  <div class="count" style="color: #072542 ">{{count($clients)}}</div>
                  <h3>Cliente(s)</h3>
                  </br>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"></br><i class="fa fa-sitemap"></i></div>
                  <div class="count" style="color: #072542 ">{{count($distributors)}}</div>
                  <h3>Distribuidore(s)</h3>
                  </br>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"></br><i class="fa fa-bar-chart"></i></div>
                  <div class="count" style="color: #072542 ">{{count($accounts)}}</div>
                  <h3>Cuenta(s)</h3>
                  <p>{{count($accounts_active)}} Activa(s)</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                  <div class="icon"></br><i class="fa fa-suitcase"></i></div>
                  <div class="count" style="color: #072542 ">{{count($apps)}}</div>
                  <h3>Aplicaciones Disponibles</h3>
                  </br>
                </div>
              </div>
            </div>

            <input type="hidden" name="asigpaqs" id="asigpaqs" value="{{$asigpaqs}}"/>
            <input type="hidden" name="appctas" id="appctas" value="{{$appctas}}"/>
            <input type="hidden" name="chartdata" id="chartdata" value="{{$chart_data}}"/>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Asignaciones <small>Último Mes</small></h2>
                    <div class="filter">

                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <!--<div class="demo-container" style="height:380px">
                        <div id="chart_plot_02" class="demo-placeholder"></div>
                      </div>-->
                      <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                    </div>

                    <!--<div class="col-md-3 col-sm-12 col-xs-12">
                      <div>
                        <div class="x_title">
                          <h2>Top 3 Distribuidores (RFCs)</h2>
                          <div class="clearfix"></div>
                        </div>
                        <ul class="list-unstyled top_profiles scroll-view">

                          @foreach($distributors_top as $distributor_top)
                            <li class="media event">
                                  @if ($loop->first)
                                      <a class="pull-left border-green profile_thumb">
                                        <i class="fa fa-user green"></i>
                                      </a>
                                  @elseif ($loop->last)
                                      <a class="pull-left border-aero profile_thumb">
                                        <i class="fa fa-user aero"></i>
                                      </a>
                                  @else
                                      <a class="pull-left border-blue profile_thumb">
                                        <i class="fa fa-user blue"></i>
                                      </a>
                                  @endif
                                <div class="media-body">
                                  <a class="title" href="#">{{$distributor_top->distrib_nom}}</a>
                                  <p><strong>{{$distributor_top->distrib_limitrfc}}</strong> RFCs </p>
                                  <p> <small>{{$distributor_top->distrib_limitgig}} Gigas</small>
                                  </p>
                                </div>
                              </li>
                          @endforeach

                        </ul>
                      </div>
                    </div>-->

                  </div>
                </div>
              </div>
            </div>

          </div>
@endsection

@section('app_js') 
    @parent
    <!-- Chart.js -->
    <script src="{{ asset('controlassets/vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- jQuery Sparklines -->
    <script src="{{ asset('controlassets/vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- Flot -->
    <script src="{{ asset('controlassets/vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/Flot/jquery.flot.time.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ asset('controlassets/vendors/DateJS/build/date.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{ asset('controlassets/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('controlassets/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
    <!-- Highcharts -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript">

     //console.log(new Date('2017-07-17').getTime());

     chart_data = jQuery.parseJSON(document.getElementById('chartdata').value);

     /*console.log(chart_data);

     console.log(document.getElementById('chartdata').value);*/

      Highcharts.setOptions({
        lang: {
        contextButtonTitle: "Menú contextual",
        decimalPoint: ".",
        downloadJPEG: "Descargar imagen JPEG",
        downloadPDF: "Descargar documento PDF ",
        downloadPNG: "Descargar imagen PNG",
        downloadSVG: "Descargar SVG",
        drillUpText: "Regresar a {series.name}",
        loading: "Cargando...",
        months: [ "Enero" , "Febrero" , "Marzo" , "Abril" , "Mayo" , "Junio" , "Julio" , "Agosto" , "Septiembre" , "Octubre" , "Noviembre" , "Diciembre"],
        noData: "Sin datos para mostrar",
        numericSymbolMagnitude: 1000,
        numericSymbols: [ "k" , "M" , "G" , "T" , "P" , "E"],
        printChart: "Imprimir gráfico",
        resetZoom: "Resetear zoom",
        resetZoomTitle: "Resetear zoom nivel 1:1",
        shortMonths: [ "Ene" , "Feb" , "Mar" , "Abr" , "May" , "Jun" , "Jul" , "Ago" , "Sep" , "Oct" , "Nov" , "Dic"],
        shortWeekdays: undefined,
        thousandsSep: " ",
        weekdays: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"]
        }
      });

      Highcharts.chart('container', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Asignaciones a cuentas'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'datetime',

        title: {
            text: 'Fecha'
        }
    },
    yAxis: {
        title: {
            text: 'Cantidad'
        },
        min: 0
    },
    tooltip: {
        headerFormat: '<b>{series.name}</b><br>',
        pointFormat: '{point.x:%e. %b}: {point.y:.2f} instancias'
    },

    plotOptions: {
        spline: {
            marker: {
                enabled: true
            }
        }
    },

    series: chart_data
    });
   
    </script>
@endsection


