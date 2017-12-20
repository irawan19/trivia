<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;
use DB;

class GameStatReportController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_gamestat_report = 'gamestat_report';
        if(Shwetech::accessRights($link_gamestat_report,'view') == 'true')
        {
            $data['link_gamestat_report']          = $link_gamestat_report;
            $data['result_word']                	= '';
            $id_admin 								= Auth::user()->id;
            $id_level_systems           			= Auth::user()->level_systems_id;
            if($id_level_systems == 1)
            {
            	$data['result_agent']        		= 0;
            	$data['view_agent']          		= \App\User::where('level_systems_id',3)
                                                        		->get();
        		$data['view_gamestat_reports']    	= \App\Master_group::join('users','users_id','=','users.id')
        																	->get();
            }
            elseif($id_level_systems == 2)
            {
            	$data['result_agent']        		= 0;
            	$data['view_agent']          		= \App\User::where('level_systems_id',3)
                                                        		->where('sub_users_id',$id_admin)
                                                        		->get();
            	$data['view_gamestat_reports']		= \App\Master_group::join('users','users_id','=','users.id')
            															->where('sub_users_id',$id_admin)
            															->get();
            }
            elseif($id_level_systems == 3)
            {
            	$data['result_agent']        		= $id_admin;
            	$data['view_agent']          		= \App\User::where('level_systems_id',3)
                                                    	->get();
                $data['view_gamestat_reports']		= \App\Master_group::join('users','users_id','=','users.id')
            															->where('users_id',$id_admin)
            															->get();
            }
            
            session()->forget('page');
            session()->forget('result_word');
            session()->forget('result_agent');
        	return view('dashboard/gamestat_report/gamestat_report_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_gamestat_report = 'gamestat_report';
        if(Shwetech::accessRights($link_gamestat_report,'view') == 'true')
        {
            $data['link_gamestat_report']      = $link_gamestat_report;
            $url_now                    		= $request->fullUrl();
            $result_word                		= $request->search_word;
            $data['result_word']        		= $result_word;
            $id_admin                   		= Auth::user()->id;
            $id_level_systems           		= Auth::user()->level_systems_id;
            if($id_level_systems == 1)
            {
                $result_agent                	= $request->search_agent; 
                $data['result_agent']        	= $result_agent;
                $data['view_agent']          	= \App\User::where('level_systems_id',3)
                                                        ->get();
                if($result_agent == 0)
                {
                	$data['view_gamestat_reports']    	= \App\Master_group::join('users','users_id','=','users.id')
                															->where('name_groups', 'LIKE', '%'.$result_word.'%')
        																	->get();
                }
                else
                {
                	$data['view_gamestat_reports']    	= \App\Master_group::join('users','users_id','=','users.id')
                															->where('users_id',$result_agent)
                															->where('name_groups', 'LIKE', '%'.$result_word.'%')
        																	->get();
                }
            }
            elseif($id_level_systems == 2)
            {
                $result_agent                		= $request->search_agent;
                $data['result_agent']        		= $result_agent;
                $data['view_agent']          		= \App\User::where('level_systems_id',3)
                                                        		->where('sub_users_id',$result_agent)
                                                        		->get();
                $data['view_gamestat_reports']    	= \App\Master_group::join('users','users_id','=','master_sessions.users_id')
				                                                        ->where('sub_users_id',$result_agent)
                														->where('name_groups', 'LIKE', '%'.$result_word.'%')
        																->get();
            }
            elseif($id_level_systems == 3)
            {
                $result_agent                	= $id_admin;
                $data['result_agent']        	= $result_agent;
                $data['view_agent']          	= \App\User::where('level_systems_id',3)
                											->where('id',$id_admin)
                                                    		->get();
                $data['view_gamestat_reports']    	= \App\Master_group::join('users','users_id','=','master_sessions.users_id')
				                                                        ->where('id',$result_agent)
                														->where('name_groups', 'LIKE', '%'.$result_word.'%')
        																->get();
            }
            
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            session(['result_agent'     => $result_agent]);
            return view('dashboard/gamestat_report/gamestat_report_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function detail($id_game=0)
    {
    	$link_gamestat_report = 'gamestat_report';
        if(Shwetech::accessRights($link_gamestat_report,'view') == 'true')
        {
            if (!is_numeric($id_game))
                $id_game = 0;
            $check_game = \App\Master_game::where('id_games',$id_game)->count();
            if($check_game != 0)
            {
                $data['read_gamestat_reports']     = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                														->join('master_groups','groups_id','=','master_groups.id_groups')
                														->where('id_games',$id_game)
                                                                		->first();
                $data['list_stakes']				= \App\Master_stake::join('master_register_members','register_members_id','=','master_register_members.id_register_members')
                														->join('master_list_stakes','list_stakes_id','=','master_list_stakes.id_list_stakes')
                														->where('games_id',$id_game)
                														->get();
            	$get_total_amount 					= \App\Master_stake::selectRaw('SUM(value_stakes) AS total_amount')
                														->where('games_id',$id_game)
                														->first();
               	if($get_total_amount != '')
	                $data['total_amount']			= $get_total_amount;
	           	else
	           		$data['total_amount']			= 0;
                return view('dashboard/gamestat_report/gamestat_report_detail',$data);
            }
            else
                return redirect('/dashboard/gamestat_report');
        }
        else
            return redirect('/dashboard/gamestat_report');
    }
}