  <!-- Navbar -->
  @include('admin.layouts.menu')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('design/adminLte/dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{admins()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item {{activate_menu('')[1]}}">
                <a href="{{aurl()}}" class="nav-link mb-0">
                    <i class="fa fa-chart-line nav-icon"></i>
                    <p>{{ trans('admin.main')}}</p>
                </a>
            </li>
            <li class="nav-item {{activate_menu('admin')[1]}}">
                <a href="{{aurl('admin')}}" class="nav-link mb-0">
                    <i class="fa fa-users nav-icon"></i>
                    <p>{{ trans('admin.admins')}}</p>
                </a>
            </li>
            <li class="nav-item {{activate_menu('student')[1]}}">
                <a href="{{aurl('student')}}" class="nav-link mb-0">
                    <i class="fa fa-users nav-icon"></i>
                    <p>{{ trans('admin.userPanel')}}</p>
                </a>
            </li>
            <li class="nav-item has-treeview {{activate_menu('exam')[0]}}">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-file-alt"></i>
                    <p>
                        {{ trans('admin.examPanel')}}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="{{ activate_menu('exam')[2] }}">
                    <li class="nav-item">
                        <a href="{{aurl('exam')}}" class="nav-link mb-0 {{lang() == 'ar' ? 'mr-3' : 'ml-3'}}">
                            <p>{{ trans('admin.exam')}}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{aurl('question/create')}}" class="nav-link mb-0 {{lang() == 'ar' ? 'mr-3' : 'ml-3'}}">
                            <p>{{ trans('admin.new_question')}}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{aurl('answer/create')}}" class="nav-link mb-0 {{lang() == 'ar' ? 'mr-3' : 'ml-3'}}">
                            <p>{{ trans('admin.new_answer')}}</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{activate_menu('answer')[1]}}">
                <a href="{{aurl('answer')}}" class="nav-link mb-0">
                    <i class="nav-icon far fa-file-alt"></i>
                    <p>{{ trans('admin.answers')}}</p>
                </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
