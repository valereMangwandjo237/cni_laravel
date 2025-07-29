<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('dash_home')}}" class="brand-link">
        <!--begin::Brand Image-->
        <img
            src="{{ asset('/assets/img/logo_dgi.png') }}"
            alt="AdminLTE Logo"
            class="brand-image opacity-75 shadow"
        />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">DGI</span>
        <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
            class="nav sidebar-menu flex-column"
            data-lte-toggle="treeview"
            role="navigation"
            aria-label="Main navigation"
            data-accordion="false"
            id="navigation"
        >
            <li class="nav-item">
                <a href="{{route('dash_home')}}" class="nav-link {{ active_class('home') }}">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('dash_all')}}" class="nav-link {{ active_class('dash_all') }}">
                    <p>
                        Totals
                        <span class="nav-badge badge text-bg-secondary me-3">{{$totals}}</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('dash_validate')}}" class="nav-link {{ active_class('dash_validate') }}">
                    <p>
                        Validées
                        <span class="nav-badge badge text-bg-secondary me-3">{{$valides}}</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('dash_wait')}}" class="nav-link {{ active_class('dash_wait') }}">
                    <p>
                        En attente
                        <span class="nav-badge badge text-bg-secondary me-3">{{$verifies}}</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('dash_block')}}" class="nav-link {{ active_class('dash_block') }}">
                    <p>
                        Bloquées
                        <span class="nav-badge badge text-bg-secondary me-3">{{$bloques}}</span>
                    </p>
                </a>
            </li>
            <li class="nav-item">
            <a href="{{route('logout')}}" class="nav-link">
                <i class="nav-icon bi bi-browser-edge"></i>
                <p>Deconnexion</p>
            </a>
            </li>



        </ul>
        <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
    </aside>
