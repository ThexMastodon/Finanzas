@extends('adminlte::page')

@section('title', 'Direcciones')

@section('content')

@include('admin.catalogos.Direccion.Direccion_modal')


<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Direcciones</h1>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">

          <div class="content-btn">
            <a @can('crear direccion') class="btn btn-primary" @else class="btn btn-primary disabled" @endcan id="btn-nuevo" data-togle="modal" data-target="#modal-add" data-product=1>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Direccion" class="table table-bordered table-hover">
                    <thead class="tableHeader">
                      <tr>
                        <th>ID</th>
                        <th>Estado</th>
                        <th>Municipio</th>
                        <th>Colonia</th>
                        <th>Calle</th>
                        <th>Codigo Postal</th>
                        <th>No. exterior</th>
                        <th>No. interior</th>
                        <th>Referencias</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="tableBody">
                      @foreach ($datos as $dato)
                      <tr>
                        <td>{{ $dato->id }}</td>
                        <td>{{ $dato->estado->nombre ?? ''}}</td>
                        <td>{{ $dato->municipio->nombre ?? ''}}</td>
                        <td>{{ $dato->colonia->colonia ?? ''}}</td>
                        <td>{{ $dato->calle ?? ''}}</td>
                        <td>{{ $dato->codigo_postal ?? ''}}</td>
                        <td>{{ $dato->no_exterior ?? ''}}</td>
                        <td>{{ $dato->no_interior ?? ''}}</td>
                        <td>{{ $dato->referencia ?? ''}}</td>
                        <td style="text-align: center">
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Acciones
                          </button>
                          <div class="dropdown-menu">
                            <a id="btn-Editar" @can('Editar direccion') class="dropdown-item btn-edit" @else class="dropdown-item btn-edit disabled" @endcan href="" data-id="{{ $dato->id }}"><i class="fas fa-pencil-alt text-warning"></i> Editar</a>
                            <div class="dropdown-divider"></div>
                            <a @can('Eliminar direccion') class="dropdown-item btn-delete disabled" @else class="dropdown-item btn-delete disabled" @endcan href="/admin/catalogos/Direcciones_delete/{{$dato->id}}"><i class="fas fa-trash-alt text-danger"></i> Deshabilitar</a>
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

    $('.select2').select2({
      theme: 'bootstrap4',
    });

    function limpiarCampos() {
      $('#TituloModal').html('');
      $('#direccionV').val('');
      $('#coloniaV').val('');
      $('#estado').val('');
      $('#municipio').val('');
      $('#colonia').val('');
      $('#calle').val('');
      $('#codigo_postal').val('');
      $('#no_interior').val('');
      $('#no_exterior').val('');
      $('textarea[name="referencia"').val('');
    }

    $('#AceptarForm').on('click', function(e) {
      form = $(this).closest('#modalDirecciones');
      var tipoPeticion = $('#tipoPeticion').val();
      var ruta = '';

      data = form.serialize();
      if (tipoPeticion === 'Agregar') {
        ruta = "{{ route('addaDireccion') }}";
      } else if (tipoPeticion === 'Editar') {
        ruta = "{{ route('editaDireccion') }}";
        var idDireccion = $('#direccionV').val();
        data += '&idDireccion=' + idDireccion;
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
            confirmButtonText: "{{ __('Aceptar') }}",
          }).then((result) => {
            if (result.isConfirmed) {
              $('#agregar').submit();
              window.location.href = "";
            }
          })
        },
        error: function(data) {
          $.each(data.responseJSON.errors, function(key, value) {
            mensaje =
              'Hubo un error, no se pudo registrar el módulo. Debe revisar que los datos capturados sean válidos.'
            $("#modal_direccion").find("#" + key).addClass('is-invalid');
            $("#modal_direccion").find("#" + key + '_error').addClass('d-block');
            $("#modal_direccion").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'La dirección no se agregó correctamente',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });

    //BUSCAR CODIGO POSTAL PRESIONANDO ENTER
    $('#codigo_postal').keyup('codigo_postal', function(e) {
      e.preventDefault();
      if (e.which === 13) {
        $("#buscaCP").click();
      }
    });

    //BUSCAR CODIGO POSTAL
    $('#buscaCP').on('click', function(e) {
      e.preventDefault();
      var codigoRequest = $('#codigo_postal').val();
      $.ajax({
        url: "{{ route('getCodigo_postal') }}",
        type: "GET",
        data: {
          "_token": "{{ csrf_token() }}",
          "codigo_postal": codigoRequest,
        },
        dataType: 'json',
        beforeSend: function() {
          let timerInterval
          Swal.fire({
            title: '{{__("Buscando Codigo Postal")}}',
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
          if (response.status === 'success') {
            $("#municipio").empty();
            $("#municipio").append(`<option id="${response.colonias[0].municipio_id}" value="${parseInt(response.colonias[0].municipio_id)}">${response.colonias[0].municipio}</option>`);

            $("#colonia").empty();
            $("#colonia").append(`<option id="" value="">Seleccionar Colonia</option>`);
            $.each(response.colonias, function(key, value) {
              $("#colonia").append(`<option id="${value.colonia_id}" value="${value.colonia_id}">${value.colonia}</option>`);
            });
          }
        },
        error: function(data) {
          $.each(data.responseJSON.errors, function(key, value) {
            mensaje =
              'Hubo un error, no se pudo registrar el módulo. Debe revisar que los datos capturados sean válidos.'
            $("#modal_afianzadoras").find("#" + key).addClass('is-invalid');
            $("#modal_afianzadoras").find("#" + key + '_error').addClass('d-block');
            $("#modal_afianzadoras").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'No se encontró el codigo postal.',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });

    $('.content-wrapper').on('click', '#btn-nuevo', function(e) {
      e.preventDefault();
      limpiarCampos();
      $('#TituloModal').html('Agregar dirección');
      $('#tipoPeticion').val('Agregar');
      $('#modal_direccion').modal('show');
    });

    $('.content-wrapper').on('click', '#btn-Editar', function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      $('#TituloModal').html('Editar dirección');
      $('#tipoPeticion').val('Editar');
      $.ajax({
        url: "{{ route('detalleDireccion') }}",
        type: "GET",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#codigo_postal').val(response.codigo_postal);
          $('#calle').val(response.calle);
          $('#coloniaV').val(response.colonia_id);
          $('#municipio').val(response.municipio_id).trigger("change");
          $('#no_exterior').val(response.no_exterior);
          $('#no_interior').val(response.no_interior);
          $('#modal_direccion textarea[name="referencia"]').val(response.referencia);
          $('#direccionV').val(response.id);
          $('#modal_direccion').modal('show');
        }
      });
    });

    //BUSCAR MUNICIPIOS
    $('#municipio').on('change', function() {
      var municipio = $('#municipio').val();
      var tipoPeticion = $('#tipoPeticion').val();
      $.ajax({
        url: "{{ route('getColonias') }}",
        type: "GET",
        data: {
          "_token": "{{ csrf_token() }}",
          "municipio": municipio,
        },
        dataType: 'json',
        beforeSend: function() {
          let timerInterval
          Swal.fire({
            title: '{{__("Buscando Colonias...")}}',
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
          $("#colonia").empty();
          $("#colonia").append(`<option id="" value="">Seleccionar Colonia</option>`);
          $.each(response, function(key, value) {
            $("#colonia").append(`<option id="${value.id}" value="${value.id}">${value.colonia}</option>`);
          });
          if (tipoPeticion === 'Editar') {
            $('#colonia').val($('#coloniaV').val()).trigger("change");
          }
        },
        error: function(data) {
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'No se pudo obtener colonias.',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });

    $('#Table_Direccion').DataTable({
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
