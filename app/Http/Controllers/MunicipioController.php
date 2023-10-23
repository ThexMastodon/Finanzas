<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Estado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MunicipioController extends Controller
{
    public function index()
    {
      $datos = Municipio::select('municipios.*',)
      ->get();
      $estados = Estado::select('estados.*',)
			->get();

      return view('admin.catalogos.Municipio.Municipio', ['datos' => $datos,'estados'=>$estados,]);

    }
    public function store(Request $request)
    {
      $customMessages = [
        'required' => 'El campo no puede ir vacio',
        'unique' => 'El municipio ya se encuentra registrado',
      ];

      $request->validate([
        'nombre' => 'required | unique:municipios',
        'estado_id' => 'required',
      ], $customMessages);
      try{
        DB::beginTransaction();
        Municipio::create([
          'nombre' => $request->input('nombre'),
          'estado_id' => $request->input('estado_id'),
          'activo' => 1,
        ]);

        DB::commit();
        $returnData = array(
          'status' => 'success',
          'title' => 'Éxito',
          'message' => 'Operación realizada correctamente.'
        );

        return response($returnData);

      }catch(\Throwable $th){
        Log::debug($th);
        DB::rollBack();

        $returnData = array(
          'status' => 'error',
          'title' => 'Error',
          'message' => 'Hubo un error, no se pudo registrar el municipio.'
        );

        return response($returnData);
      }
    }
    public function destroy(Request $id)
    {
      DB::beginTransaction();
      try{
        $dato = Municipio::find($id)->first();
        $dato->activo = $dato->activo == 0 ? 1 : 0;
        $dato->save();

        $returnData = array(
          'status' => 'success',
          'title' => 'Éxito',
          'message' => 'Operación realizada correctamente.'
        );

        DB::commit();
        return response($returnData);

      }catch(\Throwable $th){
        Log::debug($th);
        DB::rollBack();

        $returnData = array(
          'status' => 'error',
          'title' => 'Error',
          'message' => 'Hubo un error, no se pudo eliminar el municipio.'
        );
        return response($returnData);
      }
    }

    public function update(Request $request)
    {
      $customMessages = [
        'required' => 'El campo no puede ir vacio',
        'unique' => 'El municipio ya se encuentra registrado',
      ];

      $request->validate([
        'nombre' => 'required | unique:municipios,nombre,' .$request->idMunicipio,
        'estado_id' => 'required',
      ], $customMessages);

      try{
        DB::beginTransaction();
        $id = $request->input('idMunicipio');
        $dato = Municipio::find($id);

        $dato->nombre = $request->input('nombre');
        $dato->save();

        DB::commit();
        $returnData = array(
          'status' => 'success',
          'title' => 'Éxito',
          'message' => 'Operación realizada correctamente.'
        );
        return response($returnData);

      }
      catch (\Throwable $th) {
        Log::debug($th);
        DB::rollBack();

        $returnData = array(
          'status' => 'error',
          'title' => 'Error',
          'message' => 'Hubo un error, no se pudo Actualizar el municipio.'
        );

        return response($returnData);
      }
    }

    public function detalleMunicipio(Request $request)
    {
      $municipio = Municipio::find($request->id);
      return response()->json($municipio);
    }
}
