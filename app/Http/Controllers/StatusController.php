<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatusController extends Controller
{
  public function index()
  {
    $datos = Estatus::select('estatus.*',)
      ->get();

    return view('admin.catalogos.Estatus.Estatus', ['datos' => $datos]);
  }

  public function store(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'unique' => 'El estatus ya se encuentra registrado',
    ];

    $request->validate([
      'descripcion' => 'required | unique:estatus',
    ], $customMessages);

    DB::beginTransaction();
    try {
      Estatus::create([
        'descripcion' => $request->input('descripcion'),
        'activo' => 1,
      ]);
      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );
      DB::commit();
      return response($returnData);
    } catch (\Throwable $th) {
      DB::rollBack();
      Log::error($th->getMessage());
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo Actualizar el Estatus.'
      );

      return response($returnData);
    }
  }

  public function destroy(Request $id)
  {
    DB::beginTransaction();
    try {
      $dato = Estatus::find($id)->first();
      $dato->activo =  $dato->activo == 0 ? 1 : 0;
      $dato->save();

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );
      DB::commit();
      return response($returnData);
    } catch (\Throwable $th) {
      DB::rollBack();
      Log::error($th->getMessage());

      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo Actualizar el Estatus.'
      );

      return response($returnData);
    }


    return redirect()->route('Estatus');
  }

  public function detalleEstatus(Request $request)
  {
    $estatus = Estatus::find($request->id);
    return response()->json($estatus);
  }

  public function update(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'unique' => 'El estatus ya se encuentra registrado',
    ];

    $request->validate([
      'descripcion' => 'required | unique:estatus,descripcion,' .$request->id,
    ], $customMessages);

    DB::beginTransaction();
    try {
      $id = $request->id;
      $dato = Estatus::find($id);

      $dato->descripcion = $request->descripcion;
      $dato->save();

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );

      DB::commit();
      return response($returnData);
    } catch (\Throwable $th) {
      DB::rollBack();
      Log::error($th->getMessage());

      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo Actualizar el Estatus.'
      );

      return response($returnData);
    }
  }
}
