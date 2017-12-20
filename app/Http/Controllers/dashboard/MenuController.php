<?php
namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use DB;
use Shwetech;
use Auth;

class MenuController extends AdminController
{
    public function index(Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'view') == 'true')
        {
            $data['link_menu']                  = $link_menu;
            $url_now                       		= $request->fullUrl();
            $data['result_word']                = '';
        	$data['view_menus']    				= \App\Master_menu::where('sub_menus_id','=','0')
        															->orderBy('order_menus')
        															->get();
        	session()->forget('page');
            session()->forget('result_word');
        	return view('dashboard/menu/menu_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function search(Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'view') == 'true')
        {
            $data['link_menu']                  = $link_menu;
            $url_now                       		= $request->fullUrl();
            $result_word 						= $request->search_word;
            $data['result_word']                = $result_word;
            $data['view_menus']    				= \App\Master_menu::where('sub_menus_id','=','0')
            														->where('name_menus', 'LIKE', '%'.$result_word.'%')
            														->orderBy('order_menus')
                                                                   	->get();
            session(['page'             => $url_now]);
            session(['result_word'		=> $result_word]);
            return view('dashboard/menu/menu_view', $data);
        }
        else
            return redirect('/dashboard/home');
    }

    public function order()
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'edit') == 'true')
        {
        	$data['view_orders'] = \App\Master_menu::where('sub_menus_id','=','0')
        											->orderBy('order_menus')
        											->get();
        	return view('dashboard/menu/menu_order',$data);
        }
        else
            return redirect('/dashboard/menu');
    }

    public function processorder(Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'edit') == 'true')
        {
    		parse_str($request->namePage, $orderPage);
    		foreach ($orderPage['menu'] as $key => $value)
    		{
    			$no 		= $key + 1;
    			$data 		= ['order_menus' => $no];
    			\App\Master_menu::where('id_menus', $value)
                                ->update($data);
    		}
        }
        else
            return redirect('/dashboard/menu');
    }

    public function add()
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'add') == 'true')
        {
            $data['view_icons'] = Shwetech::iconMenus();
    	   return view('dashboard/menu/menu_add',$data);
        }
        else
            return redirect('/dashboard/menu');
    }

    public function processadd(Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'add') == 'true')
        {
            $this->validate($request, [
                'icon_menus'  => 'required',
                'name_menus'  => 'required',
            ]);

        	$data = [
                'icon_menus' => $request->icon_menus,
                'name_menus' => $request->name_menus,
            ];
        	\App\Master_menu::insert($data);
        	
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
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/menu';

                return redirect($redirect_page);
            }
        }
        else
            return redirect('/dashboard/menu');
    }

    public function read($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'read') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$data['read_menus'] 		= \App\Master_menu::where('id_menus',$id_menus)
                                                       		->first();
                $data['read_sub_menus'] 	= \App\Master_menu::where('sub_menus_id',$id_menus)
                                                       		->get();
                return view('dashboard/menu/menu_read',$data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function edit($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'edit') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
                $data['view_icons'] = Shwetech::iconMenus();
            	$data['edit_menus'] = \App\Master_menu::where('id_menus',$id_menus)
                                                      ->first();
                return view('dashboard/menu/menu_edit',$data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function processedit($id_menus=0, Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'edit') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$this->validate($request, [
                    'icon_menus'  => 'required',
                    'name_menus'  => 'required',
                ]);

            	$data = [
                    'icon_menus' => $request->icon_menus,
                    'name_menus' => $request->name_menus,
                ];
            	\App\Master_menu::where('id_menus', $id_menus)
                                ->update($data);
            	

            	if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/menu';
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function delete($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'delete') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	DB::select(DB::raw("DELETE t1.*, t2.*, t3.*
        				FROM master_menus t1
        				LEFT JOIN master_features t2 ON t2.menus_id=t1.id_menus
        				LEFT JOIN master_accesses t3 ON t3.features_id=t2.id_features
        				WHERE id_menus='$id_menus'
        				OR sub_menus_id='$id_menus'"));
                if(request()->session()->get('page') != '')
                    $redirect_page    = request()->session()->get('page');
                else
                    $redirect_page  = '/dashboard/menu';

                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function submenu($id_menus=0, Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'view') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
                $data['link_menu']                  = $link_menu;
                $data['result_word2']				= '';
                $data['view_menus']					= \App\Master_menu::where('id_menus','=',$id_menus)
                														->first();
            	$data['view_sub_menus']    			= \App\Master_menu::where('sub_menus_id','=',$id_menus)
            															->orderBy('order_menus')
            															->get();
                session()->forget('page2');
            	session()->forget('result_word2');
            	return view('dashboard/menu/sub_menu_view', $data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function search_submenu($id_menus=0, Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'view') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
                $data['link_menu']                  = $link_menu;
            	$url_now                       		= $request->fullUrl();
                $word                               = $request->search_word;
                $data['result_word2']               = $word;
                $data['view_menus']					= \App\Master_menu::where('id_menus','=',$id_menus)
                														->first();
                $data['view_sub_menus']    			= \App\Master_menu::where('sub_menus_id','=',$id_menus)
                														->where('name_menus', 'LIKE', '%'.$word.'%')
                														->orderBy('order_menus')
                                                                       	->get();
                session(['page2'                 	=> $url_now]);
                session(['result_word2'             => $word]);
                return view('dashboard/menu/sub_menu_view', $data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function add_submenu($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'add') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$data['view_icons']	= Shwetech::iconMenus();
            	$data['view_menus'] = \App\Master_menu::where('id_menus',$id_menus)
                                                       		->first();
            	return view('dashboard/menu/sub_menu_add',$data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function processadd_submenu($id_menus=0, Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'add') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$this->validate($request, [
                    'icon_menus'  		=> 'required',
                    'name_menus' 		=> 'required',
                    'link_menus'  		=> 'required',
                    'name_features.0'	=> 'required',
                ]);

            	$data = [
            		'sub_menus_id'	=> $id_menus,
                    'icon_menus' 	=> $request->icon_menus,
                    'name_menus' 	=> $request->name_menus,
                    'link_menus' 	=> $request->link_menus,
                ];
            	$id_sub_menu = \App\Master_menu::insertGetId($data);
                foreach($request->name_features as $name_features)
        		{
        			$fitur_data = [
        	            'name_features' => $name_features,
        	            'menus_id' 		=> $id_sub_menu,
        	        ];
        			\App\Master_feature::insert($fitur_data);
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
	                if(request()->session()->get('page2') != '')
	                    $redirect_page  = request()->session()->get('page2');
	                else
	                    $redirect_page  = '/dashboard/menu/submenu/'.$id_menus;

	                return redirect($redirect_page);
	            }
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function order_submenu($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'edit') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$data['view_menus']	 = \App\Master_menu::where('id_menus',$id_menus)->first();
            	$data['view_orders'] = \App\Master_menu::where('sub_menus_id','=',$id_menus)
            											->orderBy('order_menus')
            											->get();
            	return view('dashboard/menu/menu_order',$data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function read_submenu($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'read') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$get_sub_menus 			= \App\Master_menu::where('id_menus',$id_menus)
                                                       		->first();
                $data['read_sub_menus'] = $get_sub_menus;
                $id_sub_menus 			= $get_sub_menus->sub_menus_id;
                $data['read_menus']		= \App\Master_menu::where('id_menus',$id_sub_menus)
                											->first();
                return view('dashboard/menu/sub_menu_read',$data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function edit_submenu($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'edit') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menu = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menu != 0)
            {
            	$data['view_icons']		= Shwetech::iconMenus();
            	$get_sub_menus 			= \App\Master_menu::where('id_menus',$id_menus)
                                                       		->first();
                $data['edit_sub_menus'] = $get_sub_menus;
                $id_sub_menus 			= $get_sub_menus->sub_menus_id;
                $data['view_menus']		= \App\Master_menu::where('id_menus',$id_sub_menus)
                											->first();
                return view('dashboard/menu/sub_menu_edit',$data);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function processedit_submenu($id_menus=0, Request $request)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'edit') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$this->validate($request, [
                    'icon_menus'         => 'required',
                    'name_menus'         => 'required',
                    'link_menus'         => 'required',
                    'name_features.0'    => 'required',
                ]);

            	$data = [
                    'icon_menus' => $request->icon_menus,
                    'name_menus' => $request->name_menus,
                    'link_menus' => $request->link_menus,
                ];
            	$prosesedit = \App\Master_menu::where('id_menus', $id_menus)
                                               ->update($data);
                $prosesdelete = \App\Master_feature::where('menus_id',$id_menus)
                								->delete();
                foreach($request->name_features as $name_features)
        		{
        			$fitur_data = [
        	            'name_features' => $name_features,
        	            'menus_id' 		=> $id_menus,
        	        ];
        			\App\Master_feature::insert($fitur_data);
        		}

            	if(request()->session()->get('page2') != '')
                    $redirect_page    = request()->session()->get('page2');
                else
                {
                	$get_menus 		= \App\Master_menu::where('id_menus',$id_menus)->first();
                	$get_id_menus 	= $get_menus->sub_menus_id;
                    $redirect_page  = '/dashboard/menu/submenu/'.$get_id_menus;
                }
                
                return redirect($redirect_page);
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }

    public function delete_submenu($id_menus=0)
    {
        $link_menu = 'menu';
        if(Shwetech::accessRights($link_menu,'delete') == 'true')
        {
            if (!is_numeric($id_menus))
                $id_menus = 0;
            $check_menus = \App\Master_menu::where('id_menus',$id_menus)->count();
            if($check_menus != 0)
            {
            	$get_menus 		= \App\Master_menu::where('id_menus',$id_menus)->first();
                $get_id_menus 	= $get_menus->sub_menus_id;

            	DB::select(DB::raw("DELETE t1.*, t2.*, t3.*
        				FROM master_menus t1
        				LEFT JOIN master_features t2 ON t2.menus_id=t1.id_menus
        				LEFT JOIN master_accesses t3 ON t3.features_id=t2.id_features
        				WHERE id_menus='$id_menus'
        				OR sub_menus_id='$id_menus'"));
                	
                if(request()->session()->get('page2') != '')
                    $redirect_page  = request()->session()->get('page2');
                else
                    $redirect_page  = '/dashboard/menu/submenu/'.$get_id_menus;

                return redirect($redirect_page);;
            }
            else
                return redirect('/dashboard/menu');
        }
        else
            return redirect('/dashboard/menu');
    }
}