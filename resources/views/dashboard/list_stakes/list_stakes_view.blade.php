@extends('dashboard.layouts.container')
@section('content')

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-themecolor">List Stakes</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ URL('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">List Stakes</li>
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
							<form method="GET" action="{{ URL('dashboard/list_stakes/search') }}"  class="form-horizontal m-t-40">
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
					<div align="center">{{ Shwetech::add($link_list_stakes,'dashboard/list_stakes/add') }}</div>
					<br/>
                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">No</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2">Image</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="4">Command</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@php($no = 1)
                        	@foreach($view_list_stakes as $list_stakes)
	                            <tr>
	                                <td width="5%">{{ $no }}</td>
	                                <td width="5%">
                                        <a href="{{ URL::to($list_stakes->path_image_list_stakes) }}/{{ $list_stakes->name_image_list_stakes }}" class="image-popup-no-margins">
                                            <img width="100%" src="{{ URL::to($list_stakes->path_image_list_stakes) }}/{{ $list_stakes->name_image_list_stakes }}">
                                        </a>
                                    </td>
                                    <td>{{ $list_stakes->name_list_stakes }}</td>
	                                <td>{{ $list_stakes->command_list_stakes }}</td>
	                                <td width="5%">
	                                	<div class="input-group">
											<div class="input-group-btn">
												<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<span class="caret"></span>
												</button>
												<div class="dropdown-menu dropdown-menu-right action">
													{{ Shwetech::edit($link_list_stakes,'dashboard/list_stakes/edit/'.$list_stakes->id_list_stakes) }}
													{{ Shwetech::delete($link_list_stakes,'dashboard/list_stakes/delete/'.$list_stakes->id_list_stakes,$list_stakes->name_list_stakes) }}
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