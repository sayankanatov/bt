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
use App\Models\Contractor;
use App\Models\Setting;
use App\Models\Food;
use App\Models\KinderGartenFood;
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
        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_users.user_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        // Ссылки на меню менеджера
        $general_info_link = '/manager/general';
        $roles_link = '/manager/roles';
        $groups_link = '/manager/groups';
        $user_base_link = '/manager/childrens';
        $settings_link = '/manager/settings';
        $contractor_link = '/manager/contractors';
        $food_link = '/manager/foods';

        return view('manager.index',compact(
            'general_info_link',
            'roles_link',
            'groups_link',
            'user_base_link',
            'settings_link',
            'right_settings',
            'contractor_link',
            'food_link'
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
             \Session::flash('oops', trans('messages.please_fill_number_correctly'));
            return \Redirect('manager/general');
        }
        
        $kinder_info->email = $request->input('email');
        $kinder_info->worktime_start = $request->get('worktime_start');
        $kinder_info->worktime_end = $request->get('worktime_end');
        $kinder_info->child_reception = $request->get('child_reception');
        $kinder_info->group_count = $request->input('group_count');
        $kinder_info->project_capacity = $request->input('project_capacity');
        $kinder_info->save();

        \Session::flash('message', trans('messages.successfully_updated_general'));

        return \Redirect('manager/general');
    }

    public function roles(){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
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

        return view('manager.roles',compact('methodist','nurse','accountant','storekeeper','mentors'));
    }

    public function storeRoles(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
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
        //Если есть request и нет методиста то создаем его, иначе редактируем существующего
        // По аналогии создаем или редактируем остальных участников

        if($request->input('tel2') && !$methodist){
            $client = new Client();
            
            if(strlen($request->input('tel2')) == Config::get('constants.length.telephone')){
                $client->telephone = $request->input('tel2');
            }else {
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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
                 \Session::flash('oops', trans('messages.please_fill_number_correctly'));
                return \Redirect('manager/roles');
                }
                
                $exist_mentor->name = mb_convert_case($request->input('mentorfio_'.$mentor->id),MB_CASE_TITLE,"UTF-8");
                $exist_mentor->save();
            }
        }

        \Session::flash('message', trans('messages.successfully_updated_roles'));

        return \Redirect('manager/roles'); 
    }


    public function groups(Request $request)
    {

        //get kindergarten
        $kindergarten = DB::table('kindergartens')
            ->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_users.user_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_group_module == 0){
            //get all groups
            $groups = DB::table('groups')->select('*')
                    ->where('groups.kindergarten_id',$kindergarten->id)
                    ->get();
            // dd($groups);

            //get flash message in view
            $result = $kindergarten->group_count - $groups->count();
            $converse_result = $groups->count() - $kindergarten->group_count;

            if($result > 0){

                \Session::flash('warning', trans('messages.you_must_add').' '.$result.' '.trans('messages.group'));

            }elseif($converse_result > 0){

                \Session::flash('warning', trans('messages.you_must_edit_general_info').' '.$converse_result.' '.trans('messages.group'));
            }

            $group_categories = GroupCategory::all();

            $mentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('roles','roles.id','=','role_clients.role_id')
                ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->get();

            //выборка воспитателей стала ограниченной таким образом что воспитатели не могут быть одновременно быть в двух разных группах.

            $existInFirstMentors = DB::table('clients')
                ->select('clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('groups','groups.first_mentor_id','=','clients.id')
                ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->distinct()
                ->pluck('clients.id')
                ->toArray();

            $existInSecondMentors = DB::table('clients')
                ->select('clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('groups','groups.second_mentor_id','=','clients.id')
                ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->distinct()
                ->pluck('clients.id')
                ->toArray();

            $notExistInFirstMentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('roles','roles.id','=','role_clients.role_id')
                ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->whereNotIn('clients.id',$existInFirstMentors)
                ->get();

            $notExistInSecondMentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                 ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                 ->join('roles','roles.id','=','role_clients.role_id')
                 ->where('kindergarten_clients.kindergarten_id',$kindergarten->id)
                 ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                 ->whereNotIn('clients.id',$existInSecondMentors)
                 ->get();
                    
            // dd($notExistInSecondMentors);

            //Создаем группу
            if(!empty($request->input('group_name')) ) {

                $group = new Group();
                $group->title = $request->input('group_name');
                $group->category = $request->get('group_category');
                $group->child_count = $request->get('child_count');
                $group->kindergarten_id = $kindergarten->id;
                $group->first_mentor_id = $request->get('first_mentor');
                $group->second_mentor_id = $request->get('second_mentor');

                $group->save();

                \Session::flash('message', trans('messages.successfully_created_group'));

                if($request->has('add-group-submit')){
                    return \Redirect('manager/groups');
                }
            }

            return view('manager.groups',compact('groups','group_categories','mentors','rows','kindergarten','notExistInFirstMentors','notExistInSecondMentors'));

        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_group'));
            return \Redirect('manager');
        } 
            
        
        
    }

    public function editGroup($id){

        //get group for edit
        $group = Group::find($id);

        $mentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('roles','roles.id','=','role_clients.role_id')
                ->where('kindergarten_clients.kindergarten_id',$group->kindergarten_id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->get();

        $existInFirstMentors = DB::table('clients')
            ->select('clients.id','clients.name')
            ->join('role_clients','role_clients.client_id','=','clients.id')
            ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
            ->join('groups','groups.first_mentor_id','=','clients.id')
            ->where('kindergarten_clients.kindergarten_id',$group->kindergarten_id)
            ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
            ->distinct()
            ->pluck('clients.id')
            ->toArray();

        $existInSecondMentors = DB::table('clients')
            ->select('clients.id')
            ->join('role_clients','role_clients.client_id','=','clients.id')
            ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
            ->join('groups','groups.second_mentor_id','=','clients.id')
            ->where('kindergarten_clients.kindergarten_id',$group->kindergarten_id)
            ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
            ->distinct()
            ->pluck('clients.id')
            ->toArray();

        $notExistInFirstMentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('roles','roles.id','=','role_clients.role_id')
                ->where('kindergarten_clients.kindergarten_id',$group->kindergarten_id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->whereNotIn('clients.id',$existInFirstMentors)
                ->get();

        $notExistInSecondMentors = DB::table('clients')
                ->select('clients.name','clients.telephone','roles.name as role_name','roles.description','clients.id')
                ->join('role_clients','role_clients.client_id','=','clients.id')
                ->join('kindergarten_clients','kindergarten_clients.client_id','=','clients.id')
                ->join('roles','roles.id','=','role_clients.role_id')
                ->where('kindergarten_clients.kindergarten_id',$group->kindergarten_id)
                ->where('role_clients.role_id',Config::get('constants.roles.mentor'))
                ->whereNotIn('clients.id',$existInSecondMentors)
                ->get();

        $group_categories = GroupCategory::all();
        $child_counts = array(0 => 10, 1 => 15, 2 => 20, 3 => 25, 4 => 30, 5 => 35, 6 => 40, 7 => 45, 8 => 50);

        return view('manager.edit-group',compact('group','group_categories','child_counts','notExistInFirstMentors','notExistInSecondMentors','mentors'));
    }

    public function updateGroup(Request $request, $id){

        // get the group for update
        try{
            $group = Group::find($id);
            $group->title = $request->input('group_name');
            $group->category = $request->get('group_category');
            $group->child_count = $request->get('child_count');
            $group->first_mentor_id = $request->get('first_mentor');
            $group->second_mentor_id = $request->get('second_mentor');

            $group->save();

        }catch(QueryException $e){
             \Session::flash('oops', trans('messages.please_fill_fields'));
            return \Redirect('manager/groups/'.$group->id);
        }

        \Session::flash('message', trans('messages.successfully_updated'));

        return \Redirect('manager/groups');
    }

/**
* Display childrens in all groups for adding and updating
**/ 
    public function childrens(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        
        //check setting permissions
        if($right_settings && $right_settings->is_user_module == 0){

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
                    \Session::flash('oops', trans('messages.please_fill_number_correctly'));
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

                \Session::flash('message', trans('messages.child_successfully_created'));
            }
                
            // dd($groups);

            return view('manager.childrens',compact('groups'));

        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_user'));
            return \Redirect('manager');            
        }
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
                 \Session::flash('oops', trans('messages.please_fill_fields'));
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
                     \Session::flash('oops', trans('messages.please_fill_number_correctly'));
                    return \Redirect('manager/childrens/'.$children->id);
                }
                
                if($parent->name !== ''){
                    $parent->save();   
                }else {
                     \Session::flash('oops', trans('messages.please_fill_fields'));
                    return \Redirect('manager/childrens/'.$children->id);
                }
            }
            // $request->validate([
            //     'telephone' => 'numeric|min:10',
            // ]);

        }catch(QueryException $e){
             \Session::flash('oops', trans('messages.please_fill_fields'));
            return \Redirect('manager/childrens/'.$children->id);
        }
        

        \Session::flash('message', trans('messages.successfully_updated'));

        return \Redirect('manager/childrens');
    }

    public function settings() {

        $kindergarten = DB::table('kindergartens')
                        ->select('kindergarten_users.kindergarten_id')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->join('users','users.id','=','kindergarten_users.user_id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();
        $setting = Setting::where('kindergarten_id',$kindergarten->kindergarten_id)->first();

        return view('manager.settings',compact('kindergarten','setting'));
    }

    public function storeSettings(Request $request) {

        //get our kindergarten
        $kindergarten = DB::table('kindergartens')
                        ->select('kindergarten_users.kindergarten_id')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->join('users','users.id','=','kindergarten_users.user_id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();
        $setting = Setting::where('kindergarten_id',$kindergarten->kindergarten_id)->first();
        if($setting){
            $setting->is_group_module = $request->input('is_group_module');
            $setting->is_user_module = $request->input('is_user_module');
            $setting->is_menu_module = $request->input('is_menu_module');
            $setting->is_pp_module = $request->input('is_pp_module');
            $setting->is_prolongation = $request->input('is_prolongation');
            $setting->save();
        }else {
            $settings = new Setting();
            $settings->kindergarten_id = $kindergarten->kindergarten_id;
            $settings->is_group_module = $request->input('is_group_module');
            $settings->is_user_module = $request->input('is_user_module');
            $settings->is_menu_module = $request->input('is_menu_module');
            $settings->is_pp_module = $request->input('is_pp_module');
            $settings->is_prolongation = $request->input('is_prolongation');
            $settings->save();
        }

        \Session::flash('message', trans('messages.successfully_settings_updated'));

        return \Redirect('manager/settings');
    }

    public function contractors(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_users.user_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_pp_module == 0){

            $contractors = Contractor::where('kindergarten_id',$kindergarten->id)->where('is_deleted',0)->get();

            //Создаем поставщика
            if(!empty($request->input('contractor_title')) ) {

                $contractor = new Contractor();
                $contractor->title = mb_convert_case($request->input('contractor_title'),MB_CASE_TITLE,"UTF-8" );
                
                if(strlen($request->input('contractor_telephone')) == Config::get('constants.length.telephone')){
                    $contractor->telephone = $request->input('contractor_telephone');
                }else {
                    \Session::flash('oops', trans('messages.please_fill_number_correctly'));
                    return \Redirect('manager/contractors');
                }

                $contractor->kindergarten_id = $kindergarten->id;

                $contractor->save();

                \Session::flash('message', trans('messages.successfully_created_contractor'));

                if($request->has('add-contractor-submit')){
                    return \Redirect('manager/contractors');
                }
            }

            return view('manager.contractors',compact('contractors'));
        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_pp'));
            return \Redirect('manager'); 
        }
    }

    public function editContractor($id){
        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_users.user_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_pp_module == 0){

            $contractor = Contractor::find($id);
            return view('manager.edit-contractor',compact('contractor'));

        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_pp'));
            return \Redirect('manager');
        }
    }

    public function updateContractor(Request $request, $id){
        
        // get the contractor
        try{
            $contractor = Contractor::find($id);
            $contractor->title = mb_convert_case($request->input('contractor_title'),MB_CASE_TITLE,"UTF-8" );

            if(strlen($request->input('contractor_telephone')) == Config::get('constants.length.telephone')){
                $contractor->telephone = $request->input('contractor_telephone');
            }else {
                \Session::flash('oops', trans('messages.please_fill_number_correctly'));
                return \Redirect('manager/contractors/'.$contractor->id);
            }

            if($contractor->title !== ''){
                $contractor->save();

            }else {
                 \Session::flash('oops', trans('messages.please_fill_fields'));
                return \Redirect('manager/contractors/'.$contractor->id);
            }

        }catch(QueryException $e){
             \Session::flash('oops', trans('messages.please_fill_fields'));
            return \Redirect('manager/contractors/'.$contractor->id);
        }
        

        \Session::flash('message', trans('messages.successfully_updated'));

        return \Redirect('manager/contractors');

    }
    
    public function destroyContractor(Request $request,$id){
        // delete
        $contractor = Contractor::find($id);
        $contractor->is_deleted = 1;
        $contractor->save();
        
        \Session::flash('message', trans('messages.successfully_deleted'));
        // redirect
        return \Redirect::to('manager/contractors');
    }

    public function foods(){
        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
            ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_users.user_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_pp_module == 0){

            $kfoods = KinderGartenFood::where('kindergarten_id',$kindergarten->id)->get();
            $foods = Food::all();
            // dd($kfoods);

            $contractors = Contractor::where('kindergarten_id',$kindergarten->id)
                                ->where('is_deleted',0)->get();

            return view('manager.foods',compact('contractors','kfoods','foods'));
        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_pp'));
            return \Redirect('manager');
        }
    }

    public function storeFoods(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
            ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_users.user_id',\Auth::user()->id)
            ->first();
        if($request->has('foods')){
            foreach ($request->foods as $key => $value) {
        
                $kfood = new KinderGartenFood();
                $kfood->food_id = $value;
                $kfood->kindergarten_id = $kindergarten->id;
                // $food->food_name = $request->input('food_name'.$value);
                // $food->contractor_id = $request->input('contractor'.$value);
                // $food->price = $request->input('price'.$value);
                // $food->balance = $request->input('balance'.$value);
                if($request->has('add-food-submit')){
                    $kfood->save();
                    \Session::flash('message', trans('messages.successfully_created'));
                }

            }
            return \Redirect('manager/foods');
        }
        if($request->has('kfood-submit')){

            $kfoods = KinderGartenFood::where('kindergarten_id',$kindergarten->id)->get();

            foreach ($kfoods as $key => $kfood) {
                # code...
                $kfood = KinderGartenFood::find($kfood->id);
                $kfood->food_name = $request->input('food_name'.$kfood->id);
                $kfood->contractor_id = $request->get('contractor'.$kfood->id);
                $kfood->price = $request->input('price'.$kfood->id);
                $kfood->balance = $request->input('balance'.$kfood->id);
                $kfood->save();

            }
            \Session::flash('message', trans('messages.successfully_updated'));
            return \Redirect('manager/foods');
        }
    }

}
