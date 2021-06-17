<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    public function index()
    {
        return view('test/index');
    }

    public function index2()
    {
        return view('test/index2');
    }
}
