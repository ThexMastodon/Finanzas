<div class="modal fade bd-example-modal-lg" id="modal_municipio" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalMunicipio" method="POST" action="{{ route('addaMunicipio') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Editar municipio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label>Nombre del municipio</label>
              <input class="form-control" name="nombre" id="nombre" value="" required>
              <span id="nombre_error" class="invalid-feedback" role="alert"></span>
            </div>
            <div class="col-md-6">
              <label for="inputEstado">Estado</label>
              <select id="estado_id" name="estado_id" class="form-control select2">
                @foreach ($estados as $estado)
                <option value="{{ $estado->id }}"> {{ $estado->descripcion }}</option>
                @endforeach
              </select>
              <span id="estado_id_error" class="invalid-feedback" role="alert"></span>
            </div>
          </div>
          <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
          <input type="hidden" name="" id="municipioV" value="">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="AceptarForm" class="btn btn-primary">Aceptar</button>
        </div>
      </div>
    </form>
  </div>
</div>
