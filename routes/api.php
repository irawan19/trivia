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

/* MASTER AGENT */
	Route::post('{param}/top_up_agent', 'API\WhatsappBotController@top_up_agent');
	Route::post('{param}/mahelp', 'API\WhatsappBotController@mahelp');
	Route::post('{param}/check_credit_master_agent', 'API\WhatsappBotController@check_credit_master_agent');
	Route::post('{param}/create_agent', 'API\WhatsappBotController@create_agent');
/* MASTER AGENT */

/* AGENT */
	Route::post('{param}/check_master_agent_number', 'API\WhatsappBotController@check_master_agent_number');
	Route::post('{param}/create_group', 'API\WhatsappBotController@create_group');
	Route::post('{param}/update_group', 'API\WhatsappBotController@update_group');
	Route::post('{param}/create_sessions', 'API\WhatsappBotController@create_sessions');
	Route::post('{param}/create_game', 'API\WhatsappBotController@create_game');
	Route::post('{param}/start_game', 'API\WhatsappBotController@start_game');
	Route::post('{param}/get_group_from_private', 'API\WhatsappBotController@get_group_from_private');
	Route::post('{param}/end_game', 'API\WhatsappBotController@end_game');
	Route::post('{param}/top_up_group', 'API\WhatsappBotController@top_up_group');
	Route::post('{param}/ahelp', 'API\WhatsappBotController@ahelp');
	Route::post('{param}/top_up_member', 'API\WhatsappBotController@top_up_member');
	Route::post('{param}/check_credit_agent', 'API\WhatsappBotController@check_credit_agent');
	Route::post('{param}/check_credit_member_from_agent','API\WhatsappBotController@check_credit_member_from_agent');
/* AGENT */

/* MEMBER */
	Route::post('{param}/register_members', 'API\WhatsappBotController@register_members');
	Route::post('{param}/stakes', 'API\WhatsappBotController@stakes');
	Route::post('{param}/check_stakes_members', 'API\WhatsappBotController@check_stakes_members');
	Route::post('{param}/list_stakes', 'API\WhatsappBotController@list_stakes');
	Route::post('{param}/help', 'API\WhatsappBotController@help');
	Route::post('{param}/check_credit_member', 'API\WhatsappBotController@check_credit_member');
	Route::post('{param}/stat', 'API\WhatsappBotController@stat');
/* MEMBER */

Route::get('end_sessions', 'API\WhatsappBotController@end_sessions');
