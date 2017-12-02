@if (Auth::check())
<a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ Gravatar::get(Auth::user()->email) }}" alt="user" class="profile-pic" /></a>
<div class="dropdown-menu dropdown-menu-right animated flipInY">
    <ul class="dropdown-user">
        <li>
            <div class="dw-user-box">
                <div class="u-text">
                    <h4>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
                    <p class="text-muted">{{ Auth::user()->email }}</p></div>
            </div>
        </li>
        <li role="separator" class="divider"></li>
        <li><a href="{{ route('dashboard') }}"><i class="ti-panel"></i> Dashboard</a></li>
        <!--<li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
        <li role="separator" class="divider"></li>-->
        <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
    </ul>
</div>
@else
<a class="nav-link waves-effect waves-dark" href="{{ route('login') }}" >Login</a>
@endif