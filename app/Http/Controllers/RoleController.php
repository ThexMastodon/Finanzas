<?php

namespace App\Http\Controllers;
use App\Models\Users;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  public function index()
  {
    if (Auth::user()->hasPermissionTo('Ver roles')){
    $Roles = Role::select('roles.*',)
    ->get();
    $users = Users::select('users.*',)
    ->get();
    $Permission = Permission::select('permissions.*',)
    ->get();


    return view('admin.roles.Roles', ['Roles' => $Roles,'users'=>$users,'Permissions'=>$Permission]);
  }else {

    return redirect()->route('admin.home');
}
  }
  public function asignar(Request $request)
  {
    try
      {
    $id_usuario = $request->usuario_id;
    $rol_name=$request->rol_id;
    $usuario = User::find($id_usuario);
    $rol = Role::findByName($rol_name);
    $usuario->syncRoles([]);
    $usuario->assignRole($rol);
    $returnData = array(
      'status' => 'success',
      'title' => 'Éxito',
      'message' => 'Operación realizada correctamente.'
    );

    return response($returnData);

  }catch (\Throwable $th) {


    DB::rollBack();

    $returnData = array(
      'status' => 'error',
      'title' => 'Error',
      'message' => 'Hubo un error, al asignar el rol.'
    );

    return response()->json($returnData);
  }

}
public function editar(Request $request,$id){
  $rol = Role::find($id);
  $permisos = Permission::join('modulo_submodulo_permissions', 'permissions.id', '=', 'modulo_submodulo_permissions.permission_id')
  ->join('modulos', 'modulo_submodulo_permissions.modulo_id', '=', 'modulos.id')
  ->select('permissions.*')
  ->where('modulos.id', 1)
    ->get();
  $permisos2 = Permission::join('modulo_submodulo_permissions', 'permissions.id', '=', 'modulo_submodulo_permissions.permission_id')
  ->join('modulos', 'modulo_submodulo_permissions.modulo_id', '=', 'modulos.id')
  ->select('permissions.*')
  ->where('modulos.id', 2)
    ->get();
  $permisos3 = Permission::join('modulo_submodulo_permissions', 'permissions.id', '=', 'modulo_submodulo_permissions.permission_id')
  ->join('modulos', 'modulo_submodulo_permissions.modulo_id', '=', 'modulos.id')
  ->select('permissions.*')
  ->where('modulos.id', 3)
    ->get();

  return view('admin.roles.Editar_Roles',['rol' => $rol,'permisos'=>$permisos,'permisos3'=>$permisos3,'permisos2'=>$permisos2]);
}
public function asignarPermisos(Request $request, $id)
{
    try {
        $rol = Role::findById($id);

        // Recuperar los permisos seleccionados de los tres conjuntos
        $permisosSeleccionados1 = $request->input('permisos', []);
        $permisosSeleccionados2 = $request->input('permisos2', []);
        $permisosSeleccionados3 = $request->input('permisos3', []);

        // Revocar todos los permisos al rol
        $todosLosPermisos = Permission::all();
        $rol->revokePermissionTo($todosLosPermisos);

        // Asignar los permisos seleccionados del primer conjunto al rol
        foreach ($permisosSeleccionados1 as $permisoId) {
            $permiso = Permission::find($permisoId);
            if ($permiso) {
                $rol->givePermissionTo($permiso);
            }
        }

        // Asignar los permisos seleccionados del segundo conjunto al rol
        foreach ($permisosSeleccionados2 as $permisoId) {
            $permiso = Permission::find($permisoId);
            if ($permiso) {
                $rol->givePermissionTo($permiso);
            }
        }

        // Asignar los permisos seleccionados del tercer conjunto al rol
        foreach ($permisosSeleccionados3 as $permisoId) {
            $permiso = Permission::find($permisoId);
            if ($permiso) {
                $rol->givePermissionTo($permiso);
            }
        }

        $returnData = array(
            'status' => 'success',
            'title' => 'Éxito',
            'message' => 'Operación realizada correctamente.'
        );

        return response($returnData);
    } catch (\Throwable $th) {
        DB::rollBack();

        $returnData = array(
            'status' => 'error',
            'title' => 'Error',
            'message' => 'Hubo un error al asignar los permisos.'
        );

        return response()->json($returnData);
    }
}
public function destroy(Request $id) {
  DB::beginTransaction();
      try{
        $dato = Role::find($id)->first();
        $dato->status = $dato->status == 0 ? 1 : 0;
        $dato->save();

        $returnData = array(
          'status' => 'success',
          'title' => 'Éxito',
          'message' => 'Operación realizada correctamente.'
        );

        DB::commit();
        return response($returnData);

      }catch(\Throwable $th){

        DB::rollBack();

        $returnData = array(
          'status' => 'error',
          'title' => 'Error',
          'message' => 'Hubo un error, no se pudo eliminar el municipio.'
        );
        return response($returnData);
      }

}
public function crear(Request $request){
  try{
  $nombre=$request->input('nombre');
  $rol=Role::create(['name' => $nombre]);
  $permisosSeleccionados1 = $request->input('permisos', []);
  $permisosSeleccionados2 = $request->input('permisos2', []);
  $permisosSeleccionados3 = $request->input('permisos3', []);




  // Asignar los permisos seleccionados del primer conjunto al rol
  foreach ($permisosSeleccionados1 as $permisoId) {
      $permiso = Permission::find($permisoId);
      if ($permiso) {
          $rol->givePermissionTo($permiso);
      }
  }

  // Asignar los permisos seleccionados del segundo conjunto al rol
  foreach ($permisosSeleccionados2 as $permisoId) {
      $permiso = Permission::find($permisoId);
      if ($permiso) {
          $rol->givePermissionTo($permiso);
      }
  }

  // Asignar los permisos seleccionados del tercer conjunto al rol
  foreach ($permisosSeleccionados3 as $permisoId) {
      $permiso = Permission::find($permisoId);
      if ($permiso) {
          $rol->givePermissionTo($permiso);
      }
  }
  $returnData = array(
    'status' => 'success',
    'title' => 'Éxito',
    'message' => 'Operación realizada correctamente.'
);

return response($returnData);
} catch (\Throwable $th) {
DB::rollBack();

$returnData = array(
    'status' => 'error',
    'title' => 'Error',
    'message' => 'Hubo un error al asignar los permisos.'
);

return response()->json($returnData);
}

}
public function form(Request $request){

  $permisos = Permission::join('modulo_submodulo_permissions', 'permissions.id', '=', 'modulo_submodulo_permissions.permission_id')
  ->join('modulos', 'modulo_submodulo_permissions.modulo_id', '=', 'modulos.id')
  ->select('permissions.*')
  ->where('modulos.id', 1)
    ->get();
  $permisos2 = Permission::join('modulo_submodulo_permissions', 'permissions.id', '=', 'modulo_submodulo_permissions.permission_id')
  ->join('modulos', 'modulo_submodulo_permissions.modulo_id', '=', 'modulos.id')
  ->select('permissions.*')
  ->where('modulos.id', 2)
    ->get();
  $permisos3 = Permission::join('modulo_submodulo_permissions', 'permissions.id', '=', 'modulo_submodulo_permissions.permission_id')
  ->join('modulos', 'modulo_submodulo_permissions.modulo_id', '=', 'modulos.id')
  ->select('permissions.*')
  ->where('modulos.id', 3)
    ->get();

  return view('admin.roles.Crear_Roles',['permisos'=>$permisos,'permisos3'=>$permisos3,'permisos2'=>$permisos2]);
}
}



