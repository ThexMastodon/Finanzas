<div class="modal fade bd-example-modal-lg" id="modal_afianzadoras" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalAfianzadoras" method="POST" action="{{ route('addafianzadora') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Agregar afianzadora</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarCampos()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group col-12">
            <label>Nombre</label>
            <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
            <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre de la afianzadora">
            <span id="nombre_error" class="invalid-feedback" role="alert"></span>
          </div>
          <h4 id="title-form-dir">Datos de dirección</h4>
          <div class="form-group col-6">
            <label>Codigo postal</label>
            <div id="custom-form-group">
              <input id="codigo_postal" class="form-control" type="number" name="codigo_postal">
              <button id="buscaCP" class="btn" type="button">Buscar</button>
            </div>
            <span id="codigo_postal_error" class="invalid-feedback" role="alert"></span>
          </div>
          <div class="form-group col-12">
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
                <input type="hidden" id="coloniaV">
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
        @can('Editar afianzadoras')
        <div class="modal-footer justify-content-between">
          <div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarCampos()">Cancelar</button>
          </div>
          <div>
            <button id="AceptarForm" type="button" class="btn btn-primary ml-auto">Aceptar</button>
          </div>
        </div>
        @endcan
      </div>
    </form>
  </div>
</div>


@push('adminlte_js')
<script>
  $(document).ready(function() {
    $('#btn-agregar_af').click(function() {
      Swal.fire(
        'Registro exitoso!',
        'La afianzadora ' + document.getElementById('afianzadora').value +
        ' se agregó correctamente',
        'success',
      ).then((result) => {
        if (result.isConfirmed) {
          $('#agregar').submit();
          window.location.href = "";
        }
      })
    })
  });
</script>
@endpush
