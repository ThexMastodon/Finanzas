<div class="modal fade bd-example-modal-lg" id="modal-addMUN" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="agregar" method="POST" action="{{ route('addaMunicipio') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4>Agregar municipio</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <label>Nombre del municipio</label>
              <input class="form-control" name="nombre" id="nombre" required>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-4">
              <label for="inputEstado">Estado</label>
              <select id="estado_id" name="estado_id" class="form-control select2">
                @foreach ($estados as $estado)
                <option value="{{ $estado->id }}"> {{ $estado->nombre }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="btn-agregar_MUN" class="btn btn-primary">Aceptar</button>
        </div>
      </div>
    </form>
  </div>
</div>



