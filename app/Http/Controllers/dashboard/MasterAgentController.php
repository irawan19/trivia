<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class MasterAgentController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'view') == 'true')
        {
            $data['link_master_agent']         = $link_master_agent;
            $data['result_word']        = '';
        	$data['view_master_agents']    	= \App\User::where('level_systems_id','2')
        											->get();
            session()->forget('page');
            session()->forget('result_word');
        	return view('dashboard/master_agent/master_agent_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'view') == 'true')
        {
            $data['link_master_agent']         = $link_master_agent;
            $url_now                    = $request->fullUrl();
            $result_word                = $request->search_word;
            $data['result_word']        = $result_word;
            $data['view_master_agents']        = \App\User::where('level_systems_id','2')
        											->where('name', 'LIKE', '%'.$result_word.'%')
                                                    ->orWhere('phone_number_users', 'LIKE', '%'.$result_word.'%')
                                                    ->where('level_systems_id','2')
                                                    ->get();
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            return view('dashboard/master_agent/master_agent_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'add') == 'true')
            return view('dashboard/master_agent/master_agent_add');
        else
            return redirect('/dashboard/master_agent');
    }

    public function processadd(Request $request)
    {
    	$link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'add') == 'true')
        {
            $this->validate($request, [
                'name'               	=> 'required',
                'email'              	=> 'required|unique:users',
                'password'           	=> 'required|string|min:6|confirmed',
                'phone_number_users'	=> 'required|numeric',
                'bot_phone_number_users'=> 'required|numeric',
                'credit_users'			=> 'required|numeric',
            ]);

    		$data = [
                'sub_users_id'       => 0,
                'level_systems_id'   => 2,
    		    'name' 			     => $request->name,
    		    'email'			     => $request->email,
                'phone_number_users' => $request->phone_number_users,
                'bot_phone_number_users'=> $request->bot_phone_number_users,
                'credit_users'		 => $request->credit_users,
                'max_group_users'    => 0,
    		    'created_at'	     => date('Y-m-d H:i:s'),
    		    'updated_at'	     => date('Y-m-d H:i:s'),
    		    'password' 		     => bcrypt($request->password),
    		    'remember_token'     => str_random(100)
    		];

    		\App\Master_user::insert($data);
    	    
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
                    $redirect_page  = '/dashboard/master_agent';

                return redirect($redirect_page);
    	    }
        }
        else
            return redirect('/dashboard/master_agent');
    }

    public function read($id_master_agents=0)
    {
        $link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'read') == 'true')
        {
            if (!is_numeric($id_master_agents))
                $id_master_agents = 0;
            $check_master_agents = \App\Master_user::where('id',$id_master_agents)->count();
            if($check_master_agents != 0)
            {
                $data['read_master_agents']            = \App\Master_user::join('master_level_systems','master_level_systems.id_level_systems','=','users.level_systems_id')
                                                                    ->where('id',$id_master_agents)
                                                                    ->first();
                return view('dashboard/master_agent/master_agent_read',$data);
            }
            else
                return redirect('/dashboard/master_agent');
        }
        else
            return redirect('/dashboard/master_agent');
    }

    public function edit($id_master_agents=0)
    {
    	$link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'edit') == 'true')
        {
            if (!is_numeric($id_master_agents))
                $id_master_agents = 0;
            $check_master_agents = \App\Master_user::where('id',$id_master_agents)->count();
            if($check_master_agents != 0)
            {
                $data['edit_master_agents']			= \App\Master_user::where('id',$id_master_agents)
                													->first();
                return view('dashboard/master_agent/master_agent_edit',$data);
            }
            else
                return redirect('/dashboard/master_agent');
        }
        else
            return redirect('/dashboard/master_agent');
    }

    public function processedit($id_master_agents=0, Request $request)
    {
    	$link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'edit') == 'true')
        {
        	if (!is_numeric($id_master_agents))
                $id_master_agents = 0;
            $check_master_agents = \App\Master_user::where('id',$id_master_agents)->count();
            if($check_master_agents != 0)
            {
            	if($request->password != '')
                {
            		$this->validate($request, [
                        'name'                  => 'required',
                        'email'                 => 'required|unique:users,email,'.$id_master_agents.',id',
                        'password'              => 'required|string|min:6|confirmed',
                        'phone_number_users'	=> 'required|numeric',
                        'bot_phone_number_users'=> 'required|numeric',
                        'credit_users'			=> 'required|numeric',
                    ]);

            	    $data = [
                        'level_systems_id'    => 2,
                        'sub_users_id'        => 0,
            	        'name' 			      => $request->name,
            	        'email'			      => $request->email,
            	        'updated_at'	      => date('Y-m-d H:i:s'),
            	        'password' 		      => bcrypt($request->password),
                        'phone_number_users'  => $request->phone_number_users,
                        'bot_phone_number_users' => $request->bot_phone_number_users,
                		'credit_users'		  => $request->credit_users,
                        'max_group_users'     => 0
            	    ];
            	}
            	else
            	{
            		$this->validate($request, [
            	        'name'                 => 'required',
            	        'email'                => 'required|unique:users,email,'.$id_master_agents.',id',
            	        'phone_number_users'   => 'required|numeric',
                        'bot_phone_number_users'=> 'required|numeric',
            	        'credit_users'		   => 'required|numeric'
            	    ]);

            	    $data = [
            	        'name' 			     	=> $request->name,
            	        'email'			     	=> $request->email,
            	        'updated_at'	     	=> date('Y-m-d H:i:s'),
                        'level_systems_id'    	=> 2,
                        'sub_users_id'          => 0,
                        'phone_number_users'    => $request->phone_number_users,
                        'bot_phone_number_users'=> $request->bot_phone_number_users,
                		'credit_users'		 	=> $request->credit_users,
                        'max_group_users'       => 0
            	    ];
            	}

            	\App\Master_user::where('id', $id_master_agents)->update($data);

                $agent_data = [
                    'bot_phone_number_users'    => $request->bot_phone_number_users,
                ];
                \App\Master_user::where('sub_users_id',$id_master_agents)->update($agent_data);

	            if(request()->session()->get('page') != '')
	                $redirect_page    = request()->session()->get('page');
	            else
	                $redirect_page  = '/dashboard/master_agent';
	            
	            return redirect($redirect_page);
	        }
	        else
	        	return redirect('/dashboard/master_agent');
        }
        else
            return redirect('/dashboard/master_agent');
    }

    public function delete($id_master_agents=0)
    {
    	$link_master_agent = 'master_agent';
        if(Shwetech::accessRights($link_master_agent,'delete') == 'true')
        {
        	if (!is_numeric($id_master_agents))
                $id_master_agents = 0;
            $check_master_agents = \App\Master_user::where('id',$id_master_agents)->count();
            if($check_master_agents != 0)
            {
                $check_agent = \App\Master_user::where('sub_users_id',$id_master_agents)->count();
                if($check_agent == 0)
                {
                    \App\Master_user::where('id',$id_master_agents)
                                     ->delete();

                    if(request()->session()->get('page') != '')
                        $redirect_page    = request()->session()->get('page');
                    else
                        $redirect_page  = '/dashboard/master_agent';
                    
                    return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/master_agent');
            }
            else
                return redirect('/dashboard/master_agent');
        }
        else
            return redirect('/dashboard/master_agent');
    }

}