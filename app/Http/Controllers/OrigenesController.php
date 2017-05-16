<?php

namespace App\Http\Controllers;

use App\Models\Transformers\OrigenTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
USE Laracasts\Flash\Flash;
use App\Models\Origen;
use App\Models\TipoOrigen;
use App\Models\ProyectoLocal;
use Carbon\Carbon;


class OrigenesController extends Controller
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
    public function index(Request $request)
    {
        if($request->ajax()) {
            return response()->json(Origen::with('tiros')->get()->toArray());
        }
        return view('origenes.index')
                ->withOrigenes(Origen::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('origenes.create')
                ->withTipos(TipoOrigen::all()->lists('Descripcion', 'IdTipoOrigen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateOrigenRequest $request)
    {
        $proyecto_local = ProyectoLocal::where('IdProyectoGlobal', '=', $request->session()->get('id'))->first();
        
        $request->request->add(['IdProyecto' => $proyecto_local->IdProyecto]);
        $request->request->add(['FechaAlta' => Carbon::now()->toDateString()]);
        $request->request->add(['HoraAlta' => Carbon::now()->toTimeString()]);
      
        $origen = Origen::create($request->all());

        Flash::success('¡ORIGEN REGISTRADO CORRECTAMENTE!');
        return redirect()->route('origenes.show', $origen);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('origenes.show')
                ->withOrigen(Origen::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('origenes.edit')
                ->withOrigen(Origen::findOrFail($id))
                ->withTipos(TipoOrigen::all()->lists('Descripcion', 'IdTipoOrigen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\EditOrigenRequest $request, $id)
    {
        $origen = Origen::findOrFail($id);
        $origen->update($request->all());
        
        Flash::success('¡ORIGEN ACTUALIZADO CORRECTAMENTE!');
        return redirect()->route('origenes.show', $origen);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {

        $origen = Origen::find($id);
        if($origen->Estatus == 1) {
            $origen->update([
                'Estatus'  => 0,
                'usuario_desactivo' => auth()->user()->idusuario,
                'motivo'  => $request->motivo
            ]);
            Flash::success('¡ORIGEN ELIMINADO CORRECTAMENTE!');
        } else {
            $origen->update([
                'Estatus'  => 1,
                'usuario_desactivo' => auth()->user()->idusuario,
                'motivo'  => null
            ]);
            Flash::success('¡ORIGEN ACTIVADO CORRECTAMENTE!');
        }

        return redirect()->back();

    }
}
