<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class TopUpAgentController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'view') == 'true')
        {
            $data['link_top_up_agent']      	= $link_top_up_agent;
            $data['result_word']        		= '';
            $result_date_start              	= date('Y-m-d');
            $result_date_end                	= date('Y-m-d');
            $data['result_date_start']      	= $result_date_start;
            $data['result_date_end']        	= $result_date_end;

            $id_admins                  		= Auth::user()->id;
            $id_level_systems           		= Auth::user()->level_systems_id;
            if($id_level_systems == 1)
                $data['result_master_agent']   	= '0';
            else
                $data['result_master_agent']   	= $id_admins;

            if($id_level_systems == 1)
            {
            	$data['view_master_agent']     	= \App\User::where('level_systems_id',2)
                                                    		->get();
	        	$data['view_top_up_agents']    	= \App\Master_top_up::join('users','to_users_id','=','users.id')
	        													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
	        													->where('id_level_systems','3')
	                                                            ->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
	                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
	        													->get();
	        }
            else
            {
            	$data['view_top_up_agents']    	= \App\Master_top_up::join('users','to_users_id','=','users.id')
	        													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
	        													->where('id_level_systems','3')
	        													->where('sub_users_id',$id_admins)
	                                                            ->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
	                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
	        													->get();
            }
            session()->forget('page');
            session()->forget('result_word');
            session()->forget('result_date_start');
            session()->forget('result_date_end');
            session()->forget('result_master_agent');
        	return view('dashboard/top_up_agent/top_up_agent_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'view') == 'true')
        {
            $data['link_top_up_agent']      	= $link_top_up_agent;
            $url_now                    		= $request->fullUrl();
            $result_word                		= $request->search_word;
            $data['result_word']        		= $result_word;
            $result_date                    	= $request->search_date;
            $separate_daterange             	= explode(' - ',$result_date);
            $result_date_start              	= $separate_daterange[0];
            $result_date_end                	= $separate_daterange[1];
            $data['result_date_start']      	= $result_date_start;
            $data['result_date_end']        	= $result_date_end;
            $id_admins                  		= Auth::user()->id;
            $id_level_systems           		= Auth::user()->level_systems_id;
            if($id_level_systems == 1)
                $result_master_agent           	= $request->search_master_agent;
            else
                $result_master_agent           	= $id_admins;
            $data['view_master_agent']         	= \App\User::where('level_systems_id',2)
                                                    		->get();
            $data['result_master_agent']        = $result_master_agent;
            if($result_master_agent != 0)
            {
	            $data['view_top_up_agents']     	= \App\Master_top_up::join('users','to_users_id','=','users.id')
	        												->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
	        												->where('id_level_systems','3')
	        												->where('sub_users_id',$result_master_agent)
	                                                        ->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
	                                                        ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
	        												->where('name', 'LIKE', '%'.$result_word.'%')
                                                            ->where('id_level_systems','3')
                                                            ->where('sub_users_id',$result_master_agent)
                                                            ->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
	                                                    	->orWhere('phone_number_users', 'LIKE', '%'.$result_word.'%')
	                                                    	->where('id_level_systems','3')
	                                                    	->where('sub_users_id',$result_master_agent)
	                                                        ->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
	                                                        ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
	                                                    	->get();
	        }
            else
            {
            	$data['view_top_up_agents']     	= \App\Master_top_up::join('users','to_users_id','=','users.id')
	        												->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
	        												->where('id_level_systems','3')
	                                                        ->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
	                                                        ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
	        												->where('name', 'LIKE', '%'.$result_word.'%')
	                                                    	->orWhere('phone_number_users', 'LIKE', '%'.$result_word.'%')
	                                                    	->where('level_systems_id','3')
	                                                        ->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
	                                                        ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
	                                                    	->get();
            }
            session(['page'             		=> $url_now]);
            session(['result_word'				=> $result_word]);
            session(['result_date_start'        => $result_date_start]);
            session(['result_date_end'          => $result_date_end]);
            session(['result_master_agent'     		=> $result_master_agent]);
            return view('dashboard/top_up_agent/top_up_agent_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'add') == 'true')
        {
            $id_level_systems = Auth::user()->level_systems_id;
            if($id_level_systems == 1)
            {
                $data['add_agents']  = \App\Master_user::where('level_systems_id',3)->get();
                return view('dashboard/top_up_agent/top_up_agent_add',$data);
            }
            else
            {
                $id_admin           = Auth::user()->id;
                $data['add_agents'] = \App\Master_user::where('level_systems_id',3)
                                                        ->where('sub_users_id',$id_admin)
                                                        ->get();
                return view('dashboard/top_up_agent/top_up_agent_add', $data);
            }
        }
        else
            return redirect('/dashboard/top_up_agent');
    }

    public function processadd(Request $request)
    {
    	$link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'add') == 'true')
        {
            $this->validate($request, [
                'to_users_id'			=> 'required',
                'credit_top_ups'		=> 'required|numeric|check_top_up_agent',
            ]);

    		$id_agent 					= $request->to_users_id;
    		$get_credit 				= $request->credit_top_ups;

    		$data = [
                'from_users_id'	     => Auth::user()->id,
    			'to_users_id'		 => $id_agent,
                'to_register_members_id' => 0,
                'to_groups_id'       => 0,
    			'date_top_ups'		 => date('Y-m-d'),
    			'time_top_ups'		 => date('H:i:s'),
                'credit_top_ups'	 => $get_credit,
    		];
    		\App\Master_top_up::insert($data);

            $get_agent 			= \App\Master_user::where('id',$id_agent)->first();
    		$credit_agent 		= $get_agent->credit_users;
    		$calculate_credit	= $get_credit + $credit_agent;
    		$credit_data 		= [
    			'credit_users'	=> $calculate_credit
    		];
    		\App\Master_user::where('id',$id_agent)->update($credit_data);

            if(Auth::user()->level_systems_id == 2)
            {
                $id_master_agent                = Auth::user()->id;
                $get_master_agent               = \App\Master_user::where('id',$id_master_agent)->first();
                $credit_master_agent            = $get_master_agent->credit_users;
                $calculate_credit_master_agent  = $credit_master_agent - $get_credit;
                $credit_master_agent_data       = [
                    'credit_users'              => $calculate_credit_master_agent
                ];
                \App\Master_user::where('id',$id_master_agent)->update($credit_master_agent_data);
            }
    	    
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
                    $redirect_page  = '/dashboard/top_up_agent';

                return redirect($redirect_page);
    	    }
        }
        else
            return redirect('/dashboard/top_up_agent');
    }

    public function read($id_top_ups=0)
    {
        $link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'read') == 'true')
        {
            if (!is_numeric($id_top_ups))
                $id_top_ups = 0;
            $check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
                $data['read_top_up_agents']  = \App\Master_top_up::where('id_top_ups',$id_top_ups)
		                                                         ->first();
                return view('dashboard/top_up_agent/top_up_agent_read',$data);
            }
            else
                return redirect('/dashboard/top_up_agent');
        }
        else
            return redirect('/dashboard/top_up_agent');
    }

    public function edit($id_top_ups=0)
    {
    	$link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'edit') == 'true')
        {
            if (!is_numeric($id_top_ups))
                $id_top_ups = 0;
            $check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
                if(Auth::user()->level_systems_id == 1)
            	    $data['edit_agents']		= \App\Master_user::where('level_systems_id','3')->get();
                else
                {
                    $id_admin                   = Auth::user()->id;
                    $data['edit_agents']        = \App\Master_user::where('level_systems_id','3')
                                                                    ->where('sub_users_id',$id_admin)
                                                                    ->get();
                }
                $data['edit_top_up_agents']		= \App\Master_top_up::where('id_top_ups',$id_top_ups)
                														->first();
                return view('dashboard/top_up_agent/top_up_agent_edit',$data);
            }
            else
                return redirect('/dashboard/top_up_agent');
        }
        else
            return redirect('/dashboard/top_up_agent');
    }

    public function processedit($id_top_ups=0, Request $request)
    {
    	$link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'edit') == 'true')
        {
        	if (!is_numeric($id_top_ups))
                $id_top_ups = 0;
            $check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
            	$this->validate($request, [
                    'to_users_id'			=> 'required',
                	'credit_top_ups'		=> 'required|numeric|check_top_up_agent_edit',
                ]);

            	$id_agent 				= $request->to_users_id;
	            $get_credit 			= $request->credit_top_ups;
	            $get_agent 				= \App\Master_user::where('id',$id_agent)->first();
            	$credit_agent 			= $get_agent->credit_users;

                $get_credit_old			= \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
            	$credit_agent_old 		= $get_credit_old->credit_top_ups;

                if(Auth::user()->level_systems_id == 2)
                {
                    $id_master_agent                    = Auth::user()->id;
                    $get_master_agent                   = \App\Master_user::where('id',$id_master_agent)->first();
                    $credit_master_agent                = $get_master_agent->credit_users;
                    $calculate_credit_master_agent_old  = $credit_master_agent + $credit_agent_old;
                    $credit_master_agent_old_data       = [
                        'credit_users'                  => $calculate_credit_master_agent_old
                    ];
                    \App\Master_user::where('id',$id_master_agent)->update($credit_master_agent_old_data);
                }

            	$calculate_credit_old	= $credit_agent - $credit_agent_old;
            	$credit_old_data 		= [
            		'credit_users'		=> $calculate_credit_old
            	];
            	\App\Master_user::where('id',$id_agent)->update($credit_old_data);

	    		$data = [
	    			'from_users_id'	     => Auth::user()->id,
	    			'to_users_id'		 => $id_agent,
                    'to_register_members_id' => 0,
                    'to_groups_id'       => 0,
	    			'date_top_ups'		 => date('Y-m-d'),
	    			'time_top_ups'		 => date('H:i:s'),
	                'credit_top_ups'	 => $get_credit,
	    		];
            	\App\Master_top_up::where('id_top_ups', $id_top_ups)->update($data);

            	$get_agent_new 			= \App\Master_user::where('id',$id_agent)->first();
            	$credit_agent_new 		= $get_agent_new->credit_users;
	    		$calculate_credit_new	= $get_credit + $credit_agent_new;
	    		$credit_new_data 		= [
	    			'credit_users'	=> $calculate_credit_new
	    		];
	    		\App\Master_user::where('id',$id_agent)->update($credit_new_data);

                if(Auth::user()->level_systems_id == 2)
                {
                    $id_master_agent                = Auth::user()->id;
                    $get_master_agent               = \App\Master_user::where('id',$id_master_agent)->first();
                    $credit_master_agent            = $get_master_agent->credit_users;
                    $calculate_credit_master_agent  = $credit_master_agent - $get_credit;
                    $credit_master_agent_data       = [
                        'credit_users'              => $calculate_credit_master_agent
                    ];
                    \App\Master_user::where('id',$id_master_agent)->update($credit_master_agent_data);
                }

	            if(request()->session()->get('page') != '')
	                $redirect_page    = request()->session()->get('page');
	            else
	                $redirect_page  = '/dashboard/top_up_agent';
	            
	            return redirect($redirect_page);
	        }
	        else
	        	return redirect('/dashboard/top_up_agent');
        }
        else
            return redirect('/dashboard/top_up_agent');
    }

    public function delete($id_top_ups=0)
    {
    	$link_top_up_agent = 'top_up_agent';
        if(Shwetech::accessRights($link_top_up_agent,'delete') == 'true')
        {
        	if (!is_numeric($id_top_ups))
                $id_top_ups = 0;
            $check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
            	$get_top_ups 		= \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
            	$credit_top_ups 	= $get_top_ups->credit_top_ups;
            	

                $id_from_users      = $get_top_ups->from_users_id;
                $check_master_agent = \App\Master_user::where('id',$id_from_users)->first();
                if($check_master_agent->level_systems_id == 2)
                {
                    $id_master_agent                 = $id_from_users;
                    $get_credit_master_agent         = $check_master_agent->credit_users;
                    $calculate_credit_master_agent   = $get_credit_master_agent + $credit_top_ups;
                    $credit_master_agent_data = [
                        'credit_users'  => $calculate_credit_master_agent
                    ];
                    \App\Master_user::where('id',$id_master_agent)->update($credit_master_agent_data);
                }

                $id_agent 			= $get_top_ups->to_users_id;
            	$get_agent 			= \App\Master_user::where('id',$id_agent)->first();
            	$get_credit_agent	= $get_agent->credit_users;
            	$calculate_credit 	= $get_credit_agent - $credit_top_ups;
            	$credit_data 		= [
            		'credit_users'	=> $calculate_credit
            	];
            	\App\Master_user::where('id',$id_agent)->update($credit_data);

                \App\Master_top_up::where('id_top_ups',$id_top_ups)
                                 	->delete();

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/top_up_agent';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/top_up_agent');
        }
        else
            return redirect('/dashboard/top_up_agent');
    }
}