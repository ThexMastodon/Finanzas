<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fianza_cheque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Afianzadora;
use App\Models\Estatus;
use App\Models\Tipo;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\exportaExcel;
use App\Models\Direccion;
use App\Models\Estado;
use App\Models\Municipio;
use Yajra\DataTables\Facades\DataTables;

class Fianza_chequeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $estados = Estado::where('activo', 1)->get();
    $municipios = Municipio::where('activo', 1)->get();
    $afianzadoras = Afianzadora::where('activo', 1)->get();
    $estatus = Estatus::where('activo', 1)->get();
    $tipos = Tipo::where('activo', 1)->get();

    return view('admin.operaciones.fianzasCheques.fianzasycheques', ['municipios' => $municipios, 'estados' => $estados, 'afianzadoras' => $afianzadoras, 'estatus' => $estatus, 'tipos' => $tipos]);
  }

  private function tableServerSide($query)
  {
    $x = DataTables::of($query)
      ->addIndexColumn()
      ->addColumn('afianzadora', function ($row) {
        return $row->afianzadoras->nombre ?? '';
      })
      ->addColumn('importe', function ($row) {
        return '$' . $row->importe ?? '';
      })
      ->addColumn('estatus', function ($row) {
        return $row->estatus->descripcion;
      })
      ->addColumn('acciones', function ($row) {
        $btn = '
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              Acciones
                            </button>

                            <div class="dropdown-menu">
                              <a id="btn-Editar" @can("Editar Fianzas y cheques") class="dropdown-item btn-edit" @else class="dropdown-item btn-edit disabled" @endcan href="' . route('detalleFianzaCheque', ['id' => $row->id]) . '" data-id=' . $row->id . ' data-target="#modal-edit" data-route="' . route('detalleFianzaCheque', ['id' => $row->id]) . '"><i class="fas fa-pencil-alt text-warning"></i> Editar</a>
                            </div>
            ';
        return $btn;
      })
      ->rawColumns(['afianzadora', 'importe', 'estatus', 'acciones'])
      ->make(true);
    return $x;
  }

  public function llenadoTableFianzasCheques(Request $request)
  {
    try {

      if ($request->ajax()) {

        $query = Fianza_cheque::with([
          'afianzadoras' => function ($query) {
            $query->select('id', 'nombre');
          },
          'estatus' => function ($query) {
            $query->select('id', 'descripcion');
          }
        ])->select('id', 'no_fianza_cheque', 'importe', 'fecha_expedicion', 'afianzadoras_id', 'estatus_id')
          ->orderBy('id', 'desc')
          ->get();


        if ($request->input('search')['value'] != null) {
          $x = $this->tableServerSide($query);
          return $x;
        }

        $m = cache()->remember('consultaFianzaCheque_' . $request->input('start'), 300, function () use ($query) {
          return $this->tableServerSide($query);
        });


        if (cache()->has('consultaFianzaCheque_' . $request->input('start'))) {
          $jsonResponse  = cache()->get('consultaFianzaCheque_' . $request->input('start'));
          $responseData = json_decode($jsonResponse->getContent(), true);
          $newDrawValue = $request->input('draw');
          $responseData['draw'] = $newDrawValue;
          $jsonUpdatedResponse = json_encode($responseData);
          return \response()->json()->fromJsonString($jsonUpdatedResponse);
        }
      }
    } catch (\Exception $e) {
      Log::error('Fianza_chequeController@llenadoTableFianzasCheques ' . $e);
      return response()->json($e->getMessage(), 500);
    }
  }



  public function exportaExcel()
  {
    try {
      set_time_limit(240);
      // $data = Fianza_cheque::with('afianzadoras', 'estatus')->get();
      $data = Fianza_cheque::with([
        'afianzadoras' => function ($data) {
          $data->select('id', 'nombre');
        },
        'estatus' => function ($data) {
          $data->select('id', 'descripcion');
        }
      ])->select(
        'id',
        'no_fianza_cheque',
        'importe',
        'fecha_expedicion',
        'fecha_vencimiento',
        'fecha_captura',
        'a_favor',
        'licitación',
        'concepto',
        'afianzadoras_id',
        'estatus_id'
      )
        ->orderby('id', 'desc')
        ->get();
      $dataExcel = $data->map(function ($item) {
        return [
          'id' => $item->id,
          'no_fianza_cheque' => $item->no_fianza_cheque,
          'fecha_expedicion' => $item->fecha_expedicion,
          'fecha_vencimiento' => $item->fecha_vencimiento,
          'fecha_captura' => $item->fecha_captura,
          'a_favor' => $item->a_favor,
          'importe' => $item->importe,
          'licitacion' => $item->licitación,
          'concepto' => $item->concepto,
          'afianzadora' => $item->afianzadoras->nombre ?? '',
          'estatus' => $item->estatus->descripcion,
        ];
      });
      $headers = [
        'Id',
        'No. fianza cheque',
        'Fecha expedicion',
        'Fecha vencimiento',
        'Fecha captura',
        'A favor',
        'Importe',
        'Licitación',
        'Concepto',
        'Afianzadora',
        'Estatus',
      ];
      return Excel::download(new exportaExcel($dataExcel, $headers), 'FianzasCheques.xlsx');
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Error al exportar el excel'], 500);
    }
  }

  public function validarPestana1(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    $request->validate([], $customMessages);

    $returnData = array(
      'status' => 'success',
      'title' => 'Éxito',
    );
    return response()->json($returnData, 200);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    // VALIDACION para pedir apellidos en persona fisica
    if ($request->tipo_persona == 1) {
      $request->validate([
        'nombre' => 'required',
        'APaterno' => 'required',
        'AMaterno' => 'required',
      ], $customMessages);
    }

    $request->validate([
      'fianza_cheque' => 'required',
      'afianzadora' => 'required',
      'tipo' => 'required',
      'tipo_persona' => 'required',
      'estatus' => 'required',
      'nombre' => 'required',
      'importe' => 'required',
    ], $customMessages);


    DB::beginTransaction();
    try {
      if ($request->estado || $request->calle) {
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

      $fianzaCheque = Fianza_cheque::create([
        'no_fianza_cheque' => $request->input('fianza_cheque'),
        'fecha_expedicion' => $request->input('fecha_expedicion'),
        'fecha_vencimiento' => $request->input('fecha_vencimiento'),
        'fecha_captura' => now(),
        // 'expedido_por' => $request->input('expedido_por'),  //! Falta por checar si es foranea o no
        'a_favor' => $request->input('aFavor'),
        'importe' => $request->input('importe'),
        'licitación' => $request->input('licitacion'),
        'concepto' => $request->input('concepto'),
        'nombre' => $request->input('nombre'),
        'apellido_paterno' => $request->input('APaterno'),
        'apellido_materno' => $request->input('AMaterno'),
        'tipo_persona' => $request->input('tipo_persona'),
        'afianzadoras_id' => $request->input('afianzadora'),
        'tipo_id' => $request->input('tipo'),
        'estatus_id' => $request->input('estatus'),
        'direccion_id' => $direccion->id ?? null,
      ]);
      $fianzaCheque->save();
      DB::commit();

      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operación realizada correctamente.'
      );
      return response()->json($returnData, 200);
    } catch (\Exception $e) {
      DB::rollback();
      Log::error($e->getMessage());
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Ocurrio un error al crear la fianza o cheque'

      );
      return response()->json($returnData);
    }
  }

  public function detalleFianzaCheque(Request $request)
  {
    $fianza_cheque = Fianza_cheque::with('afianzadoras', 'estatus', 'tipo', 'direccion')->find($request->id);
    return response()->json($fianza_cheque);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function calcularFechaVencimiento(Request $request)
  {
    $fechaExpedicion = $request->input('fechaExpedicion');
    $fechaVencimiento = $this->calcularFecha($fechaExpedicion);

    return response()->json(['fechaVencimiento' => $fechaVencimiento]);
  }

  public function calcularFecha($fechaExpedicion)
  {
    $fechaInicio = Carbon::parse($fechaExpedicion);
    $fechaVencimiento = $fechaInicio->addYear();
    return $fechaVencimiento->format('Y-m-d');
  }


  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    DB::beginTransaction();

    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    if ($request->nombreHistorico) {
      $request->validate([
        'nombreHistorico' => 'required',
      ], $customMessages);
    } else {
      if ($request->tipo_persona == 1) {
        $request->validate([
          'nombre' => 'required',
          'APaterno' => 'required',
          'AMaterno' => 'required',
        ], $customMessages);
      } else {
        $request->validate([
          'nombre' => 'required',
        ], $customMessages);
      }
    }

    $request->validate([
      'fianza_cheque' => 'required',
      'afianzadora' => 'required',
      'tipo' => 'required',
      'tipo_persona' => 'required',
      'estatus' => 'required',
      'importe' => 'required',
    ], $customMessages);

    try {
      $FianzaCheque = $request->idFianzaCheque;
      $direccion = Fianza_cheque::where('id', $FianzaCheque)->first();

      if ($request->estado !== null || $request->calle !== null) {
        if ($direccion->direccion_id !== null) {
          $direccionUpdate = Direccion::updateOrCreate(
            ['id' => $direccion->direccion_id],
            [
              'municipio_id' => $request->input('municipio'),
              'estado_id' => $request->input('estado'),
              'colonia_id' => $request->input('colonia'),
              'calle' => $request->input('calle'),
              'codigo_postal' => $request->input('codigo_postal'),
              'no_interior' => $request->input('no_interior'),
              'no_exterior' => $request->input('no_exterior'),
              'referencia' => $request->input('referencia'),
            ]
          );
        } else {
          $direccionUpdate = Direccion::create([
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
        $direccionUpdate->save();

        $nuevoDireccionId = $direccionUpdate->id;
      }

      if ($request->direccion_historico) {
        $direccionHistorico = $request->direccion_historico;
      }

      Fianza_cheque::where('id', $FianzaCheque)
        ->update([
          'no_fianza_cheque' => $request->input('fianza_cheque'),
          'fecha_expedicion' => $request->input('fecha_expedicion'),
          'fecha_vencimiento' => $request->input('fecha_vencimiento'),
          'a_favor' => $request->input('aFavor'),
          'importe' => $request->input('importe'),
          'licitación' => $request->input('licitacion'),
          'concepto' => $request->input('concepto'),
          'expedido_por' => $request->nombreHistorico ?? '',
          'nombre' => $request->input('nombre'),
          'apellido_paterno' => $request->input('APaterno'),
          'apellido_materno' => $request->input('AMaterno'),
          'tipo_persona' => $request->input('tipo_persona'),
          'afianzadoras_id' => $request->input('afianzadora'),
          'tipo_id' => $request->input('tipo'),
          'estatus_id' => $request->input('estatus'),
          'direccion_id' => $nuevoDireccionId ?? null,
          'direccion_historico' => $direccionHistorico ?? null,
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
        'message' => 'Ocurrio un error al actualizar la Fianza o Cheque.'
      );
      return response()->json($returnData);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
  }
}
