@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content')

<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Usuarios</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">

          <div class="content-btn" style="text-align: end">
            <a @can('crear Usuarios') class="btn btn-primary" @else class="btn btn-primary disabled" @endcan id="btn-nuevo" href="{{route('FormNewUser')}}" data-togle="modal" data-target="#modal-addu" data-product=1>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="tUsuario" class="table table-bordered table-hover">
                    <thead class="tableHeader">
                      <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Email</th>
                        <th>Estado</th>
                      </tr>
                    </thead>
                    <tbody class="tableBody">
                      @foreach ($datos as $dato)
                      <tr>
                        <td><a @can('Editar Usuarios', 'root' ) class="" @else class="disabled" @endcan href="{{ route('detalle',($dato->id))}}">{{ $dato->username }}</a></td>
                        <td>{{ $dato->name}}</td>
                        <td>{{ $dato->last_name}}</td>
                        <td>{{ $dato->second_last_name}}</td>
                        <td>{{ $dato->email}}</td>
                        <td style="text-align: center;">
                          @if ($dato->active == 1)
                          <i class="fas fa-check text-success"></i>
                          @else
                          <i class="fas fa-times text-danger"></i>
                          @endif
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
    $('#tUsuario').DataTable({
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
@stop
