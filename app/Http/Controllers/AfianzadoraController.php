<?php

namespace App\Http\Controllers;

use App\Models\Afianzadora;
use App\Models\Direccion;
use Illuminate\Http\Request;
use App\Models\Colonia;
use App\Models\Estado;

use App\Helpers\AddressHelper;
use App\Models\Municipio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\exportaExcel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Route;

class AfianzadoraController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $estados = Estado::all();
    $municipios = Municipio::all();

    $afianzadoras = Afianzadora::with('direccion.colonia', 'direccion.municipio', 'direccion.estado')->get();

    return view('admin.catalogos.afianzadoras.afianzadoras', [
      'afianzadoras' => $afianzadoras,
      'estados' => $estados,
      'municipios' => $municipios,
    ]);
  }

  public function exportaExcel()
  {
    try {
      $data = Afianzadora::with('direccion.colonia', 'direccion.municipio', 'direccion.estado')->get();
      $dataExcel = $data->map(function ($item) {
        return [
          'id' => $item->id,
          'nombre' => $item->nombre,
          'activo' => $item->activo,
          'calle' => $item->direccion->calle ?? '',
          'no_interior' => $item->direccion->no_interior ?? '',
          'no_exterior' => $item->direccion->no_exterior ?? '',
          'codigo_postal' => $item->direccion->codigo_postal ?? '',
          'referencia' => $item->direccion->referencia ?? '',
          'colonia' => $item->direccion->colonia->colonia ?? '',
          'municipio' => $item->direccion->municipio->nombre ?? '',
          'estado' => $item->direccion->estado->nombre ?? '',
        ];
      });
      $headers = ['ID', 'Nombre', 'Activo', 'Calle', 'No. Interior', 'No. Exterior', 'Código Postal', 'Referencia', 'Colonia', 'Municipio', 'Estado'];
      return Excel::download(new exportaExcel($dataExcel, $headers), 'afianzadoras.xlsx');
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Error al exportar el excel'], 500);
    }
  }

  public function detalleAfianzadora(Request $request)
  {
    $afianzadora = Afianzadora::with('direccion.colonia', 'direccion.municipio', 'direccion.estado')->find($request->id);
    return response()->json($afianzadora);
  }

  public function getCodigoPostal(Request $request)
  {

    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'max' => 'El campo no puede tener más de : 5 caracteres',
      'min' => 'El campo no puede tener menos de : 5 caracteres',
    ];

    $request->validate([
      'codigo_postal' => 'required | max:5 | min:5',
    ], $customMessages);

    try {
      $codigo_postal = $request->codigo_postal;

      $colonias = AddressHelper::searchColonias($codigo_postal);

      if (empty($colonias)) {
        $returnData = array(
          'status' => 'error',
          'title' => 'Error',
          'message' => 'No se encontraron colonias con el código postal ' . $codigo_postal,
        );
        return response()->json($returnData, 400);
      }

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Se encontraron las siguientes colonias',
        'colonias' => $colonias,
      );
      return response()->json($returnData, 200);
    } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
  }

  public function getColonias(Request $request)
  {
    $colonias = Colonia::where('municipio_id', $request->municipio)->get();
    return response()->json($colonias);
  }

  public function getMunicipios(Request $request)
  {
    $municipios = Municipio::where('estado_id', $request->estado)->get();
    return response()->json($municipios);
  }
  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {

    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'digits' => 'El campo debe tener :digits caracteres',
      'numeric' => 'El campo solo puede contener numeros',
      'max' => 'El campo no puede tener más de :max caracteres',
    ];

    $request->validate([
      'nombre' => 'required',
    ], $customMessages);

    try {
      DB::beginTransaction();
      if ($request->estado) {
        $direccion = new Direccion([
          'municipio_id' => $request->input('municipio'),
          'estado_id' => $request->input('estado'),
          'colonia_id' => $request->input('colonia'),
          'calle' => $request->input('calle') ?? '',
          'codigo_postal' => $request->input('codigo_postal') ?? '',
          'no_interior' => $request->input('no_interior') ?? '',
          'no_exterior' => $request->input('no_exterior') ?? '',
          'referencia' => $request->input('referencia'),
        ]);
        $direccion->save();
      }

      $afianzadora = new Afianzadora([
        'nombre' => $request->input('nombre'),
        'activo' => 1,
        'direccion_id' => $direccion->id ?? null,
      ]);

      $afianzadora->save();

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );

      DB::commit();
      return response()->json($returnData, 200);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Ocurrio un error al generar nueva afianzadora.'
      );
      return response()->json($returnData);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Afianzadora $afianzadora)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $data = Afianzadora::join('direccion', 'afianzadoras.direccion_id', '=', 'direccion.id')
      ->select('afianzadoras.*', 'direccion.calle', 'direccion.no_exterior', 'direccion.colonia', 'direccion.codigo_postal', 'direccion.municipio', 'direccion.estado')
      ->where('afianzadoras.id', '=', $id)
      ->get();
    return view('admin.catalogos.edit_afianzadora_modal', [
      'data' => $data
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    DB::beginTransaction();

    $customMessages = [
      'required' => 'El campo no puede ir vacio',
      'digits' => 'El campo debe tener :digits caracteres',
      'numeric' => 'El campo solo puede contener numeros',
      'max' => 'El campo no puede tener más de :max caracteres',
    ];

    $request->validate([
      'nombre' => 'required',
    ], $customMessages);

    try {
      $idAfianzadora = $request->idAfianzadora;
      $afianzadora = Afianzadora::find($idAfianzadora);

      if ($request->estado !== null) {
        if ($afianzadora->direccion_id !== null) {

          $direccion = Direccion::updateOrCreate(
            ['id' => $afianzadora->direccion_id],
            [
              'municipio_id' => $request->municipio,
              'estado_id' => $request->estado,
              'colonia_id' => $request->colonia,
              'calle' => $request->calle,
              'codigo_postal' => $request->codigo_postal ?? '',
              'no_interior' => $request->no_interior ?? '',
              'no_exterior' => $request->no_exterior,
              'referencia' => $request->referencia,
            ]
          );
        } else {
          $direccion = Direccion::create([
            'municipio_id' => $request->municipio,
            'estado_id' => $request->estado,
            'colonia_id' => $request->colonia,
            'calle' => $request->calle,
            'codigo_postal' => $request->codigo_postal ?? '',
            'no_interior' => $request->no_interior ?? '',
            'no_exterior' => $request->no_exterior,
            'referencia' => $request->referencia,
          ]);
        }
        $direccion->save();

        $nuevoDireccionId = $direccion->id;
      }

      Afianzadora::where('id', $idAfianzadora)
        ->update([
          'nombre' => $request->nombre,
          'direccion_id' => $nuevoDireccionId ?? null,
        ]);

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );

      DB::commit();
      return response()->json($returnData, 200);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error($e->getMessage());
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Ocurrio un error al actualizar la afianzadora.'
      );
      return response()->json($returnData);
    }
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {

    DB::beginTransaction();
    try {
      $afianzadora = Afianzadora::find($request->id);

      Afianzadora::where('id', $afianzadora->id)
        ->update([
          'activo' => $afianzadora->activo == 0 ? 1 : 0,
        ]);
      DB::commit();
      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );

      DB::commit();
      return response()->json($returnData, 200);
    } catch (\Exception $e) {
      DB::rollBack();
      log::error($e->getMessage());
    }
  }

  public function llenadoTableAfianzadora(Request $request)
  {

    if ($request->ajax()) {
      $query = Afianzadora::with('direccion.colonia', 'direccion.municipio', 'direccion.estado')->get();

      $x = DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('direccion', function ($row) {
          $direccion = '';
          if($row->direccion){
            $direccion = $row->direccion->calle . ' ' . $row->direccion->no_interior . ' ' . $row->direccion->no_exterior ;
            if($row->direccion->colonia_id){
              $direccion .= ' ' . $row->direccion->colonia->colonia;
            }
            if($row->direccion->codigo_postal){
              $direccion .= ' ' . $row->direccion->codigo_postal;
            }
            if($row->direccion->municipio_id){
              $direccion .= ' ' . $row->direccion->municipio->nombre;
            }
            if($row->direccion->estado_id){
              $direccion .= ' ' . $row->direccion->estado->nombre;
            }
          }
          return $direccion;
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

                            <a id="btn-Editar" @can("Editar afianzadoras") class="dropdown-item btn-edit" @else class="dropdown-item disabled" @endcan href="" data-id=' . $row->id . '>
                              <i class="fas fa-pencil-alt text-warning"></i> Editar
                            </a>

                            <div class="dropdown-divider"></div>

                            <a id="btn-deshabilitarAfianzadora" @can("Eliminar afianzadoras") class="dropdown-item btn-delete" @else class="dropdown-item btn-delete disabled" @endcan href="" data-id=' . $row->id . '>
                              <i class="fas fa-trash-alt text-danger"></i> Eliminar</a>
                          </div>
          ';
          return $btn;
        })->rawColumns(['direccion','activo','acciones'])
        ->make(true);
      return $x;
    }

  }
}
