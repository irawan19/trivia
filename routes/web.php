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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function(){
	return view('welcome');
});
Auth::routes();
Route::post('dashboard/login', 'Auth\LoginController@login');
Route::get('/dashboard/logout', 'Auth\LoginController@logout');
Route::get('/dashboard/home', 'dashboard\HomeController@index');
Route::get('/password/email', 'Auth\ForgotPasswordController@showLinkRequestForm');

	/* PROFILE */
		Route::group(['prefix' => 'dashboard/profile'], function(){
			Route::get('/', 'dashboard\ProfileController@index');
			Route::post('/processedit/{id}', 'dashboard\ProfileController@processedit');
		});
	/* PROFILE */

	/* MASTER AGENT */
		Route::group(['prefix' => 'dashboard/agent'], function(){
			Route::get('/', 'dashboard\AgentController@index');
			Route::get('/search', 'dashboard\AgentController@search');
			Route::get('/add', 'dashboard\AgentController@add');
			Route::post('/processadd', 'dashboard\AgentController@processadd');
			Route::get('/read/{id}', 'dashboard\AgentController@read');
			Route::get('/edit/{id}', 'dashboard\AgentController@edit');
			Route::post('/processedit/{id}', 'dashboard\AgentController@processedit');
			Route::get('/delete/{id}', 'dashboard\AgentController@delete');
		});
		Route::group(['prefix' => 'dashboard/top_up_agent'], function(){
			Route::get('/', 'dashboard\TopUpAgentController@index');
			Route::get('/search', 'dashboard\TopUpAgentController@search');
			Route::get('/add', 'dashboard\TopUpAgentController@add');
			Route::post('/processadd', 'dashboard\TopUpAgentController@processadd');
			Route::get('/read/{id}', 'dashboard\TopUpAgentController@read');
			Route::get('/edit/{id}', 'dashboard\TopUpAgentController@edit');
			Route::post('/processedit/{id}', 'dashboard\TopUpAgentController@processedit');
			Route::get('/delete/{id}', 'dashboard\TopUpAgentController@delete');
		});
	/* MASTER AGENT */

	/* AGENT */
		Route::group(['prefix' => 'dashboard/group'], function(){
			Route::get('/', 'dashboard\GroupController@index');
			Route::get('/search', 'dashboard\GroupController@search');
			Route::get('/add', 'dashboard\GroupController@add');
			Route::post('/processadd', 'dashboard\GroupController@processadd');
			Route::get('/edit/{id}', 'dashboard\GroupController@edit');
			Route::post('/processedit/{id}', 'dashboard\GroupController@processedit');
			Route::get('/delete/{id}', 'dashboard\GroupController@delete');
		});
		Route::group(['prefix' => 'dashboard/sessions'], function(){
			Route::get('/', 'dashboard\SessionsController@index');
			Route::get('/search', 'dashboard\SessionsController@search');
			Route::get('/add', 'dashboard\SessionsController@add');
			Route::post('/processadd', 'dashboard\SessionsController@processadd');
			Route::get('/edit/{id}', 'dashboard\SessionsController@edit');
			Route::post('/processedit/{id}', 'dashboard\SessionsController@processedit');
			Route::get('/delete/{id}', 'dashboard\SessionsController@delete');
		});
		Route::group(['prefix' => 'dashboard/game'], function(){
			Route::get('/', 'dashboard\GameController@index');
			Route::get('/search', 'dashboard\GameController@search');
			Route::get('/add', 'dashboard\GameController@add');
			Route::post('/processadd', 'dashboard\GameController@processadd');
			Route::get('/edit/{id}', 'dashboard\GameController@edit');
			Route::post('/processedit/{id}', 'dashboard\GameController@processedit');
			Route::get('/delete/{id}', 'dashboard\GameController@delete');
		});
	/* AGENT */

	/* REPORT */
		Route::group(['prefix' => 'dashboard/list_game_report'], function(){
			Route::get('/', 'dashboard\ListGameReportController@index');
			Route::get('/search', 'dashboard\ListGameReportController@search');
		});
		Route::group(['prefix' => 'dashboard/gamestat_report'], function(){
			Route::get('/', 'dashboard\GameStatReportController@index');
			Route::get('/search', 'dashboard\GameStatReportController@search');
			Route::get('/detail/{id}', 'dashboard\GameStatReportController@detail');
		});
	/* REPORT */

	/* ADMINISTRATOR */
		Route::group(['prefix' => 'dashboard/list_stakes'], function(){
			Route::get('/', 'dashboard\ListStakesController@index');
			Route::get('/search', 'dashboard\ListStakesController@search');
			Route::get('/add', 'dashboard\ListStakesController@add');
			Route::post('/processadd', 'dashboard\ListStakesController@processadd');
			Route::get('/edit/{id}', 'dashboard\ListStakesController@edit');
			Route::post('/processedit/{id}', 'dashboard\ListStakesController@processedit');
			Route::get('/delete/{id}', 'dashboard\ListStakesController@delete');
		});
		Route::group(['prefix' => 'dashboard/level_system'], function(){
			Route::get('/', 'dashboard\LevelSystemController@index');
			Route::get('/search', 'dashboard\LevelSystemController@search');
			Route::get('/add', 'dashboard\LevelSystemController@add');
			Route::post('/processadd', 'dashboard\LevelSystemController@processadd');
			Route::get('/read/{id}', 'dashboard\LevelSystemController@read');
			Route::get('/edit/{id}', 'dashboard\LevelSystemController@edit');
			Route::post('/processedit/{id}', 'dashboard\LevelSystemController@processedit');
			Route::get('/delete/{id}', 'dashboard\LevelSystemController@delete');
		});
		Route::group(['prefix' => 'dashboard/admin'], function(){
			Route::get('/', 'dashboard\AdminController@index');
			Route::get('/search', 'dashboard\AdminController@search');
			Route::get('/add', 'dashboard\AdminController@add');
			Route::post('/processadd', 'dashboard\AdminController@processadd');
			Route::get('/read/{id}', 'dashboard\AdminController@read');
			Route::get('/edit/{id}', 'dashboard\AdminController@edit');
			Route::post('/processedit/{id}', 'dashboard\AdminController@processedit');
			Route::get('/delete/{id}', 'dashboard\AdminController@delete');
		});
		Route::group(['prefix' => 'dashboard/master_agent'], function(){
			Route::get('/', 'dashboard\MasterAgentController@index');
			Route::get('/search', 'dashboard\MasterAgentController@search');
			Route::get('/add', 'dashboard\MasterAgentController@add');
			Route::post('/processadd', 'dashboard\MasterAgentController@processadd');
			Route::get('/read/{id}', 'dashboard\MasterAgentController@read');
			Route::get('/edit/{id}', 'dashboard\MasterAgentController@edit');
			Route::post('/processedit/{id}', 'dashboard\MasterAgentController@processedit');
			Route::get('/delete/{id}', 'dashboard\MasterAgentController@delete');
		});
		Route::group(['prefix' => 'dashboard/top_up_master_agent'], function(){
			Route::get('/', 'dashboard\TopUpMasterAgentController@index');
			Route::get('/search', 'dashboard\TopUpMasterAgentController@search');
			Route::get('/add', 'dashboard\TopUpMasterAgentController@add');
			Route::post('/processadd', 'dashboard\TopUpMasterAgentController@processadd');
			Route::get('/read/{id}', 'dashboard\TopUpMasterAgentController@read');
			Route::get('/edit/{id}', 'dashboard\TopUpMasterAgentController@edit');
			Route::post('/processedit/{id}', 'dashboard\TopUpMasterAgentController@processedit');
			Route::get('/delete/{id}', 'dashboard\TopUpMasterAgentController@delete');
		});
		Route::group(['prefix' => 'dashboard/app_configuration'], function(){
			Route::get('/', 'dashboard\AppConfigurationController@index');
			Route::post('/processedit', 'dashboard\AppConfigurationController@processedit');
			Route::post('/processeditlogo', 'dashboard\AppConfigurationController@processeditlogo');
			Route::post('/processediticon', 'dashboard\AppConfigurationController@processediticon');
			Route::post('/processeditlogotext', 'dashboard\AppConfigurationController@processeditlogotext');
		});
		Route::group(['prefix' => 'dashboard/menu'], function(){
			Route::get('/', 'dashboard\MenuController@index');
			Route::get('/search', 'dashboard\MenuController@search');
			Route::get('/order', 'dashboard\MenuController@order');
			Route::post('/processorder', 'dashboard\MenuController@processorder');
			Route::get('/add', 'dashboard\MenuController@add');
			Route::post('/processadd', 'dashboard\MenuController@processadd');
			Route::get('/read/{id}', 'dashboard\MenuController@read');
			Route::get('/edit/{id}', 'dashboard\MenuController@edit');
			Route::post('/processedit/{id}', 'dashboard\MenuController@processedit');
			Route::get('/delete/{id}', 'dashboard\MenuController@delete');
			Route::get('/submenu/{id}', 'dashboard\MenuController@submenu');
			Route::get('/search_submenu/{id}', 'dashboard\MenuController@search_submenu');
			Route::get('/add_submenu/{id}', 'dashboard\MenuController@add_submenu');
			Route::post('/processadd_submenu/{id}', 'dashboard\MenuController@processadd_submenu');
			Route::get('/order_submenu/{id}', 'dashboard\MenuController@order_submenu');
			Route::get('/read_submenu/{id}', 'dashboard\MenuController@read_submenu');
			Route::get('/edit_submenu/{id}', 'dashboard\MenuController@edit_submenu');
			Route::post('/processedit_submenu/{id}', 'dashboard\MenuController@processedit_submenu');
			Route::get('/delete_submenu/{id}', 'dashboard\MenuController@delete_submenu');
		});
	/* ADMINISTRATOR */
