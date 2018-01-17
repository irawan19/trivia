<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Shwetech;
use Auth;

class RegisterBotController extends AdminCoreController
{

	public function index(Request $request)
    {
        $link_register_bot = 'register_bot';
        if(Shwetech::accessRights($link_register_bot,'view') == 'true')
        {
            $data['link_register_bot']         		= $link_register_bot;
            $data['result_word']        			= '';
        	$data['view_register_bot_registers'] 	= \App\Master_bot::where('code_bots','')
        																->get();
        	$data['view_register_bot_actives']		= \App\Master_bot::leftJoin('users','id_bots','=','users.bots_id')
        															->where('users.id',null)
        															->get();
            session()->forget('page');
            session()->forget('word');
        	return view('dashboard/register_bot/register_bot_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_register_bot = 'register_bot';
        if(Shwetech::accessRights($link_register_bot,'view') == 'true')
        {
            $data['link_register_bot']  = $link_register_bot;
            $url_now                    = $request->fullUrl();
            $result_word                = $request->search_word;
            $data['result_word']        = $result_word;
            $data['view_register_bot_registers'] 	= \App\Master_bot::where('code_bots','')
            															->where('phone_number_bots', 'LIKE', '%'.$result_word.'%')
        																->get();
        	$data['view_register_bot_actives']		= \App\Master_bot::leftJoin('users','id_bots','=','users.bots_id')
        															->where('users.id',null)
            														->where('phone_number_bots', 'LIKE', '%'.$result_word.'%')
            														->orWhere('name_bots', 'LIKE', '%'.$result_word.'%')
            														->where('users.id','')
        															->get();
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            return view('dashboard/register_bot/register_bot_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function register()
    {
    	$link_register_bot = 'register_bot';
        if(Shwetech::accessRights($link_register_bot,'add') == 'true')
        {
        	$data['add_country_phone_codes']	= \App\Master_country_phone_code::orderBy('name_country_phone_codes')
        																		->get();
            return view('dashboard/register_bot/register_bot_register',$data);
        }
        else
            return redirect('/dashboard/register_bot');
    }

    public function processregister(Request $request)
    {
    	$link_register_bot = 'register_bot';
        if(Shwetech::accessRights($link_register_bot,'add') == 'true')
        {
            $this->validate($request, [
                'country_phone_codes_id'        => 'required',
                'phone_number_bots'           	=> 'required|numeric|unique:master_bots',
            ]);

            $get_id_country_phone_codes	= $request->country_phone_codes_id;
            $get_country_phone_codes 	= \App\Master_country_phone_code::where('id_country_phone_codes',$get_id_country_phone_codes)->first();
            $get_country_code 			= $get_country_phone_codes->code_country_phone_codes;
            $get_phone_number 			= $request->phone_number_bots;

            $client 	= new \GuzzleHttp\Client();
			$response 	= $client->request('POST', 'http://43.243.201.79:80/register', ['query' => ['cc' => $get_country_code, 'phone' => $get_phone_number]])->getBody();
			$obj 		= json_decode($response);

			if($obj->pw != null)
			{
				$data = [
					'country_phone_codes_id'=> $get_id_country_phone_codes,
	    			'date_register_bots'	=> date('Y-m-d'),
	    			'time_register_bots'	=> date('H:i:s'),
	    			'name_bots'				=> '',
	    			'phone_number_bots'		=> $get_phone_number,
	    			'code_bots'				=> '',
	    			'password_bots'			=> '',
	    		];
	    		\App\Master_bot::insert($data);

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
	                    $redirect_page  = '/dashboard/register_bot';

	                return redirect($redirect_page);
	    	    }
			}
			else
			{
				$after_save = [
	    	        'alert'  => 'error',
	    	        'text'   => 'Error whatsapp, You can try register again in a few minutes',
	    	    ];
	    	    return redirect()->back()->with('after_save', $after_save)
	    	    						->withInput();
			}
        }
        else
            return redirect('/dashboard/register_bot');
    }

    public function confirmation($id_bots=0)
    {
    	$link_register_bot = 'register_bot';
        if(Shwetech::accessRights($link_register_bot,'edit') == 'true')
        {
            if (!is_numeric($id_bots))
                $id_bots = 0;
            $check_register_bots = \App\Master_bot::where('id_bots',$id_bots)->count();
            if($check_register_bots != 0)
            {
                $data['confirmation_bots']            = \App\Master_bot::where('id_bots',$id_bots)
                                                                    	->first();
                return view('dashboard/register_bot/register_bot_confirmation',$data);
            }
            else
                return redirect('/dashboard/register_bot');
        }
        else
            return redirect('/dashboard/register_bot');
    }

    public function processconfirmation($id_bots=0, Request $request)
    {
    	$link_register_bot = 'register_bot';
    	if(Shwetech::accessRights($link_register_bot,'edit') == 'true')
    	{
    		if (!is_numeric($id_bots))
    			$id_bots = 0;
    		$check_register_bots = \App\Master_bot::where('id_bots',$id_bots)->count();
    		if($check_register_bots != 0)
    		{
    			$this->validate($request, [
	                'id_country_phone_codes'        => 'required|numeric',
	                'country_phone_codes_id'        => 'required',
	                'phone_number_bots'           	=> 'required|numeric',
	                'code_bots'						=> 'required|numeric',
	                'name_bots'						=> 'required',
	            ]);

    			$get_id_country_phone_codes	= $request->id_country_phone_codes;
	            $get_country_phone_codes 	= \App\Master_country_phone_code::where('id_country_phone_codes',$get_id_country_phone_codes)->first();
	            $get_country_code 			= $get_country_phone_codes->code_country_phone_codes;
	            $get_phone_number 			= $request->phone_number_bots;
	            $get_code  					= $request->code_bots;
	            $get_bot_name 				= $request->name_bots;

	            $client 			= new \GuzzleHttp\Client();
				$response_confirm 	= $client->request('POST', 'http://43.243.201.79:80/confirm', ['query' => ['cc' => $get_country_code, 'phone' => $get_phone_number, 'code' => $get_code]])->getBody();
				$obj_confirm 		= json_decode($response_confirm);

				if($obj_confirm->status == 'ok')
				{
					$get_password_bots 	 	= $obj_confirm->pw;
					$response_create_bot 	= $client->request('POST', 'http://43.243.201.79:80/bot', ['query' => ['bot_name' => $get_bot_name, 'bot_phone' => $get_phone_number, 'bot_password' => $get_password_bots]])->getBody();
					$obj_created_bot 		= json_decode($response_create_bot);

					if($obj_created_bot->error == false)
					{
						$data = [
			    			'date_register_bots'	=> date('Y-m-d'),
			    			'time_register_bots'	=> date('H:i:s'),
			    			'code_bots'				=> $get_code,
			    			'password_bots'			=> $get_password_bots,
			    			'name_bots'				=> $get_bot_name,
			    		];
			    		\App\Master_bot::where('id_bots',$id_bots)->update($data);

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
			                    $redirect_page  = '/dashboard/register_bot';

			                return redirect($redirect_page);
			    	    }
			    	}
			    	else
			    	{
			    		$after_save = [
			    	        'alert'  => 'error',
			    	        'text'   => 'Create BOT Failed',
			    	    ];
			    	    return redirect()->back()->with('after_save', $after_save)
			    	    						->withInput();
			    	}
				}
				else
				{
					$after_save = [
		    	        'alert'  => 'error',
		    	        'text'   => 'Confirm BOT Failed',
		    	    ];
		    	    return redirect()->back()->with('after_save', $after_save)
		    	    						->withInput();
				}
    		}
    		else
    			return redirect('/dashboard/register_bot');
    	}
    	else
    		return redirect('/dashboard/register_bot');
    }

    public function delete($id_bots=0)
    {
    	$link_register_bot = 'register_bot';
        if(Shwetech::accessRights($link_register_bot,'delete') == 'true')
        {
            if (!is_numeric($id_bots))
                $id_bots = 0;
            $check_register_bots = \App\Master_bot::where('id_bots',$id_bots)->count();
            if($check_register_bots != 0)
            {
                \App\Master_bot::where('id_bots',$id_bots)
                                ->delete();

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/register_bot';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/register_bot');
        }
        else
            return redirect('/dashboard/register_bot');
    }

    public function read($id_bots=0)
    {
    	$link_register_bot = 'register_bot';
        if(Shwetech::accessRights($link_register_bot,'read') == 'true')
        {
            if (!is_numeric($id_bots))
                $id_bots = 0;
            $check_register_bots = \App\Master_bot::where('id_bots',$id_bots)->count();
            if($check_register_bots != 0)
            {
                $data['read_register_bots']	= \App\Master_bot::where('id_bots',$id_bots)
                									  ->first();
              	return view('dashboard/register_bot/register_bot_read',$data);
            }
            else
                return redirect('/dashboard/register_bot');
        }
        else
            return redirect('/dashboard/register_bot');
    }

}