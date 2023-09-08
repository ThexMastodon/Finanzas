@extends('adminlte::page')

@section('title', 'Roles')

@section('content')

@include('admin.roles.Asignar_Roles_Modal')


<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Roles</h1>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col">
              <div class="content-btn">
                <button id="btn-nuevo" data-toggle="modal" href="{{ route('Crear-Roles-form') }}" data-target="#modal-add" data-product="1" class="btn btn-primary"><i class="far fa-file-alt"></i> Nuevo</button>
              </div>
            </div>
            <div class="content-btn">
              <button id="btn-asignar" data-toggle="modal" data-target="#modal-add" data-product="1" class="btn btn-primary"><i class="far fa-file-alt"></i> Asignar Roles</button>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Roles" class="table table-bordered table-hover">
                    <thead class="tableHeader">
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="tableBody">
                      @foreach ($Roles as $Rol)
                      <tr>
                        <td>{{ $Rol->id }}</td>
                        <td>{{ $Rol->name }}</td>
                        @if ($Rol->status == 1)
                        <td style="text-align: center; color: #32CD32"><i class="fas fa-check"></i></td>
                        @else
                        <td style="text-align: center; color: red"><i class="fas fa-times"></i></td>
                        @endif
                        <td style="text-align: center">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Acciones
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item btn-edit" href="{{ route('Editar-Roles',($Rol->id))}}" data-target="#modal-Editar-rol" data-id="{{ $Rol->id }}">
                              <i class="fas fa-pencil-alt text-warning"></i>&nbsp; Editar
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item btn-delete" href="{{ route('Eliminar-Roles',($Rol->id))}}" data-id="{{ $Rol->id }}">
                              @if($Rol->status == 1)
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
  $(document).ready(function() {
    $('.btn-delete').click(function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      Swal.fire({
        icon: 'warning',
        title: 'Modificar rol',
        text: '¿Estás seguro de modificar el rol?',
        confirmButtonText: "{{ __('Aceptar') }}",
        showCancelButton: true,
        cancelButtonText: "{{ __('Cancelar') }}",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('Eliminar-Roles') }}",
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
    $('#usuario_id , #rol_id').select2({
      theme: 'bootstrap4',
    });
    $('#btn-asignar').click(function() {
      $('#modal-Asignar').modal('show');
    });
    $('#btn-nuevo').click(function() {
      window.location.href = "{{ route('Crear-Roles-form') }}";
    });

    $('#Table_Roles').DataTable({
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
