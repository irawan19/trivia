<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class AgentController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'view') == 'true')
        {
            $data['link_agent']          = $link_agent;
            $id_admins                  = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;

            if($id_level_systems == 1)
                $data['result_master_agent']   = '0';
            else
                $data['result_master_agent']   = $id_admins;
            $data['result_word']        = '';
           
            if($id_level_systems == 1)
            {
                $data['view_master_agent']     = \App\User::where('level_systems_id',2)
                                                    ->get();
            	$data['view_agents']    	= \App\User::join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
            											->where('level_systems_id','3')
            											->get();
            }
            else
            {
                $data['view_agents']     = \App\User::join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                                                        ->where('level_systems_id','3')
                                                        ->where('sub_users_id',$id_admins)
                                                        ->get();
            }
            session()->forget('page');
            session()->forget('result_master_agent');
            session()->forget('result_word');
        	return view('dashboard/agent/agent_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'view') == 'true')
        {
            $data['link_agent']         	= $link_agent;
            $url_now                    = $request->fullUrl();
            $id_admins                  = Auth::user()->id;
            $id_level_systems           = Auth::user()->level_systems_id;
            if($id_level_systems == 1)
                $result_master_agent           = $request->search_master_agent;
            else
                $result_master_agent           = $id_admins;
            $data['result_master_agent']       = $result_master_agent;
            $result_word                = $request->search_word;
            $data['result_word']        = $result_word;
            $data['view_master_agent']         = \App\User::where('level_systems_id',2)
                                                    ->get();
            if($result_master_agent != 0)
            {                                  
                $data['view_agents']        	= \App\User::join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                										->where('level_systems_id','3')
                										->where('sub_users_id',$result_master_agent)
            											->where('name', 'LIKE', '%'.$result_word.'%')
                                                        ->orWhere('phone_number_users', 'LIKE', '%'.$result_word.'%')
                                                        ->where('level_systems_id','3')
                                                        ->where('sub_users_id',$result_master_agent)
                                                        ->get();
            }
            else
            {
                $data['view_agents']         = \App\User::join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                                                        ->where('level_systems_id','3')
                                                        ->where('name', 'LIKE', '%'.$result_word.'%')
                                                        ->orWhere('phone_number_users', 'LIKE', '%'.$result_word.'%')
                                                        ->where('level_systems_id','3')
                                                        ->get();
            }
            session(['page'             => $url_now]);
            session(['result_master_agent'     => $result_master_agent]);
            session(['result_word'		=> $result_word]);
            return view('dashboard/agent/agent_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'add') == 'true')
        {
            $id_level_systems = Auth::user()->level_systems_id;
            if($id_level_systems == 1)
            {
                $data['add_sub_users']  = \App\Master_user::where('level_systems_id',2)->get();
                return view('dashboard/agent/agent_add',$data);
            }
            else
                return view('dashboard/agent/agent_add');
        }
        else
            return redirect('/dashboard/agent');
    }

    public function processadd(Request $request)
    {
    	$link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'add') == 'true')
        {
            $this->validate($request, [
                'sub_users_id'          => 'required',
                'name'               	=> 'required',
                'email'              	=> 'required|unique:users',
                'password'           	=> 'required|string|min:6|confirmed',
                'phone_number_users'    => 'required|numeric',
                'credit_users'          => 'required|check_credit_master_agent',
                'max_group_users'       => 'required|numeric'
            ]);

            $id_master_agent           = $request->sub_users_id;
            $get_master_agent          = \App\Master_user::where('id',$id_master_agent)->first();
            $credit_create_agent       = $request->credit_users;
    		$data = [
                'sub_users_id'       => $id_master_agent,
                'level_systems_id'   => 3,
    		    'name' 			     => $request->name,
    		    'email'			     => $request->email,
                'phone_number_users' => $request->phone_number_users,
                'bot_phone_number_users'=> $get_master_agent->bot_phone_number_users,
                'credit_users'       => $credit_create_agent,
                'max_group_users'    => $request->max_group_users,
    		    'created_at'	     => date('Y-m-d H:i:s'),
    		    'updated_at'	     => date('Y-m-d H:i:s'),
    		    'password' 		     => bcrypt($request->password),
    		    'remember_token'     => str_random(100)
    		];
    		\App\Master_user::insert($data);

            $credit_master_agent       = $get_master_agent->credit_users;
            $calculate_credit   = $credit_master_agent - $credit_create_agent;
            $credit_data        = [
                'credit_users'  => $calculate_credit
            ];
            \App\Master_user::where('id',$id_master_agent)->update($credit_data);
    	    
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
                    $redirect_page  = '/dashboard/agent';

                return redirect($redirect_page);
    	    }
        }
        else
            return redirect('/dashboard/agent');
    }

    public function read($id_agents=0)
    {
        $link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'read') == 'true')
        {
            if (!is_numeric($id_agents))
                $id_agents = 0;
            $check_agents = \App\Master_user::where('id',$id_agents)->count();
            if($check_agents != 0)
            {
                $data['read_agents']            = \App\Master_user::join('master_level_systems','master_level_systems.id_level_systems','=','users.level_systems_id')
                                                                    ->where('id',$id_agents)
                                                                    ->first();
                return view('dashboard/agent/agent_read',$data);
            }
            else
                return redirect('/dashboard/agent');
        }
        else
            return redirect('/dashboard/agent');
    }

    public function edit($id_agents=0)
    {
    	$link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'edit') == 'true')
        {
            if (!is_numeric($id_agents))
                $id_agents = 0;
            $check_agents = \App\Master_user::where('id',$id_agents)->count();
            if($check_agents != 0)
            {
                $id_level_systems = Auth::user()->level_systems_id;
                if($id_level_systems == 1)
                    $data['edit_sub_users']  = \App\Master_user::where('level_systems_id',2)->get();

                $data['edit_agents']			= \App\Master_user::where('id',$id_agents)
                													->first();
                return view('dashboard/agent/agent_edit',$data);
            }
            else
                return redirect('/dashboard/agent');
        }
        else
            return redirect('/dashboard/agent');
    }

    public function processedit($id_agents=0, Request $request)
    {
    	$link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'edit') == 'true')
        {
        	if (!is_numeric($id_agents))
                $id_agents = 0;
            $check_agents = \App\Master_user::where('id',$id_agents)->count();
            if($check_agents != 0)
            {
                $check_group = \App\Master_group::where('users_id',$id_agents)->count();
                if($check_group == 0)
                {
                	if($request->password != '')
                    {
                		$this->validate($request, [
                            'sub_users_id'          => 'required',
                            'name'                  => 'required',
                            'email'                 => 'required|unique:users,email,'.$id_agents.',id',
                            'password'              => 'required|string|min:6|confirmed',
                            'phone_number_users'    => 'required|numeric',
                            'credit_users'          => 'required|check_credit_master_agent_edit',
                            'max_group_users'       => 'required|numeric'
                        ]);

                        $get_agent           = \App\Master_user::where('id',$id_agents)->first();
                        $credit_agent        = $get_agent->credit_users;

                        $credit_create_agent = $request->credit_users;
                        $id_master_agent           = $request->sub_users_id;
                        $get_master_agent          = \App\Master_user::where('id',$id_master_agent)->first();
                        $credit_master_agent       = $get_master_agent->credit_users;
                        $calculate_credit   = ($credit_master_agent + $credit_agent) - $credit_create_agent;
                        $credit_data        = [
                            'credit_users'  => $calculate_credit
                        ];
                        \App\Master_user::where('id',$id_master_agent)->update($credit_data);

                	    $data = [
                            'level_systems_id'    => 3,
                            'sub_users_id'        => $id_master_agent,
                	        'name' 			      => $request->name,
                	        'email'			      => $request->email,
                	        'updated_at'	      => date('Y-m-d H:i:s'),
                	        'password' 		      => bcrypt($request->password),
                            'phone_number_users'  => $request->phone_number_users,
                            'bot_phone_number_users'=> $get_master_agent->bot_phone_number_users,
                            'credit_users'        => $credit_create_agent,
                            'max_group_users'     => $request->max_group_users
                	    ];
                	}
                	else
                	{
                		$this->validate($request, [
                            'sub_users_id'         => 'required',
                	        'name'                 => 'required',
                	        'email'                => 'required|unique:users,email,'.$id_agents.',id',
                            'phone_number_users'   => 'required|numeric',
                            'credit_users'         => 'required|check_credit_master_agent_edit',
                            'max_group_users'      => 'required|numeric',
                	    ]);

                        $get_agent           = \App\Master_user::where('id',$id_agents)->first();
                        $credit_agent        = $get_agent->credit_users;

                        $credit_create_agent = $request->credit_users;
                        $id_master_agent           = $request->sub_users_id;
                        $get_master_agent          = \App\Master_user::where('id',$id_master_agent)->first();
                        $credit_master_agent       = $get_master_agent->credit_users;
                        $calculate_credit   = ($credit_master_agent + $credit_agent) - $credit_create_agent;
                        $credit_data        = [
                            'credit_users'  => $calculate_credit
                        ];
                        \App\Master_user::where('id',$id_master_agent)->update($credit_data);

                	    $data = [
                	        'name' 			     	=> $request->name,
                	        'email'			     	=> $request->email,
                	        'updated_at'	     	=> date('Y-m-d H:i:s'),
                            'level_systems_id'    	=> 3,
                            'sub_users_id'          => $id_master_agent,
                            'phone_number_users'    => $request->phone_number_users,
                            'bot_phone_number_users'=> $get_master_agent->bot_phone_number_users,
                            'credit_users'          => $request->credit_users,
                            'max_group_users'       => $request->max_group_users
                	    ];
                	}
                }
                else
                {
                    if($request->password != '')
                    {
                        $this->validate($request, [
                            'sub_users_id'          => 'required',
                            'name'                  => 'required',
                            'email'                 => 'required|unique:users,email,'.$id_agents.',id',
                            'password'              => 'required|string|min:6|confirmed',
                            'phone_number_users'    => 'required|numeric',
                            'max_group_users'       => 'required|numeric'
                        ]);

                        $data = [
                            'level_systems_id'    => 3,
                            'sub_users_id'        => $request->sub_users_id,
                            'name'                => $request->name,
                            'email'               => $request->email,
                            'updated_at'          => date('Y-m-d H:i:s'),
                            'password'            => bcrypt($request->password),
                            'phone_number_users'  => $request->phone_number_users,
                            'bot_phone_number_users'=> $get_master_agent->bot_phone_number_users,
                            'max_group_users'     => $request->max_group_users
                        ];
                    }
                    else
                    {
                        $this->validate($request, [
                            'sub_users_id'         => 'required',
                            'name'                 => 'required',
                            'email'                => 'required|unique:users,email,'.$id_agents.',id',
                            'phone_number_users'   => 'required|numeric',
                            'max_group_users'      => 'required|numeric',
                        ]);

                        $data = [
                            'name'                  => $request->name,
                            'email'                 => $request->email,
                            'updated_at'            => date('Y-m-d H:i:s'),
                            'level_systems_id'      => 3,
                            'sub_users_id'          => $request->sub_users_id,
                            'phone_number_users'    => $request->phone_number_users,
                            'bot_phone_number_users'=> $get_master_agent->bot_phone_number_users,
                            'max_group_users'       => $request->max_group_users
                        ];
                    }
                }

            	\App\Master_user::where('id', $id_agents)->update($data);

	            if(request()->session()->get('page') != '')
	                $redirect_page    = request()->session()->get('page');
	            else
	                $redirect_page  = '/dashboard/agent';
	            
	            return redirect($redirect_page);
	        }
	        else
	        	return redirect('/dashboard/agent');
        }
        else
            return redirect('/dashboard/agent');
    }

    public function delete($id_agents=0)
    {
    	$link_agent = 'agent';
        if(Shwetech::accessRights($link_agent,'delete') == 'true')
        {
        	if (!is_numeric($id_agents))
                $id_agents = 0;
            $check_agents = \App\Master_user::where('id',$id_agents)->count();
            if($check_agents != 0)
            {
                $check_group = \App\Master_group::where('users_id',$id_agents)->count();
                if($check_group == 0)
                {
                    $get_agent           = \App\Master_user::where('id',$id_agents)->first();
                    $credit_agent        = $get_agent->credit_users;

                    $id_master_agent           = $get_agent->sub_users_id;
                    $get_master_agent          = \App\Master_user::where('id',$id_master_agent)->first();
                    $credit_master_agent       = $get_master_agent->credit_users;
                    $calculate_credit   = $credit_master_agent + $credit_agent;
                    $credit_data        = [
                        'credit_users'  => $calculate_credit
                    ];
                    \App\Master_user::where('id',$id_master_agent)->update($credit_data);

                    \App\Master_user::where('id',$id_agents)
                                      ->delete();

                    if(request()->session()->get('page') != '')
                        $redirect_page    = request()->session()->get('page');
                    else
                        $redirect_page  = '/dashboard/agent';
                    
                    return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/agent');
            }
            else
                return redirect('/dashboard/agent');
        }
        else
            return redirect('/dashboard/agent');
    }

}