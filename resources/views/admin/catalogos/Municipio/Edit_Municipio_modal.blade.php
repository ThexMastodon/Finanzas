<div class="modal fade bd-example-modal-lg" id="modal-editMUN" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="agregarMUN" method="POST" action="{{ route('editaMunicipio') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4>Editar municipio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
              <div class="form-group col-md-12">
                <label for="inputFechac">Nombre del municipio</label>
                <input type="hidden" id="id" name="id">
                <input type="input" class="form-control" name="nombre" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary " data-dismiss="modal">Cancelar</button>
          <button id="btn-editar_MUN" type="button" class="btn btn-primary ">Aceptar</button>
        </div>
      </div>
    </form>
  </div>
</div>
