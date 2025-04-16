<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Title -->
    <title>@yield('title') - {{ config('app.name') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Theme Styles -->
    <link href="{{ asset('css/lime.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    @php
        $routes = [
            [
                'route' => 'dashboard',
                'icon' => 'home',
                'label' => 'Dashboard',
                'is_active' => request()->routeIs('dashboard'),
            ],
            [
                'route' => 'criteria.index',
                'icon' => 'numbered-list',
                'label' => __('criteria.nav.label'),
                'is_active' => request()->routeIs('criteria.*'),
            ],
            [
                'route' => 'citizen.index',
                'icon' => 'user-group',
                'label' => __('citizen.nav.label'),
                'is_active' => request()->routeIs('citizen.*'),
            ],
            [
                'route' => 'user.index',
                'icon' => 'user-group',
                'label' => __('user.nav.label'),
                'is_active' => request()->routeIs('user.*'),
                'hidden' => !Auth::user()->isAdmin() && !Auth::user()->isSAdmin(),
            ],
            [
                'route' => 'assessment',
                'icon' => 'clipboard-document-check',
                'label' => __('assessment.nav.label'),
                'is_active' => request()->routeIs('assessment'),
            ],
            [
                'route' => 'calculation.index',
                'icon' => 'calculator',
                'label' => __('calculation.nav.label'),
                'is_active' => request()->routeIs('calculation.*'),
            ],
        ];
    @endphp
    <div class="lime-sidebar">
        <div class="lime-sidebar-inner slimscroll">
            <ul class="accordion-menu">
                <li class="sidebar-title">
                    Apps
                </li>
                @foreach ($routes as $route)
                    @if (!isset($route['hidden']) || !$route['hidden'])
                        <li>
                            <a href="{{ route($route['route']) }}"
                                class="d-flex {{ $route['is_active'] ? 'active' : '' }}">
                                @php
                                    $iconComponent = $route['is_active']
                                        ? 'heroicon-s-' . $route['icon']
                                        : 'heroicon-o-' . $route['icon'];
                                @endphp
                                <x-dynamic-component :component="$iconComponent" />
                                <span class="pl-3">{{ $route['label'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div class="lime-header">
        <nav class="navbar navbar-expand-lg">
            <section class="material-design-hamburger navigation-toggle">
                <a href="javascript:void(0)" class="button-collapse material-design-hamburger__icon">
                    <span class="material-design-hamburger__layer"></span>
                </a>
            </section>
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="42" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="material-icons">keyboard_arrow_down</i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <x-heroicon-s-user-circle width="24" /> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.index') }}">
                                    {{ __('general.nav.profile.label') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('general.nav.logout.label') }}
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="lime-container">
        <div class="lime-body">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <div class="lime-footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span class="footer-text">{{ now()->format('Y') }} © {{ config('app.name') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel"> {{ __('general.label.confirm.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('general.label.confirm.delete') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger"
                        id="confirmDelete">{{ __('general.actions.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <script src="{{ asset('plugins/jquery/jquery-3.1.0.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('js/lime.min.js') }}"></script>

    @if (request()->is('dashboard'))
        <script src="{{ asset('plugins/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/pages/dashboard.js') }}"></script>
    @endif

    @yield('script')

    <script>
        $(document).ready(function() {
            let formToDelete;

            $(".delete-button").on("click", function() {
                formToDelete = $(this).closest("form");
                $("#deleteModal").modal("show");
            });

            $("#confirmDelete").on("click", function() {
                if (formToDelete) {
                    formToDelete.submit();
                }
            });

            $('.custom-file-input').on('change', function() {
                var fileName = $(this).val();
                $(this).next('.custom-file-label').html(fileName);
            })

            toastr.options = {
                progressBar: true,
                timeOut: 3000,
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}");
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}");
            @endif
        });
    </script>
</body>

</html>
