<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Cancelado;
use App\Models\Afianzadora;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\exportaExcel;
use App\Models\Fianza_cheque;
use Yajra\DataTables\Facades\DataTables;

class CanceladoController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = Auth::id();

    $afianzadoras = Afianzadora::where('activo', 1)->select('afianzadoras.*',)
      ->get();

    return view('admin.operaciones.cancelados.cancelados', [
      'afianzadoras' => $afianzadoras,
      'users' => $users
    ]);
  }

  public function detalleCancelado(Request $request)
  {
    $query = Cancelado::with([
      'fianza_cheque' => function ($query) {
        $query->select('id', 'no_fianza_cheque');
      }
    ])
      ->where('id', $request->id)
      // ->select('id', 'no_fianza_cheque', 'importe', 'fecha_expedicion', 'afianzadoras_id',)
      ->first();

    return response()->json(["cancelado" => $query]);
  }

  public function llenadoTableCancelados(Request $request)
  {
    if ($request->ajax()) {
      $query = Cancelado::with('afianzadora', 'fianza_cheque', 'user')
        ->orderby('id', 'desc')
        ->get();

      $x = DataTables::of($query)
        ->addIndexColumn()
        ->addColumn('no_fianza_cheque', function ($row) {
          return $row->fianza_cheque->no_fianza_cheque ?? '';
        })
        ->addColumn('usuario', function ($row) {
          $user = '';
          if ($row->user) {
            $user = $row->user->username;
          }
          return $user;
        })
        ->addColumn('afianzadora', function ($row) {
          return $row->afianzadora->nombre ?? '';
        })
        ->addColumn('acciones', function ($row) {
          $btn = '
          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            Acciones
                          </button>
                          <div class="dropdown-menu">

                            <a @can("Editar Cancelados") class="dropdown-item btn-edit" @else class="dropdown-item btn-edit disabled" @endcan href="" data-id=' . $row->id . '>
                              <i class="fas fa-pencil-alt text-warning"></i> Editar
                            </a>

                            <div class="dropdown-divider"></div>

                            <a @can("Eliminar Cancelados") class="dropdown-item btn-delete" @else class="dropdown-item btn-delete disabled" @endcan href="" data-id=' . $row->id . '>
                              <i class="fas fa-trash-alt text-danger"></i> Eliminar</a>
                          </div>
          ';
          return $btn;
        })
        // ->order(function ($query) {
        //   if (request()->has('id')) {
        //     $query->orderBy('id', 'desc');
        //   }
        // })
        ->rawColumns(['no_fianza_cheque', 'usuario', 'afianzadora', 'acciones'])
        ->make(true);
      return $x;
    }

    // return view('admin.catalogos.cancelados');
  }

  public function exportaExcel()
  {
    try {
      set_time_limit(240);
      $data = Cancelado::with('afianzadora', 'fianza_cheque', 'user')->get();
      $dataExcel = $data->map(function ($item) {
        return [
          'id' => $item->id,
          'oficio' => $item->oficio,
          'fecha_oficio' => $item->fecha_oficio,
          'fecha_cancelacion' => $item->fecha_cancelacion,
          'afianzadora' => $item->afianzadora->nombre ?? '',
          'fianza_cheque' => $item->fianza_cheque->no_fianza_cheque ?? '',
          'fianza_cheque_vencimiento' => $item->fianza_cheque->fecha_vencimiento ?? '',
          'user' => $item->user->name ?? '',
        ];
      });
      $headers = [
        'Id',
        'Oficio',
        'Fecha Oficio',
        'Fecha Cancelacion',
        'Afianzadora',
        'Fianza Cheque',
        'Fianza Cheque Vencimiento',
        'Usuario que cancelo',
      ];
      return Excel::download(new exportaExcel($dataExcel, $headers), 'Cancelados.xlsx');
    } catch (\Exception $e) {
      Log::error($e->getMessage());
      return response()->json(['error' => 'Error al exportar el excel'], 500);
    }
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    $request->validate([
      'fecha_cancelacion' => 'required',
      'oficio' => 'required',
      'fianza_cheque' => 'required',
      'fecha_cancelacion' => 'required',
      'fecha_oficio' => 'required',
    ], $customMessages);
    try {
      DB::beginTransaction();
      Fianza_cheque::where('id', $request->fianza_cheque)->update(['estatus_id' => 1]);
      $idAfianzadora = Fianza_cheque::where('id', $request->fianza_cheque)->first();
      Cancelado::create([
        'oficio' => $request->oficio,
        'fecha_oficio' => $request->fecha_oficio,
        'fianza_cheque_id' => $request->fianza_cheque,
        'fecha_cancelacion' => $request->fecha_cancelacion,
        'users_id' => $request->users_id,
        'afianzadoras_id' => $idAfianzadora->afianzadoras_id ?? null,
      ]);
      DB::commit();
      $returnData = array(
        'status' => 'success',
        'title' => 'Éxito',
        'message' => 'Operacion realizada con exito'
      );
      return response()->json($returnData);
    } catch (\Throwable $th) {
      Log::debug($th);
      DB::rollBack();
      $returnData = array(
        'status' => 'error',
        'title' => 'Error',
        'message' => 'Hubo un error, no se pudo crear la cancelación.'
      );

      return response()->json($returnData);
    }
  }

  public function update(Request $request)
  {
    $customMessages = [
      'required' => 'El campo no puede ir vacio',
    ];

    $request->validate([
      'fecha_cancelacion' => 'required',
      'oficio' => 'required',
      'fianza_cheque' => 'required',
      'fecha_cancelacion' => 'required',
      'fecha_oficio' => 'required',
    ], $customMessages);
    try {
      DB::beginTransaction();
      Fianza_cheque::where('id', $request->fianza_cheque)->update(['estatus_id' => 1]);
      $idAfianzadora = Fianza_cheque::where('id', $request->fianza_cheque)->first();
      $id = $request->id;
      Cancelado::where('id', $id)->update([
        'oficio' => $request->oficio,
        'fecha_oficio' => $request->fecha_oficio,
        'fianza_cheque_id' => $request->fianza_cheque,
        'fecha_cancelacion' => $request->fecha_cancelacion,
        'users_id' => $request->users_id,
        'afianzadoras_id' => $idAfianzadora->afianzadoras_id ?? null,
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
        'message' => 'Hubo un error, no se pudo actualizar la cancelación.'
      );

      return response($returnData);
    }
  }

  public function destroy($id)
  {
    $cancelado = Cancelado::find($id);
    $cancelado->delete();

    return redirect()->route('cancelados');
  }

  public function cambio_fianza(Request $request){
    $fianza = $request->fianza;

    if ($fianza !== null) {
      $afianzadora = DB::table('fianza_cheques')
        ->select('af.id')
        ->where('fianza_cheques.id', $fianza)
        ->leftJoin('afianzadoras as af', 'fianza_cheques.afianzadoras_id', '=', 'af.id')
        ->first();

      return response()->json(["afianzadora" => $afianzadora->id]);
    }
  }

  public function fecha_actual(){

    $fecha = Carbon::now();
    $fechaActual = $fecha->format('Y-m-d');

    return response()->json([
      "fechaActual" => $fechaActual,
    ]);
  }

  public function busqueda_fianza(Request $request)
  {
    $fianza = $request->searchFianza;
    $fianza_cheque = Fianza_cheque::select('id', 'no_fianza_cheque as text')
      ->where('no_fianza_cheque', 'LIKE', '%' . $fianza . '%')
      ->where('estatus_id', '!=', 1)
      ->get();
    return response()->json(["fianza_cheque" => $fianza_cheque]);
  }
}
