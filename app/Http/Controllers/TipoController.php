<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tipo;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TipoController extends Controller
{
  public function index()
  {
    $datos = Tipo::select('tipo.*',)
      ->get();

    return view('admin.catalogos.tipo.tipo', ['datos' => $datos]);
  }
  public function store(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];
    $request->validate([
      'descripcion' => 'required',
    ], $customMessages);

    try {
      DB::beginTransaction();
      Tipo::create([
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
      Log::debug($th);
      DB::rollBack();
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo guardar el tipo.'
      );
      return response($returnData);
    }
  }

  public function detalleTipo(Request $request)
  {
    $tipo = Tipo::find($request->id);
    return response()->json($tipo);
  }

  public function destroy(Request $id)
  {
    DB::beginTransaction();
    try {
      $dato = Tipo::find($id)->first();
      $dato->activo = $dato->activo == 0 ? 1 : 0;
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
        'message' => 'Hubo un error, no se pudo actualizar el tipo.'
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
      'descripcion' => 'required',
    ], $customMessages);

    try {
      DB::beginTransaction();
      $id = $request->idTipo;

      Tipo::where('id', $id)->update([
        'descripcion' => $request->descripcion,
      ]);

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
        'message' => 'Hubo un error, no se pudo Actualizar el tipo.'
      );

      return response($returnData);
    }
  }
}
