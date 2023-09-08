@extends('adminlte::page')

@section('title', 'Cancelados')

@section('content')
@include('admin.operaciones.cancelados.cancelados_modal')

<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Cancelados</h1>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="content-btn" style="text-align: end">
            <a id="btn-excel" class="btn btn-primary" href="{{ route('exportaExcelCancelados') }}">
              <i class="fas fa-file-excel" style="color: #0aa340;"></i>
              Descargar excel
            </a>
            <a @can('crear Cancelados') class="btn btn-primary" @else class="btn btn-primary disabled" @endcan id="btn-nuevo" data-togle="modal" data-target="#modal-add" data-product=1>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Cancelados" class="table table-bordered table-hover">
                    <thead class="tableHeader">
                      <tr>
                        <th>ID</th>
                        <th>Oficio</th>
                        <th>Fecha oficio</th>
                        <th>Número de fianza cheque</th>
                        <th>Fecha cancelación</th>
                        <th>Usuario que canceló</th>
                        <th>Afianzadora</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody class="tableBody">
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
      $('#oficio').val('');
      $('#afianzadora').val('').trigger("change");
      $('#fecha_oficio').val('');
      $('#fecha_cancelacion').val('');
      $('#fianza_cheque').val('').trigger("change");

      $('#oficio, #afianzadora, #fecha_oficio, #fecha_cancelacion, #fianza_cheque').removeClass('is-invalid');
      $('#oficio_error, #afianzadora_error, #fecha_oficio_error, #fecha_cancelacion_error, #fianza_cheque_error').removeClass('d-block');
    }


    $('.content-wrapper').on('click', '#btn-nuevo', function(e) {
      $('#fianza_cheque').select2({
        theme: 'bootstrap4',
        searchInputPlaceholder: 'Buscar fianza o cheque',
        minimumInputLength: 2, // Establecer el número mínimo de caracteres para activar la búsqueda
        ajax: {
          url: "{{ route('busqueda_fianza') }}", // URL para realizar la búsqueda en el servidor
          type: "GET",
          dataType: "json",
          delay: 250, // Retardo en milisegundos antes de enviar la solicitud al servidor
          data: function(params) {
            return {
              searchFianza: params.term, // Término de búsqueda proporcionado por el usuario
            };
          },
          processResults: function(data) {
            // Transforms the top-level key of the response object from 'items' to 'results'
            return {
              results: data.fianza_cheque,
            };
          },
          cache: true, // Habilitar el almacenamiento en caché de resultados
        },
        language: {
          noResults: function() {
            return "No se encontraron resultados";
          },
          searching: function() {
            return "Buscando...";
          },
          inputTooShort: function(args) {
            var remainingChars = args.minimum - args.input.length;
            return "Por favor, introduce " + remainingChars + " caracteres más";
          },
          // Puedes agregar más traducciones según tus necesidades
        },
      });

      e.preventDefault();
      limpiarCampos();
      $('#TituloModal').html('Agregar cancelado');
      $('#tipoPeticion').val('Agregar');

      $.ajax({
        url: "{{ route('fecha_actual') }}",
        type: "GET",
        success: function(response) {
          $("#fecha_cancelacion").val(response.fechaActual);
          $('#modal-cancelados').modal('show');
          $('#fianza_cheque').empty();
        },
        error: function(error) {
          console.log("Ha ocurrido un error:", error);
        }
      });

    });

    $('.content-wrapper').on('click', '.btn-edit', function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      $('#TituloModal').html('Editar cancelado');
      $('#tipoPeticion').val('Editar');
      $('#canceladoV').val(id);
      $.ajax({
        url: "{{ route('detalleCancelado') }}",
        type: "GET",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#fianza_cheque').empty();
          $('#oficio').val(response.cancelado.oficio);
          $('#afianzadora').val(response.cancelado.afianzadoras_id).trigger("change");
          $('#fecha_oficio').val(response.cancelado.fecha_oficio);
          $('#fecha_cancelacion').val(response.cancelado.fecha_cancelacion);
          if (response.cancelado.fianza_cheque) {
            $('#fianza_cheque').append('<option value="' + response.cancelado.fianza_cheque.id + '" selected>' + response.cancelado.fianza_cheque.no_fianza_cheque + '</option>');
          } else {
            $('#fianza_cheque').select2({
              theme: 'bootstrap4',
              searchInputPlaceholder: 'Buscar fianza o cheque',
              minimumInputLength: 2, // Establecer el número mínimo de caracteres para activar la búsqueda
              ajax: {
                url: "{{ route('busqueda_fianza') }}", // URL para realizar la búsqueda en el servidor
                type: "GET",
                dataType: "json",
                delay: 250, // Retardo en milisegundos antes de enviar la solicitud al servidor
                data: function(params) {
                  return {
                    searchFianza: params.term, // Término de búsqueda proporcionado por el usuario
                  };
                },
                processResults: function(data) {
                  // Transforms the top-level key of the response object from 'items' to 'results'
                  return {
                    results: data.fianza_cheque,
                  };
                },
                cache: true, // Habilitar el almacenamiento en caché de resultados
              },
              language: {
                noResults: function() {
                  return "No se encontraron resultados";
                },
                searching: function() {
                  return "Buscando...";
                },
                inputTooShort: function(args) {
                  var remainingChars = args.minimum - args.input.length;
                  return "Por favor, introduce " + remainingChars + " caracteres más";
                },
                // Puedes agregar más traducciones según tus necesidades
              },
            });
          }
          $('#modal-cancelados').modal('show');
        }
      });
    });

    $('#AceptarForm').on('click', function(e) {
      e.preventDefault();
      form = $(this).closest('#modalCancelados');
      var tipoPeticion = $('#tipoPeticion').val();
      var ruta = '';

      data = form.serialize();
      if (tipoPeticion === 'Agregar') {
        ruta = "{{ route('Agregar-cancelado') }}";
      } else if (tipoPeticion === 'Editar') {
        ruta = "{{ route('Actualizar-cancelado') }}";
        var id = $('#canceladoV').val();
        data += '&id=' + id;
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
              // $('#agregar').submit();
              window.location.href = "";
            }
          })
        },
        error: function(data) {
          $.each(data.responseJSON.errors, function(key, value) {
            mensaje =
              'Hubo un error, no se pudo registrar el módulo. Debe revisar que los datos capturados sean válidos.'
            $("#modal-cancelados").find("#" + key).addClass('is-invalid');
            $("#modal-cancelados").find("#" + key + '_error').addClass('d-block');
            $("#modal-cancelados").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'La cancelación no se agregó correctamente.',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });

  });

  $('#Table_Cancelados').DataTable({
    processing: true,
    serverSide: true,
    buttons: [{
      extend: 'excel',
      text: 'Exportar a Excel',
      className: 'btn btn-success',
      title: 'Afianzadoras',
      exportOptions: {
        columns: [0, 1, 2, 3, 4, 5, 6]
      },
    }],
    ajax: "{{ route('llenadoTableCancelados') }}",
    columns: [{
        data: 'id',
        name: 'id',
      },
      {
        data: 'oficio',
        name: 'oficio'
      },
      {
        data: 'fecha_oficio',
        name: 'fecha_oficio',
      },
      {
        data: 'no_fianza_cheque',
        name: 'no_fianza_cheque',
      },
      {
        data: 'fecha_cancelacion',
        name: 'fecha_cancelacion',
      },
      {
        data: 'usuario',
        name: 'usuario',
      },
      {
        data: 'afianzadora',
        name: 'afianzadora',
      },
      {
        data: 'acciones',
        name: 'acciones',
      }
    ],
    pageLength: 50,
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
      aria: {
        "sortAscending": ": activar para ordenar la columna ascendente",
        "sortDescending": ": activar para ordenar la columna descendente"
      }
    }
  });
</script>
@endsection
@section('adminlte_js')
<script type="text/javascript"></script>
@stop
