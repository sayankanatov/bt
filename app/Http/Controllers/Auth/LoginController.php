<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated()
    {
        if(auth()->user()->hasRole('admin')){

            return redirect('/admin/dashboard');

        }elseif(auth()->user()->hasRole('Менеджер')){
            
            return redirect('/manager');
        }
        return redirect('/account');
    }

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            
            return ['number'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }
}
