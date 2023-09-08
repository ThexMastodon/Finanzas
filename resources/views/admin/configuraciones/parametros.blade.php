@extends('adminlte::page')

@section('title', 'Parametros')

@section('content_header')
  <h2>{{ __('Configuración de parametros') }}</h2>
@stop

@section('content')
  <div class="row">
    <div class="col-12 text-right">
      <button type="button" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i>
        Categoria
      </button>
      <button type="button" class="btn btn-primary">
        <i class="fas fa-plus-circle"></i>
        Parámetro
      </button>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card card-primary card-outline">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <div class="card card_parameter ui-sortable-handle" style="padding: 10px; position: relative;">
                <input type="hidden" name="form_3-parametro" value="INFO_SMTP_USUARIO" class="form-control" autocomplete="off" id="id_form_3-parametro">
                <input type="hidden" name="form_3-help_text" class="form-control" autocomplete="off" id="id_form_3-help_text">
                <div class="row">
                  <div class="col-2">
                    <span class="badge">INFO_SMTP_USUARIO</span><br>
                    <span class="help_text"></span>
                  </div>
                  <div class="col-2">
                    <select name="form_3-tipo" class="form-control" required="" id="id_form_3-tipo">
                      <option value="">---------</option>

                      <option value="8af8-c5502fc632e6" selected="">NOTIFICACION</option>

                      <option value="a0ff-c9f144e2f559">APP_MOVIL_CAMB</option>

                      <option value="b3e7-187d8d326c47">Limite_Credito_Monedero</option>

                      <option value="8640-d52d81221eae">CONF_IMPUESTOS</option>

                      <option value="b631-069c06640a43">Conf_admon</option>

                      <option value="9fea-d6b0d85f1438">Comisiones</option>

                      <option value="9677-a5894b875d57">Empresarial</option>

                      <option value="9753-6baccbf29972">DIST</option>

                      <option value="b629-8acfe8c39b4f">GENERAL</option>

                      <option value="9cb0-574a797a20c7">MAPAS</option>

                      <option value="bc37-9ff638f44eaa">logistica</option>

                      <option value="b802-cb0538f4a48f">Soporte</option>

                      <option value="a132-3e5171f07321">PREACTIVACION</option>

                      <option value="a3f3-be207d7696c9">inventarios</option>

                      <option value="9edc-f118a6905561">LFT</option>

                      <option value="97f3-4b344fe45ebd">scripts_selenium</option>

                      <option value="be18-45d03f406cdb">Altan</option>

                      <option value="8d98-bcdc686d2d55">FUN</option>

                      <option value="bdda-47544abbe1d9">recarga_paquetes</option>

                      <option value="856a-c98517783922">facturacion</option>

                    </select>
                  </div>
                  <div class="col-6">
                    <div class="row">
                      <input type="text" name="form_3-valor" value="info@newww.mx" class="form-control" id="id_form_3-valor">
                      <textarea name="form_3-archivo" cols="40" rows="10" hidden="hidden" id="id_form_3-archivo"></textarea>
                      <textarea name="form_3-orden" cols="40" rows="10" hidden="hidden" required="" id="id_form_3-orden" value="0">0</textarea>
                    </div>
                  </div>
                  <div class="col-2 div_actions">
                <span style="color:green;font-size: medium " class="edit_parameter" data-pk="99c6-e6b1c0207b52">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </span>&nbsp;&nbsp;&nbsp;
                    <span style="color:red;font-size: medium " class="delete_parameter" data-pk="99c6-e6b1c0207b52">
                  <i class="fa fa-trash" aria-hidden="true"></i>
                </span>
                  </div>
                </div>
              </div>
              <div class="card card-secondary card-outline">
                <div class="row m-4">
                  <p>jjejeje</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer"></div>
      </div>
    </div>
  </div>
@stop

@section('css')
@stop

@section('js')
  <script>
    $(document).ready(function () {
      console.log('entro');
    });
  </script>
@stop
