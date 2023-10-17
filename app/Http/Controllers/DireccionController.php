<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;
use App\Models\ApiEstado;
use App\Models\ApiMunicipio;
use App\Models\Colonia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ApiColonia;


class DireccionController extends Controller
{
  public function index()
  {
    $estados = ApiEstado::all();
    $municipios = ApiMunicipio::all();
    $datos = Direccion::with('municipio', 'estado', 'colonia')->get();

    return view('admin.catalogos.Direccion.Direccion', [
      'datos' => $datos, 'estados' => $estados,
      'municipios' => $municipios,
    ]);
  }

  public function detalleDireccion(Request $request)
  {
    $afianzadora = Direccion::find($request->id);
    return response()->json($afianzadora);
  }

  public function getColonias(Request $request)
  {
    $colonias = ApiColonia::where('municipio_id', $request->municipio)->get();
    return response()->json($colonias);
  }

  public function store(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    $request->validate([
      'codigo_postal' => 'required | max:5',
      'municipio' => 'required',
      'colonia' => 'required',
      'calle' => 'required',
      'no_exterior' => 'required',
    ], $customMessages);
    try {
      DB::beginTransaction();
      Direccion::create([
        'calle' => $request->input('calle'),
        'codigo_postal' => $request->input('codigo_postal'),
        'no_interior' => $request->input('no_interior'),
        'no_exterior' => $request->input('no_exterior'),
        'referencia' => $request->input('referencia'),
        'estado_id' => 1,
        'colonia_id' => $request->input('colonia'),
        'municipio_id' => $request->input('municipio'),
      ]);
      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );

      DB::commit();
      return response()->json($returnData, 200);
    } catch (\Throwable $th) {
      Log::debug($th);
      DB::rollBack();
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo guardar La Direccion.'
      );
      return response($returnData);
    }


    return redirect('/admin/catalogos/Direccion');
  }

  public function destroy($id)
  {
    $dato = Direccion::find($id);

    $dato->delete();

    return redirect()->route('Direccion');
  }

  public function update(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    $request->validate([
      'codigo_postal' => 'required | max:5',
      'municipio' => 'required',
      'colonia' => 'required',
      'calle' => 'required',
      'no_exterior' => 'required',
    ], $customMessages);
    try {
      DB::beginTransaction();
      $id = $request->input('idDireccion');
      $dato = Direccion::find($id);

      $dato->calle = $request->input('calle');
      $dato->codigo_postal = $request->input('codigo_postal');
      $dato->no_interior = $request->input('no_interior');
      $dato->no_exterior = $request->input('no_exterior');
      $dato->referencia = $request->input('referencia');
      $dato->colonia_id = $request->input('colonia');
      $dato->municipio_id = $request->input('municipio');
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
        'message' => 'Hubo un error, no se pudo actualizar la direccion.'
      );

      return response($returnData);
    }
  }
}
