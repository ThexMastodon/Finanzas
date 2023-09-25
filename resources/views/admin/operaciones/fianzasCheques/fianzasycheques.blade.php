@extends('adminlte::page')

@section('title', 'Fianzas y Cheques')

@section('content')
@include('admin.operaciones.fianzasCheques.fianza_cheque_modal')

<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Fianzas y Cheques</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="content-btn">
            <a id="btn-excel" class="btn btn-primary" href="{{ route('exportaExcelFiaCheq') }}">
              <i class="fas fa-file-excel" style="color: #0aa340;"></i>
              Descargar excel
            </a>
            <a @can('crear Fianzas y cheques') class="btn btn-primary" @else class="btn btn-primary disabled" @endcan id="btn-nuevo" href="" data-togle="modal" data-target="#modal-FC" data-product=1>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="fianzasChequesTable" class="table table-bordered table-hover">
                    <thead class="tableHeader">
                      <tr>
                        <th>Id</th>
                        <th>No Fianza/Cheque</th>
                        <th>Importe</th>
                        <th>Afianzadora</th>
                        <th>Estatus</th>
                        <th>Fecha de creación</th>
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
@yield('modal_js')
<style>
  .cargando {
    background-color: rgba(169, 169, 169, 0.85);
    /* Gris transparente */
  }
