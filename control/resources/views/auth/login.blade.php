@extends('layouts.app')

<style type="text/css">
      .rfc {
            font-family: 'Arial';
            font-size: 2rem;
            border-bottom: 1px solid $text-color;
            border-top: 1px solid $text-color;
            padding: 2rem 0;
            text-transform: uppercase;
            }
        .backgimg {
            background-image: url("{{asset('Fotolia_12331748_M.jpg')}}");
}


</style>

@section('content')
<div class="container" >
    <div id="loginModal" class="row modal show" tabindex="-1" role="dialog" aria-hidden="true" style="top: 5%; box-shadow: box-shadow: 10px 10px 5px green">
        <div class="modal-dialog">
            <div class="panel panel-default modal-content backgimg" style="width: 800px; height: 420px;  margin-left: 50%; margin: -100px 0 0 -100px; margin-top: 10px; box-shadow: 2px 2px 5px 5px gray">
                <!--<div class="panel-heading modal-header" ><b>BIENVENIDO AL SISTEMA DE CUENTA</b>

                </div>-->
                <div class="panel-body modal-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}


                       <div class="item form-group col-md-12" style="text-align: right;">
                           <b>BIENVENIDO AL PORTAL DE CONTROL ADVANS</b>
                       </div>

                       <div class="col-md-6 col-md-offset-6" style="border: 1px solid; margin-top: 40px; background-color: #f2f2f2">


                        <div class="form-group{{ $errors->has('usrc_nick') ? ' has-error' : '' }}">

                            <div class="col-md-8 col-md-offset-2 input-group" style="margin-top: 20px">

                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input id="usrc_nick" type="text" class="form-control" name="usrc_nick" value="{{ old('usrc_nick') }}" required placeholder="Correo electrónico" title="Correo electrónico" style="height: 30">
                                </div>

                                @if ($errors->has('usrc_nick'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usrc_nick') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-8 col-md-offset-2 input-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña" title="Contraseña" style="height: 30">
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="item form-group">
                            <div class="col-md-2 col-md-offset-5 input-group">
                                <button type="submit" class="btn btn-primary btn-block" style="background-color: #5c154d; width: 100%; ">
                                    Entrar
                                </button>

                            </div>

                            <div class="col-md-4 col-md-offset-3">

                                <a class="btn btn-link" href="{{ route('password.request') }}" style="font-size: 13px; color: black">
                                    Olvidó su constraseña?
                                </a>
                            </div>
                        </div>

                       </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--<div style="align-content: center;">
         <a href="/" class="site_title"><img src="{{asset('advans_internet.jpg')}}" alt="Advans" height="80" width="180" style="display: block; margin-top: 45%; margin-left: auto; margin-right: auto; "></a>
    </div>-->
</div>
@endsection 