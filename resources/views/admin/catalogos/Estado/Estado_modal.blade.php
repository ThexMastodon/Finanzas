<div class="modal fade bd-example-modal-lg" id="modal_estado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="modalEstado" method="POST" action="{{ route('editaestado') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Editar estado</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group col-md-12">
                <label for="inputFechac">Nombre del estado</label>
                <input type="hidden" id="id" name="id">
                <input type="input" class="form-control" id="nombre" name="nombre" required>
                <span id="nombre_error" class="invalid-feedback" role="alert"></span>
              </div>
            </div>
          </div>
          <input type="hidden" id="tipoPeticion" name="tipoPeticion" value="">
          <input type="hidden" id="estadoV" value="">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancelar</button>
          <button id="AceptarForm" type="submit" class="btn btn-primary ">Aceptar</button>
        </div>
      </div>
    </form>
  </div>
</div>
