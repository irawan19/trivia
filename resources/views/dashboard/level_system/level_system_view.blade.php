@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Level System</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Level System</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
		                <h6 class="card-subtitle" style="text-align:center">set each account to access some menus.</h6>
	                    <div class="row">
	                       	<div class="col-lg-12">
								<form method="GET" action="{{ URL('dashboard/level_system/search') }}" class="form-horizontal m-t-40">
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
						<div align="center">{{ Shwetech::add($link_level_system,'dashboard/level_system/add') }}</div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_level_systems as $level_systems)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ $level_systems->name_level_systems }}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::read($link_level_system,'dashboard/level_system/read/'.$level_systems->id_level_systems) }}
														{{ Shwetech::edit($link_level_system,'dashboard/level_system/edit/'.$level_systems->id_level_systems) }}
														@if($level_systems->id_level_systems != 1 && $level_systems->id_level_systems != 2 && $level_systems->id_level_systems != 3)
															{{ Shwetech::delete($link_level_system,'dashboard/level_system/delete/'.$level_systems->id_level_systems,$level_systems->name_level_systems) }}
														@endif
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