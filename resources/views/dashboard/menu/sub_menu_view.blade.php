@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Menu</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ URL('dashboard/menu') }}">Menu</a></li>
                <li class="breadcrumb-item active">{{ $view_menus->name_menus }}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                           	<div class="col-lg-12">
    							<form method="GET" action="{{ URL('dashboard/menu/search_submenu/'.$view_menus->id_menus) }}" class="form-horizontal m-t-40">
    							{{ csrf_field() }}
    								<div class="input-group">
    									<input name="search_word" placeholder="search" value="{{ $result_word2 }}" class="form-control" type="text">
    									<span class="input-group-btn">
    										<button class="btn btn-info" name="submit_search" value="submit_search" type="submit">Search</button>
    									</span>
    								</div>
    							</form>
    						</div>
    					</div>
    					<br/>
    					<div align="center">{{ Shwetech::add($link_menu,'dashboard/menu/add_submenu/'.$view_menus->id_menus) }} {{ Shwetech::order($link_menu,'dashboard/menu/order_submenu/'.$view_menus->id_menus) }}</div>
    					<br/>
                        <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
                            <thead>
                                <tr>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Icon</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
                                    <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Link</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	@php($no = 1)
                            	@foreach($view_sub_menus as $sub_menus)
    	                            <tr>
    	                                <td>{{ $no }}</td>
                                        <td><i class="mdi {{ $sub_menus->icon_menus }}"></i> {{ $sub_menus->icon_menus }}</td>
                                        <td>{{ $sub_menus->name_menus }}</td>
    	                                <td>{{ $sub_menus->link_menus }}</td>
    	                                <td width="5%">
    	                                	<div class="input-group">
    											<div class="input-group-btn">
    												<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    													<span class="caret"></span>
    												</button>
    												<div class="dropdown-menu dropdown-menu-right action">
    													{{ Shwetech::read($link_menu,'dashboard/menu/read_submenu/'.$sub_menus->id_menus) }}
    													{{ Shwetech::edit($link_menu,'dashboard/menu/edit_submenu/'.$sub_menus->id_menus) }}
    													{{ Shwetech::delete($link_menu,'dashboard/menu/delete_submenu/'.$sub_menus->id_menus,$sub_menus->name_menus) }}
    												</div>
    											</div>
    										</div>
    	                                </td>
    	                            </tr>
    	                            @php($no++)
    	                        @endforeach
                            </tbody>
                        </table>
                        <br/>
                        <div class="form-group" align="center">
    	            		@if(request()->session()->get('page') != '')
    	            			@php($get_back = request()->session()->get('page'))
                        	@else
                        		@php($get_back = 'dashboard/menu')
                        	@endif

                        	<a href="{{ $get_back }}" class="btn waves-effect waves-light btn-danger"> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop