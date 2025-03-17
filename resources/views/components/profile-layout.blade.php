<div class="row">
    <div class="col-md-12">
        <div class="page-title">
            <h3>{{ __('profile.nav.label') }}</h3>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl">
        <div class="card">
            <div class="card-body">
                @php
                    $routes = [
                        [
                            'label' => __('profile.nav.profile.label'),
                            'route' => 'profile.index',
                            'is_active' => request()->routeIs('profile.index'),
                        ],
                        [
                            'label' => __('profile.nav.update-password.label'),
                            'route' => 'profile.update-password',
                            'is_active' => request()->routeIs('profile.update-password'),
                        ],
                    ];
                @endphp
                <nav class="nav nav-pills">
                    @foreach ($routes as $route)
                        <li class="nav-item">
                            <a class="nav-link {{ $route['is_active'] ? 'active' : '' }}"
                                href="{{ route($route['route']) }}">
                                {{ $route['label'] }}
                            </a>
                        </li>
                    @endforeach
                </nav>

                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
