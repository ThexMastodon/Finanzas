@extends('adminlte::page')

@section('title', 'Colonias')

@section('content')

@include('admin.catalogos.Colonia.Colonia_modal')

<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Colonias</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="content-btn">
            <a id="btn-nuevo" data-togle="modal" data-target="#modal-add" data-product=1 @can('crear Colonia')class="btn btn-primary" @else class="btn btn-primary disabled" @endcan>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Colonias" class="table table-bordered table-hover">
                    <thead class="tableHeader">
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>

                        <th>Codigo Postal</th>
                        <th>Estado</th>
                        <th>Municipio</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="tableBody">

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
      $('#municipio, #estado').val('').trigger('change');
      $('#colonia').val('');
      $('#codigo_postal').val('');
      $('#estado ,#municipio, #colonia, #codigo_postal').removeClass('is-invalid');
      $('#estado_error, #municipio_error, #colonia_error, #codigo_postal_error').removeClass('d-block');
    }

    $('.content-wrapper').on('click', '#btn-nuevo', function(e) {
      e.preventDefault();
      limpiarCampos();
      $('#TituloModal').html('Agregar colonia');
      $('#tipoPeticion').val('Agregar');
      $('#modal_colonia').modal('show');
    });

    $('.content-wrapper').on('click', '#btn-Editar', function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      $('#TituloModal').html('Editar colonia');
      $('#tipoPeticion').val('Editar');
      $.ajax({
        url: "{{ route('detalleColonia') }}",
        type: "GET",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#estado').val(response.estado_id).trigger('change');
          $('#municipio').val(response.municipio_id).trigger('change');
          $('#colonia').val(response.colonia);
          $('#codigo_postal').val(response.codigo_postal);
          $('#coloniaV').val(response.id);
          $('#modal_colonia').modal('show');
        }
      });
    });

    $('#AceptarForm').on('click', function(e) {
      form = $(this).closest('#modalColonia');
      var tipoPeticion = $('#tipoPeticion').val();
      var ruta = '';

      data = form.serialize();
      if (tipoPeticion === 'Agregar') {
        ruta = "{{ route('addaColonia') }}";
      } else if (tipoPeticion === 'Editar') {
        ruta = "{{ route('editaColonia') }}";
        var idColonia = $('#coloniaV').val();
        data += '&idColonia=' + idColonia;
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
              $('#modal_colonia').modal('hide');
              window.location.href = "";
            }
          })
        },
        error: function(data) {
          $.each(data.responseJSON.errors, function(key, value) {
            mensaje =
              'Hubo un error, no se pudo registrar el módulo. Debe revisar que los datos capturados sean válidos.'
            $("#modal_colonia").find("#" + key).addClass('is-invalid');
            $("#modal_colonia").find("#" + key + '_error').addClass('d-block');
            $("#modal_colonia").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'La colonia no se agregó correctamente',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });

    $('.content-wrapper').on('click', '#btn-delete', function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      Swal.fire({
        icon: 'warning',
        title: 'Deshabilitar colonia',
        text: '¿Estás seguro de deshabilitar esta colonia?',
        confirmButtonText: "{{ __('Aceptar') }}",
        showCancelButton: true,
        denyButtonText: "{{ __('Cancelar') }}",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('COLdelete') }}",
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
            }
          });
        }
      })
    });


    $('#Table_Colonias').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('llenadoTableColonias') }}",
      columns: [{
          data: 'id',
          name: 'id',
        },
        {
          data: 'colonia',
          name: 'colonia',
        },
        {
          data: 'codigo_postal',
          name: 'codigo_postal',
        },
        {
          data: 'estado',
          name: 'estado',
        },
        {
          data: 'municipio',
          name: 'municipio',
        },
        {
          data: 'activo',
          name: 'activo',
        },
        {
          data: 'acciones',
          name: 'acciones',
        }
      ],
      pageLength: 25,
      language: {
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
