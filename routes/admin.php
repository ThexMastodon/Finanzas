<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

// Route::get('/afianzadoras', [App\Http\Controllers\AfianzadoraController::class, 'index'])->name('afianzadoras');

Route::get('', [HomeController::class, 'index']);
Route::get('/operaciones/fianzasycheques', [App\Http\Controllers\fianza_chequeController::class, 'index'])->name('fianzasycheques')->middleware('permission:Ver Fianzas y cheques');
Route::get('/password/admin', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');


Route::controller(App\Http\Controllers\UsersController::class)->group(function () {
  Route::get('/users', [App\Http\Controllers\UsersController::class, 'show'])->name('lista')->middleware('permission:Ver Usuarios');
  Route::get('/users/detail/{id?}', 'edit')->name('detalle')->middleware('permission:Editar Usuarios');
  Route::post('/users/detail/update/{id?}', 'update')->name('usuarios-editar');
  Route::post('/usuarios/usuarios-contrasena/{id?}', 'UpdatePassword')->name('usuariosContrasena');
  Route::get('/users/FormAdd', 'FormNewUser')->name('FormNewUser')->middleware('permission:crear Usuarios');
  Route::post('/users/AddUser', 'AddUser')->name('usuarios-registrar');
});

Route::controller(App\Http\Controllers\AfianzadoraController::class)->group(function () {
  Route::get('/afianzadoras', 'index')->name('afianzadoras')->middleware('permission:Ver afianzadoras');
  Route::post('/Afianzadoras_update', 'update')->name('updateAfianzadora');
  Route::get('/afianzadoras/detalle_afianzadora/{id?}', [App\Http\Controllers\AfianzadoraController::class, 'detalleAfianzadora'])->name('detalleAfianzadora');
  Route::get('admin/Afianzadoras_delete/{id?}', 'destroy')->name('afdelete');
  Route::post('/afianzadoras', 'store')->name('addafianzadora');
  Route::get('/afianzadoras/getCodigoPostal', [App\Http\Controllers\AfianzadoraController::class, 'getCodigoPostal'])->name('getCodigo_postal');
  Route::get('/afianzadoras/getColonias', [App\Http\Controllers\AfianzadoraController::class, 'getColonias'])->name('getColonias');
  Route::get('/afianzadoras/getMunicipios', [App\Http\Controllers\AfianzadoraController::class, 'getMunicipios'])->name('getMunicipios');
  Route::get('/afianzadoras/descargar-excel', [App\Http\Controllers\AfianzadoraController::class, 'exportaExcel'])->name('exportaExcelAfianzadoras');

  Route::get('/afianzadoras/llenadoTable', [App\Http\Controllers\AfianzadoraController::class, 'llenadoTableAfianzadora'])->name('llenadoTableAfianzadora');

});

Route::controller(App\Http\Controllers\CanceladoController::class)->group(function () {
  Route::get('/operaciones/cancelados', 'index')->name('cancelados')->middleware('permission:Ver Cancelados');
  Route::get('/operaciones/cancelados/cancelados_delete/{id?}', 'destroy')->name('Eliminar-cancelado');
  Route::post('/operaciones/cancelados/canceladosAdd', 'store')->name('Agregar-cancelado');
  Route::post('/operaciones/cancelados/cancelados_update/', 'update')->name('Actualizar-cancelado');
  Route::get('/operaciones/cancelados/detalle_cancelado/{id?}', [App\Http\Controllers\CanceladoController::class, 'detalleCancelado'])->name('detalleCancelado');
  Route::post('/operaciones/cancelados/cambio_fianza/', 'cambio_fianza')->name('cambio_fianza');
  Route::get('/operaciones/cancelados/fecha/', 'fecha_actual')->name('fecha_actual');
  Route::get('/operaciones/cancelados/descargar-excel', [App\Http\Controllers\CanceladoController::class, 'exportaExcel'])->name('exportaExcelCancelados');
  Route::get('/operaciones/cancelados/llenadoTable', [App\Http\Controllers\CanceladoController::class, 'llenadoTableCancelados'])->name('llenadoTableCancelados');
  Route::get('/operaciones/cancelados/busqueda_fianza', [App\Http\Controllers\CanceladoController::class, 'busqueda_fianza'])->name('busqueda_fianza');
});

Route::controller(App\Http\Controllers\Fianza_chequeController::class)->group(function () {
  Route::get('/operaciones/fianza_cheques', [App\Http\Controllers\Fianza_chequeController::class, 'index'])->name('fianzas_cheques')->middleware('permission:Ver Fianzas y cheques');
  Route::post('/operaciones/fianza_cheques/nuevaFianza_cheque', [App\Http\Controllers\Fianza_chequeController::class, 'create'])->name('nuevafianzas_cheques');
  Route::get('/operaciones/fianza_cheques/detalle_FC/{id?}', [App\Http\Controllers\Fianza_chequeController::class, 'detalleFianzaCheque'])->name('detalleFianzaCheque');
  Route::post('/operaciones/actualizarFianzaCheque', 'update')->name('actualizarFianzaCheque');
  Route::get('operaciones/fianza_cheques/modificar_estatus/{id?}', 'destroy')->name('cambiarEstatusFC');
  Route::post('operaciones/fianza_cheques/calcular-fecha-vencimiento', 'calcularFechaVencimiento')->name('calcular-fecha-vencimiento');
  Route::get('/operaciones/descargar-excel', [App\Http\Controllers\Fianza_chequeController::class, 'exportaExcel'])->name('exportaExcelFiaCheq');
  Route::post('/operaciones/fianza_cheques/validarPestana1/', 'validarPestana1')->name('validarPestana1');
  Route::post('/operaciones/fianza_cheques/llenadoTable', [App\Http\Controllers\Fianza_chequeController::class, 'llenadoTableFianzasCheques'])->name('llenadoTableFianzasCheques');
});

Route::controller(App\Http\Controllers\StatusController::class)->group(function () {
  Route::get('/catalogos/Estatus', 'index')->name('Estatus')->middleware('permission:Ver Estatus');
  Route::post('/catalogos/EstatusAdd', 'store')->name('agregarEstatus');
  Route::get('/catalogos/Estatus_delete/{id?}', 'destroy')->name('cambiarEstatus');
  Route::post('/catalogos/Estatus_update/', 'update')->name('editarEstatus');
  Route::get('/catalogos/detalle_estatus/{id?}', [App\Http\Controllers\StatusController::class, 'detalleEstatus'])->name('detalleEstatus');
});

Route::controller(App\Http\Controllers\TipoController::class)->group(function () {
  Route::get('catalogos/tipo', 'index')->name('Tipo')->middleware('permission:Ver Tipo');
  Route::post('/catalogos/tipo/tipoAdd', 'store')->name('agregarTipo');
  Route::get('/catalogos/tipo/tipo_delete/{id?}', 'destroy')->name('TPdelete');
  Route::post('/catalogos/tipo/tipo_update', 'update')->name('editarTipo');
  Route::get('/catalogos/tipo/detalleTipo/{id?}', [App\Http\Controllers\TipoController::class, 'detalleTipo'])->name('detalleTipo');
});

Route::controller(App\Http\Controllers\EstadoController::class)->group(function () {
  Route::get('catalogos/estado', 'index')->name('Estado')->middleware('permission:Ver Estados');
  Route::post('/catalogos/estado/estados_agregar', 'store')->name('addaEstado');
  Route::get('/catalogos/estado/estados_eliminar/{id?}', 'destroy')->name('ESTdelete');
  Route::post('/catalogos/estado/estado_actualizaar/', 'update')->name('editaestado');
  Route::get('/catalogos/estado/detalle_estado/{id?}', [App\Http\Controllers\EstadoController::class, 'detalleEstado'])->name('detalleEstado');

});

Route::controller(App\Http\Controllers\MunicipioController::class)->group(function () {
  Route::get('catalogos/municipio', 'index')->name('Municipio')->middleware('permission:Ver Municipios');
  Route::post('/catalogos/municipio/municipio_agregar', 'store')->name('addaMunicipio');
  Route::get('/catalogos/municipio/municipio_eliminar/{id?}', 'destroy')->name('MUNdelete');
  Route::post('/catalogos/municipio_actualizar/', 'update')->name('editaMunicipio');
  Route::get('/catalogos/municipio/detalle_municipio/{id?}', [App\Http\Controllers\MunicipioController::class, 'detalleMunicipio'])->name('detalleMunicipio');
});

Route::controller(App\Http\Controllers\ColoniaController::class)->group(function () {
  Route::get('catalogos/Colonia', 'index')->name('Colonia')->middleware('permission:Ver Colonia');
  Route::post('/catalogos/colonia/agregar', 'store')->name('addaColonia');
  Route::get('/catalogos/colonia/eliminar/{id?}', 'destroy')->name('COLdelete');
  Route::post('/catalogos/colonia/actualizar', 'update')->name('editaColonia');
  Route::get('/catalogos/colonia/detalle_colonia/{id?}', [App\Http\Controllers\ColoniaController::class, 'detalleColonia'])->name('detalleColonia');
  Route::get('/catalogos/colonia/llenadoTable', [App\Http\Controllers\ColoniaController::class, 'llenadoTableColonias'])->name('llenadoTableColonias');
});

Route::controller(App\Http\Controllers\DireccionController::class)->group(function () {
  Route::get('catalogos/Direccion', 'index')->name('Direccion')->middleware('permission:Ver direccion');
  Route::get('/Direccion/getColonias', 'getColonias')->name('getColoniasDir');
  Route::post('/catalogos/DireccionAdd', 'store')->name('addaDireccion');
  Route::get('/catalogos/Direcciones_delete/{id?}', 'destroy')->name('DIRdelete');
  Route::post('/Direccion_update/', 'update')->name('editaDireccion');
  Route::get('/direccion/detalle_direccion/{id?}', [App\Http\Controllers\DireccionController::class, 'detalleDireccion'])->name('detalleDireccion');
});

Route::controller(App\Http\Controllers\RoleController::class)->group(function () {
  Route::get('roles/roles', 'index')->name('Roles')->middleware('permission:Ver roles');
  Route::post('roles/asignar-roles', 'asignar')->name('Asignar-Roles');
  Route::get('roles/crear-roles-formulario', 'form')->name('Crear-Roles-form')->middleware('permission:crear roles');
  Route::post('roles/crear-roles', 'crear')->name('Crear-Roles');
  Route::get('roles/editar-roles/{id?}', 'editar')->name('Editar-Roles')->middleware('permission:Ver roles');
  Route::post('roles/permisos-roles/{id?}', 'asignarPermisos')->name('Editar-Persmisos-Roles');
  Route::get('/roles/Rol_delete/{id?}', 'destroy')->name('Eliminar-Roles');


});
Route::controller(App\Http\Controllers\PermissionsController::class)->group(function () {
  Route::get('permisos/permisos', 'index')->name('Permisos')->middleware('permission:Ver Permisos');
  Route::post('permisos/crear-permiso', 'crear')->name('crear-Permisso');


});
