@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 75vh">
        <div class="col-md-5">
            <div class="row w-100 m-auto justify-content-center align-items-center">
                <div class="col-11">
                    <h2 class="mb-4" style="font-family: Montserrat;font-weight: 700;">Авторизация</h2>
                </div>
                <div class="col-11">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row mt-2">
                            <div class="col-md-12">
                                <label for="email" class="d-flex" style="font-family: Montserrat;font-size: 9px;color: #959597;font-weight: 400;">
                                    {{ __('E-mail') }}
                                </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" style="background-color: transparent" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="password" class="d-flex" style="font-family: Montserrat;font-size: 9px;color: #959597;font-weight: 400;">{{ __('Пароль') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" style="background-color: transparent"  name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row m-auto w-100 justify-content-end mb-0">
                            <button type="submit" class="btn btn-primary float-right px-4 py-2" style="background: #7c34f2; border: none; color: #FFFFFF; font-size: 12px">
                                {{ __('Войти') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
