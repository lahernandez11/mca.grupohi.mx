<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Camion;
use App\Models\Sindicato;
use App\Models\Operador;
use App\Models\Marca;
use App\Models\Boton;
use App\Models\ProyectoLocal;
use Carbon\Carbon;
use App\Models\ImagenCamion;
use Laracasts\Flash\Flash;

class CamionesController extends Controller
{
    
    function __construct() {
        $this->middleware('auth');
        $this->middleware('context');
       
        parent::__construct();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('camiones.index')
                ->withCamiones(Camion::paginate(50));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('camiones.create')
                ->withSindicatos(Sindicato::all()->lists('Descripcion', 'IdSindicato'))
                ->withOperadores(Operador::all()->lists('Nombre', 'IdOperador'))
                ->withMarcas(Marca::all()->lists('Descripcion', 'IdMarca'))
                ->withBotones(Boton::all()->lists('Identificador', 'IdBoton'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateCamionRequest $request)
    {
        $proyecto_local = ProyectoLocal::where('IdProyectoGlobal', '=', $request->session()->get('id'))->first();
        $request->request->add(['IdProyecto' => $proyecto_local->IdProyecto]);
        $request->request->add(['FechaAlta' => Carbon::now()->toDateString()]);
        $request->request->add(['HoraAlta' => Carbon::now()->toTimeString()]);
        
        $camion = Camion::create($request->all());
        
        foreach($request->file() as $key => $file) {
            $tipo = $key == 'Frente' ? 'f' : ($key == 'Derecha' ? 'd' : ($key == 'Atras' ? 't' : ($key == 'Izquierda' ? 'i' : '')));
            $imagen = new ImagenCamion();
            $nombre = $imagen->creaNombre($file, $camion, $key);
            $file->move($imagen->baseDir(), $nombre);
            $imagen->IdCamion = $camion->IdCamion;
            $imagen->TipoC = $tipo;
            $imagen->Tipo = $file->getClientMimeType();
            $imagen->Ruta = $imagen->baseDir().'/'.$nombre;
            $imagen->save();
        }
        
        Flash::success('¡CAMIÓN REGISTRADO CORRECTAMENTE!');
        return redirect()->route('camiones.show', $camion);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('camiones.show')
                ->withCamion(Camion::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
