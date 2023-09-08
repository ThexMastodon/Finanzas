<?php

namespace App\Http\Controllers;
use App\Models\Modulo;
use App\Models\ModuloSubmoduloPermissions;
use App\Models\Submodulo;
use App\Models\TipoPermiso;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class PermissionsController extends Controller
{
  public function index()
  {
    if (Auth::user()->hasPermissionTo('Ver Permisos')) {
      $datos = Permission::select('permissions.*',)
    ->get();
    $Modulos = Modulo::select('modulos.*',)
    ->get();
    $Submodulos = Submodulo::select('submodulos.*',)
    ->get();
    $Tipos = TipoPermiso::select('tipo_permiso.*',)
    ->get();

    return view('admin.permissions.Permissions', ['datos' => $datos, 'Modulos' => $Modulos, 'Tipos' => $Tipos, 'Submodulos' => $Submodulos]);
  } else {

      return redirect()->route('admin.home');
  }


  }
  public function crear(Request $request){
    try {
      $permiso = $request->input('permiso');
      $tipo = $request->input('Tipo');
      $Submodulo = $request->input('Submodulo');
      $Modulo = $request->input('Modulo');

      $permisoCreado = Permission::create(['name' => $permiso, 'tipo_permiso_id' => $tipo]);
      $rootRole = Role::findByName('root');
      $rootRole->givePermissionTo($permisoCreado);

      ModuloSubmoduloPermissions::create(['modulo_id' => $Modulo, 'submodulo_id' => $Submodulo, 'permission_id' => $permisoCreado->id]);

      $returnData = array(
          'status' => 'success',
          'title' => 'Éxito',
          'message' => 'Operación realizada correctamente.'
      );

      return response($returnData);
} catch (\Throwable $th) {
  $returnData = array(
    'status' => 'error',
    'title' => 'Error',
    'message' => 'Hubo un error al crear el permiso.'
);

return response()->json($returnData);
}

  }

}
