<div class="modal fade bd-example-modal-lg" id="modal-FC" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalFianzaCheques" method="POST" action="">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Agregar Fianza/Cheque</h4>
          <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarCampos()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-address-tab" data-toggle="pill" href="#custom-content-address" role="tab" aria-controls="custom-content-address" aria-selected="true">Domicilio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-general-tab" data-toggle="pill" href="#custom-content-general" role="tab" aria-controls="custom-content-general" aria-selected="false">General</a>
            </li>
          </ul>

          <div class="tab-content" id="custom-content-below-tabContent">
            <div class="tab-pane fade active show" id="custom-content-address" role="tabpanel" aria-labelledby="custom-address-tab">
              <br>
              <div class="form-row">
                <div id="dirHistorico" class="form-group col-12 direccion_historico" hidden>
                  <label>Dirección</label>
                  <div id="custom-form-group">
                    <textarea class="form-control dir-ref" rows="3" id="direccion_historico" name="direccion_historico"></textarea>
                  </div>
                </div>
                <div class="form-group col-6 NewDireccion">
                  <label>Codigo postal</label>
                  <div id="custom-form-group">
                    <input id="codigo_postal" class="form-control" type="number" name="codigo_postal">
                    <button id="buscaCP" class="btn" type="button">Buscar</button>
                  </div>
                  <span id="codigo_postal_error" class="invalid-feedback" role="alert"></span>
                </div>
                <div class="form-group col-12 NewDireccion">
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="Estado">Estado</label>
                      <select id="estado" name="estado" style="width: 100%" class="form-select select2">
                        <option value="">Seleccionar estado</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}" data-id="{{ $estado->id }}"> {{ $estado->descripcion }}</option>
                        @endforeach
                      </select>
                      <span id="estado_error" class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputMunicipio">Municipio</label>
                      <select id="municipio" name="municipio" style="width: 100%" class="form-select select2">
                        <option value="">Seleccionar municipio</option>
                        @foreach ($municipios as $municipio)
                        <option value="{{ $municipio->id }}" data-id="{{ $municipio->id }}"> {{ $municipio->descripcion }}</option>
                        @endforeach
                      </select>
                      <span id="municipio_error" class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group col-md-4">
                      <input type="hidden" id="municipioEditV">
                      <label for="inputColonia">Colonia</label>
                      <select id="colonia" name="colonia" style="width: 100%" class="form-select select2">
                        <option value="">Seleccionar colonia</option>
                      </select>
                      <span id="colonia_error" class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCalle">Calle</label>
                      <input id="calle" type="text" class="form-control" name="calle">
                      <span id="calle_error" class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputNoExterior">No. Exterior</label>
                      <input id="no_exterior" type="number" class="form-control" name="no_exterior">
                      <span id="no_exterior_error" class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputNoInterior">No. Interior</label>
                      <input id="no_interior" type="number" class="form-control" name="no_interior">
                      <span id="no_interior_error" class="invalid-feedback" role="alert"></span>
                    </div>
                    <div class="form-group col-12">
                      <label for="exampleFormControlTextarea1">Referencias</label>
                      <textarea class="form-control dir-ref" rows="3" name="referencia"></textarea>
                      <span id="referencia_error" class="invalid-feedback" role="alert"></span>
                    </div>
                    <input type="hidden" name="" id="afianzadoraV" value="">
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="custom-content-general" role="tabpanel" aria-labelledby="custom-general-tab">
              <br>
              <div class="form-group">

                <div class="form-row">
                  <div class="form-group col-8">
                    <label>No. Fianza/Cheque</label>
                    <input id="fianza_cheque" class="form-control" type="text" name="fianza_cheque" placeholder="Numero fianza cheque" required>
                    <span id="fianza_cheque_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="col-4">
                    <label>Tipo de persona</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="tipo_persona" value="1">
                      <label class="form-check-label">Física</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="tipo_persona" value="0">
                      <label class="form-check-label">Moral</label>
                    </div>
                    <span id="tipo_persona_error" class="invalid-feedback" role="alert"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row newNombre">
                  <div class="col-4 rsocial">
                    <label for="nombre">Nombre / razon social</label>
                    <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre o razon social" required>
                    <span id="nombre_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="col-4 fisica">
                    <label for="APaterno">Apellido Paterno</label>
                    <input id="APaterno" class="form-control" type="text" name="APaterno" placeholder="Apellido Paterno">
                    <span id="APaterno_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="col-4 fisica">
                    <label for="AMaterno">Apellido Materno</label>
                    <input id="AMaterno" class="form-control" type="text" name="AMaterno" placeholder="Apellido Materno">
                    <span id="AMaterno_error" class="invalid-feedback" role="alert"></span>
                  </div>
                </div>
                <div id="nameHistorico" class="form-row" hidden>
                  <div class="nameHistorico col-12">
                    <label for="nombre">Nombre / razon social</label>
                    <input id="nombreHistorico" class="form-control" type="text" name="nombreHistorico" placeholder="Nombre o razon social">
                    <span id="nombreHistorico_error" class="invalid-feedback" role="alert"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-4">
                    <label>Tipo</label>
                    <select id="tipo" class="form-control select2" name="tipo" required>
                      <option value="">Selecciona un tipo</option>
                      @foreach ($tipos as $tipo)
                      <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                      @endforeach
                    </select>
                    <span id="tipo_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="col-4">
                    <label>Afianzadora</label>
                    <select id="afianzadora" class="form-control select2" name="afianzadora" required>
                      <option value="">Selecciona una afianzadora</option>
                      @foreach ($afianzadoras as $afianzadora)
                      <option value="{{ $afianzadora->id }}">{{ $afianzadora->nombre }}</option>
                      @endforeach
                    </select>
                    <span id="afianzadora_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="col-4 estatusFianza">
                    <label>Estatus</label>
                    <select id="estatus" class="form-control select2" name="estatus" required>
                      <option value="">Selecciona un estatus</option>
                      @foreach ($estatus as $estatu)
                      <option value="{{ $estatu->id }}">{{ $estatu->descripcion }}</option>
                      @endforeach
                    </select>
                    <span id="estatus_error" class="invalid-feedback" role="alert"></span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="form-row">
                  <div class="form-group col-6">
                    <label>Fecha de expedición</label>
                    <input id="fecha_expedicion" class="form-control" type="date" name="fecha_expedicion">
                    <span id="fecha_expedicion_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="form-group col-6">
                    <label>Fecha de vencimiento</label>
                    <input id="fecha_vencimiento" class="form-control" type="date" name="fecha_vencimiento">
                    <span id="fecha_vencimiento_error" class="invalid-feedback" role="alert"></span>
                  </div>
                </div>
              </div>
              <div class="form-group col-12">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="aFavor">A favor</label>
                    <input type="text" class="form-control" name="aFavor" id="aFavor">
                    <span id="aFavor_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="licitacion">Licitación</label>
                    <input type="text" class="form-control" name="licitacion" id="licitacion">
                    <span id="licitacion_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="importe">Importe</label>
                    <input type="text" class="form-control" name="importe" id="importe">
                    <span id="importe_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <div class="form-group col-12">
                    <label for="exampleFormControlTextarea1">Concepto</label>
                    <textarea id="concepto" class="form-control dir-ref" rows="3" name="concepto"></textarea>
                    <span id="concepto_error" class="invalid-feedback" role="alert"></span>
                  </div>
                  <input type="hidden" name="" id="FianzaChequeV" value="">
                </div>
              </div>
            </div>
          </div>
        </div>
        <input type="hidden" id="coloniaV">
        @can('Editar Fianzas y cheques')
        <div class="modal-footer row m-0">
          <div class="col-md-6 text-left m-0">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarCampos()">Cancelar</button>
          </div>
          <div class="col-md-6 text-right m-0">
            <button id="AceptarForm" type="button" class="btn btn-primary">Aceptar</button>
          </div>
        </div>
        @endcan
      </div>
    </form>

  </div>
</div>


@section('modal_js')
<script type="text/javascript">
  function returnTab() {
    $('#custom-address-tab').addClass('active');
    $('#custom-general-tab').removeClass('active');
    $('#custom-content-address').addClass('active show');
    $('#custom-content-general').removeClass('active show');
  }

  $(document).ready(function() {

    $('body').on('click', '#custom-general-tab', function(e) {
      $.ajax({
        url: "{{ route('validarPestana1') }}",
        type: "POST",
        data: $(this).closest('#modalFianzaCheques').serialize(),
        dataType: 'json',
        beforeSend: function() {
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
            text: 'Complete los campos obligatorios.',
            confirmButtonText: "{{ __('Aceptar') }}",
            allowOutsideClick: false,
          }).then((result) => {
            if (result.isConfirmed) {
              returnTab();
            }
          })
        }
      });

    });

  });
</script>
@endsection
