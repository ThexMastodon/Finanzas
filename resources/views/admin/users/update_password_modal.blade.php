{{-- Modal Cambio de Contraseña --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="exampleModalLabel">Cambio de Contraseña</h5>
        <button type="button" class="close " data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>
      <form id="formCambioContrasena" method="POST" action="{{ route('usuariosContrasena', ['id' => $data->id])}}" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nueva contraseña') }}</label>
            <div class="col-md-6">
              <input id="password" type="password"  class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar nueva contraseña') }}</label>
            <div class="col-md-6">
              <input id="cpassword" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button id="btn-pass" type="submit" class="btn btn-primary fa-light fa-floppy-disk"> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
