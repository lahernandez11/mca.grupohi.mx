<?php

namespace App\Http\Controllers;

use App\Models\Telefono;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class TelefonosController extends Controller
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
        $telefonos = Telefono::Activos()->get();
        return view('telefonos.index')
            ->withTelefonos($telefonos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('telefonos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'imei' => 'required|unique:sca.telefonos,imei',
            'linea' => 'required|unique:sca.telefonos,linea'
        ]);
        
        Telefono::create([
            'imei' => $request->imei,
            'linea' => $request->linea,
            'registro' => auth()->user()->idusuario,
        ]);
        
        Flash::success('¡TELÉFONO CREADO CORRECTAMENTE!');
        return redirect()->route('telefonos.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $telefono = Telefono::find($id);
        return view('telefonos.show')->withTelefono($telefono);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $telefono = Telefono::find($id);
        return view('telefonos.edit')->withTelefono($telefono);
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
        $this->validate($request, [
            'imei' => 'required|unique:sca.telefonos,imei,'.$request->route('telefonos').',id',
            'linea' => 'required|unique:sca.telefonos,linea,'.$request->route('telefonos').',id',
        ]);

        $telefono = Telefono::find($id);
        $telefono->update($request->all());

        Flash::success('¡TELÉFONO ACTUALIZADO CORRECTAMENTE!');
        return redirect()->route('telefonos.show', $telefono);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $telefono = Telefono::find($id);
        $telefono->update([
            'estatus'  => 0,
            'elimino' => auth()->user()->idusuario,
            'motivo'  => $request->motivo
        ]);

        Flash::success('¡TELÉFONO ELIMINADO CORRECTAMENTE!');
        return redirect()->back();
    }
}