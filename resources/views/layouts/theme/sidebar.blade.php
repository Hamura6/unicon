<nav>
    <div class="navigation">
        <ul>
            <li class="pr">
                <a href="">
                    {{-- <span class="icon mt-5">
                        <ion-icon class="fas fa-industry"></ion-icon>
                    </span> --}}
                    <img src="{{ asset('IMG/log.png') }}" alt="">
                    <span class="title">UNICON <strong style="color: white">S.A. </strong>
                    </span>
                </a>
            </li>
            <hr class="linear-sidebar">
            @can('Ver panel de control')
                
            <li>
                <a class="a {{ request()->routeIs('panel.control') ? 'hovered' : '' }}"
                    href="{{ route('panel.control') }}">
                    <span class="icon">
                        <ion-icon class="fa-sharp fa-solid fa-house-chimney"></ion-icon>
                    </span>
                    <span class="title">Panel de control</span>
                </a>
            </li>
            @endcan
            @if (auth()->user()->can('Ver usuarios') || auth()->user()->can('Ver roles') || auth()->user()->can('Ver permisos'))
                <li class="li">
                    <a class="sub">
                        <span class="icon">
                            <ion-icon class="fa-sharp fa-solid fa-users-gear"></ion-icon>
                        </span>
                        <span class="title">Control de usuario</span>
                        <i class="fas fa-angle-down arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        @can('Ver usuarios')
                            <li> <a class="a {{ request()->routeIs('users') ? 'hovered' : '' }}"
                                    href="{{ route('users') }}">
                                    <span class="icon">
                                        <ion-icon class="fa-sharp fa-solid fa-user-pen"></ion-icon>
                                    </span>
                                    <span class="title">Usuarios</span>
                                </a>
                            </li>
                        @endcan
                        @can('Ver roles')
                            <li>
                                <a class="a {{ request()->routeIs('roles') ? 'hovered' : '' }}" href="{{ route('roles') }}">
                                    <span class="icon">
                                        <ion-icon class="fa-sharp fa-solid fa-user-tie"></ion-icon>
                                    </span>
                                    <span class="title">Roles</span>
                                </a>
                            </li>
                        @endcan
                        @can('Ver permisos')
                            <li>
                                <a class="a {{ request()->routeIs('permissions') ? 'hovered' : '' }}"
                                    href="{{ route('permissions') }}">
                                    <span class="icon">
                                        <ion-icon class="fa-sharp fa-solid fa-person-circle-plus"></ion-icon>
                                    </span>
                                    <span class="title">Permisos</span>
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endif


            @can('Administrar ventas')
                <li>
                    <a class="a {{ request()->routeIs('sales') ? 'hovered' : '' }}" href="{{ route('sales') }}">
                        <span class="icon">
                            <ion-icon class="fa-sharp fa-solid fa-cart-shopping"></ion-icon>
                        </span>
                        <span class="title">Ventas</span>
                    </a>
                </li>
            @endcan
            @can('Ver produccion')
                <li>
                    <a class="a {{ request()->routeIs('productions') ? 'hovered' : '' }}"
                        href="{{ route('productions') }}">
                        <span class="icon">
                            <ion-icon class="fa-sharp fa-solid fa-industry"></ion-icon>
                        </span>
                        <span class="title">Produccion</span>
                    </a>
                </li>
            @endcan

            <li class="li">
                <a class="sub">
                    <span class="icon">
                        <ion-icon class="fa-sharp fa-solid fa-warehouse"></ion-icon>
                    </span>
                    <span class="title">Inventario</span>
                    <i class="fas fa-angle-down arrow"></i>
                </a>
                <ul class="sub-menu">
                    @can('Ver materiales')
                        <li>
                            <a class="a {{ request()->routeIs('materials') ? 'hovered' : '' }}"
                                href="{{ route('materials') }}">
                                <span class="icon">
                                    <ion-icon class="fa-sharp fa-solid fa-box-open"></ion-icon>
                                </span>
                                <span class="title">Material</span>
                            </a>
                        </li>
                    @endcan
                    @can('Ver productos')
                        <li>
                            <a class="a {{ request()->routeIs('products') ? 'hovered' : '' }}"
                                href="{{ route('products') }}">
                                <span class="icon">
                                    <ion-icon class="fa-sharp fa-solid fa-boxes-stacked"></ion-icon>
                                </span>
                                <span class="title">Productos</span>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
            @if (auth()->user()->can('Ver reporte de ventas') ||
                    auth()->user()->can('Ver reporte de produccion') ||
                    auth()->user()->can('Ver repòrte de compras'))
                <li class="li">
                    <a class="sub">
                        <span class="icon">
                            <ion-icon class="fa-sharp fa-solid fa-list"></ion-icon>
                        </span>
                        <span class="title">Reportes</span>
                        <i class="fas fa-angle-down arrow"></i>
                    </a>
                    <ul class="sub-menu">
                        @can('Ver reporte de ventas')
                            <li>
                                <a class="a {{ request()->routeIs('report-sales') ? 'hovered' : '' }}"
                                    href="{{ route('report-sales') }} ">
                                    <span class="icon">
                                        <ion-icon class="fa-sharp fa-solid fa-sim-card"></ion-icon>
                                    </span>
                                    <span class="title">Ventas</span>
                                </a>
                            </li>
                        @endcan
                        @can('Ver reporte de produccion')
                            <li>
                                <a class="a {{ request()->routeIs('report-productions') ? 'hovered' : '' }}"
                                    href="{{ route('report-productions') }}">
                                    <span class="icon">
                                        <ion-icon class="fa-sharp fa-solid fa-list-check"></ion-icon>
                                    </span>
                                    <span class="title">Producccion</span>
                                </a>
                            </li>
                        @endcan
                        @can('Ver repòrte de compras')
                            <li>
                                <a class="a {{ request()->routeIs('report-buys') ? 'hovered' : '' }}"
                                    href="{{ route('report-buys') }}">
                                    <span class="icon">
                                        <ion-icon class="fa-sharp fa-solid fa-clipboard-list"></ion-icon>
                                    </span>
                                    <span class="title">Compras</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            @can('Ver proveedores')
                <li>
                    <a class="a {{ request()->routeIs('suppliers') ? 'hovered' : '' }}" href="{{ route('suppliers') }}">
                        <span class="icon">
                            <ion-icon class="fa-sharp fa-solid fa-address-card"></ion-icon>
                        </span>
                        <span class="title">Proveedores</span>
                    </a>
                </li>
            @endcan
            @can('Ver clientes')
                <li>
                    <a class="a {{ request()->routeIs('customers') ? 'hovered' : '' }}" href="{{ route('customers') }}">
                        <span class="icon">
                            <ion-icon class="fa-sharp fa-solid fa-address-book"></ion-icon>
                        </span>
                        <span class="title">Clientes</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</nav>
