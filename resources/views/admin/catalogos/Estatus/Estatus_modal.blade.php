<div class="modal fade bd-example-modal-lg" id="modal_estatus" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalEstatus" method="POST" action="{{ route('editarEstatus') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Editar estatus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="descripcion">Descripción</label>
              <input type="input" class="form-control" name="descripcion" id="descripcion">
              <span id="descripcion_error" class="invalid-feedback" role="alert"></span>
            </div>
          </div>
          <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
          <input type="hidden" name="" id="estatusV" value="">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary " data-dismiss="modal" onclick="limpiarCampos()">Cancelar</button>
          <button id="AceptarForm" type="submit" class="btn btn-primary ">Aceptar</button>
        </div>
      </div>
    </form>
  </div>
</div>
