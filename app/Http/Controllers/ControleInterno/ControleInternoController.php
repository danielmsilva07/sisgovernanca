<?php

namespace App\Http\Controllers\ControleInterno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControleInternoController extends Controller
{
    public function index()
    {
        return view('controle-interno.index', [
            'title' => 'Controle Interno — SisGovernança'
        ]);
    }
}