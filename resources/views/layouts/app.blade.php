<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Sistema SCM')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
              integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
              crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Modern Styles -->
        <link href="{{ asset('css/modern-styles.css') }}" rel="stylesheet">
        <!-- Navigation Styles -->
        <link href="{{ asset('css/navigation-new.css') }}" rel="stylesheet">
        <!-- Whitespace Fix -->
        <link href="{{ asset('css/whitespace-fix.css') }}" rel="stylesheet">

        <!-- Google Fonts - Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            :root {
                --header-height: 64px;
                --sidebar-width: 280px;
            }

            /* 🔧 SOLUCIÓN SIMPLE Y EFECTIVA */
            body {
                font-family: 'Inter', sans-serif;
                margin: 0;
                padding: 0;
            }

            /* Contenedor principal con padding-top para navbar fijo */
            .min-h-screen {
                min-height: 100vh;
                margin: 0;
                padding: 0;
            }

            /* Main sin espacios adicionales */
            main {
                margin: 0;
                padding: 0;
            }

            /* Containers sin espacios superiores */
            .container-fluid,
            .container {
                margin-top: 0;
                padding-top: 0;
            }

            /* Elementos específicos sin espacios */
            .welcome-header,
            .dashboard-card,
            .alert {
                margin-top: 0;
            }

            .nav-dropdown-trigger {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                color: #6B7280;
                border: none;
                background: transparent;
                border-radius: 0.375rem;
                transition: all 0.2s;
                white-space: nowrap;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .nav-dropdown-trigger:hover,
            .nav-dropdown-trigger.active {
                background-color: #F3F4F6;
                color: #1F2937;
            }

            .nav-dropdown-menu {
                position: absolute;
                top: 100%;
                left: 0;
                z-index: 1000;
                background: white;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
                min-width: 220px;
                margin-top: 0.5rem;
            }

            .nav-dropdown-item {
                padding: 0.75rem 1rem;
                color: #4B5563;
                text-decoration: none;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                transition: all 0.2s;
            }

            .nav-dropdown-item:hover {
                background-color: #F3F4F6;
                color: #1F2937;
            }

            .nav-dropdown-item.active {
                background-color: #E5E7EB;
                color: #1F2937;
            }

            .module-description {
                font-size: 0.75rem;
                color: #6B7280;
                white-space: normal;
            }

            @media (max-width: 768px) {
                .nav-dropdown-trigger .text {
                    display: none;
                }

                .nav-dropdown-trigger .icon {
                    margin: 0;
                }
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <!-- Navegación fija FUERA del contenedor principal -->
        @include('layouts.navigation')

        <!-- Contenedor principal CON el padding-top correcto -->
        <div class="min-h-screen bg-gray-100" style="padding-top: 64px; margin: 0;">

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main style="margin: 0; padding: 0;">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4" role="alert" style="margin-top: 0;">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert" style="margin-top: 0;">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert" style="margin-top: 0;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Modern UI Enhancements -->
        <script src="{{ asset('js/modern-ui.js') }}"></script>

        @stack('scripts')
    </body>
</html>
