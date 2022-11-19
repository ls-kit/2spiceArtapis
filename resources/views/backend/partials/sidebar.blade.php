@php
use App\Models\Ticket;
use App\Models\TicketReply;

$totalTickets = Ticket::where('status', 'pending')->get()->count();
$userticekt = Ticket::where('user_id', auth()->user()->id)->pluck('id');
$totalusermessage = TicketReply::whereIn('ticket_id', $userticekt)->where('is_admin', 1)->where('is_seen', 0)->count();

@endphp
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="{{route('home')}}" class="header-logo">
            <img src="{{$settings->logo}}" class="img-fluid rounded-normal" alt="">
            <div class="logo-title">
                {{-- <span class="text-primary text-uppercase">{{($settings->app_name)? $settings->app_name : config('app.name')}}</span> --}}
            </div>
        </a>
        <div class="iq-menu-bt-sidebar">
            <div class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="main-circle"><i class="las la-bars"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar-scrollbar">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">
                @role('admin')
                <li class="{{ Request::is('admin/home')? 'active' : null }}"><a href="{{ route('public.home') }}" class="iq-waves-effect"><i
                            class="las la-home iq-arrow-left"></i><span>Dashboard</span></a>
                </li>
                <li class="{{ (Request::is('roles') || Request::is('permissions') || Request::is('users*'))? 'active active-menu' : null }}">
                    <a href="#pages" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="{{ (Request::is('roles') || Request::is('permissions') || Request::is('users*'))? 'true' : 'false' }}"><i
                            class="las la-file-alt iq-arrow-left"></i><span>Authentication</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="pages" class="iq-submenu collapse {{ (Request::is('roles') || Request::is('permissions') || Request::is('users*'))? 'show' : null }}" data-parent="#iq-sidebar-toggle">
                        <li class="{{ (Request::is('roles') || Request::is('permissions')) ? 'active' : null }}"><a href="{{ route('laravelroles::roles.index') }}"><i class="las la-user"></i>Role Management</a></li>
                        <li class="{{ Request::is('users', 'users/' . Auth::user()->id, 'users/' . Auth::user()->id . '/edit') ? 'active' : null }}"><a href="{{ url('/users') }}"><i class="las la-users"></i>Users Management</a></li>
                        <li class="{{ Request::is('users/create') ? 'active' : null }}"><a href="{{ url('/users/create') }}"><i class="las la-plus"></i>Add New User</a></li>
                    </ul>
                </li>
                <!-- Category -->
                {{-- <li class="{{ Request::is('admin/category*')? 'active active-menu' : null }}">
                    <a href="#category" class="iq-waves-effect collapsed" data-toggle="collapse"
                        aria-expanded="{{ Request::is('admin/category*')? 'true' : 'false' }}"><i class="las la-list-ul"></i><span>Category</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="category" class="iq-submenu collapse {{ Request::is('admin/category*')? 'show' : null }}" data-parent="#iq-sidebar-toggle">
                        <li class="{{ Request::is('admin/category/create')? 'active' : null }}"><a href="{{Route('categories.create')}}"><i class="las la-user-plus"></i>Add Category</a></li>
                        <li class="{{ Request::is('admin/category')? 'active' : null }}"><a href="{{Route('categories')}}"><i class="las la-eye"></i>Category List</a></li>
                    </ul>
                </li> --}}
                <!-- Menu -->
                <li class="{{ Request::is('admin/menu*')? 'active active-menu' : null }}">
                    <a href="#menu" class="iq-waves-effect collapsed" data-toggle="collapse"
                        aria-expanded="{{ Request::is('admin/menu*')? 'true' : 'false' }}"><i class="las la-list-ul"></i><span>Menu</span><i
                            class="ri-arrow-right-s-line iq-arrow-right"></i></a>
                    <ul id="menu" class="iq-submenu collapse {{ Request::is('admin/menu*')? 'show' : null }}" data-parent="#iq-sidebar-toggle">
                        <li class="{{ Request::is('admin/menu/create')? 'active' : null }}"><a href="{{Route('public.menu.create')}}"><i class="las la-user-plus"></i>Add Menu</a></li>
                        <li class="{{ Request::is('admin/menu')? 'active' : null }}"><a href="{{Route('public.menu.index')}}"><i class="las la-eye"></i>Menu List</a></li>
                    </ul>
                </li>
                <li class="{{ (Request::is('roles') || Request::is('permissions') || Request::is('users*'))? 'active active-menu' : null }}">
                    <a href="{{Route('site.settings')}}" class="iq-waves-effect"><i class="las la-tools"></i><span>Site Settings</span></a>
                </li>
                <li class="{{ (Request::is('roles') || Request::is('permissions') || Request::is('users*'))? 'active active-menu' : null }}">
                    <a href="{{Route('ticket.index')}}" class="iq-waves-effect"><i class="las la-tools"></i>
                        <span>Tickets</span>
                        @if($totalTickets)
                            <span class="iq-arrow-right badge badge-primary p-1">{{$totalTickets}}</span>
                        @endif
                    </a>
                </li>
                @endrole
                {{-- For referral --}}
                <li class="{{ Request::is('admin/referral')? 'active' : null }}">
                    <a href="{{route('referrallist')}}" class="iq-waves-effect"><i class="las la-upload"></i><span>My Referral</span></a>
                </li>
                <li class="{{ Request::is('admin/upload')? 'active' : null }}">
                    <a href="{{Route('public.upload')}}" class="iq-waves-effect"><i class="las la-upload"></i><span>Upload Content</span></a>
                </li>
                <li class="{{ Request::is('admin/music')? 'active' : null }}">
                    <a href="{{Route('public.music')}}" class="iq-waves-effect"><i class="las la-music"></i><span>Music List</span></a>
                </li>
                <li class="{{ Request::is('admin/talent')? 'active' : null }}">
                    <a href="{{Route('public.talent')}}" class="iq-waves-effect"><i class="las la-brain"></i><span>Talent List</span></a>
                </li>
                <li class="{{ Request::is('admin/comedy')? 'active' : null }}">
                    <a href="{{Route('public.comedy')}}" class="iq-waves-effect"><i class="las la-smile"></i><span>Comedy List</span></a>
                </li>
                @role('user')
                <li class="{{ Request::is('admin/comedy')? 'active' : null }}">
                    <a href="{{Route('user.ticket.index')}}" class="iq-waves-effect"><i class="las la-smile"></i>
                        <span>Ticket</span>
                        @if($totalusermessage> 0)
                        <span class="iq-arrow-right badge badge-primary p-1">{{$totalusermessage}}</span>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/sell-list')? 'active' : null }}">
                    <a href="{{Route('user.sellslist')}}" class="iq-waves-effect"><i class="las la-smile"></i>
                        <span>Selling List</span>
                    </a>
                </li>
                @endrole
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="iq-waves-effect"><i class="ri-login-box-line"></i><span>Sign out</span></a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</div>
