@extends('adminlte::page')
@section('title', 'Asignar Permisos')
@section('css')
<!-- Agrega aquí tus estilos personalizados si los tienes -->
@stop
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form id="form-permisos" action="{{ route('Editar-Persmisos-Roles', $rol->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">
            <h4>{{ __('Editar los permisos de rol ') }}{{ $rol->name }} </h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="searchInput">Buscar permisos:</label>
                  <input type="text" id="searchInput" class="form-control" placeholder="Buscar">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary card-outline">
                  <div class="card-body box" id="permisos-container">
                    <h5><strong>Permisos configuraciones</strong></h5> <!-- Agrega una clase al contenedor -->
                    @foreach ($permisos as $permiso)
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="permisos[]" value="{{ $permiso->id }}" id="permiso{{ $permiso->id }}" @if ($rol->hasPermissionTo($permiso)) checked @endif>
                      <label class="form-check-label" for="permiso{{ $permiso->id }}">{{ $permiso->name }}</label>
                    </div>
                    @endforeach
                    <br>
                    <h5><strong>Permisos catalogos</strong></h5>
                    @foreach ($permisos2 as $permiso)
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="permisos2[]" value="{{ $permiso->id }}" id="permiso{{ $permiso->id }}" @if ($rol->hasPermissionTo($permiso)) checked @endif>
                      <label class="form-check-label" for="permiso{{ $permiso->id }}">{{ $permiso->name }}</label>
                    </div>
                    @endforeach
                    <br>

                    <h5><strong>Permisos operaciones</strong></h5>

                    @foreach ($permisos3 as $permiso)
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="permisos3[]" value="{{ $permiso->id }}" id="permiso{{ $permiso->id }}" @if ($rol->hasPermissionTo($permiso)) checked @endif>
                      <label class="form-check-label" for="permiso{{ $permiso->id }}">{{ $permiso->name }}</label>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <button id="btn-actualizar" type="button" class="btn btn-primary float-right">
              <i class="far fa-file-alt"></i>&nbsp;Guardar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@stop
@section('adminlte_js')
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    document.getElementById("btn-actualizar").addEventListener("click", function(event) {
      // Enviar el formulario mediante JavaScript

      form = $("#form-permisos");
      var form_data = new FormData($('#form-permisos')[0]);
      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: form_data,
        processData: false,
        contentType: false,
        beforeSend: function() {
          Swal.fire({
            title: 'Guardando Datos',
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
              window.location.href = '{{ route("Roles") }}'; // Recargar la página
            }
          });
        },
      });
    });

    function filterChecklist() {
      var input, filter, div, checkboxes, label, i, txtValue;
      input = document.getElementById('searchInput');
      filter = input.value.toLowerCase();
      div = document.getElementById('permisos-container'); // Usa la clase del contenedor
      checkboxes = div.getElementsByClassName('form-check');

      for (i = 0; i < checkboxes.length; i++) {
        label = checkboxes[i].getElementsByTagName('label')[0];
        txtValue = label.textContent || label.innerText;
        if (txtValue.toLowerCase().indexOf(filter) > -1) {
          checkboxes[i].style.display = '';
        } else {
          checkboxes[i].style.display = 'none';
        }
      }
    }

    // Agrega un listener al campo de búsqueda para llamar a la función de filtrado
    document.getElementById('searchInput').addEventListener('keyup', filterChecklist);

    // Agrega un listener al campo de búsqueda para llamar a la función de filtrado
    document.getElementById('searchInput').addEventListener('keyup', filterChecklist);

  });
</script>
@endsection
