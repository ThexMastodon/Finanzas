<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Estado;

class EstadoController extends Controller
{
  public function index()
  {
    $datos = Estado::select('estados.*',)
      ->get();

    return view('admin.catalogos.Estado.Estado', ['datos' => $datos]);
  }

  public function store(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    $request->validate([
      'nombre' => 'required',
    ], $customMessages);
    try{
      DB::beginTransaction();
      Estado::create([
        'nombre' => $request->input('nombre'),
        'activo' => 1,
      ]);

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );
      //return redirect('/admin/catalogos/Estado');
      DB::commit();

      return response($returnData);

    }catch (\Throwable $th) {
      Log::debug($th);
      DB::rollBack();

      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo Agregar el Estatus.'
      );

      return response($returnData);
    }


  }

  public function destroy(Request $id)
  {
    try {
      $dato = Estado::find($id)->first();
      $dato->activo = $dato->activo == 0 ? 1 : 0;
      $dato->save();

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );
      DB::commit();
      return response($returnData);
    } catch (\Throwable $th) {
      Log::debug($th);
      DB::rollBack();
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo modificar el estado.'
      );

      return response($returnData);
    }
  }
  public function update(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    $request->validate([
      'nombre' => 'required',
    ], $customMessages);

    try {
      DB::beginTransaction();
      $id = $request->input('idEstado');
      $dato = Estado::find($id);
      log::debug($id);

      $dato->nombre = $request->input('nombre');
      $dato->save();

      DB::commit();
      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );
      return response($returnData);

    } catch (\Throwable $th) {
      Log::debug($th);
      DB::rollBack();

      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo Actualizar el Estado.'
      );

      return response($returnData);
    }
  }

  public function detalleEstado(Request $request)
  {
    $estado = Estado::find($request->id);
    return response()->json($estado);
  }
}

