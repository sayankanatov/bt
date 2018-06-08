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
        $groups_link = '/manager/groups';
        $user_base_link = '/manager/childrens';

        return view('manager.index',compact(
            'general_info_link',
            'roles_link',
            'groups_link',
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
        $kinder_info->telephone = $request->input('telephone');
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
            $client->telephone = $request->input('tel1');
            $client->name = mb_convert_case($request->input('fio1'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name1');
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль Заведующий
            $client->role()->attach(Config::get('constants.roles.deputy'));

        }elseif(isset($deputy) && $request->input('tel1')) {
            $client = Client::where('id',$deputy->client_id)->first();
            $client->telephone = $request->input('tel1');
            $client->name = mb_convert_case($request->input('fio1'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name1');
            $client->save();
        }

        if($request->input('tel2') && !$methodist){
            $client = new Client();
            $client->telephone = $request->input('tel2');
            $client->name = mb_convert_case($request->input('fio2'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name2');
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.methodist'));

        }elseif(isset($methodist) && $request->input('tel2')){
            $client = Client::where('id',$methodist->client_id)->first();
            $client->telephone = $request->input('tel2');
            $client->name = mb_convert_case($request->input('fio2'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name2');
            $client->save();
        }

        if($request->input('tel3') && !$nurse){
            $client = new Client();
            $client->telephone = $request->input('tel3');
            $client->name = mb_convert_case($request->input('fio3'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name3');
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.nurse'));

        }elseif(isset($nurse) && $request->input('tel3')){
            $client = Client::where('id',$nurse->client_id)->first();
            $client->telephone = $request->input('tel3');
            $client->name = mb_convert_case($request->input('fio3'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name3');
            $client->save();
        }

        if($request->input('tel4') && !$accountant){
            $client = new Client();
            $client->telephone = $request->input('tel4');
            $client->name = mb_convert_case($request->input('fio4'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name4');
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.accountant'));

        }elseif(isset($accountant) && $request->input('tel4')){
            $client = Client::where('id',$accountant->client_id)->first();
            $client->telephone = $request->input('tel4');
            $client->name = mb_convert_case($request->input('fio4'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name4');
            $client->save();
        }

        if($request->input('tel5') && !$storekeeper){
            $client = new Client();
            $client->telephone = $request->input('tel5');
            $client->name = mb_convert_case($request->input('fio5'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name5');
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.storekeeper'));

        }elseif(isset($storekeeper) && $request->input('tel5')) {
            $client = Client::where('id',$storekeeper->client_id)->first();
            $client->telephone = $request->input('tel5');
            $client->name = mb_convert_case($request->input('fio5'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name5');
            $client->save();
        }

        if($request->input('tel6')){
            $client = new Client();
            $client->telephone = $request->input('tel6');
            $client->name = mb_convert_case($request->input('fio6'),MB_CASE_TITLE,"UTF-8");
            $client->role_name = $request->input('role_name6');
            $client->save();
            //Устанавливаем связь с садиком
            $client->kindergarten()->attach($kindergarten->id);
            //Устанавливаем роль
            $client->role()->attach(Config::get('constants.roles.mentor'));
        }

        if($request->input('mentor_tel')){
            $mentor = new Client();
            $mentor->name = mb_convert_case($request->input('mentor_fio'),MB_CASE_TITLE,"UTF-8");
            $mentor->telephone = $request->input('mentor_tel');
            $mentor->save();
            $mentor->kindergarten()->attach($kindergarten->id);
            $mentor->role()->attach(Config::get('constants.roles.mentor'));
        }
        // Редактируем всех воспитателей внутри foreach
        foreach ($mentors as $mentor) {
            # code...
            if($request->input('mentortel_'.$mentor->id)){
                $exist_mentor = Client::where('id',$mentor->id)->first();
                $exist_mentor->telephone = $request->input('mentortel_'.$mentor->id);
                $exist_mentor->name = mb_convert_case($request->input('mentorfio_'.$mentor->id),MB_CASE_TITLE,"UTF-8");
                $exist_mentor->save();
            }
        }

        \Session::flash('message', 'Successfully updated roles!');

        return \Redirect('manager/roles'); 
    }

    public function groups(Request $request)
    {
        //get kindergarten
        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
                        ->join('kindergarten_users','kindergarten_users.kindergarten_id','=','kindergartens.id')
                        ->where('kindergarten_users.user_id',\Auth::user()->id)
                        ->first();

        //get all groups
        $groups = DB::table('groups')->select('*')
                    ->where('groups.kindergarten_id',$kindergarten->id)
                    ->get();
        // dd($groups);

        //get flash message in view
        if($kindergarten->group_count - $groups->count() > 0){

            \Session::flash('warning', trans('messages.you_must_add').' '.$kindergarten->group_count - $groups->count().' '.trans('messages.group'));

        }elseif($groups->count() - $kindergarten->group_count > 0){
            
            \Session::flash('warning', trans('messages.you_must_edit_general_info').' '.$groups->count() - $kindergarten->group_count.' '.trans('messages.group'));
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

            \Session::flash('message', 'Successfully created group!');

            if($request->has('add-group-submit')){
                return \Redirect('manager/groups');
            }
        }

        return view('manager.groups',compact('groups','group_categories','mentors','rows','kindergarten'));
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
        $group_categories = GroupCategory::all();
        $child_counts = array(0 => 10, 1 => 15, 2 => 20, 3 => 25, 4 => 30, 5 => 35, 6 => 40, 7 => 45, 8 => 50);

        return view('manager.edit_group',compact('group','mentors','group_categories','child_counts'));
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
            \Session::flash('oops', 'Sorry something went worng. Please try again!');
            return \Redirect('manager/groups/'.$group->id);
        }
        // $request->validate([
        //     'title' => 'filled',
        // ]);

        \Session::flash('message', 'Successfully updated!');

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

        $groups = Group::where('kindergarten_id',$kindergarten->id)->get();
        // dd($groups);
        $getGroup = Group::where('id',$request->input('group_id'))->first();

        if($request->has('child-submit')){
            
            $parent = new Client();
            $parent->name = mb_convert_case($request->input('parent_name'),MB_CASE_TITLE,"UTF-8");
            $parent->telephone = $request->input('parent_telephone');
            $parent->role_name = 'Родитель';
            $parent->save();
            $parent->role()->attach(Config::get('constants.roles.parent'));

            $children = new Children();
            $children->name = mb_convert_case($request->input('children_name'),MB_CASE_TITLE,"UTF-8");
            $children->iin = $request->input('children_iin');
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
        $children = Children::find($id);
        $children->name = mb_convert_case($request->input('child_name'),MB_CASE_TITLE,"UTF-8" );
        $children->iin = $request->input('child_iin');
        $children->save();

        $parents = Client::where('id',$children->client_id)->get();
        foreach ($parents as $key => $parent) {
            # code...
            $parent->name = mb_convert_case($request->input('parent_name'.++$key),MB_CASE_TITLE,"UTF-8" );
            $parent->telephone = $request->input('parent_telephone'.++$key);
            $parent->save();
        }

        \Session::flash('message', 'Successfully updated!');

        return \Redirect('manager/childrens');
    }

}
