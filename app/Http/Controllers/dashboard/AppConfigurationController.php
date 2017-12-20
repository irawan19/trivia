<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;

class AppConfigurationController extends AdminCoreController
{
    public function index(Request $request)
    {
    	$link_app_configuration = 'app_configuration';
        if(Shwetech::accessRights($link_app_configuration,'view') == 'true')
        {
		    $data['view_app_configurations']   	= \App\Master_app_configuration::first();
		    session()->forget('page');
		    return view('dashboard/app_configuration/app_configuration_view', $data);
    	}
    	else
    		return redirect('/dashboard/home');
    }

    public function processedit(Request $request)
    {
        $link_app_configuration = 'app_configuration';
        if(Shwetech::accessRights($link_app_configuration, 'view') == 'true')
        {
            $this->validate($request, [
                'sessions_days_duration_app_configurations' => 'required|not_in:0',
                'game_minutes_duration_app_configurations'  => 'required|not_in:0',
            ]);

            $app_configuration_data = [
                'sessions_days_duration_app_configurations'  => $request->sessions_days_duration_app_configurations,
                'game_minutes_duration_app_configurations'   => $request->game_minutes_duration_app_configurations
            ];
            \App\Master_app_configuration::query()->update($app_configuration_data);
            $after_save = [
                'alert' => 'success',
                'text'  => 'Data Successfully Updated'
            ];
            return redirect()->back()->with('after_save', $after_save);
        }
    }

    public function processeditlogo(Request $request)
    {
        $link_app_configuration = 'app_configuration';
        if(Shwetech::accessRights($link_app_configuration,'view') == 'true')
        {
            $this->validate($request, [
                'userfile_logo'     => 'required|mimes:png,jpg,jpeg',
            ]);

            $check_logo       = \App\Master_app_configuration::first();
            if($check_logo != null)
            {
                $old_picture        = $check_logo->path_logo_app_configurations . $check_logo->name_logo_app_configurations;
                if (file_exists($old_picture))
                    unlink($old_picture);
            }

            $name_picture = $request->file('userfile_logo')->getClientOriginalName();
            $path_picture = './public/images/';
            $request->file('userfile_logo')->move(
                base_path() . '/public/images/', $name_picture
            );

            $data = [
                    'name_logo_app_configurations' => $name_picture,
                    'path_logo_app_configurations' => $path_picture
            ];

            \App\Master_app_configuration::query()->update($data);

            $after_save_logo = [
                'alert'                     => 'success',
                'text'                      => 'Data Successfully Updated',
            ];
            return redirect()->back()->with('after_save_logo', $after_save_logo);
        }
        else
            return redirect('/dashboard/home');
    }

    public function processediticon(Request $request)
    {
        $link_app_configuration = 'app_configuration';
        if(Shwetech::accessRights($link_app_configuration,'view') == 'true')
        {
            $this->validate($request, [
                'userfile_icon'     => 'required|mimes:png,jpg,jpeg',
            ]);

            $check_icon       = \App\Master_app_configuration::first();
            if($check_icon != null)
            {
                $old_picture        = $check_icon->path_icon_app_configurations . $check_icon->name_icon_app_configurations;
                if (file_exists($old_picture))
                    unlink($old_picture);
            }

            $name_picture = $request->file('userfile_icon')->getClientOriginalName();
            $path_picture = './public/images/';
            $request->file('userfile_icon')->move(
                base_path() . '/public/images/', $name_picture
            );

            $data = [
                    'name_icon_app_configurations' => $name_picture,
                    'path_icon_app_configurations' => $path_picture
            ];

            \App\Master_app_configuration::query()->update($data);

            $after_save_icon = [
                'alert'                     => 'success',
                'text'                      => 'Data Successfully Updated',
            ];
            return redirect()->back()->with('after_save_icon', $after_save_icon);
        }
        else
            return redirect('/dashboard/home');
    }
}