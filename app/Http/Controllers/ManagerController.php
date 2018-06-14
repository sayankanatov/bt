<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use Illuminate\Database\QueryException;

use App\Models\KinderGarten;
use App\Models\KinderGartenUser;
use App\Models\KinderGartenType;
use App\Models\KinderGartenLang;
use App\Models\Bank;
use App\Models\City;
use App\Models\Role;
use App\Models\Client;
use App\Models\GroupCategory;
use App\Models\Group;
use App\Models\Children;
use DB;
use Config;

class ManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Home Page for Manager Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ссылки на меню менеджера
        $general_info_link = '/manager/general';
        $roles_link = '/manager/roles';
        $user_base_link = '/manager/childrens';

        return view('manager.index',compact(
            'general_info_link',
            'roles_link',
            'user_base_link'
        ));
    }

    public function general()
    {
        //
        $worktime_start = array(
            '07:00:00' => '07:00',
            '08:00:00' => '08:00',
            '09:00:00' => '09:00',
            '10:00:00' => '10:00',
        );
        $worktime_end = array(
            '16:00:00' => '16:00',
            '17:00:00' => '17:00',
            '18:00:00' => '18:00',
            '19:00:00' => '19:00',
            '20:00:00' => '20:00',
            '21:00:00' => '21:00',
        );
        $child_reception = array(
            '08:00:00' => '08:00',
            '09:00:00' => '09:00',
        );

        $categories = array('ГККП' => 'ГККП','КГКП' => 'КГКП');

        //get kindergarten
        $kindergarten = DB::table('kindergartens')
                        ->select('kindergartens.name','kindergartens.category','kindergartens.num','kindergartens.telephone','users.email','kindergarten_users.kindergarten_id','cities.description','cities.region_ru','cities.tel_code')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->join('users','users.id','=','kindergarten_users.user_id')
                        ->join('kindergarten_cities','kindergarten_cities.kindergarten_id','=','kindergartens.id')
                        ->join('cities','cities.id','=','kindergarten_cities.city_id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();

        // dd($kindergarten);

        //get variables
        $kindergarten_types = KinderGartenType::all();
        $banks = Bank::all();
        $kindergarten_langs = KinderGartenLang::all();
        // 
        $kinder_info = KinderGarten::where('id',$kindergarten->kindergarten_id)->first();

        return view('manager.general',compact('kindergarten', 'kindergarten_types', 'banks', 'kindergarten_langs', 'worktime_start','worktime_end','child_reception','kinder_info','categories'));
    }

    public function storeGeneral(Request $request){

        //get our kindergarten
        $kindergarten = DB::table('kindergartens')
                        ->select('kindergarten_users.kindergarten_id')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->join('users','users.id','=','kindergarten_users.user_id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();

        //получаем детсад для редактирования
        $kinder_info = KinderGarten::where('id',$kindergarten->kindergarten_id)->first();
        $kinder_info->type = $request->get('kindergarten_types');
        //Скрыто в связи с неактуальностью
        // $kinder_info->iik = $request->input('iik');
        // $kinder_info->bank = $request->get('bank');
        // $kinder_info->bik = $request->input('bik');
        // $kinder_info->bin = $request->input('bin');
        $kinder_info->category = $request->get('kindergarten_category');
        $kinder_info->region = $request->input('region');
        $kinder_info->city = $request->get('city');
        $kinder_info->address = $request->input('address');
        $kinder_info->lang = $request->get('lang');

        if(strlen($request->input('telephone')) == Config::get('constants.length.telephone')){
            $kinder_info->telephone = $request->input('telephone');
        }else {
            \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
            return \Redirect('manager/general');
        }
        
        $kinder_info->email = $request->input('email');
        $kinder_info->worktime_start = $request->get('worktime_start');
        $kinder_info->worktime_end = $request->get('worktime_end');
        $kinder_info->child_reception = $request->get('child_reception');
        $kinder_info->group_count = $request->input('group_count');
        $kinder_info->project_capacity = $request->input('project_capacity');
        $kinder_info->save();

        \Session::flash('message', 'Successfully updated general information!');

        return \Redirect('manager/general');
    }

    public function roles(){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();
        //Получаем заведующего
        $deputy = DB::table('clients')
                    ->select('clients.name','clients.telephone','clients.role_name','roles.description')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->join('roles','roles.id','=','role_clients.role_id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.deputy'))
                    ->first();
        //Получаем методиста
        $methodist = DB::table('clients')
                    ->select('clients.name','clients.telephone','clients.role_name','roles.description')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->join('roles','roles.id','=','role_clients.role_id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.methodist'))
                    ->first();
        //Получаем медсестру
        $nurse = DB::table('clients')
                    ->select('clients.name','clients.telephone','clients.role_name','roles.description')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->join('roles','roles.id','=','role_clients.role_id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.nurse'))
                    ->first();
        //Получаем бухгалтера
        $accountant = DB::table('clients')
                    ->select('clients.name','clients.telephone','clients.role_name','roles.description')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->join('roles','roles.id','=','role_clients.role_id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.accountant'))
                    ->first();
        //Получаем кладовщика
        $storekeeper = DB::table('clients')
                    ->select('clients.name','clients.telephone','clients.role_name','roles.description')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->join('roles','roles.id','=','role_clients.role_id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.storekeeper'))
                    ->first();
        //Получаем воспитателя
        $mentor = DB::table('clients')
                    ->select('clients.name','clients.telephone','clients.role_name','roles.description')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->join('roles','roles.id','=','role_clients.role_id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                    ->first();
        // Получаем всех воспитателей
        $mentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('roles','roles.id','=','role_clients.role_id')
                ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->get();
        // dd($mentors);

        return view('manager.roles',compact('deputy','methodist','nurse','accountant','storekeeper','mentors'));
    }

    public function storeRoles(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();
        //Получаем заведующего
        $deputy = DB::table('clients')
                    ->select('*')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.deputy'))
                    ->first();
        //Получаем методиста
        $methodist = DB::table('clients')
                    ->select('*')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.methodist'))
                    ->first();
        //Получаем медсестру
        $nurse = DB::table('clients')
                    ->select('*')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.nurse'))
                    ->first();
        //Получаем бухгалтера
        $accountant = DB::table('clients')
                    ->select('*')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.accountant'))
                    ->first();
        //Получаем кладовщика
        $storekeeper = DB::table('clients')
                    ->select('*')
                    ->join('role_clients','role_clients.client_id','=','clients.id')
                    ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                    ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                    ->where('role_clients.role_id',Config::get('constants.roles.storekeeper'))
                    ->first();
        //Получаем всех воспитателей
        $mentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('roles','roles.id','=','role_clients.role_id')
                ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->get();
        //Если есть request и нет заведущего то создаем его, иначе редактируем существующего
        // По аналогии создаем или редактируем остальных участников
        if($request->input('tel1') && !$deputy){
            $client = new Client();
            
            if(strlen($request->input('tel1')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel1');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio1'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name1'),MB_CASE_TITLE,"UTF-8");
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль Заведующий
            $client->role()->attach(Config::get('constants.roles.deputy'));

        }elseif(isset($deputy) && $request->input('tel1')) {
            $client = Client::where('id',$deputy->client_id)->first();

            if(strlen($request->input('tel1')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel1');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio1'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name1'),MB_CASE_TITLE,"UTF-8");
            $client->save();
        }

        if($request->input('tel2') && !$methodist){
            $client = new Client();
            
            if(strlen($request->input('tel2')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel2');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio2'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name2'),MB_CASE_TITLE,"UTF-8");
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.methodist'));

        }elseif(isset($methodist) && $request->input('tel2')){
            $client = Client::where('id',$methodist->client_id)->first();

            if(strlen($request->input('tel2')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel2');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio2'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name2'),MB_CASE_TITLE,"UTF-8");
            $client->save();
        }

        if($request->input('tel3') && !$nurse){
            $client = new Client();
            
            if(strlen($request->input('tel3')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel3');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio3'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name3'),MB_CASE_TITLE,"UTF-8");
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.nurse'));

        }elseif(isset($nurse) && $request->input('tel3')){
            $client = Client::where('id',$nurse->client_id)->first();

            if(strlen($request->input('tel3')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel3');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }
            
            $client->name = mb_convert_case($request->input('fio3'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name3'),MB_CASE_TITLE,"UTF-8");
            $client->save();
        }

        if($request->input('tel4') && !$accountant){
            $client = new Client();

            if(strlen($request->input('tel4')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel4');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio4'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name4'),MB_CASE_TITLE,"UTF-8");
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.accountant'));

        }elseif(isset($accountant) && $request->input('tel4')){
            $client = Client::where('id',$accountant->client_id)->first();

            if(strlen($request->input('tel4')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel4');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->telephone = $request->input('tel4');
            $client->name = mb_convert_case($request->input('fio4'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name4'),MB_CASE_TITLE,"UTF-8");
            $client->save();
        }

        if($request->input('tel5') && !$storekeeper){
            $client = new Client();

            if(strlen($request->input('tel5')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel5');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio5'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name5'),MB_CASE_TITLE,"UTF-8");
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.storekeeper'));

        }elseif(isset($storekeeper) && $request->input('tel5')) {
            $client = Client::where('id',$storekeeper->client_id)->first();

            if(strlen($request->input('tel5')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel5');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->telephone = $request->input('tel5');
            $client->name = mb_convert_case($request->input('fio5'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name5'),MB_CASE_TITLE,"UTF-8");
            $client->save();
        }
        // Создаем первого воспитателя
        if($request->input('tel6')){
            $client = new Client();

            if(strlen($request->input('tel6')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel6');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $client->name = mb_convert_case($request->input('fio6'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = mb_convert_case($request->input('role_name6'),MB_CASE_TITLE,"UTF-8");
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.mentor'));
        }
        // Создаем остальных воспитателей
        if($request->input('mentor_tel')){
            $mentor = new Client();
            $mentor->name = mb_convert_case($request->input('mentor_fio'),MB_CASE_TITLE,"UTF-8");

            if(strlen($request->input('mentor_tel')) == Config::get('constants.length.telephone')){
                $mentor->telephone = $request->input('mentor_tel');
            }else {
               \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
            }

            $mentor->save();
            $mentor->kindergarten()->attach($kindergarten->id);
            $mentor->role()->attach(Config::get('constants.roles.mentor'));
        }
        // Редактируем всех воспитателей внутри foreach
        foreach ($mentors as $mentor) {
            # code...
            if($request->input('mentortel_'.$mentor->id)){
                $exist_mentor = Client::where('id',$mentor->id)->first();

                if(strlen($request->input('mentortel_'.$mentor->id)) == Config::get('constants.length.telephone')){
                    $exist_mentor->telephone = $request->input('mentortel_'.$mentor->id);
                }else {
                \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/roles');
                }
                
                $exist_mentor->name = mb_convert_case($request->input('mentorfio_'.$mentor->id),MB_CASE_TITLE,"UTF-8");
                $exist_mentor->save();
            }
        }

        \Session::flash('message', 'Successfully updated roles!');

        return \Redirect('manager/roles'); 
    }

/**
* Display childrens in all groups for adding and updating
**/ 
    public function childrens(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();

        $groups = Group::where('kindergarten_id',$kindergarten->id)->get();

        //Вывод для каждой группы флэш сообщения о необходимом количестве детей
        
        // dd($groups);
        $getGroup = Group::where('id',$request->input('group_id'))->first();

        if($request->has('child-submit')){
            
            $parent = new Client();
            //Скрыто в связи с неактуальностью
            // $parent->name = mb_convert_case($request->input('parent_name'),MB_CASE_TITLE,"UTF-8");

            if(strlen($request->input('parent_telephone')) == Config::get('constants.length.telephone')){
                $parent->telephone = $request->input('parent_telephone');
            }else {
                \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                return \Redirect('manager/childrens');
            }

            // $parent->telephone = $request->input('parent_telephone');
            $parent->role_name = 'Родитель';
            $parent->save();
            $parent->role()->attach(Config::get('constants.roles.parent'));

            $children = new Children();
            $children->name = mb_convert_case($request->input('children_name'),MB_CASE_TITLE,"UTF-8");
            $children->is_contract = $request->input('is_contract');
            //Скрыто в связи с неактуальностью
            // $children->iin = $request->input('children_iin');
            $children->group()->associate($getGroup->id);

            $getParent = Client::where('telephone',$request->input('parent_telephone'))->first();
            $children->parent()->associate($getParent->id);
            
            $children->save();

            \Session::flash('message', 'Child successfully created!');
        }
        
        // dd($groups);

        return view('manager.childrens',compact('groups'));
    }

/*
* Edit child
*
*/
    public function editChild($id){

        $children = Children::find($id);
        // dd($children);
        $parents = Client::where('id',$children->client_id)->get();

        return view('manager.edit_child',compact('children','parents'));
    }

/*
* Update child
*
*/
    public function updateChild(Request $request, $id){

        // get the children and his parents
        try{
            $children = Children::find($id);
            $children->name = mb_convert_case($request->input('child_name'),MB_CASE_TITLE,"UTF-8" );
            //Скрыто в связи с неактуальностью
            // $children->iin = $request->input('child_iin');
            if($children->name !== ''){
                $children->save();
            }else {
                \Session::flash('oops', 'Sorry something went wrong. Please fill fields!');
                return \Redirect('manager/childrens/'.$children->id);
            }
            
            $parents = Client::where('id',$children->client_id)->get();

            foreach ($parents as $key => $parent) {
                # code...
                //Скрыто в связи с неактуальностью
                // $parent->name = mb_convert_case($request->input('parent_name'.$parent->id),MB_CASE_TITLE,"UTF-8" );

                if(strlen($request->input('parent_telephone'.$parent->id)) == Config::get('constants.length.telephone')){
                    $parent->telephone = $request->input('parent_telephone'.$parent->id);
                }else {
                    \Session::flash('oops', 'Sorry something went wrong. Please fill number correctly!');
                    return \Redirect('manager/childrens/'.$children->id);
                }
                
                if($parent->name !== ''){
                    $parent->save();   
                }else {
                    \Session::flash('oops', 'Sorry something went wrong. Please fill fields!');
                    return \Redirect('manager/childrens/'.$children->id);
                }
            }
            // $request->validate([
            //     'telephone' => 'numeric|min:10',
            // ]);

        }catch(QueryException $e){
            \Session::flash('oops', 'Sorry something went wrong. Please fill fields!');
            return \Redirect('manager/childrens/'.$children->id);
        }
        

        \Session::flash('message', 'Successfully updated!');

        return \Redirect('manager/childrens');
    }

}
