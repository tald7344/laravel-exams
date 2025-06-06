<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/')}}" class="nav-link">{{trans('admin.website')}}</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ aurl('logout') }}" class="nav-link">{{trans('admin.logout')}}</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto mr-0">
        <!-- Language Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fa fa-globe"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="{{ aurl('lang/ar') }}" class="dropdown-item">
              <span class="dropdown-item dropdown-header">عربي</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ aurl('lang/en') }}" class="dropdown-item">
              <span class="dropdown-item dropdown-header">English</span>
            </a>
          </div>
        </li>
{{--        <li class="nav-item">--}}
{{--          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">--}}
{{--            <i class="fas fa-th-large"></i>--}}
{{--          </a>--}}
{{--        </li>--}}
    </ul>
  </nav>
