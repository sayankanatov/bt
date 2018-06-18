<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use DB;
use Config;

use App\Models\KinderGarten;
use App\Models\KinderGartenUser;
use App\Models\KinderGartenCity;
use App\Models\RoleUser;
use App\Models\Role;
use App\Models\CityUser;
use App\Models\City;
use App\User;

use App\Mail\Manager;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //Ссылки в меню координатора
        $kindergarten_link = '/account/kindergarten';
        $report_link = '/account/report';

        return view('account.account',compact('kindergarten_link','report_link'));
    }

    public function kinder(Request $request)
    {
        //При создании детсада, выбираем принадлежность его к городу
        $city = CityUser::where('user_id',\Auth::user()->id)->pluck('city_id');

        //Создаем обьект детсада
        $kindergarten = new KinderGarten();
        $kindergarten->name = $request->input('kindergarten_name');
        $kindergarten->num = $request->input('kindergarten_number');
        if(!empty($kindergarten->name)){
            $kindergarten->save();
            //Устанавливаем детсаду принадлежность к городу
            $kindergarten->city()->attach($city);

            \Session::flash('message', 'Successfully created!');
        }

        // Выбираем детсад к которому будет относиться новый юзер
        $kindergarten_select = KinderGarten::where('name',$request->input('kindergarten_name'))->first();

        //Создаем обьект юзера
        $user = new User();
        $user->name = City::where('id',$city)->pluck('description')->first().$kindergarten->num;
        $user->email = $request->input('email');
        $password = str_random(8);
        $user->password = Hash::make($password);
        // $user->number = $request->input('tel');
        if(!empty($user->email)){
            $user->save();
            //Устанавливаем юзеру роль "Менеджер"
            $user->role()->attach(Config::get('constants.roles.manager'));
            // Отправляем на почту юзеру письмо
            $obj = new \stdClass();
            $obj->name = $user->name;
            $obj->email = $user->email;
            $obj->password = $password;
            // $obj->number = $user->number;

            Mail::to($user->email)->send(new Manager($obj));
        }

        //Устанавливаем сад к данному юзеру
        $user->kindergarten()->attach($kindergarten_select);

        //Выбираем все детсады
        if(isset($city)){
            $kinder_array = KinderGartenCity::where('city_id',$city)->pluck('kindergarten_id');
        }
        if(!empty($kinder_array)){
            $kindergartens = KinderGarten::whereIn('id',$kinder_array)->paginate(Config::get('constants.paginate.kindergarten'));
        }

        //Джоиним четыре модели для выборки менеджеров детсадов
        $managers = DB::table('users')
                    ->select('users.name','users.number','kindergartens.id','users.email')
                    ->join('kindergarten_users','kindergarten_users.user_id','=','users.id')
                    ->join('kindergartens','kindergartens.id','=','kindergarten_users.kindergarten_id')
                    ->join('role_users','role_users.user_id','=','users.id')
                    ->where('role_users.role_id',Config::get('constants.roles.manager'))
                    ->whereIn('kindergartens.id',$kinder_array)
                    ->get();

        return view('account.kinder',compact(
            'kindergartens',
            'users',
            'managers'
        ));
    }

    // edit kindergarten
    public function edit($id)
    {
        $kindergarten = KinderGarten::find($id);

        return view('account.edit',compact('kindergarten'));
    }

    public function update(Request $request, $id)
    {
         // get the kindergarten
        $kindergarten = KinderGarten::find($id);
        $kindergarten->name = $request->get('KindergartenName');
        $kindergarten->num = $request->input('num');

        $kindergarten->save();

        \Session::flash('message', 'Successfully updated!');

        return \Redirect('account/kindergarten');
    }

    // delete item
    public function destroy($id)
    {
        // delete
        $kindergarten = KinderGarten::find($id);
        $kindergarten->delete();
        
        \Session::flash('message', 'Successfully deleted!');
        // redirect
        return \Redirect::to('account/kindergarten');
    }

    // метод show нужен для реализации, но не функционирует на данный момент
    
    public function show($id)
    {
        // show
        $kindergarten = KinderGarten::find($id);

        return view('account.show',compact('kindergarten'));
    }
}
