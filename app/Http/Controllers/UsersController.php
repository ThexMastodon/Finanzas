<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

use App\Models\User;
use App\Models\Users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    Users::create([
      'username' => $request->username,
      'name' => $request->name,
      'last_name' => $request->last_name,
      'second_last_name' => $request->second_lastname,
      'email' => $request->email,
      'active' => $request->active,
      'password' => $request->name,
      'image' => $request->image,
    ],);
    return view('admin.users.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(  )
  {

    }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $datosUser = request()->all();
    $datosUser = request()->except('_token');
    if ($request->hasFile('image')) {
      $datosUser['image'] = $request->file('image')->store('uploads', 'public');
    }

    Users::insert($datosUser);

    return response()->json($datosUser);
  }

  /**
   * Display the specified resource.
   */
  public function show()
  {

    $users = Users::select('users.*',)
    ->get();
    $Roles = Role::select('roles.*',)
    ->get();

    return view('admin.users.list_users', ['datos' => $users,'Roles' => $Roles]);

  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $Roles=Role::select('roles.*')
    ->get();
    $data = User::select('users.*',)
      ->where('id', '=', $id)
      ->first();
      //dd($data);
      return view('admin.users.detail_user', [
        'data'=>$data ,'Roles'=>$Roles
      ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request,$id)
  {
    try
    {
      $request->validate([
        'username' => 'required|min:1',
        'name' => 'required|min:1',
        'email' => 'required|min:1'
      ]);

      $user = User::find($id);

      if($request->photo){
        $image = $request->photo;
        $imageData = file_get_contents($image->getRealPath());
        $user->image = base64_encode($imageData);
      }
      $user->username = $request->username;
      $user->name = $request->name;
      $user->last_name = $request->last_name;
      $user->second_last_name = $request->second_last_name;
      $user->email = $request->email;
      $user->active = $request->active;
      $rol=$request->rol_id;

        $rol = Role::findById($rol);
        $user->syncRoles([]);
        $user->assignRole($rol);


      $user->save();

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );


      return response()->json($returnData);
    }
    catch (\Throwable $th) {


      DB::rollBack();

      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo realizar la operacion.'
      );

      return response()->json($returnData);
    }

}

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Users $users)
  {
    //
  }

  public function UpdatePassword(Request $request,$id)
  {
    try
    {
    $request->validate([
      'password' => 'required|confirmed|min:1'
    ]);

    $user = User::find($id);


    $user->password = bcrypt($request->password);

    $user->save();

    $returnData = array(
      'status' => 'success',
      'title' => 'Éxito',
      'message' => 'Se logro actualizar la contraseña con éxito'
    );

    return response($returnData);
  }
  catch (\Throwable $th) {
    Log::debug($th);

    DB::rollBack();

    $returnData = array(
      'status' => 'error',
      'title' => 'Error',
      'message' => 'Hubo un error, no se pudo actualizar la informacion.'
    );

    return response($returnData);
  }
  }
  public function FormNewUser()
    {
      $Roles = Role::select('roles.*',)
        ->get();
      return view('admin.users.add_user', ['Roles' => $Roles]);
    }

    public function AddUser(Request $request)
    {
      try
      {

        $username = $request->username;
        $name = $request->name;
        $last_name = $request->last_name;
        $second_last_name = $request->second_last_name;
        $email = $request->email;

        $new = new User;

        $new->username = $username;
        $new->name = $name;
        $new->last_name = $last_name;
        $new->second_last_name = $second_last_name;
        $new->email = $email;
        $new->password = bcrypt('12345678');
        $new->image = null;
        $new->active = '1';

        $new->save();
        $rol_name=$request->rol_id;

        $rol = Role::findByName($rol_name);
        $new->syncRoles([]);
        $new->assignRole($rol);
        $returnData = array(
          'status' => 'success',
          'title' => 'Éxito',
          'message' => 'Operación realizada correctamente.'
        );

        return response($returnData);
      }catch (\Throwable $th) {
        Log::debug($th);

        DB::rollBack();

        $returnData = array(
          'status' => 'error',
          'title' => 'Error',
          'message' => 'Hubo un error, no se pudo completar la operacion.'
        );

        return response()->json($returnData);
      }
    }

}
