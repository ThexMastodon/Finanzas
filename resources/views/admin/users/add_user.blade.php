@extends('adminlte::page')
@section('title', 'Dashboard')

@section('css')
  <style>
    .btn-confcam:hover {
      color:black;
      transition: 0.7s;
    }
  </style>

@stop

@section('content')
  <div class="row">
    <div class="col-lg-12 col-md-12">
      <h2 style="text-align: left; font-weight: bold;" class="mt-4">{{ __('Registro de Usuario') }}</h2>
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
      {{-- <div class="card"> --}}
        <form id="formNuevoUsuario" action="{{ route('usuarios-registrar')}}" method="POST">
          @csrf
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card card-primary card-outline">
                    <div class="row card-body box">
                      <div class="col-md-5">
                        <div class="row">
                          <div class="form-group col-6">
                            <label>Usuario</label>
                            <input id="username" name="username" type="text" class="form-control">
                          </div>
                          <div class="form-group col-6">
                            <label>Nombre</label>
                            <input id="name" name="name" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-6">
                            <label>A. Paterno</label>
                            <input id="last_name" name="last_name" type="text" class="form-control">
                          </div>
                          <div class="form-group col-6">
                            <label>A. Materno</label>
                            <input id="second_last_name" name="second_last_name" type="text" class="form-control">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-12">
                            <label>Email</label>
                            <input id="email" name="email" type="email" class="form-control">
                          </div>
                        </div>

                      </div>
                      <div class="col-md-7">
                        <div class="col-6">
                          <div >
                            <label for="inputAfianzadora">rol</label>
                            <select id="rol_id"  name="rol_id" multiple class="form-control">
                              @foreach ($Roles as $Rol)
                                <option value="{{ $Rol->name }}"> {{$Rol->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <br>
                        <br>
                        <br>
                        <br>
                        <button id="btn-guardar"  type="submit" class="btn btn-primary float-right">
                          <i class="far fa-file-alt"></i>&nbsp;Guardar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </form>
    </div>
  </div>


@stop
@section('adminlte_js')

<script type="text/javascript">
  $(document).ready(function () {

    $('#btn-guardar').on('click', function (event) {
      event.preventDefault()
      let username = $('#username').val(),
          name = $('#name').val(),
          email= $('#email').val();
          role = $('#rol_id').val();

        if (username == '' || name == '' || email == ''|| role == '') {
          Swal.fire({
            title: '¡Atención!',
            text: 'Los campos usuario, nombre ,email y rol , no pueden ir vacios por favor revisa que los hayas llenado correctamente',
            icon: 'error',
          });
        } else {
          form = $("#formNuevoUsuario");
          var form_data = new FormData($('#formNuevoUsuario')[0]);
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
                  window.location.href='{{route ('lista')}}'; // Recargar la página
                }
              });
            },
          });
        }

    });
  });

</script>

@stop
