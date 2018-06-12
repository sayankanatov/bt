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
            # code...
            return redirect('/admin/dashboard');

        }elseif(auth()->user()->hasRole('Менеджер')){
            # code...
            return redirect('/manager');

        }elseif (auth()->user()->hasRole('Координатор')) {
            # code...
            return redirect('/account');
        }
        return redirect('/');
        
    }

    protected function credentials(Request $request)
    {
        if(filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)){

            return $request->only($this->username(), 'password');

        }elseif(is_string($request->get('email')) ) {

            return [
                'name' => $request->get('email'),
                'password' => $request->get('password')
            ];

        }else {

            return [
                'number' => $request->get('email'),
                'password' => $request->get('password')
            ];
        }
    }
}
