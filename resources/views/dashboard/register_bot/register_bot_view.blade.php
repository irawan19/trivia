@extends('dashboard.layouts.container')
@section('content')

	<div class="row page-titles">
	    <div class="col-md-5 align-self-center">
	        <h3 class="text-themecolor">Register BOT</h3>
	    </div>
	    <div class="col-md-7 align-self-center">
	        <ol class="breadcrumb">
	            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
	            <li class="breadcrumb-item active">Register BOT</li>
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
								<form method="GET" action="{{ URL('dashboard/register_bot/search') }}" class="form-horizontal m-t-40">
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
						<div align="center">{{ Shwetech::register($link_register_bot,'dashboard/register_bot/register') }}</div>
						<br/>
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Date</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Time</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Phone</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_register_bot_registers as $register_bot_registers)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ Shwetech::changeDBToDate($register_bot_registers->date_register_bots) }}</td>
		                                <td>{{ $register_bot_registers->time_register_bots }}</td>
		                                <td>{{ $register_bot_registers->phone_number_bots }}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::confirmation($link_register_bot,'dashboard/register_bot/confirmation/'.$register_bot_registers->id_bots) }}
														{{ Shwetech::delete($link_register_bot,'dashboard/register_bot/delete/'.$register_bot_registers->id_bots,$register_bot_registers->phone_number_bots) }}
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

	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
	                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
	                        <thead>
	                            <tr>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Name</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Phone</th>
	                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Code</th>
	                                <th scope="col">Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@php($no = 1)
	                        	@foreach($view_register_bot_actives as $register_bot_actives)
		                            <tr>
		                                <td>{{ $no }}</td>
		                                <td>{{ $register_bot_actives->name_bots }}</td>
		                                <td>{{ $register_bot_actives->phone_number_bots }}</td>
		                                <td>{{ $register_bot_actives->code_bots }}</td>
		                                <td width="5%">
		                                	<div class="input-group">
												<div class="input-group-btn">
													<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
														<span class="caret"></span>
													</button>
													<div class="dropdown-menu dropdown-menu-right action">
														{{ Shwetech::read($link_register_bot,'dashboard/register_bot/read/'.$register_bot_actives->id_bots) }}
														{{ Shwetech::delete($link_register_bot,'dashboard/register_bot/delete/'.$register_bot_actives->id_bots,$register_bot_actives->name_bots) }}
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