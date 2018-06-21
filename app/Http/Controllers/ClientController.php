<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\GroupCategory;
use App\Models\Group;
use App\Models\Children;
use App\Models\Setting;
use App\Models\Contractor;
use App\Models\Food;
use App\Models\KinderGartenFood;

use DB;
use Config;

class ClientController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
    	$metodist_link = '/user/groups';
    	$nurse_link = '/user/menus';
        $contractor_link = '/user/contractors';
    	$food_link = '/user/foods';
    	$storekeeper_link = '/user/store';
    	$mentor_link = '/user/childrens';
    	$parent_link = '/user/info';

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_clients','kindergarten_clients.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_clients.client_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();
        
        $user = DB::table('clients')
        		->select('role_clients.client_id','role_clients.role_id','clients.telephone','clients.name')
        		->join('role_clients','role_clients.client_id','=','clients.id')
        		->where('clients.id',\Auth::user()->id)
        		->first();
        // dd($user);

        return view('client.home',compact('right_settings','user','metodist_link','nurse_link','contractor_link','food_link','storekeeper_link','mentor_link','parent_link'));
    }

    public function groups(Request $request)
    {
        //get kindergarten
        $kindergarten = DB::table('kindergartens')
        	->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_clients','kindergarten_clients.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_clients.client_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_group_module == 1){
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
                    return \Redirect('user/groups');
                }
            }

            return view('client.groups',compact('groups','group_categories','mentors','rows','kindergarten','notExistInFirstMentors','notExistInSecondMentors'));
        }else{

            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_group'));
            return \Redirect('user/home');
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

        return view('client.edit-group',compact('group','group_categories','child_counts','notExistInFirstMentors','notExistInSecondMentors','mentors'));
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
            return \Redirect('user/groups/'.$group->id);
        }

        \Session::flash('message', trans('messages.successfully_updated'));

        return \Redirect('user/groups');
    }

    /**
* Display childrens in all groups for adding and updating
**/ 
    public function childrens(Request $request){

        $kindergarten = DB::table('kindergartens')
        	->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_clients','kindergarten_clients.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_clients.client_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        
            //check setting permissions
        if($right_settings && $right_settings->is_user_module == 1){

            $groups = Group::where('first_mentor_id',\Auth::user()->id)
                    ->orWhere('second_mentor_id',\Auth::user()->id)
                    ->get();
            // dd($groups);

            //Вывод для каждой группы флэш сообщения о необходимом количестве детей
            $getGroup = Group::where('id',$request->input('group_id'))->first();

            if($request->has('child-submit')){
                    
                $parent = new Client();
                //Скрыто в связи с неактуальностью
                // $parent->name = mb_convert_case($request->input('parent_name'),MB_CASE_TITLE,"UTF-8");

                if(strlen($request->input('parent_telephone')) == Config::get('constants.length.telephone')){
                    $parent->telephone = $request->input('parent_telephone');
                }else {
                     \Session::flash('oops', trans('messages.please_fill_number_correctly'));
                    return \Redirect('user/childrens');
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

            return view('client.childrens',compact('groups'));
        }else {

            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_user'));
            return \Redirect('user/home');
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

        return view('client.edit-child',compact('children','parents'));
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
                return \Redirect('user/childrens/'.$children->id);
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
                    return \Redirect('user/childrens/'.$children->id);
                }
                
                if($parent->name !== ''){
                    $parent->save();   
                }else {
                     \Session::flash('oops', trans('messages.please_fill_fields'));
                    return \Redirect('user/childrens/'.$children->id);
                }
            }
            // $request->validate([
            //     'telephone' => 'numeric|min:10',
            // ]);

        }catch(QueryException $e){
             \Session::flash('oops', trans('messages.please_fill_fields'));
            return \Redirect('user/childrens/'.$children->id);
        }
        

        \Session::flash('message', trans('messages.successfully_updated'));

        return \Redirect('user/childrens');
    }

    public function contractors(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_clients','kindergarten_clients.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_clients.client_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_pp_module == 1){

            $contractors = Contractor::where('kindergarten_id',$kindergarten->id)->where('is_deleted',0)->get();

            //Создаем поставщика
            if(!empty($request->input('contractor_title')) ) {

                $contractor = new Contractor();
                $contractor->title = mb_convert_case($request->input('contractor_title'),MB_CASE_TITLE,"UTF-8" );
                
                if(strlen($request->input('contractor_telephone')) == Config::get('constants.length.telephone')){
                    $contractor->telephone = $request->input('contractor_telephone');
                }else {
                    \Session::flash('oops', trans('messages.please_fill_number_correctly'));
                    return \Redirect('user/contractors');
                }

                $contractor->kindergarten_id = $kindergarten->id;

                $contractor->save();

                \Session::flash('message', trans('messages.successfully_created_contractor'));

                if($request->has('add-contractor-submit')){
                    return \Redirect('user/contractors');
                }
            }

            return view('client.contractors',compact('contractors'));
        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_pp'));
            return \Redirect('user/home'); 
        }
    }

    public function editContractor($id){
        $kindergarten = DB::table('kindergartens')->select('kindergartens.id','kindergartens.group_count')
            ->join('kindergarten_clients','kindergarten_clients.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_clients.client_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_pp_module == 1){

            $contractor = Contractor::find($id);
            return view('client.edit-contractor',compact('contractor'));

        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_pp'));
            return \Redirect('user/home');
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
                return \Redirect('user/contractors/'.$contractor->id);
            }

            if($contractor->title !== ''){
                $contractor->save();

            }else {
                 \Session::flash('oops', trans('messages.please_fill_fields'));
                return \Redirect('user/contractors/'.$contractor->id);
            }

        }catch(QueryException $e){
             \Session::flash('oops', trans('messages.please_fill_fields'));
            return \Redirect('user/contractors/'.$contractor->id);
        }
        

        \Session::flash('message', trans('messages.successfully_updated'));

        return \Redirect('user/contractors');

    }
    
    public function destroyContractor(Request $request,$id){
        // delete
        $contractor = Contractor::find($id);
        $contractor->is_deleted = 1;
        $contractor->save();
        
        \Session::flash('message', trans('messages.successfully_deleted'));
        // redirect
        return \Redirect::to('user/contractors');
    }

    public function foods(){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
            ->join('kindergarten_clients','kindergarten_clients.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_clients.client_id',\Auth::user()->id)
            ->first();

        $right_settings = Setting::where('kindergarten_id',$kindergarten->id)->first();

        //check setting permissions
        if($right_settings && $right_settings->is_pp_module == 1){

            $kfoods = KinderGartenFood::where('kindergarten_id',$kindergarten->id)->get();
            $foods = Food::all();
            // dd($kfoods);

            $contractors = Contractor::where('kindergarten_id',$kindergarten->id)
                                ->where('is_deleted',0)->get();

            return view('client.foods',compact('contractors','kfoods','foods'));
        }else {
            \Session::flash('oops', trans('messages.you_dont_have_perm_for_open_pp'));
            return \Redirect('user/home');
        }
    }

    public function storeFoods(Request $request){

        $kindergarten = DB::table('kindergartens')->select('kindergartens.id')
            ->join('kindergarten_clients','kindergarten_clients.kindergarten_id','=','kindergartens.id')
            ->where('kindergarten_clients.client_id',\Auth::user()->id)
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
            return \Redirect('user/foods');
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
            return \Redirect('user/foods');
        }
    }
}
