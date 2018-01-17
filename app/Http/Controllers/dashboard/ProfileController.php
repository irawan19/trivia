<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class ProfileController extends AdminCoreController
{
    public function index()
    {
    	$link_admin = 'admin';
        if(Shwetech::accessRights($link_admin,'edit') == 'true')
        {
	    	$id_admins 					= Auth::user()->id;
	    	$data['view_profile']       = \App\Master_user::join('master_bots','bots_id','=','master_bots.id_bots')
	    													->join('master_level_systems','level_systems_id','=','master_level_systems.id_level_systems')
	    													->where('id',$id_admins)
	    													->first();
	    	$data['view_id']			= $id_admins;
	    	return view('dashboard/profile/profile_view', $data);
    	}
    	else
    		return redirect('/dashboard/home');
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
			    		'phone_number_users'	=> 'required|numeric',
			            'name'  				=> 'required',
			            'email'					=> 'required|unique:users,email,'.$id_admins.',id',
			            'password'				=> 'required|string|min:6|confirmed'
			        ]);

			        $data = [
			        	'phone_number_users'	=> $request->phone_number_users,
				        'name' 					=> $request->name,
				        'email'					=> $request->email,
				        'updated_at'			=> date('Y-m-d H:i:s'),
				        'password' 				=> bcrypt($request->password),
				    ];
			    }
			    else
			    {
			    	$this->validate($request, [
			    		'phone_number_users'	=> 'required|numeric',
			            'name'  				=> 'required',
			            'email'					=> 'required|unique:users,email,'.$id_admins.',id',
			        ]);

			        $data = [
			        	'phone_number_users'	=> $request->phone_number_users,
				        'name' 					=> $request->name,
				        'email'					=> $request->email,
				        'updated_at'			=> date('Y-m-d H:i:s')
				    ];
			    }
			    
		    	\App\Master_user::where('id', $id_admins)->update($data);

		    	$after_save = [
		            'alert'                     => 'success',
		            'text'                      => 'Data Successfully Updated',
		        ];
		    	return redirect()->back()->with('after_save', $after_save);
    		}
    		else
    			return redirect('/dashboard/home');
    	}
    	else
    		return redirect('/dashboard/home');
    }
}