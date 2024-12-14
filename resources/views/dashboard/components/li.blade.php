<li class="nav-item">
  <a class="nav-link menu-link @if($routeName === Route::currentRouteName()) active @endIf" href="{{route($routeName)}}">
      <i class="ri-{{ $icon }}"></i> <span data-key="t-{{$lable}}">{{$lable}}</span>
  </a>
</li>