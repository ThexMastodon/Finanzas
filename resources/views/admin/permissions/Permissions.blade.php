@extends('adminlte::page')

@section('title', 'Permisos')

@section('content')

@include('admin.permissions.Pemissions-modal')


<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Permisos</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="content-btn">
            <button @can('crear Permisos') class="btn btn-primary" @else class="btn btn-primary disabled" @endcan id="btn-nuevo" data-toggle="modal" data-target="#modal_Permissions" data-product="1"><i class="far fa-file-alt"></i> Nuevo</button>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Permisos" class="table table-bordered table-hover">
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
                        <td>{{ $dato->name }}</td>

                        @if ($dato->status == 1)
                        <td style="text-align: center; color: #32CD32"><i class="fas fa-check"></i></td>
                        @else
                        <td style="text-align: center; color: red"><i class="fas fa-times"></i></td>
                        @endif
                        <td style="text-align: center">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Acciones
                          </button>
                          <div class="dropdown-menu" style="">

                            <a class="dropdown-item btn-edit disabled" href="" data-target="#modal-editc">
                              <i class="fas fa-pencil-alt text-warning"></i>&nbsp;Editar
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete disabled" href="" data-id="{{ $dato->id }}">
                              <i class="fas fa-trash-alt text-danger"></i>&nbsp;Eliminar</a>
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
    document.getElementById("btn-AceptarForm").addEventListener("click", function(event) {
      // Enviar el formulario mediante JavaScript

      form = $("#form_Permissions");
      var form_data = new FormData($('#form_Permissions')[0]);
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
              window.location.href = '{{ route("Permisos") }}'; // Recargar la página
            }
          });
        },
      });
    });
    $('.select2').select2({
      theme: 'bootstrap4',
    });
    $('#btn-nuevo').click(function() {
      $('#modal_Permissions').modal('show');
    });



    $('#Table_Permisos').DataTable({
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
  });
</script>
@endsection
@section('adminlte_js')
<script type="text/javascript"></script>
@stop
