<li class="nav-item">
    <a class="nav-link menu-link" href="#{{ $routeName }}" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="{{ $routeName }}">
        <i class="ri-{{ $icon }}"></i> <span data-key="t-{{ $lable }}">{{ $lable }}</span>
    </a>
    <div class="collapse menu-dropdown @if (str_contains(Route::currentRouteName(), $routeName)) show @endIf" id="{{ $routeName }}">
        <ul class="nav nav-sm flex-column">
            @foreach ($lis as $li)
                @can($li['permission'])
                    <li class="nav-item">
                        <a href="{{ route($li['routeName']) }}"
                            class="nav-link @if ($li['routeName'] === Route::currentRouteName()) active @endIf">
                            {{ $li['lable'] }}
                        </a>
                    </li>
                @endcan
            @endforeach
        </ul>
    </div>
</li>
