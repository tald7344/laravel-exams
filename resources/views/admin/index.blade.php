@include('admin.layouts.header')
@include('admin.layouts.navbar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ trans('admin.dashboard') }}</h1>
          </div><!-- /.col -->
            @if (!empty(getBreadcrumbWord()))
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ aurl() }}">{{ trans('admin.main') }}</a></li>
                    {!! getBreadcrumbWord() !!}
                </ol>
              </div><!-- /.col -->
            @endif
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        @include('admin.layouts.message')
        @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


@include('admin.layouts.footer')
