<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('create_group', 'API\WhatsappBotController@create_group');
Route::post('update_group', 'API\WhatsappBotController@update_group');
Route::post('create_sessions', 'API\WhatsappBotController@create_sessions');
Route::post('register_members', 'API\WhatsappBotController@register_members');
Route::post('create_game', 'API\WhatsappBotController@create_game');
Route::post('start_game', 'API\WhatsappBotController@start_game');
Route::post('end_game', 'API\WhatsappBotController@end_game');
Route::post('stakes', 'API\WhatsappBotController@stakes');
Route::post('check_stakes_members', 'API\WhatsappBotController@check_stakes_members');
Route::post('list_stakes', 'API\WhatsappBotController@list_stakes');
Route::post('top_up_agent', 'API\WhatsappBotController@top_up_agent');
Route::post('top_up_group', 'API\WhatsappBotController@top_up_group');
Route::get('end_sessions', 'API\WhatsappBotController@end_sessions');
Route::post('help', 'API\WhatsappBotController@help');
Route::post('ahelp', 'API\WhatsappBotController@ahelp');
Route::post('check_credit_member', 'API\WhatsappBotController@check_credit_member');