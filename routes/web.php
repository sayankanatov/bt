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

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin'], 'namespace' => 'Admin'], function () {
    // Backpack\NewsCRUD
    CRUD::resource('kindergarten', 'KinderGartenCrudController');
    CRUD::resource('city', 'CityCrudController');
    CRUD::resource('cityuser', 'CityUserCrudController');
});

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function(){
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');

	Route::group(['prefix'=>'account', 'as'=>'account.'], function(){
        Route::resource('kindergarten','AccountController');
        Route::post('kindergarten/{id}', [ 'as' => 'kindergartenUpdate','uses' => 'AccountController@update']);
    	Route::get('/', 'AccountController@index')->name('account');
    	Route::get('kindergarten', ['as' => 'kindergarten', 'uses' => 'AccountController@kinder']);
    	Route::post('kindergarten', ['as' => 'kindergarten', 'uses' => 'AccountController@kinder']);
	});

    Route::group(['prefix'=>'manager', 'as'=>'manager.'], function(){
        Route::get('/', 'ManagerController@index')->name('manager');
        Route::get('/general', 'ManagerController@general');
        Route::post('/general', 'ManagerController@storeGeneral');

        Route::get('/roles', 'ManagerController@roles');
        Route::post('/roles', 'ManagerController@storeRoles');
        
        Route::get('/groups', ['as' => 'groups','uses' => 'ManagerController@groups']);
        Route::post('/groups', ['as' => 'groups','uses' => 'ManagerController@groups']);

        Route::get('/groups/{id}', 'ManagerController@editGroup');
        Route::post('/groups/{id}', 'ManagerController@editGroup');
        Route::post('/groups/{id}', 'ManagerController@updateGroup');


        Route::get('/users', 'ManagerController@users');
        Route::post('/users', 'ManagerController@users');
    });
});


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
