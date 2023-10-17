@extends('adminlte::page')

@section('title', 'Estado')

@section('content')

@include('admin.catalogos.Estado.Estado_modal')


<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Estados</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="content-btn">
            <a id="btn-nuevo" data-togle="modal" data-target="#modal-add" data-product=1 @can('crear Estados')class="btn btn-primary" @else class="btn btn-primary disabled" @endcan>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Estados" class="table table-bordered table-hover">
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
                        <td>{{ $dato->descripcion }}</td>

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
                            <a id="btn-Editar" @can('Editar Estados') class="dropdown-item btn-edit" @else class="dropdown-item btn-edit disabled" @endcan href="" data-target="#modal_estado" data-id="{{ $dato->id }}"><i class="fas fa-pencil-alt text-warning"></i> Editar</a>
                            <div class="dropdown-divider"></div>
                            <a @can('Eliminar Estados') class="dropdown-item btn-delete" @else class="dropdown-item btn-delete disabled" @endcan data-id="{{ $dato->id }}" href="/admin/catalogos/Estados_delete/{{$dato->id}}">
                              @if($dato->activo == 1)
                              <i class="fas fa-trash-alt text-danger"></i>
                              Deshabilitar
                              @else
                              <i class="fas fa-trash-restore text-success"></i>
                              Habilitar @endif</a>
                            </a>
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
  $(document).ready(function() {

    $('#AceptarForm').on('click', function(e) {
      e.preventDefault();
      form = $(this).closest('#modalEstado');
      var tipoPeticion = $('#tipoPeticion').val();
      var ruta = '';

      data = form.serialize();
      if (tipoPeticion === 'Agregar') {
        ruta = "{{ route('addaEstado') }}";
      } else if (tipoPeticion === 'Editar') {
        ruta = "{{ route('editaestado') }}";
        var idEstado = $('#estadoV').val();
        data += "&idEstado=" + idEstado;
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
              window.location.href = '{{route ("Estado")}}'; // Recargar la página
            }
          });
        },
        error: function(data) {
          $.each(data.responseJSON.errors, function(key, value) {
            mensaje =
              'Hubo un error, no se pudo registrar el módulo. Debe revisar que los datos capturados sean válidos.'
            $("#modal_estado").find("#" + key).addClass('is-invalid');
            $("#modal_estado").find("#" + key + '_error').addClass('d-block');
            $("#modal_estado").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'El estado no se agregó correctamente',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    })

    $('.content-wrapper').on('click', '#btn-nuevo', function(e) {
      e.preventDefault();
      limpiarCampos();
      $('#TituloModal').html('Agregar estado');
      $('#tipoPeticion').val('Agregar');
      $('#modal_estado').modal('show');
    });

    $('.content-wrapper').on('click', '#btn-Editar', function(e) {
      e.preventDefault();
      limpiarCampos();
      var id = $(this).data('id');
      $('#TituloModal').html('Editar estado');
      $('#tipoPeticion').val('Editar');
      $('#estadoV').val(id);
      $.ajax({
        url: "{{ route('detalleEstado') }}",
        type: "GET",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#nombre').val(response.descripcion);
          $('#modal_estado').modal('show');
        }
      });
    });

    $('.btn-delete').click(function(e) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: 'Modificar Estado',
        text: '¿Estás seguro de modificar el estado?',
        confirmButtonText: "{{ __('Aceptar') }}",
        showCancelButton: true,
        denyButtonText: "{{ __('Cancelar') }}",
      }).then((result) => {
        if (result.isConfirmed) {
          var id = $(this).data('id');
          $.ajax({
            url: "{{ route('ESTdelete') }}",
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

    $('#Table_Estados').DataTable({
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
      $('#nombre').val('');
      $('#id').val('');

      $('#nombre').removeClass('is-invalid');
      $('#nombre_error').removeClass('d-block');
    }


  });
</script>
@endsection
@section('adminlte_js')
<script type="text/javascript"></script>
@stop
