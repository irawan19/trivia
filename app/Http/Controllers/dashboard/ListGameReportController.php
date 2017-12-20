<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;
use DB;

class ListGameReportController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_list_game_report = 'list_game_report';
        if(Shwetech::accessRights($link_list_game_report,'view') == 'true')
        {
            $data['link_list_game_report']          = $link_list_game_report;
            $data['result_word']                	= '';
            $id_admin 								= Auth::user()->id;
            $id_level_systems           			= Auth::user()->level_systems_id;
            if($id_level_systems == 1)
            {
            	$data['result_agent']        		= 0;
            	$data['view_agent']          		= \App\User::where('level_systems_id',3)
                                                        		->get();
        		$data['view_list_game_reports']    	= \App\Master_group::join('users','users_id','=','users.id')
        																	->get();
            }
            elseif($id_level_systems == 2)
            {
            	$data['result_agent']        		= 0;
            	$data['view_agent']          		= \App\User::where('level_systems_id',3)
                                                        		->where('sub_users_id',$id_admin)
                                                        		->get();
            	$data['view_list_game_reports']		= \App\Master_group::join('users','users_id','=','users.id')
            															->where('sub_users_id',$id_admin)
            															->get();
            }
            elseif($id_level_systems == 3)
            {
            	$data['result_agent']        		= $id_admin;
            	$data['view_agent']          		= \App\User::where('level_systems_id',3)
                                                    	->get();
                $data['view_list_game_reports']		= \App\Master_group::join('users','users_id','=','users.id')
            															->where('users_id',$id_admin)
            															->get();
            }
            
            session()->forget('page');
            session()->forget('result_word');
            session()->forget('result_agent');
        	return view('dashboard/list_game_report/list_game_report_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_list_game_report = 'list_game_report';
        if(Shwetech::accessRights($link_list_game_report,'view') == 'true')
        {
            $data['link_list_game_report']      = $link_list_game_report;
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
                	$data['view_list_game_reports']    	= \App\Master_group::join('users','users_id','=','users.id')
                															->where('name_groups', 'LIKE', '%'.$result_word.'%')
        																	->get();
                }
                else
                {
                	$data['view_list_game_reports']    	= \App\Master_group::join('users','users_id','=','users.id')
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
                $data['view_list_game_reports']    	= \App\Master_group::join('users','users_id','=','master_sessions.users_id')
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
                $data['view_list_game_reports']    	= \App\Master_group::join('users','users_id','=','master_sessions.users_id')
				                                                        ->where('id',$result_agent)
                														->where('name_groups', 'LIKE', '%'.$result_word.'%')
        																->get();
            }
            
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            session(['result_agent'     => $result_agent]);
            return view('dashboard/list_game_report/list_game_report_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }
}