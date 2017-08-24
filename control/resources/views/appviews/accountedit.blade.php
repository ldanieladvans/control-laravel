@extends('template.applayout')

@section('app_css')
  @parent
    <!-- Switchery -->
    <link href="{{ asset('controlassets/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('controlassets/build/css/custom.css') }}" rel="stylesheet">
    <!-- Datetime -->
    <link href="{{ asset('controlassets/vendors/datetime/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">
    <!-- Chosen -->
    <link href="{{ asset('controlassets/vendors/chosen/chosen.css') }}" rel="stylesheet" type="text/css" />
    <!-- Select 2 -->
    <link href="{{ asset('controlassets/vendors/select2/dist/css/select2.css') }}" rel="stylesheet">
@endsection

@section('app_content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Editar Cuenta</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <button type="button" id="alertmsgcta" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ Session::get('message') }}</strong>
                    </div>
                @endif

                <input id="apps_aux" type="hidden" value="{{$apps}}">
                <input id="obj_id" type="hidden" value="{{$account->id}}">

                <div class="x_content">
                    {{ Form::open(['route' => ['account.update', $account], 'class'=>'form-horizontal form-label-left']) }}
                        {{ Form::hidden('_method', 'PUT') }}

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Cliente*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_cliente_id" id="cta_cliente_id" disabled>
                                    <option value="">Seleccione una opción ...</option>
                                    @foreach($clients as $client)
                                        @if ($client->id == $account->cta_cliente_id)
                                            <option value="{{ $client->id }}" selected="selected">{{ $client->cliente_nom }}</option>
                                        @else
                                            <option value="{{ $client->id }}">{{ $client->cliente_nom }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Número</label>                     
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cta_num" title="RFC" class="form-control has-feedback-left" name="cta_num" placeholder="Número de Cuenta / RFC *" type="text" value="{{$account->cta_num}}" readonly="readonly">
                                <span class="fa fa-bar-chart form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Distribuidor*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_distrib_id" id="cta_distrib_id" disabled>
                                    <option value="">Seleccione una opción ...</option>
                                    @foreach($distributors as $distributor)
                                        @if ($distributor->id == $account->cta_distrib_id)
                                            <option value="{{ $distributor->id }}" selected="selected">{{ $distributor->distrib_nom }}</option>
                                        @else
                                            <option value="{{ $distributor->id }}">{{ $distributor->distrib_nom }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Tipo de Cuenta*</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_type" id="cta_type" required {{$account->cta_fecha ? 'disabled' : ''}}>
                                    <option value="">Seleccione una opción ...</option>
                                    <option value="single" {{ $account->cta_type == 'single' ? 'selected' : ''}}>1 RFC</option>
                                    <option value="multi" {{ $account->cta_type == 'multi' ? 'selected' : ''}}>Múltiple RFCs</option>
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Estado</label>                     
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cta_estado" title="Estado" class="form-control has-feedback-left" name="cta_estado" placeholder="Estado *"  type="text" readonly="readonly" value="{{$account->cta_estado}}">
                                <span class="fa fa-certificate form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Fecha Activación</label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input id="cta_fecha" title="Fecha" class="form-control has-feedback-left" name="cta_fecha" placeholder="Fecha" type="date" value="{{$account->cta_fecha}}" disabled="">
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Periodicidad: </label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_periodicity" id="cta_periodicity" {{ (Auth::user()->can('change.period.accounts') || Auth::user()->usrc_admin) ? '' : 'disabled'}}>
                                    <option value="3" {{ $account->cta_periodicity == '3' ? 'selected' : ''}}>Trimestral</option>
                                    <option value="6" {{ $account->cta_periodicity == '6' ? 'selected' : ''}}>Semestral</option>
                                    <option value="12" {{ $account->cta_periodicity == '12' ? 'selected' : ''}}>Anual</option>
                                </select>
                            </div>
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Recursivo: </label>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_recursive" id="cta_recursive" {{ (Auth::user()->can('change.rec.accounts') || Auth::user()->usrc_admin) ? '' : 'disabled'}}>
                                    <option value="1" {{$account->cta_recursive==1 ? 'selected':''}}>Si</option>
                                    <option value="0" {{$account->cta_recursive!=1 ? 'selected':''}}>No</option>
                                </select>
                            </div>
                        </div>

                        @if(Auth::user()->usrc_admin || Auth::user()->can('manage.details.accounts') || Auth::user()->can('manage.tls.accounts'))
                            <div class="x_content" id="tabaccedit">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Detalles</a>
                                        </li>
                                        <li role="presentation"><a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Historial Fechas-Contratos</a>
                                        </li>
                                    </ul>

                                    <div id="myTabContent" class="tab-content">
                                        @if(Auth::user()->usrc_admin || Auth::user()->can('manage.details.accounts'))
                                            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab"> 
                                                <div class="item form-group">                       
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <table id="editable-dt1" class="table table-striped table-bordered" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th align="left">#</th>
                                                                    <th align="left">Aplicación</th>
                                                                    <th align="left">Cantidad Soluciones</th>
                                                                    <th align="left">Cantidad Megas</th>
                                                                    <th align="left">Ambiente</th>
                                                                    <th align="left">Fecha Activación</th>
                                                                    <th align="left">Estado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($account->packages as $appcta)
                                                                    <tr data-id="{{$appcta->id}}">
                                                                        <td class="tabledit-data">{{$appcta->id}}</td>
                                                                        <td class="tabledit-data">
                                                                            @foreach($appsne as $appne)
                                                                                @if ($appcta->hasApp($appne->code,true))
                                                                                    {{$appne->name}}
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                        <td class="tabledit-data">{{$appcta->appcta_rfc}}</td>
                                                                        <td class="tabledit-data">{{$appcta->appcta_gig}}</td>
                                                                        <td class="tabledit-data">{{$appcta->sale_estado}}</td>
                                                                        <td class="tabledit-data">{{$appcta->appcta_f_act}}</td>
                                                                        <td class="tabledit-data">{{$appcta->appcta_estado}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <button id="testbtn" type="button" onclick="addLine()" >Agregar [+]</button>
                                                            <div class="modal fade" id="addappmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Añadir Aplicación:</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form>
                                                                                <div class="item form-group">
                                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                        <select class="js-example-basic-single js-states form-control" name="addapps" id="addapps" style="width: 100%; display: none;">
                                                                                            @foreach($appsne as $appne)
                                                                                                @if ($account->hasApp($appne->code,true)==0)
                                                                                                    <option value="{{$appne->code}}" >{{$appne->name}}</option>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="item form-group">
                                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                        <input id="appcta_rfc" class="form-control has-feedback-left" name="appcta_rfc" title="Cantidad de Soluciones" placeholder="Cantidad Soluciones *" type="numberint" value="{{$account->cta_type == 'single' ? '1' : '0'}}" {{$account->cta_type == 'single' ? 'readonly' : ''}}>
                                                                                        <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
                                                                                    </div>
                                                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                        <input id="appcta_gig" class="form-control has-feedback-left" name="appcta_gig" placeholder="Cantidad Megas *" value="{{$account->cta_type == 'single' ? '1' : '0'}}" type="number" title="Almacenamiento en Megas">
                                                                                        <span class="fa fa-archive form-control-feedback left" aria-hidden="true"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"  onclick="addApp({{$account->id}});" class="btn btn-primary">Ok</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if(Auth::user()->usrc_admin || Auth::user()->can('manage.tls.accounts'))
                                            <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab"> 
                                                <div class="item form-group" id="dates_div" >
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        <input id="acctl_f_ini" title="Fecha Inicio" class="form-control has-feedback-left" name="acctl_f_ini" placeholder="Fecha Inicio" type="date">
                                                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                                    </div>

                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        <input id="acctl_f_fin" title="Fecha Fin" class="form-control has-feedback-left" name="acctl_f_fin" placeholder="Fecha Fin" type="date">
                                                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                                    </div>
                                                    
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        <input id="acctl_f_corte" title="Fecha Corte" class="form-control has-feedback-left" name="acctl_f_corte" placeholder="Fecha Corte" type="date">
                                                        <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                                                    </div>

                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        <button id="addlinedate" type="button" onclick="addtl({{$account->id}})" class="btn btn-success">Agregar</button>
                                                    </div>
                                                </div>
                                                <div class="item form-group" >
                                                    <table id="tabletl1" class="table table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha Inicio</th>
                                                                <th>Fecha Fin</th>
                                                                <th>Fecha Corte</th>
                                                                <th>Estado</th>
                                                                <th>Fecha de Pago</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($account->timelines as $tl)
                                                                <tr id="tbrow{{$tl->id}}">
                                                                    <td id="tdrow{{$tl->id}}1">{{$tl->acctl_f_ini}}</td>
                                                                    <td id="tdrow{{$tl->id}}2">{{$tl->acctl_f_fin}}</td>
                                                                    <td id="tdrow{{$tl->id}}3">{{$tl->acctl_f_corte}}</td>
                                                                    <td id="tdrow{{$tl->id}}4">{{$tl->acctl_estado}}</td>
                                                                    <td id="tdrow{{$tl->id}}5">{{$tl->acctl_f_pago}}</td>
                                                                    <td>
                                                                        <div class='btn-group'><div class='btn-group'><a id='{{$tl->id}}' onclick='quittl("{{$tl->id}}","{{$account->id}}")' class='btn btn-xs' data-placement='left' title='Borrar' ><i class='fa fa-trash fa-3x'></i></a></div>
                                                                        <div class='btn-group'><div class='btn-group'><a id='{{$tl->id}}' onclick='edittl({{$tl->id}})' class='btn btn-xs' data-placement='left' title='Editar' ><i class='fa fa-edit fa-3x'></i></a></div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endif 
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-3">
                                <button id="cancel" type="button" onclick="location.href = '/account/account';" class="btn btn-info">Cancelar</button>
                                <button id="send" type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('app_js') 
    @parent
    <!-- Chosen -->
    <script src="{{ asset('controlassets/vendors/chosen/chosen.jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/prism.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('controlassets/vendors/chosen/docsupport/init.js') }}" type="text/javascript" charset="utf-8"></script>
    <!-- validator -->
    <script src="{{ asset('controlassets/vendors/validator/control.validator.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('controlassets/build/js/custom.js') }}"></script>
    <!-- Date Time -->
    <script type="text/javascript" src="{{ asset('controlassets/vendors/datetime/js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{ asset('controlassets/vendors/datetime/js/locales/bootstrap-datetimepicker.es.js') }}" charset="UTF-8"></script>
    <!-- Select 2 -->
    <script src="{{ asset('controlassets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <!-- Table Edit -->
    <script src="{{ asset('controlassets/vendors/Tabledit/jquery.tabledit.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('controlassets/vendors/switchery/dist/switchery.min.js') }}"></script>
    <script type="text/javascript">

        var cta_periodicity = document.getElementById('cta_periodicity').value;
        var today = new Date();

        var account_id = document.getElementById('obj_id').value;

        var rowCount = document.getElementById('tabletl1').rows.length;

        Date.prototype.addDays = function(days) {
          var dat = new Date(this.valueOf());
          dat.setDate(dat.getDate() + days);
          return dat;
        }

        Date.isLeapYear = function (year) { 
            return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0)); 
        };

        Date.getDaysInMonth = function (year, month) {
            return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
        };

        Date.prototype.isLeapYear = function () { 
            return Date.isLeapYear(this.getFullYear()); 
        };

        Date.prototype.getDaysInMonth = function () { 
            return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
        };

        Date.prototype.addMonths = function (value) {
            var n = this.getDate();
            this.setDate(1);
            this.setMonth(this.getMonth() + value);
            this.setDate(Math.min(n, this.getDaysInMonth()));
            return this;
        };

        var today_day = today.getDate();
        

        


        $('#cta_periodicity').change(function() {
            cta_periodicity = this.value;
        });

        $( function() {
            $('#alertmsgcta').click(function() {
                console.log('alertmsgcta button clicked');
            });
          
            setTimeout(function() {
                $('#alertmsgcta').trigger('click');
            }, 4e3);
        });

        var trselected = false;
        var val_date_ini = false;
        var val_date_fin = false;
        var val_date_corte = false;

        function addApp(accid){
            var e = document.getElementById("addapps");
            //$('#loadingmodal').modal('show');
            $.ajax({
                url: '/addapp',
                type: 'POST',
                data: {_token: CSRF_TOKEN,accid:accid,appcta_rfc:document.getElementById('appcta_rfc').value,'appcta_gig':document.getElementById('appcta_gig').value,'app':e.options[e.selectedIndex].value},
                dataType: 'JSON',
                success: function (data) {
                    $("#addappmodal").modal('hide');
                    window.location.href = window.location.href;
                }
            });
        }

        function addtl(accid){
            $('#loadingmodal').modal('show');
            $.ajax({
                url: '/addtl',
                type: 'POST',
                data: {_token: CSRF_TOKEN,accid:accid,f_ini:document.getElementById('acctl_f_ini').value,'f_fin':document.getElementById('acctl_f_fin').value,'f_corte':document.getElementById('acctl_f_corte').value,tlid:trselected},
                dataType: 'JSON',
                success: function (data) {
                    var str = document.getElementById("tbrow"+data['tlid']);
                    console.log(data);
                    if(data['tlid']!='false'){
                        document.getElementById("tbrow"+data['tlid']).innerHTML = "<tr id='tbrow"+data['id']+"'><td id='tdrow"+data['id']+"1'>"+data['acctl_f_ini']+"</td><td id='tdrow"+data['id']+"2'>"+data['acctl_f_fin']+"</td><td id='tdrow"+data['id']+"3'>"+data['acctl_f_corte']+"</td><td id='tdrow"+data['id']+"4'>"+data['acctl_estado']+"</td><td id='tdrow"+data['id']+"5'>"+data['acctl_f_pago']+"</td><td><div class='btn-group'><div class='btn-group'><a id='"+data['id']+"' onclick='quittl("+data['id']+","+data['accid']+")' class='btn btn-xs' data-placement='left' title='Borrar' ><i class='fa fa-trash fa-3x'></i> </a></div><div class='btn-group'><div class='btn-group'><a id='"+data['id']+"' onclick='edittl("+data['id']+")' class='btn btn-xs' data-placement='left' title='Editar' ><i class='fa fa-edit fa-3x'></i></a></div></td></tr>";
                        str.removeAttribute("selected");
                        str.style.backgroundColor='#f9f9f9';
                        document.getElementById('acctl_f_ini').min = val_date_fin;
                        document.getElementById('acctl_f_fin').min = val_date_fin;
                        document.getElementById('acctl_f_corte').min = val_date_corte;
                            
                    }else{
                        $('#tabletl1').find('tbody').append("<tr id='tbrow"+data['id']+"'><td id='tdrow"+data['id']+"1'>"+data['acctl_f_ini']+"</td><td id='tdrow"+data['id']+"2'>"+data['acctl_f_fin']+"</td><td id='tdrow"+data['id']+"3'>"+data['acctl_f_corte']+"</td><td id='tdrow"+data['id']+"4'>"+data['acctl_estado']+"</td><td id='tdrow"+data['id']+"5'>"+data['acctl_f_pago']+"</td><td><div class='btn-group'><div class='btn-group'><a id='"+data['id']+"' onclick='quittl("+data['id']+","+data['accid']+")' class='btn btn-xs' data-placement='left' title='Borrar' ><i class='fa fa-trash fa-3x'></i> </a></div><div class='btn-group'><div class='btn-group'><a id='"+data['id']+"' onclick='edittl("+data['id']+")' class='btn btn-xs' data-placement='left' title='Editar' ><i class='fa fa-edit fa-3x'></i></a></div></td></tr>");
                        document.getElementById('acctl_f_ini').min = data['acctl_f_ini_next'];
                        document.getElementById('acctl_f_fin').min = data['acctl_f_fin_next'];
                        document.getElementById('acctl_f_corte').min = data['acctl_f_corte_next'];
                    }

                    $('#loadingmodal').modal('hide');
                    document.getElementById('acctl_f_ini').value = "";
                    document.getElementById('acctl_f_fin').value = "";
                    document.getElementById('acctl_f_corte').value = "";
                    document.getElementById("addlinedate").innerText="Agregar";
                    trselected = false;
                    
                }
            });
        }

        function addLine(){
            $("#addappmodal").modal('show');
            /*var tableditTableName = '#editable-dt1'; 
            var newID = parseInt($(tableditTableName + " tr:last").attr("data-id")) + 1; 
            var clone = $("table tr:last").clone(); 
            $(".tabledit-data span", clone).text(""); 
            $(".tabledit-data input", clone).val(""); 
            clone.appendTo("table"); $
            (tableditTableName + " tr:last").attr("data-id", newID); 
            $(tableditTableName + " tr:last td .tabledit-span.tabledit-identifier").text(newID); $(tableditTableName + " tr:last td .tabledit-input.tabledit-identifier").val(newID);*/
        }

        

        if(rowCount >= 2){

            var inidate = new Date(($('#tabletl1 tbody tr:last td:nth-child(2)').text()).replace('-','/'));
            inidate = inidate.addDays(1);

            var month = inidate.getMonth() + 1;
            if(month<10){
                month = '0'+month;
            }
            var day = inidate.getDate();
            if(day<10){
                day = '0'+day;
            }
            var year = inidate.getFullYear();

            val_date_ini = [year, month, day].join('-');

            var enddate = new Date(($('#tabletl1 tbody tr:last td:nth-child(2)').text()).replace('-','/'));
            //enddate = enddate.addDays(1);
            enddate.setDate(enddate.getDate()-1);
            enddate.setMonth(enddate.getMonth() + parseInt(cta_periodicity));

            var month = enddate.getMonth() + 1;
            if(month<10){
                month = '0'+month;
            }
            var day = enddate.getDate();
            if(day<10){
                day = '0'+day;
            }
            var year = enddate.getFullYear();

            val_date_fin = [year, month, day].join('-');

            var courtdate = new Date(($('#tabletl1 tbody tr:last td:nth-child(3)').text()).replace('-','/'));
            //courtdate = courtdate.addDays(1);
            courtdate.setDate(courtdate.getDate()-1);
            courtdate.setMonth(courtdate.getMonth() + parseInt(cta_periodicity));

            var month = courtdate.getMonth() + 1;
            if(month<10){
                month = '0'+month;
            }
            var day = courtdate.getDate();
            if(day<10){
                day = '0'+day;
            }
            var year = courtdate.getFullYear();

            val_date_corte = [year, month, day].join('-');

            document.getElementById('acctl_f_ini').min = val_date_ini;
            document.getElementById('acctl_f_fin').min = val_date_fin;
            document.getElementById('acctl_f_corte').min = val_date_corte;

        }else{

            if(today_day<10){
                today_day = '0'+today_day;
            }
            var today_month = today.getMonth()
            if(today_month<10){
                today_month = '0'+today_month;
            }
            var today_year = today.getFullYear();
            console.log(today);
            document.getElementById('acctl_f_ini').value = [today_year, today_month, today_day].join('-');


            var today_end = today.addMonths(parseInt(cta_periodicity));
            var today_end_day = today_end.getDate();
            if(today_end_day<10){
                today_end_day = '0'+today_end_day;
            }
            var today_end_month = today_end.getMonth();
            if(today_end_month<10){
                today_end_month = '0'+today_end_month;
            }
            var today_end_year = today_end.getFullYear();

            document.getElementById('acctl_f_fin').value = [today_end_year, today_end_month, today_end_day].join('-');
            document.getElementById('acctl_f_corte').value = [today_end_year, today_end_month, today_end_day].join('-');

            /*if(account_id){
                addtl(account_id);
            }*/

        }

        $('#editable-dt1').Tabledit({
            url: '/crudtabledit',
            restoreButton: false,
            buttons: {
                edit: {
                    class: 'btn btn-sm btn-primary',
                    html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp Editar',
                    action: 'edit'
                },
                save: {
                    class: 'btn btn-sm btn-success',
                    html: '<span class="glyphicon glyphicon-check"></span> &nbsp Guardar',
                    action: 'save'
                },
                delete: {
                    class: 'btn btn-sm btn-danger',
                    html: '<span class="glyphicon glyphicon-trash"></span> &nbsp Borrar',
                    action: 'delete'
                },
            },
            columns: {
                identifier: [0, 'id'],
                editable: [[2, 'appcta_rfc'],[3, 'appcta_gig',],[4, 'sale_estado','{"test": "Prueba", "prod": "Producción"}']]
            },
            onDraw: function() {
                console.log('onDraw()');
            },
            onSuccess: function(data, textStatus, jqXHR) {
                console.log('onSuccess(data, textStatus, jqXHR)');
                console.log(data);
                console.log(textStatus);
                console.log(jqXHR);
                $('#loadingmodal').modal('hide');
                window.location.href = window.location.href;
            },
            onFail: function(jqXHR, textStatus, errorThrown) {
                console.log('onFail(jqXHR, textStatus, errorThrown)');
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            },
            onAlways: function() {
                console.log('onAlways()');
            },
            onAjax: function(action, serialize) {
                console.log('onAjax(action, serialize)');
                console.log(action);
                console.log(serialize);
            }
        });

        $('.form_datetime').datetimepicker({
            language:  'es',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0,
            showMeridian: 1
        });

        $("#cta_cliente_id").select2({
            placeholder: "Selecciona el cliente",
            allowClear: true
        });

        $("#addapps").select2({
            placeholder: "Selecciona el cliente",
            allowClear: true
        });

        $("#cta_distrib_id").select2({
            placeholder: "Selecciona el distribuidor",
            allowClear: true
        });

        $("#cta_periodicity").select2({
            placeholder: "Selecciona el distribuidor",
            allowClear: true
        });

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $('#cta_cliente_id').change(function(){
            if(this.value!=""){
                $.ajax({
                    url: '/getclientrfc',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN,clientid:this.value},
                    dataType: 'JSON',
                    success: function (data) {
                        document.getElementById('cta_num').value=data['rfc'];
                    }
                });
            }else{
              document.getElementById('cta_num').value='';
            }
        });

        

        function quittl(tlid,accid){
            var result = confirm("¿Está seguro que desea eliminar esta línea?");
            if(result){
                $('#loadingmodal').modal('show');
                $.ajax({
                    url: '/quittl',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN,tlid:tlid,accid:accid},
                    dataType: 'JSON',
                    success: function (data) {
                        window.location.href = window.location.href;
                    }
                });
            }
        }


        function edittl(tlid){
            var tr = document.getElementById("tbrow"+tlid);
            
            
            if(tr.hasAttribute("selected")){
                
                tr.removeAttribute("selected");
                tr.style.backgroundColor='#f9f9f9';
                document.getElementById('acctl_f_ini').value = "";
                document.getElementById('acctl_f_fin').value = "";
                document.getElementById('acctl_f_corte').value = "";
                document.getElementById("addlinedate").innerText="Agregar";
                document.getElementById('acctl_f_ini').min = val_date_fin;
                document.getElementById('acctl_f_fin').min = val_date_fin;
                document.getElementById('acctl_f_corte').min = val_date_corte;
                trselected = false;
            }else{
                var table = document.getElementById('tabletl1');
                var rowLength = table.rows.length;
                for(var i=1; i<rowLength; i+=1){
                  table.rows[i].removeAttribute("selected");
                  table.rows[i].style.backgroundColor='#f9f9f9';
                }
                tr.setAttribute("selected", "1");
                tr.style.backgroundColor='#c9f2cc';
                document.getElementById('acctl_f_ini').value = document.getElementById("tdrow"+tlid+"1").innerText;
                document.getElementById('acctl_f_fin').value = document.getElementById("tdrow"+tlid+"2").innerText;
                document.getElementById('acctl_f_corte').value = document.getElementById("tdrow"+tlid+"3").innerText;
                document.getElementById("addlinedate").innerText="Modificar";
                document.getElementById('acctl_f_ini').min = document.getElementById('acctl_f_ini').value;
                document.getElementById('acctl_f_fin').min = document.getElementById('acctl_f_fin').value;
                document.getElementById('acctl_f_corte').min = document.getElementById('acctl_f_corte').value;
                trselected = tlid;
            }

        }
    </script>

@endsection

