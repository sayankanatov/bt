<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Admin routes
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin'], 'namespace' => 'Admin'], function () {
    // Backpack\NewsCRUD
    CRUD::resource('kindergarten', 'KinderGartenCrudController');
    CRUD::resource('city', 'CityCrudController');
    CRUD::resource('cityuser', 'CityUserCrudController');
});

//Main route group with locale prefix
Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function(){
    
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');

    //route group for client side
    Route::group(['prefix' => 'user'], function () {

        Route::get('/home','ClientController@index')->name('user.home');

        Route::get('/login', 'ClientAuth\LoginController@showLoginForm')->name('login');
        Route::post('/login', 'ClientAuth\LoginController@login');
        Route::post('/logout', 'ClientAuth\LoginController@logout')->name('logout');

        Route::post('/password/email', 'ClientAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
        Route::post('/password/reset', 'ClientAuth\ResetPasswordController@reset')->name('password.email');
        Route::get('/password/reset', 'ClientAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::get('/password/reset/{token}', 'ClientAuth\ResetPasswordController@showResetForm');

        Route::get('/groups', ['as' => 'groups','uses' => 'ClientController@groups']);
        Route::post('/groups', ['as' => 'groups','uses' => 'ClientController@groups']);
        Route::get('/groups/{id}', 'ClientController@editGroup');
        Route::post('/groups/{id}', 'ClientController@updateGroup');

        Route::get('/childrens', ['as' => 'childrens','uses' => 'ClientController@childrens']);
        Route::post('/childrens', ['as' => 'childrens','uses' => 'ClientController@childrens']);
        Route::get('/childrens/{id}', 'ClientController@editChild');
        Route::post('/childrens/{id}','ClientController@updateChild');

    });

    //route group for koordinator side
	Route::group(['prefix'=>'account', 'as'=>'account.','middleware' => ['role:Координатор']], function(){
        Route::resource('kindergarten','AccountController');
        Route::post('kindergarten/{id}', [ 'as' => 'kindergartenUpdate','uses' => 'AccountController@update']);
    	Route::get('/', 'AccountController@index')->name('account');
    	Route::get('kindergarten', ['as' => 'kindergarten', 'uses' => 'AccountController@kinder']);
    	Route::post('kindergarten', ['as' => 'kindergarten', 'uses' => 'AccountController@kinder']);
	});

    //route group for manager side
    Route::group(['prefix'=>'manager', 'as'=>'manager.','middleware' => ['role:Менеджер']], function(){
        Route::get('/', 'ManagerController@index')->name('manager');

        Route::get('/general', 'ManagerController@general');
        Route::post('/general', 'ManagerController@storeGeneral');

        Route::get('/roles', 'ManagerController@roles');
        Route::post('/roles', 'ManagerController@storeRoles');

        Route::get('/groups', ['as' => 'groups','uses' => 'ManagerController@groups']);
        Route::post('/groups', ['as' => 'groups','uses' => 'ManagerController@groups']);
        Route::get('/groups/{id}', 'ManagerController@editGroup');
        Route::post('/groups/{id}', 'ManagerController@updateGroup');

        Route::get('/childrens', ['as' => 'childrens','uses' => 'ManagerController@childrens']);
        Route::post('/childrens', ['as' => 'childrens','uses' => 'ManagerController@childrens']);
        Route::get('/childrens/{id}', 'ManagerController@editChild');
        Route::post('/childrens/{id}','ManagerController@updateChild');

        Route::get('/settings', 'ManagerController@settings');
        Route::post('/settings', 'ManagerController@storeSettings');

    });
});

// Route::get('/test', 'HomeController@tets')->name('tets');


//Переключение языков
Route::get('setlocale/{lang}', function ($lang) {

    $referer = Redirect::back()->getTargetUrl(); //URL предыдущей страницы
    $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

    //разбиваем на массив по разделителю
    $segments = explode('/', $parse_url);

    //Если URL (где нажали на переключение языка) содержал корректную метку языка
    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {

        unset($segments[1]); //удаляем метку
    }
    
    //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
    if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){ 
        array_splice($segments, 1, 0, $lang); 
    }

    //формируем полный URL
    $url = Request::root().implode("/", $segments);
    
    //если были еще GET-параметры - добавляем их
    if(parse_url($referer, PHP_URL_QUERY)){    
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }
    return redirect($url); //Перенаправляем назад на ту же страницу                            

})->name('setlocale');

