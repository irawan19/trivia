<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class GroupController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_group = 'group';
        if(Shwetech::accessRights($link_group,'view') == 'true')
        {
            $data['link_group']         = $link_group;
            $data['result_word']        = '';
            $id_admin 					= Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            $data['result_word']        = '';
	        if($id_level_systems == 1)
	        {
                $data['result_agent']        = 0;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->get();
	        	$data['view_groups']		= \App\Master_group::get();
	        }
            elseif($id_level_systems == 2)
            {
                $data['result_agent']        = 0;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('sub_users_id',$id_admin)
                                                        ->get();
                $data['view_groups']        = \App\Master_group::join('users','users_id','=','master_group.users_id')
                                                                ->where('sub_users_id',$id_admin)
                                                                ->get();
            }
	        elseif($id_level_systems == 3)
	        {
                $data['result_agent']        = $id_admin;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('id',$id_admin)
                                                        ->get();
		        $data['view_groups']    	= \App\Master_group::where('users_id',$id_admin)
		        												->get();
	        }
            session()->forget('page');
            session()->forget('result_word');
            session()->forget('result_agent');
        	return view('dashboard/group/group_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_group = 'group';
        if(Shwetech::accessRights($link_group,'view') == 'true')
        {
            $data['link_group']         = $link_group;
            $url_now                    = $request->fullUrl();
            $result_word                = $request->search_word;
            $data['result_word']        = $result_word;
            $id_admin                   = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                    ->get();
            if($id_level_systems == 1)
            {
                $result_agent                = $request->search_agent; 
                $data['result_agent']        = $result_agent;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->get();
	            $data['view_groups']        = \App\Master_group::where('name_groups', 'LIKE', '%'.$result_word.'%')
                                                        ->get();
            }
            elseif($id_level_systems == 2)
            {
                $result_agent                = $request->search_agent;
                $data['result_agent']        = $result_agent;
                $data['view_agent']          = \App\User::where('level_systems_id',3)
                                                        ->where('sub_users_id',$id_admin)
                                                        ->get();
            	$data['view_groups']        = \App\Master_group::join('users','users_id','=','master_group.users_id')
                                                                ->where('sub_users_id',$id_admin)
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
                $data['view_groups']        = \App\Master_group::where('id',$id_admin)
                                                                ->where('name_groups', 'LIKE', '%'.$result_word.'%')
                                                                ->get();
            }
            
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            session(['result_agent'     => $result_agent]);
            return view('dashboard/group/group_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_group = 'group';
        if(Shwetech::accessRights($link_group,'add') == 'true')
        {
            if(Auth::user()->level_systems_id != '3')
            {
                $data['add_agents']  = \App\Master_user::where('level_systems_id',3)->get();
                return view('dashboard/group/group_add',$data);
            }
            elseif(Auth::user()->level_systems_id == '3')
            {
                $get_users = \App\Master_user::where('id',Auth::user()->id)->first();
                $check_total_group = \App\Master_group::where('users_id',Auth::user()->id)->count();
                if($check_total_group < $get_users->max_group_users)
                {
                    $data['add_agents']  = \App\Master_user::where('level_systems_id',3)->first();
                    return view('dashboard/group/group_add',$data);
                }
                else
                    return redirect('/dashboard/group');
            }
        }
        else
            return redirect('/dashboard/group');
    }

    public function processadd(Request $request)
    {
    	$link_group = 'group';
        if(Shwetech::accessRights($link_group,'add') == 'true')
        {
            if(Auth::user()->level_systems_id != '3')
            {
    	        $this->validate($request, [
    	        	'users_id'			=> 'required',
    	        	'name_groups'		=> 'required|check_whitespace|check_name_group',
                    'credit_agents'      => 'required|not_in:0',
                    'credit_groups'     => 'required|not_in:0|check_credit_groups',
    	        ]);

                $id_admin = $request->users_id;

    	    	$data = [
    	    		'users_id'			=> $id_admin,
    	    		'name_groups'		=> $request->name_groups,
    	    		'credit_groups'		=> $request->credit_groups,
    	    		'whatsapp_group_id'	=> '',
    	    		'created_on_groups'	=> date('Y-m-d H:i:s')
    	    	];
    	    	\App\Master_group::insert($data);

                $calculate_credit_agent = $request->credit_agents - $request->credit_groups;
    	    	$credit_data = [
    	    		'credit_users'	  => $calculate_credit_agent
    	    	];
    	    	\App\Master_user::where('id',$id_admin)->update($credit_data);
    	    	
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
    	                $redirect_page  = '/dashboard/group';

    	            return redirect($redirect_page);
    	    	}
            }
            else
            {
                $get_users = \App\Master_user::where('id',Auth::user()->id)->first();
                $check_total_group = \App\Master_group::where('users_id',Auth::user()->id)->count();
                if($check_total_group < $get_users->max_group_users)
                {
                    $this->validate($request, [
                        'users_id'          => 'required',
                        'name_groups'       => 'required|check_whitespace|check_name_group',
                        'credit_agents'      => 'required|not_in:0',
                        'credit_groups'     => 'required|not_in:0|check_credit_groups',
                    ]);

                    $id_admin = $request->users_id;

                    $data = [
                        'users_id'          => $id_admin,
                        'name_groups'       => $request->name_groups,
                        'credit_groups'     => $request->credit_groups,
                        'whatsapp_group_id' => '',
                        'created_on_groups' => date('Y-m-d H:i:s')
                    ];
                    \App\Master_group::insert($data);

                    $calculate_credit_agent = $request->credit_agents - $request->credit_groups;
                    $credit_data = [
                        'credit_users'    => $calculate_credit_agent
                    ];
                    \App\Master_user::where('id',$id_admin)->update($credit_data);
                    
                    $save           = $request->save;
                    $save_exit      = $request->save_exit;
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
                            $redirect_page  = '/dashboard/group';

                        return redirect($redirect_page);
                    }
                }
                else
                    return redirect('/dashboard/group');
            }
        }
        else
            return redirect('/dashboard/group');
    }

    public function edit($id_groups=0)
    {
    	$link_group = 'group';
        if(Shwetech::accessRights($link_group,'edit') == 'true')
        {
            if (!is_numeric($id_groups))
                $id_groups = 0;
            $check_groups = \App\Master_group::where('id_groups',$id_groups)->count();
            if($check_groups != 0)
            {
                $check_sessions = \App\Master_session::where('groups_id',$id_groups)->count();
                if($check_sessions == 0)
                {
                	$data['edit_agents']			= \App\Master_user::where('level_systems_id','3')->get();
                    $data['edit_groups']		= \App\Master_group::join('users','users_id','=','users.id')
                                                                    ->where('id_groups',$id_groups)
                    											    ->first();
                    return view('dashboard/group/group_edit',$data);
                }
                else
                    return redirect('/dashboard/group');
            }
            else
                return redirect('/dashboard/group');
        }
        else
            return redirect('/dashboard/group');
    }

    public function processedit($id_groups=0, Request $request)
    {
    	$link_group = 'group';
        if(Shwetech::accessRights($link_group,'edit') == 'true')
        {
        	if (!is_numeric($id_groups))
                $id_groups = 0;
            $check_groups = \App\Master_group::where('id_groups',$id_groups)->count();
            if($check_groups != 0)
            {
                $check_sessions = \App\Master_session::where('groups_id',$id_groups)->count();
                if($check_sessions == 0)
                {
                	$this->validate($request, [
    		        	'users_id'			=> 'required',
    		        	'name_groups'		=> 'required|check_whitespace|check_name_group_edit',
                        'credit_agents'      => 'required|not_in:0',
                        'credit_groups'     => 'required|not_in:0|check_credit_groups'
    		        ]);

                    $id_admin           = $request->users_id;
                    $get_credit_agents   = $request->credit_agents;
                    $get_credit_groups  = $request->credit_groups;
                    $calculate_credit   = $get_credit_agents - $get_credit_groups; 
                    $data               = [
                        'users_id'          => $id_admin,
                        'name_groups'       => $request->name_groups,
                        'credit_groups'     => $request->credit_groups,
                        'whatsapp_group_id' => '',
                        'created_on_groups' => date('Y-m-d')
                    ];
                    \App\Master_group::where('id_groups',$id_groups)->update($data);

                    $credit_data        = [
                        'credit_users'      => $calculate_credit
                    ];
                    \App\Master_user::where('id',$id_admin)->update($credit_data);

    	            if(request()->session()->get('page') != '')
    	                $redirect_page    = request()->session()->get('page');
    	            else
    	                $redirect_page  = '/dashboard/group';
    	            
    	            return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/group');
	        }
	        else
	        	return redirect('/dashboard/group');
        }
        else
            return redirect('/dashboard/group');
    }

    public function delete($id_groups=0)
    {
    	$link_group = 'group';
        if(Shwetech::accessRights($link_group,'delete') == 'true')
        {
        	if (!is_numeric($id_groups))
                $id_groups = 0;
            $check_groups = \App\Master_group::where('id_groups',$id_groups)->count();
            if($check_groups != 0)
            {
                $check_sessions = \App\Master_session::where('groups_id',$id_groups)->count();
                if($check_sessions == 0)
                {
                	$get_groups 		= \App\Master_group::where('id_groups',$id_groups)->first();
                	$credit_groups 		= $get_groups->credit_groups;
                	$id_agent 			= $get_groups->users_id;
                	$get_agent 			= \App\Master_user::where('id',$id_agent)->first();
                	$get_credit_agent	= $get_agent->credit_users;
                	$calculate_credit 	= $get_credit_agent + $credit_groups;
                	$credit_data 		= [
                		'credit_users'	=> $calculate_credit
                	];
                	\App\Master_user::where('id',$id_agent)->update($credit_data);

                    \App\Master_group::where('id_groups',$id_groups)
                                     	->delete();

                    if(request()->session()->get('page') != '')
                        $redirect_page    = request()->session()->get('page');
                    else
                        $redirect_page  = '/dashboard/group';
                    
                    return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/group');
            }
            else
                return redirect('/dashboard/group');
        }
        else
            return redirect('/dashboard/group');
    }

}