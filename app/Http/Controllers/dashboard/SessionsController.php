<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class SessionsController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'view') == 'true')
        {
            $data['link_sessions']         = $link_sessions;
            $data['result_word']           = '';
            $id_admin 					   = Auth::user()->id;
            $id_level_systems              = Auth::user()->level_systems_id;
            $data['result_word']           = '';
	        if($id_level_systems == 1)
	        {
                $data['result_agent']        = 0; 
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->get();
	        	$data['view_sessions']		= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
	        													->get();
	        }
            elseif($id_level_systems == 2)
            {
                $data['result_agent']        = 0;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('sub_users_id',$id_admin)
                                                        ->get();
                $data['view_sessions']        = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                												->join('users','users_id','=','master_groups.users_id')
                                                                ->where('sub_users_id',$id_admin)
                                                                ->get();
            }
	        elseif($id_level_systems == 3)
	        {
                $data['result_agent']        = $id_admin;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                    ->where('id',$id_admin)
                                                    ->get();
		        $data['view_sessions']    	= \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
		        												->where('users_id',$id_admin)
		        												->get();
	        }
            session()->forget('page');
            session()->forget('result_word');
            session()->forget('result_agent');
        	return view('dashboard/sessions/sessions_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'view') == 'true')
        {
            $data['link_sessions']      = $link_sessions;
            $url_now                    = $request->fullUrl();
            $result_word                = $request->search_word;
            $data['result_word']        = $result_word;
            $id_admin                   = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems == 1)
            {
                $result_agent                = $request->search_agent; 
                $data['result_agent']        = $result_agent;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->get();
                if($result_agent == 0)
                {
		            $data['view_sessions']      = \App\Master_session::join('master_groups','groups_id','=','master_sessions.groups_id')
		            													->where('name_groups', 'LIKE', '%'.$result_word.'%')
	                                                        			->get();
                }
                else
                {
                	$data['view_sessions']		= \App\Master_session::join('master_groups','groups_id','=','master_sessions.groups_id')
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
            	$data['view_sessions']      = \App\Master_session::join('master_groups','groups_id','=','master_sessions.groups_id')
            														->join('users','users_id','=','master_sessions.users_id')
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
                $data['view_sessions']      = \App\Master_session::join('master_groups','groups_id','=','master_sessions.groups_id')
                												->where('id',$id_admin)
                                                                ->where('name_groups', 'LIKE', '%'.$result_word.'%')
                                                                ->get();
            }
            
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            session(['result_agent'     => $result_agent]);
            return view('dashboard/sessions/sessions_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'add') == 'true')
        {
            if(Auth::user()->level_systems_id != 3)
            {
                if(Auth::user()->level_systems_id == 1)
                {
                   $data['add_groups'] = \App\Master_group::get();
                }
                elseif(Auth::user()->level_systems_id == 2)
                {
                    $id_admin           = Auth::user()->id;
                    $data['add_groups'] = \App\Master_group::join('users','users_id','=','users.id')
                                                        ->where('sub_users_id',$id_admin)
                                                        ->get();
                }

                return view('/dashboard/sessions/sessions_add',$data);
            }
            else
            {
                $date_now            = date('Y-m-d H:i:s');
                $check_last_sessions = \App\Master_session::join('master_groups','groups_id','=','master_groups.id_groups')
                                                                                ->where('users_id',Auth::user()->id)
                                                                                ->where('end_date_sessions','>',$date_now)
                                                                                ->count();
                if($check_last_sessions == 0)
                {
                    $id_admin 			= Auth::user()->id;
                    $data['add_groups'] = \App\Master_group::join('users','users_id','=','users.id')
                    										 ->where('users_id',$id_admin)
                    										 ->get();

                    return view('/dashboard/sessions/sessions_add',$data);
                }
                else
                    return redirect('/dashboard/sessions');
            }
        }
        else
            return redirect('/dashboard/sessions');
    }

    public function processadd(Request $request)
    {
    	$link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'add') == 'true')
        {
            $this->validate($request, [
            	'groups_id'				=> 'required|check_last_sessions|check_credit_sessions',
            	'date_sessions'			=> 'required',
                'credit_member_sessions'=> 'required|not_in:0|check_credit_members',
            ]);

            $id_groups 					= $request->groups_id;
            $get_date 					= $request->date_sessions;
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
            	'groups_id'				=> $id_groups,
            	'start_date_sessions'	=> $start_date,
            	'end_date_sessions'		=> $end_date,
            	'credit_member_sessions'=> $request->credit_member_sessions,
            	'status_active_sessions'=> $status,
            ];
            \App\Master_session::insert($data);
            
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
                    $redirect_page  = '/dashboard/sessions';

                return redirect($redirect_page);
            }
        }
        else
            return redirect('/dashboard/sessions');
    }

    public function edit($id_sessions=0)
    {
    	$link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'edit') == 'true')
        {
            if (!is_numeric($id_sessions))
                $id_sessions = 0;
            $check_sessions = \App\Master_session::where('id_sessions',$id_sessions)->count();
            if($check_sessions != 0)
            {
                $check_game = \App\Master_game::where('sessions_id',$id_sessions)->count();
                if($check_game == 0)
                {
	            	if(Auth::user()->level_systems_id == 1)
			        {
				        $data['edit_groups'] = \App\Master_group::get();
			        }
			        elseif(Auth::user()->level_systems_id == 2)
			        {
			        	$id_admin 			= Auth::user()->id;
			        	$data['edit_groups'] = \App\Master_group::join('users','users_id','=','users.id')
			        										->where('sub_users_id',$id_admin)
			        										->get();
			        }
			        elseif(Auth::user()->level_systems_id == 3)
			        {
			        	$id_admin 			= Auth::user()->id;
			        	$data['edit_groups'] = \App\Master_group::join('users','users_id','=','users.id')
			        											 ->where('users_id',$id_admin)
			        											 ->get();
			        }
	                $data['edit_sessions']		= \App\Master_session::where('id_sessions',$id_sessions)
	                														->first();
	                return view('dashboard/sessions/sessions_edit',$data);
                }
                else
                	return redirect('/dashboard/sessions');
            }
            else
                return redirect('/dashboard/sessions');
        }
        else
            return redirect('/dashboard/sessions');
    }

    public function processedit($id_sessions=0, Request $request)
    {
    	$link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'edit') == 'true')
        {
        	if (!is_numeric($id_sessions))
                $id_sessions = 0;
            $check_sessions = \App\Master_session::where('id_sessions',$id_sessions)->count();
            if($check_sessions != 0)
            {
                $check_game = \App\Master_game::where('sessions_id',$id_sessions)->count();
                if($check_game == 0)
                {
                	$this->validate($request, [
		    	    	'groups_id'				=> 'required',
		    	    	'date_sessions'			=> 'required',
                        'credit_member_sessions'=> 'required|not_in:0|check_credit_members',
		    	    ]);

		    	    $id_groups 					= $request->groups_id;
		    	    $get_date 					= $request->date_sessions;
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
		    	    	'groups_id'				=> $request->groups_id,
		    	    	'start_date_sessions'	=> $start_date,
		    	    	'end_date_sessions'		=> $end_date,
		    	    	'credit_member_sessions'=> $request->credit_member_sessions,
		    	    	'status_active_sessions'=> $status,
		    	    ];
		    	    \App\Master_session::where('id_sessions',$id_sessions)->update($data);

    	            if(request()->session()->get('page') != '')
    	                $redirect_page    = request()->session()->get('page');
    	            else
    	                $redirect_page  = '/dashboard/sessions';
    	            
    	            return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/sessions');
	        }
	        else
	        	return redirect('/dashboard/sessions');
        }
        else
            return redirect('/dashboard/sessions');
    }

    public function delete($id_sessions=0)
    {
    	$link_sessions = 'sessions';
        if(Shwetech::accessRights($link_sessions,'delete') == 'true')
        {
        	if (!is_numeric($id_sessions))
                $id_sessions = 0;
            $check_sessions = \App\Master_session::where('id_sessions',$id_sessions)->count();
            if($check_sessions != 0)
            {
                $check_game = \App\Master_game::where('sessions_id',$id_sessions)->count();
                if($check_game == 0)
                {
                    \App\Master_session::where('id_sessions',$id_sessions)
                                     	->delete();

                    if(request()->session()->get('page') != '')
                        $redirect_page    = request()->session()->get('page');
                    else
                        $redirect_page  = '/dashboard/sessions';
                    
                    return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/sessions');
            }
            else
                return redirect('/dashboard/sessions');
        }
        else
            return redirect('/dashboard/sessions');
    }

}