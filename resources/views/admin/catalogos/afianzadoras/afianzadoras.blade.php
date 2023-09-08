@extends('adminlte::page')

@section('title', 'Afianzadoras')

@section('content')
@include('admin.catalogos.afianzadoras.modal_afianzadoras')

<body class="hold-transition sidebar-mini">
  <div>
    <div>
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Afianzadoras</h1>
            </div>
          </div>
        </div>
      </section>
      <section class="content">
        <div class="container-fluid">
          <div class="content-btn">
            <a id="btn-excel" class="btn btn-primary" href="{{ route('exportaExcelAfianzadoras') }}">
              <i class="fas fa-file-excel" style="color: #0aa340;"></i>
              Descargar excel
            </a>
            <a @can('crear afianzadoras') class="btn btn-primary" @else class="btn btn-primary disabled" @endcan id="btn-nuevo" href="" data-togle="modal" data-target="#modal-add" data-product=1>
              <i class="far fa-file-alt"></i>
              Nuevo
            </a>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="Table_Afianzadora" class="table table-bordered table-hover nowrap" style="width:100%">
                    <thead class="tableHeader">
                      <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Domicilio</th>
                        <th>Activo</th>
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
  $('.select2').select2({
    theme: 'bootstrap4',
  });

  function limpiarCampos() {
    $('#TituloModal').html('');
    $('#afianzadoraV').val('');
    $('#nombre').val('');
    $('#codigo_postal').val('');
    $('#estado').val('').trigger('change');
    $('#municipio').val('').trigger('change');
    $('#colonia').val('').trigger('change');
    $('#calle').val('');
    $('#no_exterior').val('');
    $('#no_interior').val('');
    $('#modal_afianzadoras textarea[name="referencia"]').val('');

    $('#nombre, #codigo_postal, #municipio, #colonia, #calle, #no_exterior, #estado').removeClass('is-invalid');
    $('#nombre_error,#codigo_postal_error, #municipio_error, #colonia_error, #calle_error, #no_exterior_error, #estado_error').removeClass('d-block');

  }

  $(document).ready(function() {

    $('#AceptarForm').on('click', function(e) {
      form = $(this).closest('#modalAfianzadoras');
      var tipoPeticion = $('#tipoPeticion').val();
      var ruta = '';
      data = form.serialize();
      if (tipoPeticion === 'Agregar') {
        ruta = "{{ route('addafianzadora') }}";
      } else if (tipoPeticion === 'Editar') {
        ruta = "{{ route('updateAfianzadora') }}";
        // var idAfianzadora = $('#btn-Editar').data('id');
        var idAfianzadora = $('#afianzadoraV').val();
        data += '&idAfianzadora=' + idAfianzadora;
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
            $("#modal_afianzadoras").find("#" + key).addClass('is-invalid');
            $("#modal_afianzadoras").find("#" + key + '_error').addClass('d-block');
            $("#modal_afianzadoras").find("#" + key + '_error').html('<strong>' + value + '</strong>');
          });
          Swal.fire({
            icon: 'error',
            title: "{{ __('Error!') }}",
            text: 'La afianzadora no se agregó correctamente',
            confirmButtonText: "{{ __('Aceptar') }}",
          });
        }
      });
    });


    $('.content-wrapper').on('click', '#btn-nuevo', function(e) {
      e.preventDefault();
      limpiarCampos();
      $('#TituloModal').html('Agregar afianzadora');
      $('#tipoPeticion').val('Agregar');
      $('#modal_afianzadoras').modal('show');
    });

    $('.content-wrapper').on('click', '#btn-Editar', function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      $('#TituloModal').html('Editar Afianzadora');
      $('#tipoPeticion').val('Editar');
      $.ajax({
        url: "{{ route('detalleAfianzadora') }}",
        type: "GET",
        data: {
          id: id
        },
        dataType: 'json',
        success: function(response) {
          $('#nombre').val(response.nombre);
          if (response.direccion) {
            $('#calle').val(response.direccion.calle);
            $('#coloniaV').val(response.direccion.colonia_id);
            if (response.direccion.municipio) {
              $('#estado').val(response.direccion.municipio.estado_id).trigger("change");
              $('#municipio').val(response.direccion.municipio.id).trigger("change");
              $('#municipioEditV').val(response.direccion.municipio.id);
            }
            response.activo === 1 ? $('#estadoActivo').prop('checked', true) : $('#estadoInactivo').prop('checked', true);
            $('#codigo_postal').val(response.direccion.codigo_postal);
            $('#no_exterior').val(response.direccion.no_exterior);
            $('#no_interior').val(response.direccion.no_interior);
            $('#modal_afianzadoras textarea[name="referencia"]').val(response.direccion.referencia);
          }
          $('#colonia').select2({
            theme: 'bootstrap4',
          });
          $('#afianzadoraV').val(response.id);
          $('#modal_afianzadoras').modal('show');
        }
      });
    });

    //DESHABILITAR AFIANZADORA
    $('.content-wrapper').on('click', '#btn-deshabilitarAfianzadora', function(e) {
      e.preventDefault();
      var id = $(this).data('id');
      Swal.fire({
        icon: 'warning',
        title: 'Modificar estatus afianzadora',
        text: '¿Estás seguro de modificar el estatus de esta afianzadora?',
        confirmButtonText: "{{ __('Aceptar') }}",
        showCancelButton: true,
        denyButtonText: "{{ __('Cancelar') }}",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('afdelete') }}",
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
  });

  //BUSCAR CODIGO POSTAL PRESIONANDO ENTER
  $('#codigo_postal').keyup('codigo_postal', function(e) {
    event.preventDefault();
    if (event.which === 13) {
      $("#buscaCP").click();
    }
  });

  //GENERAR TABLA DE TODAS LAS AFIANZADORAS
  $('#Table_Afianzadora').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: "{{ route('llenadoTableAfianzadora') }}",
    columns: [
      {
        data: 'id',
        name: 'id',
      },
      {
        data: 'nombre',
        name: 'nombre'
      },
      {
        data: 'direccion',
        name: 'direccion',
      },
      {
        data: 'activo',
        name: 'activo',
      },
      {
        data: 'acciones',
        name: 'acciones',
      },
    ],
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
</script>
@endsection
@section('adminlte_js')
<script type="text/javascript">

</script>
@stop
