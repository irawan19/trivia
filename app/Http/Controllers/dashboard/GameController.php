<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class GameController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_game = 'game';
        if(Shwetech::accessRights($link_game,'view') == 'true')
        {
            $data['link_game']         	= $link_game;
            $data['result_word']        = '';
            $id_admin 					= Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            $data['result_word']        = '';

	        if($id_level_systems == 1)
	        {
                $data['result_agent']        = 0; 
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->get();
	        	$data['view_game']			= \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
	        													->join('master_groups','groups_id','=','master_groups.id_groups')
	        													->get();
	        }
            elseif($id_level_systems == 2)
            {
                $data['result_agent']        = 0;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('sub_users_id',$id_admin)
                                                        ->get();
                $data['view_game']        = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                												->join('master_groups','groups_id','=','master_groups.id_groups')
                												->join('users','users_id','=','users.id')
                                                                ->where('sub_users_id',$id_admin)
                                                                ->get();
            }
	        elseif($id_level_systems == 3)
	        {
                $data['result_agent']        = $id_admin;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('id',$id_admin)
                                                        ->get();
		        $data['view_game']    	    = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
		        												->join('master_groups','groups_id','=','master_groups.id_groups')
                                                                ->join('users','users_id','=','users.id')
		        												->where('id',$id_admin)
		        												->get();
	        }
            session()->forget('page');
            session()->forget('result_word');
            session()->forget('result_agent');
        	return view('dashboard/game/game_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_game = 'game';
        if(Shwetech::accessRights($link_game,'view') == 'true')
        {
            $data['link_game']      = $link_game;
            $url_now                    = $request->fullUrl();
            $result_word                = $request->search_word;
            $data['result_word']        = $result_word;
            $id_admin                  = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                    ->get();
            if($id_level_systems == 1)
            {
                $result_agent                = $request->search_agent; 
                $data['result_agent']        = $result_agent;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->get();
                if($result_agent == 0)
                {
		            $data['view_game']      = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
		            													->join('master_groups','groups_id','=','master_groups.id_groups')
		            													->where('name_groups', 'LIKE', '%'.$result_word.'%')
	                                                        			->get();
                }
                else
                {
                	$data['view_game']		= \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                														->join('master_groups','groups_id','=','master_groups.id_groups')
                														->where('users_id',$result_agent)
                														->where('name_groups','LIKE','%'.$result_word.'%')
                														->get();
                }
            }
            elseif($id_level_systems == 2)
            {
                $result_agent                = $request->search_agent;
                $data['result_agent']        = $result_agent;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('sub_users_id',$result_agent)
                                                        ->get();
            	$data['view_game']      = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
            														->join('master_groups','groups_id','=','master_groups.id_groups')
            														->join('users','users_id','=','users.id')
		                                                         	->where('sub_users_id',$result_agent)
		                                                         	->where('name_groups', 'LIKE', '%'.$result_word.'%')
		                                                         	->get();
            }
            elseif($id_level_systems == 3)
            {
                $result_agent                = $id_admin;
                $data['result_agent']        = $result_agent;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('id',$id_admin)
                                                        ->get();
                $data['view_game']          = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                												->join('master_groups','groups_id','=','master_groups.id_groups')
                                                                ->join('users','users_id','=','users.id')
                												->where('id',$id_admin)
                                                                ->where('name_groups', 'LIKE', '%'.$result_word.'%')
                                                                ->get();
            }
            
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            session(['result_agent'     	=> $result_agent]);
            return view('dashboard/game/game_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_game = 'game';
        if(Shwetech::accessRights($link_game,'add') == 'true')
        {
            if(Auth::user()->level_systems_id != 3)
            {
                if(Auth::user()->level_systems_id == 1)
                {
                    $data['add_sessions']   = \App\Master_session::get();
                }
                elseif(Auth::user()->level_systems_id == 2)
                {
                    $id_admin               = Auth::user()->id;
                    $data['add_sessions']   = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                                    ->join('users','users_id','=','users.id')
                                                                    ->where('sub_users_id',$id_admin)
                                                                    ->get();
                }
                return view('/dashboard/game/game_add',$data);
            }
            else
            {
                $check_total_game = \App\Master_game::join('master_sessions','sessions_id','=','master_sessions.id_sessions')
                                                                            ->join('master_groups','groups_id','=','master_groups.id_groups')
                                                                            ->where('users_id',Auth::user()->id)
                                                                            ->where('status_active_games','0')
                                                                            ->orWhere('status_active_games','1')
                                                                            ->where('users_id',Auth::user()->id)
                                                                            ->count();
                if($check_total_game == 0)
                {
                    $id_admin 				= Auth::user()->id;
                    $data['add_sessions'] 	= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                    												->join('users','users_id','=','users.id')
                    												->where('users_id',$id_admin)
                    												->get();
                   	return view('/dashboard/game/game_add',$data);
                }
                else
                    return redirect('/dashboard/game');
            }
        }
        else
            return redirect('/dashboard/game');
    }

    public function processadd(Request $request)
    {
    	$link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'add') == 'true')
        {
        	$this->validate($request, [
        		'sessions_id'			=> 'required|check_last_game',
        		'date_games'			=> 'required',
        	]);

        	$get_date 					= $request->date_games;
        	$separate_date 				= explode(' - ',$get_date);
        	$start_date 				= $separate_date[0];
        	$end_date 					= $separate_date[1];
        	$date_now 					= date('Y-m-d H:i:s');
        	if(strtotime($date_now) < strtotime($start_date) && strtotime($date_now) < strtotime($end_date))
        		$status 				= '0';
        	elseif(strtotime($date_now) >= strtotime($start_date) && strtotime($date_now) <= strtotime($end_date))
        		$status 				= '1';
        	elseif(strtotime($date_now) >= strtotime($start_date) && strtotime($date_now) >= strtotime($end_date))
        		$status 				= '2';

        	$data = [
        		'sessions_id'			=> $request->sessions_id,
        		'start_date_games'		=> $start_date,
        		'end_date_games'		=> $end_date,
        		'status_active_games'	=> $status,
        	];
        	\App\Master_game::insert($data);
        	
        	$save         	= $request->save;
        	$save_exit 		= $request->save_exit;
        	if($save)
        	{
        	    $after_save = [
        	        'alert'  => 'success',
        	        'text'   => 'Data Successfully Added',
        	    ];
        		return redirect()->back()->with('after_save', $after_save);
        	}
        	if($save_exit)
        	{
        		if(request()->session()->get('page') != '')
        	        $redirect_page  = request()->session()->get('page');
        	    else
        	        $redirect_page  = '/dashboard/game';

        	    return redirect($redirect_page);
            }
        }
        else
            return redirect('/dashboard/game');
    }

    public function edit($id_games=0)
    {
    	$link_game = 'game';
        if(Shwetech::accessRights($link_game,'edit') == 'true')
        {
            if (!is_numeric($id_games))
                $id_games = 0;
            $check_game = \App\Master_game::where('id_games',$id_games)->count();
            if($check_game != 0)
            {
	            if(Auth::user()->level_systems_id == 1)
			    {
				    $data['edit_sessions'] = \App\Master_session::get();
			    }
			    elseif(Auth::user()->level_systems_id == 2)
			    {
			    	$id_admin 				= Auth::user()->id;
			    	$data['edit_sessions'] 	= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
			    													->join('users','users_id','=','users.id')
			    													->where('sub_users_id',$id_admin)
			    													->get();
			    }
			    elseif(Auth::user()->level_systems_id == 3)
			    {
			    	$id_admin 				= Auth::user()->id;
			    	$data['edit_sessions'] 	= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
			    													->join('users','users_id','=','users.id')
					    											 ->where('users_id',$id_admin)
					    											 ->get();
			    }
	            $data['edit_games']		= \App\Master_game::where('id_games',$id_games)
	            											->first();
	            return view('dashboard/game/game_edit',$data);
            }
            else
                return redirect('/dashboard/game');
        }
        else
            return redirect('/dashboard/game');
    }

    public function processedit($id_games=0, Request $request)
    {
    	$link_game = 'game';
        if(Shwetech::accessRights($link_game,'edit') == 'true')
        {
        	if (!is_numeric($id_games))
                $id_games = 0;
            $check_game = \App\Master_game::where('id_games',$id_games)->count();
            if($check_game != 0)
            {
                 $this->validate($request, [
	    	    	'sessions_id'			=> 'required',
	    	    	'date_games'			=> 'required',
	    	    ]);

		    	$get_date 					= $request->date_games;
		    	$separate_date 				= explode(' - ',$get_date);
		    	$start_date 				= $separate_date[0];
		    	$end_date 					= $separate_date[1];
		    	$date_now 					= date('Y-m-d H:i:s');
		    	if(strtotime($date_now) < strtotime($start_date) && strtotime($date_now) < strtotime($end_date))
		    		$status 				= '0';
		    	elseif(strtotime($date_now) >= strtotime($start_date) && strtotime($date_now) <= strtotime($end_date))
		    		$status 				= '1';
		    	elseif(strtotime($date_now) >= strtotime($start_date) && strtotime($date_now) >= strtotime($end_date))
		    		$status 				= '2';

		    	$data = [
		    		'sessions_id'			=> $request->sessions_id,
	    	    	'start_date_games'		=> $start_date,
	    	    	'end_date_games'		=> $end_date,
	    	    	'status_active_games'	=> $status,
		    	];
		    	\App\Master_game::where('id_games',$id_games)->update($data);

    	        if(request()->session()->get('page') != '')
    	            $redirect_page    = request()->session()->get('page');
    	        else
    	            $redirect_page  = '/dashboard/game';
    	        
    	        return redirect($redirect_page);
	        }
	        else
	        	return redirect('/dashboard/game');
        }
        else
            return redirect('/dashboard/game');
    }

    public function delete($id_games=0)
    {
    	$link_game = 'game';
        if(Shwetech::accessRights($link_game,'delete') == 'true')
        {
        	if (!is_numeric($id_games))
                $id_games = 0;
            $check_game = \App\Master_game::where('id_games',$id_games)->count();
            if($check_game != 0)
            {
                \App\Master_game::where('id_games',$id_games)
                                 	->delete();

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/game';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/game');
        }
        else
            return redirect('/dashboard/game');
    }
}