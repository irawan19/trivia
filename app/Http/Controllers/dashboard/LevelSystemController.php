<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Shwetech;
use Auth;
use DB;

class LevelSystemController extends AdminCoreController
{
    public function index(Request $request)
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'view') == 'true')
        {
            $data['link_level_system']          = $link_level_system;
            $data['result_word']                = '';
        	$data['view_level_systems']    		= \App\Master_level_system::get();
            session()->forget('page');
            session()->forget('result_word');
        	return view('dashboard/level_system/level_system_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'view') == 'true')
        {
            $data['link_level_system']          = $link_level_system;
            $url_now                            = $request->fullUrl();
            $result_word                        = $request->search_word;
            $data['result_word']                = $result_word;
            $data['view_level_systems']         = \App\Master_level_system::where('name_level_systems', 'LIKE', '%'.$result_word.'%')
                                                                            ->get();
            session(['page'                     => $url_now]);
            session(['result_word'              => $result_word]);
            return view('dashboard/level_system/level_system_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function add()
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'add') == 'true')
        {
            $data['add_menus']            = \App\Master_menu::where('sub_menus_id',0)
                                                            ->orderBy('order_menus')
                                                            ->get();
            return view('dashboard/level_system/level_system_add',$data);
        }
        else
            return redirect('/dashboard/level_system');
    }

    public function processadd(Request $request)
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'add') == 'true')
        {
            $this->validate($request, [
                'name_level_systems'  => 'required',
            ]);

            $data = [
                'name_level_systems' => $request->name_level_systems,
            ];
            $id_level_systems = \App\Master_level_system::insertGetId($data);

            foreach ($request->features_id as $features_id)
            {
                $access_data = [
                    'level_systems_id'      => $id_level_systems,
                    'features_id'           => $features_id
                ];
                \App\Master_access::insert($access_data);
            }
            
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
                    $redirect_page  = '/dashboard/level_system';

                return redirect($redirect_page);
            }
        }
        else
            return redirect('/dashboard/level_system');
    }

    public function read($id_level_systems=0)
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'read') == 'true')
        {
            if (!is_numeric($id_level_systems))
                $id_level_systems = 0;
            $check_level_systems = \App\Master_level_system::where('id_level_systems',$id_level_systems)->count();
            if($check_level_systems != 0)
            {
                $data['read_menus']             = \App\Master_menu::where('sub_menus_id',0)
                                                                ->orderBy('order_menus')
                                                                ->get();
                $data['read_level_systems']     = \App\Master_level_system::where('id_level_systems',$id_level_systems)
                                                                ->first();
                return view('dashboard/level_system/level_system_read',$data);
            }
            else
                return redirect('/dashboard/level_system');
        }
        else
            return redirect('/dashboard/level_system');
    }

    public function edit($id_level_systems=0)
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'edit') == 'true')
        {
            if (!is_numeric($id_level_systems))
                $id_level_systems = 0;
            $check_level_systems = \App\Master_level_system::where('id_level_systems',$id_level_systems)->count();
            if($check_level_systems != 0)
            {
                $data['edit_menus']          = \App\Master_menu::where('sub_menus_id',0)
                                                                ->orderBy('order_menus')
                                                                ->get();
                $data['edit_level_systems']  = \App\Master_level_system::where('id_level_systems',$id_level_systems)
                                                                      ->first();
                return view('dashboard/level_system/level_system_edit',$data);
            }
            else
                return redirect('/dashboard/level_system');
        }
        else
            return redirect('/dashboard/level_system');
    }

    public function processedit($id_level_systems=0, Request $request)
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'edit') == 'true')
        {
            if (!is_numeric($id_level_systems))
                $id_level_systems = 0;
            $check_level_systems = \App\Master_level_system::where('id_level_systems',$id_level_systems)->count();
            if($check_level_systems != 0)
            {
                $this->validate($request, [
                    'name_level_systems'  => 'required',
                ]);

                $data = [
                    'name_level_systems' => $request->name_level_systems,
                ];
                \App\Master_level_system::where('id_level_systems', $id_level_systems)
                                        ->update($data);
                
                \App\Master_access::where('level_systems_id',$id_level_systems)->delete();
                foreach ($request->features_id as $features_id)
                {
                    $access_data = [
                        'level_systems_id'   => $id_level_systems,
                        'features_id'        => $features_id
                    ];
                    \App\Master_access::insert($access_data);
                }

                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/level_system';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/level_system');
        }
        else
            return redirect('/dashboard/level_system');
    }

    public function delete($id_level_systems=0)
    {
        $link_level_system = 'level_system';
        if(Shwetech::accessRights($link_level_system,'delete') == 'true')
        {
            if (!is_numeric($id_level_systems))
                $id_level_systems = 0;
            $check_level_systems = \App\Master_level_system::where('id_level_systems',$id_level_systems)->count();
            if($check_level_systems != 0)
            {
                if($id_level_systems != 1 && $id_level_systems != 2 && $id_level_systems != 3)
                {
                    DB::select(DB::raw("DELETE t1.*, t2.*
                        FROM Master_level_systems t1
                        LEFT JOIN master_accesses t2 ON t2.level_systems_id=t1.id_level_systems
                        WHERE id_level_systems='$id_level_systems'"));

                    if(request()->session()->get('page') != '')
                        $redirect_page    = request()->session()->get('page');
                    else
                        $redirect_page  = '/dashboard/level_system';
                    
                    return redirect($redirect_page);
                }
                else
                    return redirect('/dashboard/level_system');
            }
            else
                return redirect('/dashboard/level_system');
        }
        else
            return redirect('/dashboard/level_system');
    }

}
