<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class HelpController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    public function help()
    {
  
        return view('help/help');
    }
    public function about()
    {
        return response()->json([
            'view' => view('help/about')->render()
        ]);
        // return view('help/about');
    }
    public function credit()
    {
        return response()->json([
            'view' => view('help/credit')->render()
        ]);
        // return view('help/credit');
    }

    public function started()
    {
        return view('help/started');
    }

    public function kpis()
    {
        return view('help/kpis');
    }

    public function admin()
    {
        return view('help/admin');
    }

    public function users()
    {
        return view('help/users');
    }

    public function download($lang, $archivo)
    {
        $destinationPath = "app/public/help/".$lang."/".$archivo;
        // echo $destinationPath;
        if (Storage::disk('help')->exists($lang."/".$archivo))
        {

            return response()->download(storage_path($destinationPath));
        }
    }


}
