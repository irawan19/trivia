@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Menu</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                @if(Request::segment(4) == '')
                    <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL('dashboard/menu') }}">Menu</a></li>
                    <li class="breadcrumb-item active">Order</li>
                @else
                    <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL('dashboard/menu') }}">Menu</a></li>
                    <li class="breadcrumb-item active">{{ $view_menus->name_menus }}</li>
                @endif
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
    			       <ul class="handles list sortable" id="order_page" style="cursor:pointer;margin-left:-35px">
                            @foreach($view_orders as $orders)
                                @php(printf('<li id="menu_%s" class="btn btn-outline-secondary btn-lg btn-block btn-order"><span>:: '.$orders->name_menus.'</li></span>', $orders->id_menus, $orders->name_menus))
                            @endforeach
                        </ul>
    					<br/>
                        <div class="form-group" align="center">
    	            		@if(request()->session()->get('page') != '')
    	            			@php($get_back = request()->session()->get('page'))
                        	@else
                                @if(Request::segment(4) == '')
                        	       @php($get_back = 'dashboard/menu')
                        	    @else
                                    @php($get_back = 'dashboard/menu/submenu/'.$view_menus->id_menus)
                                @endif
                            @endif

                        	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
                        </div>
    				</div>
                </div>
            </div>
        </div>
    </div>

@stop