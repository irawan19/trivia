<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;
use DB;

class ListStakesController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'view') == 'true')
        {
            $data['link_list_stakes']          = $link_list_stakes;
            $data['result_word']            = '';
        	$data['view_list_stakes']    		= \App\Master_list_stake::get();
            session()->forget('page');
            session()->forget('result_word');
        	return view('dashboard/list_stakes/list_stakes_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'view') == 'true')
        {
            $data['link_list_stakes']          	= $link_list_stakes;
            $url_now                            = $request->fullUrl();
            $result_word                        = $request->search_word;
            $data['result_word']                = $result_word;
            $data['view_list_stakes']         	= \App\Master_list_stake::where('name_list_stakes', 'LIKE', '%'.$result_word.'%')
                                                                            ->get();
            session(['page'                     => $url_now]);
            session(['result_word'              => $result_word]);
            return view('dashboard/list_stakes/list_stakes_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
    	$link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'add') == 'true')
        {
            return view('dashboard/list_stakes/list_stakes_add');
        }
        else
            return redirect('/dashboard/list_stakes');
    }

    public function processadd(Request $request)
    {
        $link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'add') == 'true')
        {
            $this->validate($request, [
                'userfile_image'  => 'required|mimes:png,jpg,jpeg',
                'name_list_stakes'  => 'required',
            ]);

            $name_image = $request->file('userfile_image')->getClientOriginalName();
            $path_image = './public/images/stake/';
            $request->file('userfile_image')->move(
                base_path() . '/public/images/stake/', $name_image
            );

            $data = [
                'name_list_stakes'        => $request->name_list_stakes,
                'path_image_list_stakes'   => $path_image,
                'name_image_list_stakes'   => $name_image,
            ];
            \App\Master_list_stake::insert($data);
            
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
                    $redirect_page  = '/dashboard/list_stakes';

                return redirect($redirect_page);
            }
        }
        else
            return redirect('/dashboard/list_stakes');
    }

    public function status($id_list_stakes=0)
    {
        $link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'edit') == 'true')
        {
            if (!is_numeric($id_list_stakes))
                $id_list_stakes = 0;
            $check_list_stakes = \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)->count();
            if($check_list_stakes != 0)
            {
                $non_active_all_list_stakes = [ 'active_list_stakes' => 0];
                \App\Master_list_stake::query()->update($non_active_all_list_stakes);

                $data = [
                    'active_list_stakes' => 1,
                ];
                \App\Master_list_stake::where('id_list_stakes', $id_list_stakes)
                                        ->update($data);

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/list_stakes';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/list_stakes');
        }
        else
            return redirect('/dashboard/list_stakes');
    }

    public function edit($id_list_stakes=0)
    {
        $link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'edit') == 'true')
        {
            if (!is_numeric($id_list_stakes))
                $id_list_stakes = 0;
            $check_list_stakes = \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)->count();
            if($check_list_stakes != 0)
            {
                $data['edit_list_stakes']  		= \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)
                                                                      ->first();
                return view('dashboard/list_stakes/list_stakes_edit',$data);
            }
            else
                return redirect('/dashboard/list_stakes');
        }
        else
            return redirect('/dashboard/list_stakes');
    }

    public function processedit($id_list_stakes=0, Request $request)
    {
        $link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'edit') == 'true')
        {
            if (!is_numeric($id_list_stakes))
                $id_list_stakes = 0;
            $check_list_stakes = \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)->count();
            if($check_list_stakes != 0)
            {
                $this->validate($request, [
                    'name_list_stakes'  => 'required',
                ]);

                if($request->file('userfile_image') != '')
                {
                    $check_image       = \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)->first();
                    if($check_image != null)
                    {
                        $old_picture        = $check_image->path_image_list_stakes . $check_image->name_image_list_stakes;
                        if (file_exists($old_picture))
                            unlink($old_picture);
                    }

                    $name_image = $request->file('userfile_image')->getClientOriginalName();
                    $path_image = './public/images/stake/';
                    $request->file('userfile_image')->move(
                        base_path() . '/public/images/stake/', $name_image
                    );

                    $data = [
                        'name_list_stakes'        => $request->name_list_stakes,
                        'path_image_list_stakes'   => $path_image,
                        'name_image_list_stakes'   => $name_image,
                    ];
                }
                else
                {
                    $data = [
                        'name_list_stakes'        => $request->name_list_stakes
                    ];
                }
                \App\Master_list_stake::where('id_list_stakes', $id_list_stakes)
                                            ->update($data);

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/list_stakes';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/list_stakes');
        }
        else
            return redirect('/dashboard/list_stakes');
    }

    public function delete($id_list_stakes=0)
    {
        $link_list_stakes = 'list_stakes';
        if(Shwetech::accessRights($link_list_stakes,'delete') == 'true')
        {
            if (!is_numeric($id_list_stakes))
                $id_list_stakes = 0;
            $check_list_stakes = \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)->count();
            if($check_list_stakes != 0)
            {
                $check_image       = \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)->first();
                if($check_image != null)
                {
                    $old_picture        = $check_image->path_image_list_stakes . $check_image->name_image_list_stakes;
                    if (file_exists($old_picture))
                        unlink($old_picture);
                }
                \App\Master_list_stake::where('id_list_stakes',$id_list_stakes)->delete();

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/list_stakes';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/list_stakes');
        }
        else
            return redirect('/dashboard/list_stakes');
    }
}