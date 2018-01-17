<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class TopUpGroupController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_top_up_group = 'top_up_group';
        if(Shwetech::accessRights($link_top_up_group,'view') == 'true')
        {
            $data['link_top_up_group']      	= $link_top_up_group;
            $data['result_word']        		= '';
            $result_date_start              	= date('Y-m-d');
            $result_date_end                	= date('Y-m-d');
            $data['result_date_start']      	= $result_date_start;
            $data['result_date_end']        	= $result_date_end;

            $id_admins                  		= Auth::user()->id;
            $id_level_systems           		= Auth::user()->level_systems_id;

            if($id_level_systems == 1)
            {
                $data['result_agent']           = '0';
            	$data['view_agent']     		= \App\User::where('level_systems_id',3)
                                                    		->get();

                $data['view_top_up_groups']		= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
	        }
            elseif($id_level_systems == 2)
            {
                $data['result_agent']               = 0;
                $data['view_agent']                 = \App\User::where('level_systems_id',3)
                                                                ->where('sub_users_id',$id_admins)
                                                                ->get();
                $data['view_top_up_groups']			= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                                                                	->where('users.sub_users_id',$id_admins)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
            }
            else
            {
                $data['result_agent']               = $id_admins;
            	$data['view_top_up_groups']			= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                                                                	->where('users.id',$id_admins)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
            }
            session()->forget('page');
            session()->forget('result_word');
            session()->forget('result_date_start');
            session()->forget('result_date_end');
            session()->forget('result_agent');
        	return view('dashboard/top_up_group/top_up_group_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_top_up_group = 'top_up_group';
        if(Shwetech::accessRights($link_top_up_group,'view') == 'true')
        {
            $data['link_top_up_group']      	= $link_top_up_group;
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

            if($id_level_systems != 3)
                $result_agent           		= $request->search_agent;
            else
                $result_agent           		= $id_admins;

            $data['view_agent']                 = \App\User::where('level_systems_id',3)
                                                    		  ->get();

            $data['result_agent']               = $result_agent;

            if($result_agent != 0)
            {
            	if($id_level_systems == 1)
            	{
            		$data['view_top_up_groups']		= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                													->where('users.id',$result_agent)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		                                                            ->where('name_groups', 'LIKE', '%'.$result_word.'%')
		                                                            ->orWhere('users.name', 'LIKE', '%'.$result_word.'%')
		                                                            ->where('users.id',$result_agent)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
            	}
            	elseif($id_level_systems == 2)
            	{
            		$data['view_top_up_groups']		= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                													->where('users.id',$result_agent)
                													->where('users.sub_users_id',$id_admins)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		                                                            ->where('name_groups', 'LIKE', '%'.$result_word.'%')
		                                                            ->orWhere('users.name', 'LIKE', '%'.$result_word.'%')
		                                                            ->where('users.id',$result_agent)
                													->where('users.sub_users_id',$id_admins)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
            	}
            	elseif($id_level_systems == 3)
            	{
            		$data['view_top_up_groups']		= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                													->where('users.id',$result_agent)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		                                                            ->where('name_groups', 'LIKE', '%'.$result_word.'%')
		                                                            ->orWhere('users.name', 'LIKE', '%'.$result_word.'%')
		                                                            ->where('users.id',$result_agent)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
            	}
	        }
            else
            {
                if($id_level_systems == 1)
                {
                    $data['view_top_up_groups']		= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		                                                            ->where('name_groups', 'LIKE', '%'.$result_word.'%')
		                                                            ->orWhere('users.name', 'LIKE', '%'.$result_word.'%')
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
                }
                elseif($id_level_systems == 2)
                {
                    $data['view_top_up_groups']		= \App\Master_top_up::join('master_groups','to_groups_id','=','master_groups.id_groups')
                													->join('users','from_users_id','=','users.id')
                													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
                													->where('users.sub_users_id',$id_admins)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		                                                            ->where('name_groups', 'LIKE', '%'.$result_word.'%')
		                                                            ->orWhere('users.name', 'LIKE', '%'.$result_word.'%')
                													->where('users.sub_users_id',$id_admins)
                													->whereRaw('DATE(date_top_ups) >= "'.$result_date_start.'"')
		                                                            ->whereRaw('DATE(date_top_ups) <= "'.$result_date_end.'"')
		        													->get();
                }
            }
            session(['page'             		=> $url_now]);
            session(['result_word'				=> $result_word]);
            session(['result_date_start'        => $result_date_start]);
            session(['result_date_end'          => $result_date_end]);
            session(['result_agent'     	    => $result_agent]);
            return view('dashboard/top_up_group/top_up_group_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_top_up_group = 'top_up_group';
        if(Shwetech::accessRights($link_top_up_group,'add') == 'true')
        {
        	$id_admins 			= Auth::user()->id; 
            $id_level_systems 	= Auth::user()->level_systems_id;
            if($id_level_systems == 1)
            {
            	$data['add_groups']		= \App\Master_group::join('users','users_id','=','users.id')
            												->get();
            }
            elseif($id_level_systems == 2)
            {
            	$data['add_groups']		= \App\Master_group::join('users','users_id','=','users.id')
            												->where('users.sub_users_id',$id_admins)
            												->get();
            }
            else
            {
            	$data['add_groups']		= \App\Master_group::join('users','users_id','=','users.id')
            												->where('users.id',$id_admins)
            												->get();
            }
            return view('dashboard/top_up_group/top_up_group_add', $data);
        }
        else
            return redirect('/dashboard/top_up_group');
    }

    public function processadd(Request $request)
    {
    	$link_top_up_group = 'top_up_group';
        if(Shwetech::accessRights($link_top_up_group,'add') == 'true')
        {
            $this->validate($request, [
                'to_groups_id'	    => 'required',
                'credit_top_ups'	=> 'required|numeric|check_top_up_group',
            ]);

            $id_groups 				= $request->to_groups_id;
            $get_credit 			= $request->credit_top_ups;

            $data = [
            	'from_users_id'				=> Auth::user()->id,
            	'to_users_id'				=> 0,
            	'to_register_members_id'	=> 0,
            	'to_groups_id'				=> $id_groups,
            	'date_top_ups'				=> date('Y-m-d'),
            	'time_top_ups'				=> date('H:i:s'),
            	'credit_top_ups'			=> $get_credit
            ];
            \App\Master_top_up::insert($data);

            if(Auth::user()->level_systems_id != 1)
            {
            	$id_agent_master_agent 			=  Auth::user()->id;
            	$get_credit_agent_master_agent	= \App\Master_user::where('id',$id_agent_master_agent)->first();
            	$credit_agent_master_agent 		= $get_credit_agent_master_agent->credit_users;
            	$calculate_agent_master_agent 	= $credit_agent_master_agent - $get_credit;
            	$credit_agent_master_agent_data = [
            		'credit_users'				=> $calculate_agent_master_agent
            	];
            	\App\Master_user::where('id',$id_agent_master_agent)->update($credit_agent_master_agent_data);
            }

            $get_group					= \App\Master_group::where('id_groups',$id_groups)->first();
            $credit_group 				= $get_group->credit_groups;
            $calculate_credit_group 	= $credit_group + $get_credit;
            $credit_group_data 			= [
            	'credit_groups'			=> $calculate_credit_group
            ];
            \App\Master_group::where('id_groups',$id_groups)->update($credit_group_data);

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
                    $redirect_page  = '/dashboard/top_up_group';

                return redirect($redirect_page);
    	    }
        }
        else
            return redirect('/dashboard/top_up_group');
    }

    public function read($id_top_ups=0)
    {
    	$link_top_up_group = 'top_up_group';
    	if(Shwetech::accessRights($link_top_up_group, 'read') == 'true')
    	{
    		if(!is_numeric($id_top_ups))
    			$id_top_ups = 0;
    		$check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
                $data['read_top_up_groups']  = \App\Master_top_up::where('id_top_ups',$id_top_ups)
                                                                 ->first();
                return view('dashboard/top_up_group/top_up_group_read',$data);
            }
            else
                return redirect('/dashboard/top_up_group');
    	}
    	else
    		return redirect('dashboard/top_up_group');
    }

    public function edit($id_top_ups=0)
    {
    	$link_top_up_group = 'top_up_group';
    	if(Shwetech::accessRights($link_top_up_group, 'edit') == 'true')
    	{
    		if(!is_numeric($id_top_ups))
    			$id_top_ups = 0;
    		$check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
                $id_admins 			= Auth::user()->id; 
	            $id_level_systems 	= Auth::user()->level_systems_id;
	            if($id_level_systems == 1)
	            {
	            	$data['edit_groups']		= \App\Master_group::join('users','users_id','=','users.id')
	            												->get();
	            }
	            elseif($id_level_systems == 2)
	            {
	            	$data['edit_groups']		= \App\Master_group::join('users','users_id','=','users.id')
	            												->where('users.sub_users_id',$id_admins)
	            												->get();
	            }
	            else
	            {
	            	$data['edit_groups']		= \App\Master_group::join('users','users_id','=','users.id')
	            												->where('users.id',$id_admins)
	            												->get();
	            }
	            $data['edit_top_up_groups']		= \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
	            return view('dashboard/top_up_group/top_up_group_edit', $data);
            }
            else
                return redirect('/dashboard/top_up_group');
    	}
    	else
    		return redirect('dashboard/top_up_group');
    }

    public function processedit($id_top_ups=0, Request $request)
    {
        $link_top_up_group = 'top_up_group';
        if(Shwetech::accessRights($link_top_up_group,'edit') == 'true')
        {
            if (!is_numeric($id_top_ups))
                $id_top_ups = 0;
            $check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
                $this->validate($request, [
                    'to_groups_id'            => 'required',
                    'credit_top_ups'          => 'required|numeric|check_top_up_group_edit',
                ]);

                $id_agent_master_agent 					= Auth::user()->id;
                $id_groups 								= $request->to_groups_id;
                $get_credit 							= $request->credit_top_ups;
                $get_credit_groups 						= \App\Master_group::where('id_groups',$id_groups)->first();
                $credit_groups 							= $get_credit_groups->credit_groups;

                $get_credit_groups_old 					= \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
                $credit_groups_old 						= $get_credit_groups_old->credit_top_ups;

                if(Auth::user()->level_systems_id != 1)
                {
                	$get_agent_master_agent 					= \App\Master_user::where('id',$id_agent_master_agent)->first();
                	$credit_agent_master_agent 					= $get_agent_master_agent->credit_users;
                	$calculate_credit_agent_master_agent_old	= $credit_agent_master_agent + $credit_groups_old;
                	$credit_agent_master_agent_old_data 		= [
                		'credit_users'							=> $calculate_credit_agent_master_agent_old
                	];
                	\App\Master_user::where('id',$id_agent_master_agent)->update($credit_agent_master_agent_old_data);
                }

                $calculate_credit_group_old 	= $credit_groups - $credit_groups_old;
                $credit_groups_old_data 		= [
                	'credit_groups'				=> $calculate_credit_group_old
                ];
                \App\Master_group::where('id_groups',$id_groups)->update($credit_groups_old_data);

                $data = [
                	'from_users_id'				=> Auth::user()->id,
                	'to_users_id'				=> 0,
                	'to_register_members_id'	=> 0,
                	'to_groups_id'				=> $id_groups,
                	'date_top_ups'				=> date('Y-m-d'),
                	'time_top_ups'				=> date('H:i:s'),
                	'credit_top_ups'			=> $get_credit,
                ];
                \App\Master_top_up::where('id_top_ups',$id_top_ups)->update($data);

                $get_groups_new 					= \App\Master_group::where('id_groups',$id_groups)->first();
                $credit_groups_new 					= $get_groups_new->credit_groups;
                $calculate_credit_new 				= $get_credit + $credit_groups_new;
                $credit_new_data 					= [
                	'credit_groups'					=> $calculate_credit_new
                ];
                \App\Master_group::where('id_groups',$id_groups)->update($credit_new_data);

                if(Auth::user()->level_systems_id != 1)
                {
                	$get_agent_master_agent 					= \App\Master_user::where('id',$id_agent_master_agent)->first();
                	$credit_agent_master_agent_new 				= $get_agent_master_agent->credit_users;
                	$calculate_credit_agent_master_agent_new	= $credit_agent_master_agent_new - $get_credit;
                	$credit_agent_master_agent_data_new			= [
                		'credit_users'							=> $calculate_credit_agent_master_agent_new
                	];
                	\App\Master_user::where('id',$id_agent_master_agent)->update($credit_agent_master_agent_data_new);
                }

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/top_up_group';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/top_up_group');
        }
        else
            return redirect('/dashboard/top_up_group');
    }

    public function delete($id_top_ups=0)
    {
        $link_top_up_group = 'top_up_group';
        if(Shwetech::accessRights($link_top_up_group,'delete') == 'true')
        {
            if (!is_numeric($id_top_ups))
                $id_top_ups = 0;
            $check_top_ups = \App\Master_top_up::where('id_top_ups',$id_top_ups)->count();
            if($check_top_ups != 0)
            {
                $get_top_ups           	= \App\Master_top_up::where('id_top_ups',$id_top_ups)->first();
                $credit_top_ups        	= $get_top_ups->credit_top_ups;
                $id_groups 				= $get_top_ups->to_groups_id;
                $id_from_user	 		= $get_top_ups->from_users_id;

                $get_from_user 			= \App\Master_user::where('id',$id_from_user)->first();
                if($get_from_user->level_systems_id != 1)
                {
                	$id_agent_master_agent 					= $id_from_user;
                	$get_credit_agent_master_agent			= $get_from_user->credit_users;
                	$calculate_credit_agent_master_agent 	= $get_credit_agent_master_agent + $credit_top_ups;
                	$credit_agent_master_agent_data 		= [
                		'credit_users'						=> $calculate_credit_agent_master_agent
                	];
                	\App\Master_user::where('id',$id_agent_master_agent)->update($credit_agent_master_agent_data);
                }

                $get_credit_groups 				= \App\Master_group::where('id_groups',$id_groups)->first();
                $credit_groups 					= $get_credit_groups->credit_groups;
                $calculate_credit_group   		= $credit_groups - $credit_top_ups;
                $calculate_credit_group_data 	= [
                	'credit_groups'				=> $calculate_credit_group
                ];
                \App\Master_group::where('id_groups',$id_groups)->update($calculate_credit_group_data);
                
                \App\Master_top_up::where('id_top_ups',$id_top_ups)->delete();

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/top_up_group';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/top_up_group');
        }
        else
            return redirect('/dashboard/top_up_group');
    }

}