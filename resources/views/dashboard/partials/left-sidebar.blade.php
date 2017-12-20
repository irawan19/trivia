@php ($id_user = Auth::user()->id)
<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li>
                    <a class="has-arrow waves-effect waves-dark" href="{{ URL('dashboard/home') }}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                </li>

                    @php($get_menus = \App\Master_menu::where('sub_menus_id',0)->orderBy('order_menus')->get())
                    @foreach ($get_menus as $menus)
                        @php($id_menus             = $menus->id_menus)
                        @php($get_sub_menus        = \App\Master_menu::join('master_features','master_menus.id_menus','=','master_features.menus_id')
                                                                    ->join('master_accesses','master_features.id_features','=','master_accesses.features_id')
                                                                    ->join('master_level_systems','master_accesses.level_systems_id','=','master_level_systems.id_level_systems')
                                                                    ->join('users','master_level_systems.id_level_systems','=','users.level_systems_id')
                                                                    ->where('sub_menus_id',$id_menus)
                                                                    ->where('id',$id_user)
                                                                    ->where('name_features','view')
                                                                    ->groupBy('name_menus')
                                                                    ->orderBy('order_menus')
                                                                    ->get())
                        @php($total_sub_menu      = \App\Master_menu::join('master_features','master_menus.id_menus','=','master_features.menus_id')
                                                                    ->join('master_accesses','master_features.id_features','=','master_accesses.features_id')
                                                                    ->join('master_level_systems','master_accesses.level_systems_id','=','master_level_systems.id_level_systems')
                                                                    ->join('users','master_level_systems.id_level_systems','=','users.level_systems_id')
                                                                    ->where('master_menus.sub_menus_id',$id_menus)
                                                                    ->where('master_menus.link_menus','!=','user')
                                                                    ->where('users.id',$id_user)
                                                                    ->where('name_features','view')
                                                                    ->groupBy('name_menus')
                                                                    ->orderBy('order_menus')
                                                                    ->count())
                        @if($total_sub_menu != 0)
                            <li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi {{ $menus->icon_menus }}"></i><span class="hide-menu">{{ $menus->name_menus }}</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    @foreach($get_sub_menus as $sub_menus)
                                        <li>
                                            <a href="{{ URL('dashboard/'.$sub_menus->link_menus) }}"><i class="mdi {{ $sub_menus->icon_menus }}"></i> {{ $sub_menus->name_menus }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach

                <li>
                    <a class="has-arrow waves-effect waves-dark" href="{{ URL('dashboard/logout') }}" aria-expanded="false"><i class="mdi mdi-logout"></i><span class="hide-menu">Logout</span></a>
                </li>
            </ul>
        </nav>
    </div>
</aside>