</style>
<script type="text/javascript">
  $('input[name="tipo_persona"]').on("change", function() {
    var selectedValue = $(this).val();
    if (selectedValue === "1") {
      // Mostrar campos para "Física"
      $('.rsocial, .fisica').show();
      $('.rsocial').removeClass('col-12').addClass('col-4');
    } else if (selectedValue === "0") {
      // Mostrar campos para "Moral"
      $('.rsocial').show();
      $('.fisica').hide();
      $('.rsocial').removeClass('col-4').addClass('col-12');
    }
  });

  $('#tab2-tab').on("click", function(e) {
    e.preventDefault();

  });

  $("#fecha_expedicion").on("change", function() {
    var fechaExpedicion = $("#fecha_expedicion").val();

    $.ajax({
      url: "{{ route('calcular-fecha-vencimiento') }}",
      type: "POST",
      data: {
        _token: "{{ csrf_token() }}",
        fechaExpedicion: fechaExpedicion
      },
      success: function(response) {
        $("#fecha_vencimiento").val(response.fechaVencimiento);
      },
      error: function(error) {
        console.log("Ha ocurrido un error:", error);
      }
    });
  });

  $('.select2').select2({
    theme: 'bootstrap4',
  });

  $('#fianzasChequesTable').DataTable({
    processing: true,
    serverSide: true,
    buttons: [{
      extend: 'excel',
      text: 'Exportar a Excel',
      className: 'btn btn-success',
      title: 'Afianzadoras',
      exportOptions: {
        columns: [0, 1, 2, 3]
      },
    }],
    order: [[0, 'desc']],
    ajax: {
      url: "{{ route('llenadoTableFianzasCheques') }}",
      type: "POST", // Cambiamos el tipo de petición
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Agregar el token CSRF si estás utilizando Laravel
      },
      beforeSend: function() {
        var dt = $('#fianzasChequesTable').DataTable();
        var settings = dt.settings();
        if (settings[0].jqXHR) {
          settings[0].jqXHR.abort();
        }
      },
    },

    columns: [{
        data: 'id',
        name: 'id',
      },
      {
        data: 'no_fianza_cheque',
        name: 'no_fianza_cheque'
      },
      {
        data: 'importe',
        name: 'importe',
      },
      {
        data: 'afianzadora',
        name: 'afianzadora',
      },
      {
        data: 'estatus',
        name: 'estatus',
      },
      {
        data: 'fecha_expedicion',
        name: 'fecha_expedicion',
      },
      {
        data: 'acciones',
        name: 'acciones',
      }
    ],
    preDrawCallback: function(settings) {

      $('#fianzasChequesTable').addClass('cargando');
    },
    drawCallback: function(settings) {
      // Elimina la clase de cargando después de que se complete la búsqueda
      $('#fianzasChequesTable').removeClass('cargando');
    },
    pageLength: 10,
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

  function limpiarCampos() {
    $('input:text').val('');
    $('#codigo_postal').val('');
    $('#estado').val('').trigger('change');
    $('#municipio').val('').trigger('change');
    $('#colonia').val('').trigger('change');
    $('#no_exterior').val('');
    $('#no_interior').val('');
    $('textarea[name="referencia"]').val('');
    $('textarea[name="concepto"]').val('');
    $('textarea[name="direccion_historico"]').val('');
    $('#tipo').val('').trigger('change');
    $('#afianzadora').val('').trigger('change');
    $('#estatus').val('').trigger('change');
    $('#fecha_oficio').val('');
    $('#fecha_expedicion').val('');
    $('#fecha_vencimiento').val('');
    $('#fecha_vencimiento').val('');
    $('#nombreHistorico').val('');
    $('#tipo,#afianzadora,#estatus,#fianza_cheque,#fecha_oficio,#fecha_expedicion, #fecha_vencimiento,#aFavor, #importe , #licitacion,#concepto,#estado,#municipio,#colonia,#calle,#no_exterior,#nombre,#APaterno,#AMaterno,#nombreHistorico').removeClass('is-invalid');
    $('#tipo_error,#afianzadora_error,#estatus_error,#fianza_cheque_error,#fecha_oficio_error,#fecha_expedicion_error, #fecha_vencimiento_error,#aFavor_error, #importe_error , #licitacion_error,#concepto_error,#estado_error,#municipio_error,#colonia_error,#calle_error,#no_exterior_error,#nombre_error,#APaterno_error,#AMaterno_error').removeClass('d-block');
  }
  $(document).ready(function() {

    $('#btn-nuevo').click(function(e) {
      $('#nameHistorico').prop('hidden', true);
      $('.newNombre').prop('hidden', false);
      if ($("#custom-general-tab").hasClass("active")) {
        $("#custom-address-tab").click();
      }
      limpiarCampos();
      e.preventDefault();
      $('#TituloModal').html('Agregar Fianza/Cheque');
      $("#tab1-tab").click();
      $('#tipoPeticion').val('Agregar');
      $('#dirHistorico').prop('hidden', true);
      $('.NewDireccion').prop('hidden', false);
      $('#estatus').val('2').trigger('change');
      $('.estatusFianza').hide();
      $('#aFavor').val('Secretaría de Finanzas y Administración');
      $('#modal-FC').modal('show');
    });


    // LLENAMOS EL MODAL CON LOS DATOS DE ESA FIANZA/CHEQUE
    $('.content-wrapper').on('click', '#btn-Editar', function(e) {
      e.preventDefault();
      $('textarea[name="direccion_historico"]').val('');
      $('.estatusFianza').show();
      $('#tipo,#afianzadora,#estatus,#fianza_cheque,#fecha_oficio,#fecha_expedicion, #fecha_vencimiento,#aFavor, #importe , #licitacion,#concepto,#estado,#municipio,#colonia,#calle,#no_exterior,#nombre,#APaterno,#AMaterno').removeClass('is-invalid');
      $('#tipo_error,#afianzadora_error,#estatus_error,#fianza_cheque_error,#fecha_oficio_error,#fecha_expedicion_error, #fecha_vencimiento_error,#aFavor_error, #importe_error , #licitacion_error,#concepto_error,#estado_error,#municipio_error,#colonia_error,#calle_error,#no_exterior_error,#nombre_error,#APaterno_error,#AMaterno_error').removeClass('d-block');
      var id = $(this).data('id');
      $('#TituloModal').html('Editar Fianza/Cheque');
      $('#tipoPeticion').val('Editar');
      $.ajax({
        url: "{{ route('detalleFianzaCheque') }}",
        type: "GET",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          if (response.direccion_historico) {
            $('#dirHistorico').prop('hidden', false);
            $('.NewDireccion').prop('hidden', true);
            $('#direccion_historico').val(response.direccion_historico);
          } else {
            $('#dirHistorico').prop('hidden', true);
            $('.NewDireccion').prop('hidden', false);
          }
          if (response.expedido_por) {
            $('#nameHistorico').prop('hidden', false);
            $('.newNombre').prop('hidden', true);
            $('#nombreHistorico').val(response.expedido_por);
          } else {
            $('#nameHistorico').prop('hidden', true);
            $('.newNombre').prop('hidden', false);
            $('#nombre').val(response.nombre);
            $('#APaterno').val(response.apellido_paterno);
            $('#AMaterno').val(response.apellido_materno);
          }
          if (response.direccion) {
            $('#coloniaV').val(response.direccion.colonia_id);
            $('#municipioEditV').val(response.direccion.municipio_id);
            $('#codigo_postal').val(response.direccion.codigo_postal);
            $('#estado').val(response.direccion.estado_id).trigger('change');
            $('#municipio').val(response.direccion.municipio_id).trigger('change');
            $('#colonia').val(response.direccion.colonia_id).trigger('change');
            $('#calle').val(response.direccion.calle);
            $('#no_exterior').val(response.direccion.no_exterior);
            $('#no_interior').val(response.direccion.no_interior);
            $('textarea[name="referencia"]').val(response.direccion.referencia);
          }
          if (response.tipo_persona != null) {
            response.tipo_persona === "1" ? $('input[name="tipo_persona"][value="1"]').prop('checked', true) : $('input[name="tipo_persona"][value="0"]').prop('checked', true);
          }
          $('#fianza_cheque').val(response.no_fianza_cheque);
          $('#fecha_expedicion').val(response.fecha_expedicion);
          $('#fecha_vencimiento').val(response.fecha_vencimiento);
          $('#aFavor').val(response.a_favor);
          $('#importe').val(response.importe);
          $('#licitacion').val(response.licitación);
          $('#oficio').val(response.oficio);
          $('#fecha_oficio').val(response.fecha_oficio);
          $('#afianzadora').val(response.afianzadoras_id).trigger('change');
          $('#tipo').val(response.tipo_id).trigger('change');
          $('#estatus').val(response.estatus_id).trigger('change');
          $('#concepto').val(response.concepto);
          $('#FianzaChequeV').val(response.id);

          var selectedValue = response.tipo_persona;
          if (selectedValue === "1") {
            // Mostrar campos para "Física"
            $('.rsocial, .fisica').show();
            $('.rsocial').removeClass('col-12').addClass('col-4');
          } else if (selectedValue === "0") {
            // Mostrar campos para "Moral"
            $('.rsocial').show();
            $('.fisica').hide();
            $('.rsocial').removeClass('col-4').addClass('col-12');
          }
          $('#modal-FC').modal('show');
        }
      });
    });

    $('.content-wrapper').on('click', '#AceptarForm', function(e) {
      form = $(this).closest('#modalFianzaCheques');
      var tipoPeticion = $('#tipoPeticion').val();
      var ruta = '';
      data = form.serialize();
      if ($("#custom-address-tab").hasClass("active")) {
        ruta = "{{ route('validarPestana1') }}";
      } else if (tipoPeticion === 'Agregar') {
        ruta = "{{ route('nuevafianzas_cheques') }}";
      } else if (tipoPeticion === 'Editar') {
        ruta = "{{ route('actualizarFianzaCheque') }}";
        var idFianzaCheque = $('#FianzaChequeV').val();
        data += '&idFianzaCheque=' + idFianzaCheque;
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
            timer: 200,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
            }
          });
        },
        success: function(response) {

          if ($("#custom-address-tab").hasClass("active")) {
            $("#custom-general-tab").click();
          } else {
            Swal.fire({
              icon: response.status,
              title: response.title,
              text: response.message,
              confirmButtonText: "{{ __('Aceptar') }}",
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = "";
              }
            });
          }
        },
        error: function(data) {
          $.each(data.responseJSON.errors, function(key, value) {
            mensaje =
              'Hubo un error, no se pudo registrar el módulo. Debe revisar que los datos capturados sean válidos.'
            $("#modal-FC").find("#" + key).addClass('is-invalid');
            $("#modal-FC").find("#" + key + '_error').addClass('d-block');
            $("#modal-FC").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'La fianza o cheque no se agregó correctamente',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });

    });


    //BUSCAR CODIGO POSTAL PRESIONANDO ENTER
    $('#codigo_postal').keyup('codigo_postal', function(e) {
      event.preventDefault();
      if (event.which === 13) {
        $("#buscaCP").click();
      }
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
          $('#colonia').select2({
            theme: 'bootstrap4',
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

    //BUSCAR ESTADOS
    $('#estado').on('change', function() {
      var estado = $('#estado').val();
      var tipoPeticion = $('#tipoPeticion').val();
      $.ajax({
        url: "{{ route('getMunicipios') }}",
        type: "GET",
        data: {
          "_token": "{{ csrf_token() }}",
          "estado": estado,
        },
        dataType: 'json',
        beforeSend: function() {
          let timerInterval
          Swal.fire({
            title: '{{__("Buscando Municipios...")}}',
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
          $("#municipio").empty();
          $("#municipio").append(`<option id="" value="">Seleccionar Municipio</option>`);
          $.each(response, function(key, value) {
            $("#municipio").append(`<option id="${value.id}" value="${value.id}">${value.nombre}</option>`);
          });
          $('#municipio').select2({
            theme: 'bootstrap4',
          });
          if (tipoPeticion === 'Editar') {
            $('#municipio').val($('#municipioEditV').val()).trigger("change");
          }
        },
        error: function(data) {
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'No se pudo obtener municipios.',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });

    //BUSCAR CODIGO POSTAL
    $('#buscaCP').on('click', function() {
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
            $("#estado").empty();
            $("#estado").append(`<option id="${response.colonias[0].estado_id}" value="${parseInt(response.colonias[0].estado_id)}">${response.colonias[0].estado}</option>`);
            $("#municipio").empty();
            $("#municipio").append(`<option id="${response.colonias[0].municipio_id}" value="${parseInt(response.colonias[0].municipio_id)}">${response.colonias[0].municipio}</option>`);
            $("#colonia").empty();
            $("#colonia").append(`<option id="" value="">Seleccionar Colonia</option>`);
            $.each(response.colonias, function(key, value) {
              $("#colonia").append(`<option id="${value.colonia_id}" value="${value.colonia_id}">${value.colonia}</option>`);
            });
            $('#colonia, #municipio, #estado').select2({
              theme: 'bootstrap4',
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

  });
</script>
@endsection
