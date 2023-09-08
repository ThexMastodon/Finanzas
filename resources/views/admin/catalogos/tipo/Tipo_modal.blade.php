<div class="modal fade bd-example-modal-lg" id="modal_tipo" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalTipo" method="POST" action="">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Editar tipo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarCampos()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="col-md-12">
                <label>Descripción</label>
                <input id="descripcion" type="input" class="form-control" name="descripcion" required>
                <span id="descripcion_error" class="invalid-feedback" role="alert"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
          <input type="hidden" name="" id="tipoV" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarCampos()">Cancelar</button>
          <button id="AceptarForm" type="submit" class="btn btn-primary">Aceptar</button>
        </div>
      </div>
    </form>
  </div>
</div>
