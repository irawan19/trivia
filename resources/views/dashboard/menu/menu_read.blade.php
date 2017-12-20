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
	            <li class="breadcrumb-item active">Read</li>
	        </ol>
	    </div>
	</div>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-12">
	            <div class="card">
	                <div class="card-body">
	                    @if($read_sub_menus != null)
				        	<table class="table table-bordered table-condensed">
								<thead>
									<tr>
										<th>Menu</td>
										<th>Sub Menu</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><i class="mdi {{ $read_menus->icon_menus }}"></i> {{ $read_menus->name_menus }}</td>
										<td></td>
									</tr>
									@php($no=1)
									@foreach($read_sub_menus as $sub_menus)
										<tr>
											<td></td>
											<td>{{ $no++ }}. <i class="mdi {{ $sub_menus->icon_menus }}"></i> {{ $sub_menus->name_menus }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@else
							<table id="example2" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Menu</td>
										<th>Sub Menu</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{ $read_menus->name_menus }}</td>
										<td></td>
									</tr>
								</tbody>
							</table>
				        @endif
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