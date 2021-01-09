<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">

            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>

            {{-- Scoreboard Controller START --}}
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon"> </i>
                    Scoreboard Manage
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.teams.index") }}"
                            class="nav-link {{ request()->is('admin/teams') || request()->is('admin/teams/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-unlock-alt nav-icon"> </i>
                            Teams
                        </a>
                    </li>

                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.whistles.index") }}"
                            class="nav-link {{ request()->is('admin/whistles') || request()->is('admin/whistles/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon"> </i>
                            Whistles
                        </a>
                    </li>

                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.timers.index") }}"
                            class="nav-link {{ request()->is('admin/timers') || request()->is('admin/timers/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon"> </i>
                            Timers
                        </a>
                    </li>

                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.games.index") }}"
                            class="nav-link {{ request()->is('admin/games') || request()->is('admin/games/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-briefcase nav-icon"> </i>
                            Games
                        </a>
                    </li>

                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.scoreboards.index") }}"
                            class="nav-link {{ request()->is('admin/scoreboards') || request()->is('admin/scoreboards/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon"> </i>
                            Scoreboards
                        </a>
                    </li>
                </ul>
            </li>
            {{-- Scoreboard Controller END --}}


            {{-- Song Manage START --}}
            <li class="nav-item">
                <a href="{{ route("admin.songs.index") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt"> </i>
                    Songs
                </a>
            </li>
            {{-- Song Manage END --}}

            {{-- Ads Manage START --}}
            <li class="nav-item">
                <a href="{{ route("admin.ads.index") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt"> </i>
                    Ads Manage
                </a>
            </li>
            {{-- Ads Manage END --}}

            {{-- Ads Manage START --}}
            <li class="nav-item">
                <a href="{{ route("admin.settings.index") }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt"> </i>
                    Settings
                </a>
            </li>
            {{-- Ads Manage END --}}

            @can('users_manage')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.permissions.index") }}"
                            class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('cruds.permission.title') }}
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.roles.index") }}"
                            class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('cruds.role.title') }}
                        </a>
                    </li>
                    <li class="nav-item" style="margin-left: 30px;">
                        <a href="{{ route("admin.users.index") }}"
                            class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon">

                            </i>
                            {{ trans('cruds.user.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan

            <li class="nav-item">
                <a href="{{ route('auth.change_password') }}" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-key">

                    </i>
                    Change password
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>

            @can('dashboard_only')
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    User Only
                    {{-- {{ trans('global.logout') }} --}}
                </a>
            </li>
            @endcan


        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>