<?php

namespace App\Http\Controllers\Integridade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IntegridadeController extends Controller
{
    public function index()
    {
        return view('integridade.index', [
            'title' => 'Integridade — SisGovernança'
        ]);
    }
}