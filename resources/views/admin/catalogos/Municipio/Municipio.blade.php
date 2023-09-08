@extends('adminlte::page')

@section('title', 'Municipio')

@section('content')

@include('admin.catalogos.Municipio.Municipio_modal')


<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Municipios</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="content-btn">
            <!-- <button id="btn-nuevo" data-togle="modal" data-target="#modal-add" data-product=1 class="btn btn-secondary">Nuevo</button> -->
            <a id="btn-nuevo" data-togle="modal" data-target="#modal-add" data-product=1 @can('crear Municipios')class="btn btn-primary" @else class="btn btn-primary disabled" @endcan>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Municipios" class="table table-bordered table-hover">
                    <thead class="tableHeader">
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="tableBody">
                      @foreach ($datos as $dato)
                      <tr>
                        <td>{{ $dato->id }}</td>
                        <td>{{ $dato->nombre }}</td>

                        @if ($dato->activo == 1)
                        <td style="text-align: center; color: #32CD32"><i class="fas fa-check"></i></td>
                        @else
                        <td style="text-align: center; color: red"><i class="fas fa-times"></i></td>
                        @endif
                        <td style="text-align: center">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Acciones
                          </button>
                          <div class="dropdown-menu">
                            <a @can('Editar Municipios') class="dropdown-item btn-edit" @else class="dropdown-item btn-edit disabled" @endcan href="#" data-target="#modal-edit" data-id="{{ $dato->id }}" data-nombre="{{ $dato->nombre }}"><i class="fas fa-pencil-alt text-warning"></i> Editar</a>

                            <div class="dropdown-divider"></div>
                            <a id="" @can('Eliminar Municipios') class="dropdown-item btn-delete" @else class="dropdown-item btn-delete disabled" @endcan href="/admin/catalogos/Estatus_delete/{{$dato->id}}" data-id="{{ $dato->id }}">
                              @if($dato->activo == 1)
                              <i class="fas fa-trash-alt text-danger"></i>
                              Deshabilitar
                              @else
                              <i class="fas fa-trash-restore text-success"></i>
                              Habilitar @endif</a>
                          </div>
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
      </section>
    </div>
  </div>
</body>
@stop
@section('adminlte_js')
<script type="text/javascript">
  $('.select2').select2({
    theme: 'bootstrap4',
  });
  $(document).ready(function() {

    $('#AceptarForm').click(function(e) {
      e.preventDefault();
      form = $(this).closest('#modalMunicipio');
      var tipoPeticion = $('#tipoPeticion').val();
      var ruta = '';

      data = form.serialize();
      if (tipoPeticion === 'Agregar') {
        ruta = "{{ route('addaMunicipio') }}";
      } else if (tipoPeticion === 'Editar') {
        ruta = "{{ route('editaMunicipio') }}";
        var idMunicipio = $('#municipioV').val();
        data += "&idMunicipio=" + idMunicipio;
      }

      $.ajax({
        url: ruta,
        type: "POST",
        data: data,
        dataType: 'json',
        beforeSend: function() {
          let timerInterval
          Swal.fire({
            title: '{{__("Guardando datos")}}',
            html: ' <b></b>',
            allowOutsideClick: false,
            timer: 500,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
            }
          });
        },
        success: function(response) {
          Swal.fire({
            icon: response.status,
            title: response.title,
            text: response.message,
            confirmButtonText: "Aceptar",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '{{route ("Municipio")}}'; // Recargar la página
            }
          });
        },
        error: function(data) {
          $.each(data.responseJSON.errors, function(key, value) {
            mensaje =
              'Hubo un error, no se pudo registrar el módulo. Debe revisar que los datos capturados sean válidos.'
            $("#modal_municipio").find("#" + key).addClass('is-invalid');
            $("#modal_municipio").find("#" + key + '_error').addClass('d-block');
            $("#modal_municipio").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'El municipio no se agregó correctamente',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });

    $('#btn-nuevo').click(function(e) {
      e.preventDefault();
      limpiarCampos();
      $('#TituloModal').html('Agregar municipio');
      $('#tipoPeticion').val('Agregar');
      $('#modal_municipio').modal('show');
    });

    $('.btn-edit').click(function(e) {
      e.preventDefault();
      limpiarCampos();
      var id = $(this).data('id');
      $('#TituloModal').html('Editar municipio');
      $('#tipoPeticion').val('Editar');
      $('#municipioV').val(id);
      $.ajax({
        url: "{{ route('detalleMunicipio') }}",
        type: "GET",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#nombre').val(response.nombre);
          $('#estado_id').val(response.estado_id).trigger('change');
          $('#modal_municipio').modal('show');
        },
      });
    });

    $('.btn-delete').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      Swal.fire({
        icon: 'warning',
        title: 'Modificar Municipio',
        text: '¿Estás seguro de modificar el municipio?',
        confirmButtonText: "{{ __('Aceptar') }}",
        showCancelButton: true,
        cancelButtonText: "{{ __('Cancelar') }}",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('MUNdelete') }}",
            type: "GET",
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              Swal.fire({
                icon: response.status,
                title: response.title,
                text: response.message,
                confirmButtonText: "{{ __('Aceptar') }}",
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "";
                }
              })
            },
          });
        }
      })
    });

    $('#Table_Municipios').DataTable({
      "processing": true,
      "searching": true,
      "columnDefs": [{
        "targets": ['_all'],
        "orderable": true,
        "searchable": true
      }],
      "language": {
        "decimal": "",
        "emptyTable": "No hay datos disponibles en la tabla",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
        "infoFiltered": "(filtrado de _MAX_ entradas totales)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros coincidentes",
        "paginate": {
          "first": "Primero",
          "last": "Último",
          "next": "Siguiente",
          "previous": "Anterior"
        },
        "aria": {
          "sortAscending": ": activar para ordenar la columna ascendente",
          "sortDescending": ": activar para ordenar la columna descendente"
        }
      }
    });

    function limpiarCampos() {
      $('#TituloModal').html('');
      $('#tipoPeticion').val('');
      $('#estado_id').val('').trigger('change');
      $('#municipioV').val('');
      $('#nombre').val('');
      $('#id').val('');

      $('#nombre, #estado_id').removeClass('is-invalid');
      $('#nombre_error, #estado_id_error').removeClass('d-block');
    }

  });
</script>
@endsection
@section('adminlte_js')
<script type="text/javascript"></script>
@stop
