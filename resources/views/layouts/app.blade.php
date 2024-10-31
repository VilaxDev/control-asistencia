<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modernize Dashboard</title>
    <link rel="shortcut icon" type="image/png" href="{{ url('/assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ url('/assets/css/styles.min.css') }} " />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Carga de Chart.js desde el CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="{{ url('/assets/images/logos/dark-logo.svg') }}" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Inicio</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/dashboard') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Administracion</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/ubicacion-empresarial') }}"
                                aria-expanded="false">
                                <span>
                                    <i class="ti ti-map-pin"></i>
                                </span>
                                <span class="hide-menu">Ubicación Empresarial</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/periodos') }}" aria-expanded="false">
                                <span>
                                    <img src="{{ url('/assets/images/logos/calendar-bolt.svg') }}" alt="">
                                </span>
                                <span class="hide-menu">Periodos</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/eventos') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-calendar-event"></i>
                                </span>
                                <span class="hide-menu">Eventos</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link dropdown-toggle" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-calendar-plus"></i>
                                </span>
                                <span class="hide-menu">Gestion de Horarios</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ url('admin/horarios') }}" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-calendar-stats"></i>
                                        </div>
                                        <span class="hide-menu">Horarios</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link dropdown-toggle" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-user-plus"></i>
                                </span>
                                <span class="hide-menu">Gestion de Usuarios</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ url('admin/tipos-colaborador') }}" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-user"></i>
                                        </div>
                                        <span class="hide-menu">Tipos</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ url('admin/colaboradores') }}" class="sidebar-link">
                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <span class="hide-menu">Colaboradores</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/asistencias') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-circle-check"></i>
                                </span>
                                <span class="hide-menu">Asistencias</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/reportes') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-chart-bar"></i>
                                </span>
                                <span class="hide-menu">Reportes</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Usuario</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/perfil') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-user"></i>
                                </span>
                                <span class="hide-menu">Perfil</span>
                            </a>
                        </li>
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Configuración</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('admin/acerca-de') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-info-circle"></i>
                                </span>
                                <span class="hide-menu">Acerca de...</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-settings"></i>
                                </span>
                                <span class="hide-menu">Configuración</span>
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            @php
                                $userType = '';
                                if (Auth::guard('admin')->check()) {
                                    $userType = 'Admin';
                                } elseif (Auth::guard('supervisor')->check()) {
                                    $userType = 'Supervisor';
                                } elseif (Auth::guard('colaborador')->check()) {
                                    $userType = 'Colaborador';
                                }
                            @endphp

                            <a href="" target="_blank" class="btn btn-primary">{{ $userType }}</a>

                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ url('/assets/images/profile/user-1.jpg') }}" alt=""
                                        width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="{{ url('admin/perfil') }}"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Mi Perfil</p>
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-outline-primary mx-3 mt-2 d-block">Cerrar
                                                Sesión</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!--  Header End -->
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ url('/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ url('/assets/js/app.min.js') }}"></script>
    <script src="{{ url('/assets/libs/simplebar/dist/simplebar.js') }}"></script>
</body>

</html>
