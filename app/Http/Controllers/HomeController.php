<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KinderGarten;
use App\Models\KinderGartenUser;
use App\Models\RoleUser;
use App\Models\Role;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        return view('welcome',compact(''));
    }

    public function test(Request $request)
    {
        //При создании детсада, выбираем принадлежность его к городу
        $city = CityUser::where('user_id',\Auth::user()->id)->pluck('city_id');

        //Создаем обьект детсада
        $kindergarten = new KinderGarten();
        $kindergarten->name = $request->input('name');
        if(!empty($kindergarten->name)){
            $kindergarten->save();
            //Устанавливаем детсаду принадлежность к городу
            $kindergarten->city()->attach($city);
        }
        //Выбираем все детсады
        $kinder_array = KinderGartenCity::where('city_id',$city)->pluck('kindergarten_id');
        $kindergartens = KinderGarten::whereIn('id',$kinder_array)->get();

        // Делаем выборку для соединения внешних ключей
        $kindergarten_select = KinderGarten::where('id',$request->kindergarten_select)->first();

        //Создаем обьект юзера
        $user = new User();
        $user->name = $request->input('username');
        $user->email = $request->input('email');
        $user->password = \Hash::make($request->input('password'));
        $user->number = $request->input('tel');
        if(!empty($user->email)){
            $user->save();
            //Устанавливаем юзеру роль "Менеджер"
            $user->role()->attach(3);
        }

        //Соединяем все модели по внешним ключам
        $user->kindergarten()->attach($kindergarten_select);

        //Создаем переменную для проверки в шаблоне
        $kindergarten_users = KinderGartenUser::all();

        //Юзеры с ролью Менеджер
        $user_roles = RoleUser::where('role_id',3)->get();

        // return view('test',compact('kindergartens','users','kindergarten_users','user_roles'));
    }


    public function tets(){
        
        $client = new \GuzzleHttp\Client(['verify' => false]);
        $api_call = $client->get('https://data.egov.kz/api/v2/s_pb/data');
        $api_response = json_decode($api_call->getBody());

        // dd($api_response);

        return view('test');
    }
}
