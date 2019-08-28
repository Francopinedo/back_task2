<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use App\RoleUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     */
    protected function redirectTo()
	{
	    $id = Auth::id();

	    $roleUser = RoleUser::where('user_id', $id)->first();

	    // redirijo si es admin
	    if ($roleUser && $roleUser->role_id == 1)
	    {
	    	return '/dashboard';
	    }
	    elseif($roleUser && $roleUser->role_id == 2)
	    {
	    	return '/dashboard';
	    }
	    else
	    {
	    	return '/dashboard';
	    }
	}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
