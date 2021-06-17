<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class AuditlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
        $audit_log = $this->getFromApi('GET', 'audit_log');

      
        return view('audit_log/index', [
            'audit_log' => $audit_log
        ]);
    }

  

    
}
