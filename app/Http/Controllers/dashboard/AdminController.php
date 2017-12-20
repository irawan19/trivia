<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class AdminController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'view') == 'true')
        {
            $data['link_admin']         = $link_admin;
            $data['result_word']        = '';
        	$data['view_admins']    	= \App\User::where('level_systems_id','1')
        											->get();
            session()->forget('page');
            session()->forget('result_word');
        	return view('dashboard/admin/admin_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'view') == 'true')
        {
            $data['link_admin']         = $link_admin;
            $url_now                    = $request->fullUrl();
            $result_word                = $request->search_word;
            $data['result_word']        = $result_word;
            $data['view_admins']        = \App\User::where('level_systems_id','1')
        											->where('name_level_systems', 'LIKE', '%'.$result_word.'%')
                                                    ->get();
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            return view('dashboard/admin/admin_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'add') == 'true')
            return view('dashboard/admin/admin_add');
        else
            return redirect('/dashboard/admin');
    }

    public function processadd(Request $request)
    {
    	$link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'add') == 'true')
        {
            $this->validate($request, [
                'name'               	=> 'required',
                'email'              	=> 'required|unique:users',
                'password'           	=> 'required|string|min:6|confirmed',
            ]);

    		$data = [
                'sub_users_id'       => 0,
                'level_systems_id'   => 1,
    		    'name' 			     => $request->name,
    		    'email'			     => $request->email,
                'phone_number_users' => 0,
                'credit_users'       => 0,
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
                    $redirect_page  = '/dashboard/admin';

                return redirect($redirect_page);
    	    }
        }
        else
            return redirect('/dashboard/admin');
    }

    public function read($id_admins=0)
    {
        $link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'read') == 'true')
        {
            if (!is_numeric($id_admins))
                $id_admins = 0;
            $check_admins = \App\Master_user::where('id',$id_admins)->count();
            if($check_admins != 0)
            {
                $data['read_admins']            = \App\Master_user::join('master_level_systems','master_level_systems.id_level_systems','=','users.level_systems_id')
                                                                    ->where('id',$id_admins)
                                                                    ->first();
                return view('dashboard/admin/admin_read',$data);
            }
            else
                return redirect('/dashboard/admin');
        }
        else
            return redirect('/dashboard/admin');
    }

    public function edit($id_admins=0)
    {
    	$link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'edit') == 'true')
        {
            if (!is_numeric($id_admins))
                $id_admins = 0;
            $check_admins = \App\Master_user::where('id',$id_admins)->count();
            if($check_admins != 0)
            {
                $data['edit_admins']			= \App\Master_user::where('id',$id_admins)
                													->first();
                return view('dashboard/admin/admin_edit',$data);
            }
            else
                return redirect('/dashboard/admin');
        }
        else
            return redirect('/dashboard/admin');
    }

    public function processedit($id_admins=0, Request $request)
    {
    	$link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'edit') == 'true')
        {
        	if (!is_numeric($id_admins))
                $id_admins = 0;
            $check_admins = \App\Master_user::where('id',$id_admins)->count();
            if($check_admins != 0)
            {
            	if($request->password != '')
                {
            		$this->validate($request, [
                        'name'                  => 'required',
                        'email'                 => 'required|unique:users,email,'.$id_admins.',id',
                        'password'              => 'required|string|min:6|confirmed',
                    ]);

            	    $data = [
                        'level_systems_id'    => 1,
                        'sub_users_id'        => 0,
            	        'name' 			      => $request->name,
            	        'email'			      => $request->email,
            	        'updated_at'	      => date('Y-m-d H:i:s'),
            	        'password' 		      => bcrypt($request->password),
                        'phone_number_users'  => 0,
                        'credit_users'        => 0,
                        'max_group_users'     => 0
            	    ];
            	}
            	else
            	{
            		$this->validate($request, [
            	        'name'                 => 'required',
            	        'email'                => 'required|unique:users,email,'.$id_admins.',id',
            	    ]);

            	    $data = [
            	        'name' 			     	=> $request->name,
            	        'email'			     	=> $request->email,
            	        'updated_at'	     	=> date('Y-m-d H:i:s'),
                        'level_systems_id'    	=> 1,
                        'sub_users_id'          => 0,
                        'phone_number_users'    => 0,
                        'credit_users'          => 0,
                        'max_group_users'       => 0
            	    ];
            	}

            	\App\Master_user::where('id', $id_admins)->update($data);

	            if(request()->session()->get('page') != '')
	                $redirect_page    = request()->session()->get('page');
	            else
	                $redirect_page  = '/dashboard/admin';
	            
	            return redirect($redirect_page);
	        }
	        else
	        	return redirect('/dashboard/admin');
        }
        else
            return redirect('/dashboard/admin');
    }

    public function delete($id_admins=0)
    {
    	$link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'delete') == 'true')
        {
        	if (!is_numeric($id_admins))
                $id_admins = 0;
            $check_admins = \App\Master_user::where('id',$id_admins)->count();
            if($check_admins != 0)
            {
                if($id_admins != 1)
                {
                    \App\Master_user::where('id',$id_admins)
                                     ->delete();

                    if(request()->session()->get('page') != '')
                        $redirect_page    = request()->session()->get('page');
                    else
                        $redirect_page  = '/dashboard/admin';
                    
                    return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/admin');
            }
            else
                return redirect('/dashboard/admin');
        }
        else
            return redirect('/dashboard/admin');
    }

}