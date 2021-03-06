<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Laracasts\Flash\Flash;
use Carbon\Carbon;
use App\Models\Ruta;
use App\Models\Origen;
use App\Models\Tiro;
use App\Models\TipoRuta;
use App\Models\Cronometria;
use App\Models\ArchivoRuta;

class RutasController extends Controller
{
    
    function __construct() {
        $this->middleware('auth');
        $this->middleware('context');
        $this->middleware('permission:desactivar-rutas', ['only' => ['destroy']]);
        $this->middleware('permission:crear-rutas', ['only' => ['create', 'store']]);

        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return response()->json(Ruta::where([
                'IdOrigen' => $request->get('IdOrigen'),
                'IdTiro' => $request->get('IdTiro')
            ])->get()->toArray());
        } else {
            return view('rutas.index')
                ->withRutas(Ruta::all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rutas.create')
                ->withOrigenes(Origen::all()->lists('Descripcion', 'IdOrigen'))
                ->withTiros(Tiro::all()->lists('Descripcion', 'IdTiro'))
                ->withTipos(TipoRuta::all()->lists('Descripcion', 'IdTipoRuta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\CreateRutaRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateRutaRequest $request)
    {
        $request->request->add(['IdProyecto' => $request->session()->get('id')]);
        $request->request->add(['usuario_registro' => auth()->user()->idusuario]);

        if($existe = Ruta::where($request->only(['IdOrigen', 'IdTiro']))->first()) {
            $errors = ['Ya existe una ruta para el Origen y Tiro seleccionados'];
            return redirect()->back()->withErrors($errors);
        }
        $ruta = Ruta::create($request->all());
        
        $cronometria = new Cronometria();
        $cronometria->IdRuta = $ruta->IdRuta;
        $cronometria->TiempoMinimo = $request->get('TiempoMinimo');
        $cronometria->Tolerancia = $request->get('Tolerancia');
        $cronometria->FechaAlta = Carbon::now()->toDateString();
        $cronometria->HoraAlta = Carbon::now()->toTimeString();
        $cronometria->Registra = auth()->user()->idusuario;
        $cronometria->save();
                
        if($request->hasFile('Croquis')) {
            $croquis = $request->file('Croquis');
            $archivo = new ArchivoRuta();
            $nombre = $archivo->creaNombre($croquis, $ruta);
            $croquis->move($archivo->baseDir(), $nombre);
            $archivo->IdRuta = $ruta->IdRuta;
            $archivo->Tipo = $croquis->getClientMimeType();
            $archivo->Ruta = $archivo->baseDir().'/'.$nombre;
            $archivo->save();
        }

        Flash::success('¡RUTA REGISTRADA CORRECTAMENTE!');
        return redirect()->route('rutas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('rutas.show')
                ->withRuta(Ruta::findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $ruta = Ruta::find($id);

        if($ruta->Estatus == 1) {
            $ruta->update([
                'Estatus' => 0,
                'usuario_desactivo' => auth()->user()->idusuario,
                'motivo' => $request->motivo
            ]);

            Flash::success('¡RUTA DESACTIVADA CORRECTAMENTE!');
        } else if($ruta->Estatus == 0) {

            $ruta->update([
                'Estatus' => 1,
                'usuario_desactivo' => null,
                'motivo' => null
            ]);

            Flash::success('¡RUTA ACTIVADA CORRECTAMENTE!');
        }
        return redirect()->back();
    }
}
