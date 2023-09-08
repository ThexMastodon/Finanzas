@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )

@section('auth_header', __('adminlte::adminlte.password_reset_message'))

@section('auth_body')
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
      <div class="alert" role="alert" style="color: #1f2d3d; background-color: #FFC3D0; border-color:#FFC3D0;">
        <strong>¡Importante!</strong><br>
        <p>Es necesario el cambio de contraseña, recuerda, una vez generada, no podrás recuperarla. </p>
      </div>
    </div>
  </div>
  <form action="{{ route('pwd.update') }}" method="post">
    @csrf
    {{-- Password field --}}
    <div class="input-group mb-3">
      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
             placeholder="{{ __('adminlte::adminlte.password') }}" autofocus>

      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
        </div>
      </div>

      @error('password')
      <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
      @enderror
    </div>

    {{-- Password confirmation field --}}
    <div class="input-group mb-3">
      <input type="password" name="password_confirmation"
             class="form-control @error('password_confirmation') is-invalid @enderror"
             placeholder="{{ trans('adminlte::adminlte.retype_password') }}">

      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
        </div>
      </div>

      @error('password_confirmation')
      <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
      @enderror
    </div>

    {{-- Confirm password reset button --}}
    <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
      <span class="fas fa-sync-alt"></span>
      {{ __('adminlte::adminlte.reset_password') }}
    </button>

  </form>
@stop
