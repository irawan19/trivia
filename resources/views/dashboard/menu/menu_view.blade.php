@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Menu</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Menu</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
		                <h6 class="card-subtitle" style="text-align:center">set menu for dashboard.</h6>
	                    <div class="row">
	                       	<div class="col-lg-12">
								<form method="GET" action="{{ URL('dashboard/menu/search') }}" class="form-horizontal m-t-40">
								{{ csrf_field() }}
									<div class="input-group">
										<input name="search_word" placeholder="search" value="{{ $result_word }}" class="form-control" type="text">
										<span class="input-group-btn">
											<button class="btn btn-info" name="submit_search" value="submit_search" type="submit">Search</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<br/>
						<div align="center">{{ Shwetech::add($link_menu,'dashboard/menu/add') }} {{ Shwetech::order($link_menu,'dashboard/menu/order') }}</div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Icon</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_menus as $menus)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td><i class="mdi {{ $menus->icon_menus }}"></i> {{ $menus->icon_menus }}</td>
		                                <td>{{ $menus->name_menus }}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::subMenu($link_menu,'dashboard/menu/submenu/'.$menus->id_menus) }}
														{{ Shwetech::read($link_menu,'dashboard/menu/read/'.$menus->id_menus) }}
														{{ Shwetech::edit($link_menu,'dashboard/menu/edit/'.$menus->id_menus) }}
														{{ Shwetech::delete($link_menu,'dashboard/menu/delete/'.$menus->id_menus,$menus->name_menus) }}
													</div>
												</div>
											</div>
		                                </td>
		                            </tr>
		                            @php($no++)
		                        @endforeach
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

@stop