@extends('adminlte::page')

@section('title', 'Detalles de usuario')

@include('admin.users.update_password_modal')
@section('css')
@stop

@section('content')
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <h2 style="text-align: left;" class="mt-4" >{{ __('Detalles de Usuario') }}</h2>
      <br>
      <form action="" id="buscarForm" method="POST">
        @csrf
        <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-dark float-right col-1 mb-3 mr-3" href="{{ route('lista') }}" type="button">Listado</a>
          </div>
        </div>
      </form>
      <br>
      <div class="card">
        <form id="formEditarUsuario" action="{{route('usuarios-editar',  ['id' => $data->id])}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <div class="row">
              <div class="col-md-3">
                <div class="card card-primary card-outline">
                  <div class="card-body box profile">
                    <div class="form-group col-12">
                      <label>Foto de perfil</label>
                      <br>
                      <img @if($data->image) src="data:image/png;base64,{{ $data->image }}" @else src="{{ asset('image/perfil.png')}}" @endif class="img-fluid mb-4" alt="" style="width: 250px">
                      <input id="photo" type="file" name="photo" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-9">
                <div class="card card-primary card-outline">
                  <div class="row card-body box">
                    <div class="col-md-5">
                      <div class="row">
                        <div class="form-group col-6">
                          <label>Usuario</label>
                          <input id="username" name="username" type="text" class="form-control" value="{{$data->username}}">
                        </div>
                        <div class="form-group col-6">
                          <label>Nombre</label>
                          <input id="name" name="name" type="text" class="form-control" value="{{$data->name}}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-6">
                          <label>A.  Parterno</label>
                          <input id="last_name" name="last_name" type="text" class="form-control"value="{{$data->last_name}}">
                        </div>
                        <div class="form-group col-6">
                          <label>A.  Materno</label>
                          <input id="second_last_name" name="second_last_name" type="text" class="form-control" value="{{$data->second_last_name}}">
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-12">
                          <label>Email</label>
                          <input id="email" name="email" type="email" class="form-control" value="{{$data->email}}">
                        </div>
                      </div>
                      <div class="form-group col-4">
                        <label>Estado</label>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="active" value="1" @if($data->active) checked @endif>
                          <label class="form-check-label">Activo</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="active" value="0" @empty($data->active) checked @endempty>
                          <label class="form-check-label">Inactivo</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-7">
                      <div class="alert bg-secondary col-12 form-group" role="alert">
                        Si desea actualizar su contraseña haga
                        <a id="change-password" type="button" class="btn-confcam">
                          click aqui.
                        </a>
                      </div>
                      <div class="form-group col-12">
                        <label>Roles</label>
                        <select id="rol_id" name="rol_id" multiple class="form-control">
                          @foreach ($Roles as $Rol)
                            <option value="{{ $Rol->id }} " @if ($data->hasRole($Rol->name)) selected @endif>
                              {{ $Rol->name }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                      <br>
                      <br>
                      <br>
                      <br>
                      <button id="btn-actualizar" class="btn btn-primary float-right">
                        <i class="far fa-file-alt"></i>&nbsp;Guardar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>



@stop
@section('adminlte_js')

<script type="text/javascript">
  $(document).ready(function () {

    $('#btn-actualizar').on('click', function (event) {
      event.preventDefault()
      let username = $('#username').val(),
          name = $('#name').val(),
          email= $('#email').val();

        if (username === '' || name === '' || email === '') {
          Swal.fire({
            title: '¡Atención!',
            text: 'Los campos usuario, nombre y email, no pueden ir vacios',
            icon: 'error',
          });
        } else {
          form = $("#formEditarUsuario");
          var form_data = new FormData($('#formEditarUsuario')[0]);
          $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form_data,
            processData: false,
            contentType: false,
            success: function(response) {
            Swal.close();
            Swal.fire({
              icon: response.status,
              title: response.title,
              text: response.message,
              confirmButtonText: "Aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href='{{route ('lista')}}';
              }
            });
          },
          }).done(() => {

          });
        }

    });

    $('#btn-pass').on('click', function (event) {
      event.preventDefault()
      form = $("#formCambioContrasena");
      var form_data = new FormData($('#formCambioContrasena')[0]);
        $.ajax({
          url: form.attr('action'),
          type: form.attr('method'),
          data: form_data,
          processData: false,
          contentType: false,
          beforeSend: function () {
            Swal.fire({
              title: 'Actualizando contraseña',
              text: 'Por favor espere a que la página lo redireccione.',
              allowOutsideClick: false,
              didOpen: () => {
                Swal.showLoading()
              },
              timer: 1500
            });
          },
          success: function(response) {
            Swal.close();
            Swal.fire({
              icon: response.status,
              title: response.title,
              text: response.message,
              confirmButtonText: "Aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href='{{route ('lista')}}';
              }
            });
          },
        });

      });

      $('#change-password').on('click', function (event) {
        Swal.fire({
          icon: 'warning',
          title: '¿Estas seguro de cambiar tu contraseña?',
          text: "No se podrá recuperar tu contraseña anterior después.",
          showCancelButton: true,
          confirmButtonColor: '#6A0F49',
          cancelButtonColor: '#6D807F',
          confirmButtonText: 'Si, Cambiar'
        }).then((result) => {
          if (result.isConfirmed) {
            $("#myModal").modal("show");
          }
        });
      });

  });

</script>

@stop
