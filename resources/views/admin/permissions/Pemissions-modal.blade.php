<div class="modal fade bd-example-modal-lg" id="modal_Permissions" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <form id="form_Permissions" method="POST" action="{{ route('crear-Permisso') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 id="TituloModal">Agregar Permisos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="limpiarCampos()">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="col-12">
            <input type="hidden" id="id" name="id">
            <div class="row">
              <div class="form-group col-md-6">
                <label for="inputModulo">Modulo</label>
                <select id="Modulo" name="Modulo" style="width: 100%" class="form-select select2">
                  <option value="">Seleccionar Modulo</option>
                  @foreach ($Modulos as $Modulo)
                  <option value="{{ $Modulo->id }}" data-id="{{ $Modulo->id }}"> {{ $Modulo->nombre }}</option>
                  @endforeach
                </select>
                <span id="Modulo_error" class="invalid-feedback" role="alert"></span>
              </div>
              <div class="form-group col-md-6">
                <label for="inputSubmodulo">Submodulo</label>
                <select id="Submodulo" name="Submodulo" style="width: 100%" class="form-select select2">
                  <option value="">Seleccionar Submodulo</option>
                  @foreach ($Submodulos as $Submodulo)
                  <option value="{{ $Submodulo->id }}" data-id="{{ $Submodulo->id }}"> {{ $Submodulo->nombre }}</option>
                  @endforeach
                </select>
                <span id="Submodulo_error" class="invalid-feedback" role="alert"></span>
              </div>

            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label for="inputModulo">Tipo de Permiso</label>
                <select id="Tipo" name="Tipo" style="width: 100%" class="form-select select2">
                  <option value="">Seleccionar Tipo</option>
                  @foreach ($Tipos as $Tipo)
                  <option value="{{ $Tipo->id }}" data-id="{{ $Tipo->id }}"> {{ $Tipo->nombre }}</option>
                  @endforeach
                </select>
                <span id="Modulo_error" class="invalid-feedback" role="alert"></span>
              </div>

            </div>
            <div class="form-group col-12">
              <label for="permiso">Permiso</label>
              <input id="permiso" type="text" class="form-control" name="permiso">
              <span id="referencia_error" class="invalid-feedback" role="alert"></span>
            </div>
          </div>
          </div>

          <div class="modal-footer group-btns">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiarCampos()">Cancelar</button>
            <button id="btn-AceptarForm" type="button" class="btn btn-primary">Aceptar</button>
          </div>
    </form>
  </div>
</div>
</div>
</div>


@push('adminlte_js')
@endpush
