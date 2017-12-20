@extends('dashboard.layouts.container')
@section('content')

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                Laravel {{ App::VERSION() }}
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align:center">
                            Welcome <b>{{ Auth::user()->name }}</b> to Trivia Web Admin Panel
                            <br/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align:center">
                            @if($total_list_stakes != 0)
                                <b>The following is a list of stakes</b>
                                <br/>
                                <div class="col-12" style="float:none;margin: 0 auto;">
                                    <table class="tablesaw table-striped table-hover table-bordered table" data-tablesaw-mode="columntoggle">
                                        <thead>
                                            <tr>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist" width="5%">No</th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="2" width="5%">Image</th>
                                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Name</th>
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
                                                </tr>
                                                @php($no++)
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <b style="color:red">no list of stakes</b>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop