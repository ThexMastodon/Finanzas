<div class="modal fade bd-example-modal-lg" id="modal_colonia" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalColonia" method="POST" action="{{ route('editaColonia') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Editar colonia</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-4">
              <label for="Estado">Estado</label>
              <select id="estado" name="estado" style="width: 100%" class="form-select select2">
              <option value="">Seleccionar estado</option>
              @foreach ($estados as $estado)
              <option value="{{ $estado->id }}" data-id="{{ $estado->id }}"> {{ $estado->nombre }}</option>
              @endforeach
              </select>
              <span id="estado_error" class="invalid-feedback" role="alert"></span>
            </div>
            <div class="col-4">
              <label for="Municipio">Municipio</label>
              <select id="municipio" name="municipio" style="width: 100%" class="form-select select2">
                <option value="">Seleccionar municipio</option>
                @foreach ($municipios as $municipio)
                <option value="{{ $municipio->id }}" data-id="{{ $municipio->id }}"> {{ $municipio->nombre }}</option>
                @endforeach
              </select>
              <span id="municipio_error" class="invalid-feedback" role="alert"></span>
            </div>
            <div class="col-4">
              <label for="codigo_postal">Codigo postal</label>
              <input id="codigo_postal" type="text" class="form-control" name="codigo_postal" value="">
              <span id="codigo_postal_error" class="invalid-feedback" role="alert"></span>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-12">
              <label for="inputFechac">Nombre de la Colonia</label>
              <input id="colonia" type="input" class="form-control" name="colonia" required>
              <span id="colonia_error" class="invalid-feedback" role="alert"></span>
            </div>
          </div>
        </div>
        <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
        <input type="hidden" name="" id="coloniaV" value="">
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancelar</button>
          <button id="AceptarForm" type="button" class="btn btn-primary ">Aceptar</button>
        </div>
      </div>
    </form>
  </div>
</div>
