@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Seguridad {{ config('app.name') }}</div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <!--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>-->

                        

                        <!-- TODO Uncomment for multiple BD Con -->
                        <!--{{ Session::pull('midred') }}

                        <div class="form-group{{ Session::get('loginrfcerr') ? ' has-error' : '' }}">
                            <label for="login_rfc" class="col-md-4 control-label">RFC</label>

                            <div class="col-md-6">
                                <input id="login_rfc" type="text" class="form-control" value="{{ Session::get('login_rfc') }}" name="login_rfc" required>

                                @if (Session::has('loginrfcerr'))
                                    <span class="help-block">
                                        <strong>{{ Session::get('loginrfcerr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>-->

                        <div class="form-group{{ $errors->has('usrc_nick') ? ' has-error' : '' }}">
                            <label for="usrc_nick" class="col-md-4 control-label">Usuario</label>

                            <div class="col-md-6">
                                <input id="usrc_nick" type="text" class="form-control" value="{{ old('usrc_nick') }}" name="usrc_nick" required>

                                @if ($errors->has('usrc_nick'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('usrc_nick') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recordarme
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Entrar
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    ¿Olvidó su contraseña?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
