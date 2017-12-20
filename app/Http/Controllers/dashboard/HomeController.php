<?php

namespace App\Http\Controllers\dashboard;

use Illuminate\Http\Request;
use Auth;

class HomeController extends AdminCoreController
{
    public function index()
    {

    	$data['view_message']		= "Hi ".Auth::user()->name.", Welcome To Trivia.";
    	$data['view_list_stakes']	= \App\Master_list_stake::get();
    	$data['total_list_stakes']	= \App\Master_list_stake::count();
        return view('dashboard/home/home_view',$data);
    }
}

?>