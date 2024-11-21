<div class="sidebar">
    <div class="menu-btn">
        <i class="ph-bold ph-caret-left"></i>
    </div>
    <div class="head">
        <div class="user-img">
            <img src="{{ asset('/assets/images/aloo-salhi-logo-new.png') }}" alt="" />
        </div>
        <div class="user-details">
            <p class="title">Salhi<span style="color: orange;">hub</span></p>
            <p class="name">
                User </p>
        </div>
    </div>
    <div class="nav">
        <div class="menu">
            <p class="title">Main</p>
            <ul>
                <li class="{{ request()->routeIs('home') ? 'mainMenu' : '' }}">
                    <a href="{{ route('home') }}">
                        <i class="icon ph-bold ph-house-simple"></i>
                        <span class="text">Home</span>
                    </a>
                </li>

                <li class="{{ request()->is('Parcels/*') ? 'mainMenu' : '' }}">
                    <a href="#">
                        <i class="icon fa-solid fa-box"></i>
                        <span class="text">Prarcels</span>
                        <i class="arrow ph-bold ph-caret-down"></i>
                    </a>
                    <ul class="sub-menu">
                        <li class="#">
                            @auth
                                @if (auth()->user()->type === 'admin')
                                    <a class="{{ request()->is('Parcels/index') ? 'sub-active' : '' }}"
                                        href="{{ route('parcels') }}">
                                        <span class="text">> All Parcels</span>
                                    </a>
                                @endif
                            @endauth
                        </li>
                        <li>
                            <a class="{{ request()->is('Parcels/deliverymen/index') || request()->is('Parcels/deliverymen/*') ? 'sub-active' : '' }}"
                                href="{{ route('deliverymen') }}">
                                <span class="text">> Per deliveryman</span>
                            </a>
                        </li>
                        @auth
                            @if (auth()->user()->type == 'admin')
                        <li class="#">
                            <a class="{{ request()->is('Parcels/companies/index') || request()->is('Parcels/companies/*')  ? 'sub-active' : '' }}"
                                href="{{ route('companies') }}">
                                <span class="text">> Per Client</span>
                            </a>
                        </li>
                        @endif
                        @endauth

                    </ul>
                </li>

                <li class="#">
                    <a href="#">
                        <i class="fas fa-file-invoice"></i>
                        <span class="text">Bon de payement</span>
                        <i class="arrow ph-bold ph-caret-down"></i>
                    </a>
                    <ul class="sub-menu">
                        <li class="#">
                            <a class="#" href="#">
                                <span class="text">> Pour Livereur</span>
                            </a>
                        </li>
                        <li class="#">
                            <a href="#">
                                <span class="text">> Pour Client</span>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
        @auth
            @if (auth()->user()->type == 'admin')
                <div class="menu">
                    <p class="title">Settings</p>
                    <ul>
                        <li class="{{ request()->routeIs('settings') ? 'mainMenu' : '' }}">
                            <a href="{{ route('settings') }}">
                                <i class="icon ph-bold ph-gear"></i>
                                <span class="text">Settings</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('insertion') ? 'mainMenu' : '' }}">
                            <a href="{{ route('insertion') }}">
                                <i class="fas fa-file-upload"></i>
                                <span class="text">Data Exporting</span>
                            </a>
                        </li>
                    </ul>

                </div>
            @endif
        @endauth
        <br>
        <div class="menu">
            <p class="title">Account</p>
            <ul>

                @guest
                    <li class="{{ request()->routeIs('login') ? 'mainMenu' : '' }}">
                        <a href="{{ route('login') }}">
                            <i class="icon ph-bold ph-sign-in"></i>
                            <span class="text">Login</span>
                        </a>

                    </li>
                @endguest
                @auth
                    <li>
                        <a class="{{ request()->routeIs('logout') ? 'mainMenu' : '' }}" href="{{ route('logout') }}">
                            <i class="icon ph-bold ph-sign-out"></i>
                            <span class="text">Logout</span>
                        </a>

                    </li>
                @endauth
            </ul>
        </div>
    </div>

</div>
