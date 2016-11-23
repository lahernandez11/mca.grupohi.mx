<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    function __construct() {
        
        $this->middleware('auth');
        
        parent::__construct();
    }
    
    public function home() {
        return view('pages.home');
    }
    
    public function proyectos() {
        $proyectos = Auth::user()->proyectos()->paginate(15);
        return view('pages.proyectos')->withProyectos($proyectos);
    }
}