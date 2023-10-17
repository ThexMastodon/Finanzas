<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiColonia;
use App\Models\ApiMunicipio;
use App\Models\ApiEstado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ColoniaController extends Controller
{
  public function index()
  {
    $estados = ApiEstado::select('catalogo_estados_api.*',)->get();
    $municipios = ApiMunicipio::select('catalogo_municipios_api.*',)->get();

    return view('admin.catalogos.Colonia.Colonia', ['estados' => $estados, 'municipios' => $municipios,]);
  }

  private function tableServerSide($query)
  {
    $x = DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('estado', function ($row) {
          return $row->municipio->estado->descripcion ?? '';
        })
        ->addColumn('municipio', function ($row) {
          return $row->municipio->descripcion ?? '';
        })
        ->addColumn('activo', function ($row) {
          $activo = $row->activo == 1 ? '<i style="text-align: center; color: #32CD32" class="fas fa-check"></i>' : '<i style="text-align: center; color: red" class="fas fa-times"></i>';
          return $activo;
        })
        ->addColumn('acciones', function ($row) {
          $btn = '
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Acciones
                          </button>
                          <div class="dropdown-menu">

                            <a id="btn-Editar" @can("Editar Colonia") class="dropdown-item btn-edit" @else class="dropdown-item disabled" @endcan href="" data-id=' . $row->id . '>
                              <i class="fas fa-pencil-alt text-warning"></i> Editar
                            </a>

                            <div class="dropdown-divider"></div>

                            <a id="btn-delete" @can("Eliminar Colonia") class="dropdown-item btn-delete" @else class="dropdown-item btn-delete disabled" @endcan href="" data-id=' . $row->id . '>
                              <i class="fas fa-trash-alt text-danger"></i> Eliminar</a>
                          </div>
          ';
          return $btn;
        })
        ->rawColumns(['estado', 'municipio','activo','acciones'])
        ->make(true);
      return $x;
  }

  public function llenadoTableColonias(Request $request)
  {
    if ($request->ajax()) {
      $query = ApiColonia::with('municipio.estado')->get();

      if ($request->input('search')['value'] != null) {
        $x = $this->tableServerSide($query);
        return $x;
      }

      $m = cache()->remember('consultaColonias_' . $request->input('start'), 300, function () use ($query) {
        return $this->tableServerSide($query);
      });

      if (cache()->has('consultaColonias_' . $request->input('start'))) {
        $jsonResponse  = cache()->get('consultaColonias_' . $request->input('start'));
        $responseData = json_decode($jsonResponse->getContent(), true);
        $newDrawValue = $request->input('draw');
        $responseData['draw'] = $newDrawValue;
        $jsonUpdatedResponse = json_encode($responseData);
        return \response()->json()->fromJsonString($jsonUpdatedResponse);
      }

    }

  }

  public function detalleColonia(Request $request)
  {
    $afianzadora = ApiColonia::find($request->id);
    return response()->json($afianzadora);
  }

  public function store(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'max' => 'El campo no puede tener mas de :max caracteres',
      'digits' => 'El campo debe tener :digits caracteres',
      'numeric' => 'El campo solo puede contener numeros',

    ];

    $request->validate([
      'codigo_postal' => 'required | digits:5 | numeric',
      'estado' => 'required',
      'municipio' => 'required',
      'colonia' => 'required',
    ], $customMessages);

    try {
      DB::beginTransaction();
      ApiColonia::create([
        'descripcion' => $request->colonia,
        'codigo_postal' => $request->codigo_postal,
        'municipio_id' => $request->municipio,
        'activo' => 1,
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
        'message' => 'Hubo un error, no se pudo guardar la colonia.'
      );
      return response($returnData);
    }
  }

  public function destroy(Request $id)
  {
    try {
      DB::beginTransaction();
      $dato = ApiColonia::find($id)->first();
      $dato->activo = 0;
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

  public function update(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'max' => 'El campo no puede tener mas de :max caracteres',
      'digits' => 'El campo debe tener :digits caracteres',
      'numeric' => 'El campo solo puede contener numeros',

    ];

    $request->validate([
      'codigo_postal' => 'required | digits:5 | numeric',
      'estado' => 'required',
      'municipio' => 'required',
      'colonia' => 'required',
    ], $customMessages);
    try {
      DB::beginTransaction();
      $id = $request->idColonia;
      $dato = ApiColonia::find($id);
      $dato->descripcion = $request->colonia;
      $dato->codigo_postal = $request->codigo_postal;
      $dato->municipio_id = $request->municipio;
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
        'message' => 'Hubo un error, no se pudo actualizar la colonia.'
      );

      return response($returnData);
    }
  }
}
