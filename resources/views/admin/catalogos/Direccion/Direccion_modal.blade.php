<div class="modal fade bd-example-modal-lg" id="modal_direccion" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalDirecciones" method="POST" action="{{ route('editaDireccion') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Editar dirección</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarCampos()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group col-6">
            <label>Codigo postal</label>
            <div id="custom-form-group">
              <input id="codigo_postal" class="form-control" type="number" name="codigo_postal">
              <button id="buscaCP" class="btn" type="button">Buscar</button>
              <input type="hidden" id="id" name="id">
            </div>
            <span id="codigo_postal_error" class="invalid-feedback" role="alert"></span>
          </div>
          <div class="col-12">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="inputMunicipio">Municipio</label>
                <select id="municipio" name="municipio" style="width: 100%" class="form-select select2">
                  <option value="">Seleccionar municipio</option>
                  @foreach ($municipios as $municipio)
                  <option value="{{ $municipio->id }}" data-id="{{ $municipio->id }}"> {{ $municipio->nombre }}</option>
                  @endforeach
                </select>
                <span id="municipio_error" class="invalid-feedback" role="alert"></span>
              </div>
              <div class="form-group col-md-6">
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
            </div>
          </div>
          <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
          <input type="hidden" name="" id="direccionV" value="">
          <input type="hidden" id="coloniaV">
        </div>
        <div class="modal-footer group-btns">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarCampos()">Cancelar</button>
          <button id="AceptarForm" type="button" class="btn btn-primary">Aceptar</button>
        </div>
    </form>
  </div>
</div>
</div>
</div>


@push('adminlte_js')
@endpush
