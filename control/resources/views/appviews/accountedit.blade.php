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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
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
                                <select class="js-example-basic-single js-states form-control" name="cta_cliente_id" id="cta_cliente_id" required>
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
                                <select class="js-example-basic-single js-states form-control" name="cta_distrib_id" id="cta_distrib_id" required>
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
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Estado</label>                     
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input id="cta_estado" title="Estado" class="form-control has-feedback-left" name="cta_estado" placeholder="Estado *"  type="text" readonly="readonly" value="{{$account->cta_estado}}">
                                <span class="fa fa-certificate form-control-feedback left" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Fecha: </label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <input id="cta_fecha" title="Fecha" class="form-control has-feedback-left" name="cta_fecha" placeholder="Fecha" type="date" value="{{$account->cta_fecha}}" disabled="">
                                <span class="fa fa-calendar form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Periodicidad: </label>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_periodicity" id="cta_periodicity">
                                    <option value="3" selected>Trimestral</option>
                                    <option value="6" >Semestral</option>
                                    <option value="12" >Anual</option>
                                </select>
                            </div>
                            <label class="control-label col-md-1 col-sm-1 col-xs-12">Recursivo: </label>
                            <div class="col-md-1 col-sm-1 col-xs-12">
                                <select class="js-example-basic-single js-states form-control" name="cta_recursive" id="cta_recursive">
                                    <option value="1" {{$account->cta_recursive==1 ? 'selected':''}}>Si</option>
                                    <option value="0" {{$account->cta_recursive!=1 ? 'selected':''}}>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="x_content" id="tabaccedit">
                            <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Detalles</a>
                                    </li>
                                    <li role="presentation"><a href="#tab_content2" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Historial Fechas-Contratos</a>
                                    </li>
                                </ul>

                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab"> 
                                        <div class="item form-group">                       
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <table id="editable-dt1" class="table table-striped table-bordered" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th align="left">#</th>
                                                            <th align="left">Aplicación</th>
                                                            <th align="left">Cantidad Instancias</th>
                                                            <th align="left">Cantidad Gigas</th>
                                                            <th align="left">Estado</th>
                                                            <th align="left">Fecha Activación</th>
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
                                                                                <input id="appcta_rfc" class="form-control has-feedback-left" name="appcta_rfc" title="Cantidad de Instancias" placeholder="Cantidad Instancias *" type="numberint" value="0">
                                                                                <span class="fa fa-bank form-control-feedback left" aria-hidden="true"></span>
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                                <input id="appcta_gig" class="form-control has-feedback-left" name="appcta_gig" placeholder="Cantidad Gigas *" value="0" type="number" title="Almacenamiento en Gigas">
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
                                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="home-tab"> 
                                        <div class="item form-group" id="dates_div" {{$account->cta_recursive==1 ? 'hidden':''}}>
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
                                                <button id="addline" type="button" onclick="addtl({{$account->id}})" class="btn btn-success">Agregar</button>
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
                                                        <tr>
                                                            <td>{{$tl->acctl_f_ini}}</td>
                                                            <td>{{$tl->acctl_f_fin}}</td>
                                                            <td>{{$tl->acctl_f_corte}}</td>
                                                            <td>{{$tl->acctl_estado}}</td>
                                                            <td>{{$tl->acctl_f_pago}}</td>
                                                            <td>
                                                                <div class='btn-group'><div class='btn-group'><a id='{{$tl->id}}' onclick='quittl("{{$tl->id}}",this)' class='btn btn-xs' data-placement='left' title='Borrar' ><i class='fa fa-trash fa-3x'></i></a></div>
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

        $('#cta_recursive').on('change', function() {
             if(this.value==='1'){
                document.getElementById('dates_div').hidden = true;
             }else{
                document.getElementById('dates_div').hidden = false;
             }
        });

        function addApp(accid){
            var e = document.getElementById("addapps");
            $.ajax({
                url: '/addapp',
                type: 'POST',
                data: {_token: CSRF_TOKEN,accid:accid,appcta_rfc:document.getElementById('appcta_rfc').value,'appcta_gig':document.getElementById('appcta_gig').value,'app':e.options[e.selectedIndex].value},
                dataType: 'JSON',
                success: function (data) {
                    $("#addappmodal").remove();
                    window.location.href = window.location.href;
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

        var rowCount = document.getElementById('editable-dt1').rows.length;


        /*if(rowCount < 2){
            document.getElementById("testbtn").hidden = true;
            document.getElementById("tabaccedit").hidden = true;
        }else{
            document.getElementById("testbtn").hidden = false;
            document.getElementById("tabaccedit").hidden = false;
        }*/

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

        function addtl(accid){
            $.ajax({
                url: '/addtl',
                type: 'POST',
                data: {_token: CSRF_TOKEN,accid:accid,f_ini:document.getElementById('acctl_f_ini').value,'f_fin':document.getElementById('acctl_f_fin').value,'f_corte':document.getElementById('acctl_f_corte').value},
                dataType: 'JSON',
                success: function (data) {
                    $('#tabletl1').find('tbody').append( "<tr><td>"+data['acctl_f_ini']+"</td><td>"+data['acctl_f_fin']+"</td><td>"+data['acctl_f_corte']+"</td><td>"+data['acctl_estado']+"</td><td>"+data['acctl_f_pago']+"</td><td><div class='btn-group'><div class='btn-group'><a id='"+data['id']+"' onclick='quittl("+data['id']+",this)' class='btn btn-xs' data-placement='left' title='Borrar' ><i class='fa fa-trash fa-3x'></i> </a></div></td></tr>");
                    //window.location.href = window.location.href;
                }
            });
        }

        function quittl(accid,rrow){
            var rowtable = rrow.parentNode.parentNode.parentNode.parentNode.rowIndex;
            $.ajax({
                url: '/quittl',
                type: 'POST',
                data: {_token: CSRF_TOKEN,accid:accid},
                dataType: 'JSON',
                success: function (data) {
                    document.getElementById("tabletl1").deleteRow(rowtable);
                }
            });
        }
    </script>

@endsection

