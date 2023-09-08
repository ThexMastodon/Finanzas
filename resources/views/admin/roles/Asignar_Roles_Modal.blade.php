<div class="modal fade bd-example-modal-lg" id="modal-Asignar" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h4 class="modal-title">Asignar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="agregar" method="POST" action="{{ route('Asignar-Roles') }}">
          @csrf
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="inputAfianzadora">Usuario</label>
                <select id="usuario_id" name="usuario_id" class="form-control select2">
                  <option value="">Seleccionar usuario</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}"> {{ $user->username }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="inputAfianzadora">Rol</label>
                <select id="rol_id" name="rol_id" class="form-control select2">
                  <option value="">Seleccionar rol</option>
                  @foreach ($Roles as $Rol)
                    <option value="{{ $Rol->name }}"> {{ $Rol->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

          </div>

        </form>
      </div>
      <div class="modal-footer group-btns">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button id="btn-asignar-rol" class="btn btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
<script>
  // Agregar el evento click al botón "Agregar"
  document.getElementById("btn-asignar-rol").addEventListener("click", function(event) {
    // Enviar el formulario mediante JavaScript

    form = $("#agregar");
    var form_data = new FormData($('#agregar')[0]);
    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form_data,
      processData: false,
      contentType: false,
      beforeSend: function() {
        Swal.fire({
          title: 'Guardando Datos',
          text: 'Por favor espere a que la página lo redireccione.',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading()
          },
          timer: 1500
        });
      },
      success: function(response) {
        Swal.close();
        Swal.fire({
          icon: response.status,
          title: response.title,
          text: response.message,
          confirmButtonText: "Aceptar",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = ''; // Recargar la página
          }
        });
      },
    });
  });
</script>
