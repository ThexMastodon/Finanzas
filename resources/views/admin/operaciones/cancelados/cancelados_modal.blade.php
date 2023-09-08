<div class="modal fade bd-example-modal-lg" id="modal-cancelados" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalCancelados" method="POST" action="{{ route('Actualizar-cancelado') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h3 id="TituloModal">Editar</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group col-8">
              <label>Oficio</label>
              <input id="oficio" class="form-control" type="text" name="oficio" placeholder="Oficio">
              <span id="oficio_error" class="invalid-feedback" role="alert"></span>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-12">
              <h4>Datos de Cancelación</h4>
              <div class="form-row">
                <div class="col-md-4">
                  <label for="inputFechao">Fecha del Oficio</label>
                  <input id="fecha_oficio" type="date" class="form-control" name="fecha_oficio" required>
                  <span id="fecha_oficio_error" class="invalid-feedback" role="alert"></span>
                </div>
                <div class="col-md-4">
                  <label for="inputNfianza">Numero de fianza/cheque</label>
                  <select id="fianza_cheque" name="fianza_cheque" class="form-control select2">
                  </select>
                  <span id="fianza_cheque_error" class="invalid-feedback" role="alert"></span>
                </div>
                <div class="col-md-4">
                  <label for="inputFechac">Fecha de la Cancelación</label>
                  <input id="fecha_cancelacion" type="date" class="form-control" name="fecha_cancelacion" required>
                  <span id="fecha_cancelacion_error" class="invalid-feedback" role="alert"></span>
                </div>
                <div class="col-md-4">
                  <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
                  <input type="hidden" name="" id="canceladoV" value="">
                  <input type="hidden" value="{{ $users }}" id="users_id" name="users_id">
                </div>
              </div>
            </div>
          </div>
    </form>
  </div>
  <div class="modal-footer group-btns">
    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarCampos()">Cancelar</button>
    <button id="AceptarForm" type="button" class="btn btn-primary">Aceptar</button>
  </div>
</div>
</div>
</div>
