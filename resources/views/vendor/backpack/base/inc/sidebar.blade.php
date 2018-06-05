@if (backpack_auth()->check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        @include('backpack::inc.sidebar_user_panel')

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->

          @include('backpack::inc.sidebar_content')

          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}

@role('admin')
<!-- Users, Roles Permissions -->
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
            </ul>
          </li>
          <!-- База Данных -->
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>База</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url('admin/kindergarten') }}"><i class="fa fa-newspaper-o"></i> <span>Детсады</span></a></li>
              <li><a href="{{ url('admin/city') }}"><i class="fa fa-newspaper-o"></i> <span>Города</span></a></li>
              <li><a href="{{ url('admin/cityuser') }}"><i class="fa fa-newspaper-o"></i> <span>Координаторы по городам</span></a></li>
            </ul>
          </li>
          <li><a href="{{ url('admin/calendar') }}"><i class="fa fa-newspaper-o"></i> <span>Календарь</span></a></li>
          <li><a href="{{ url('admin/mail') }}"><i class="fa fa-newspaper-o"></i> <span>Расссылка</span></a></li>
          <li><a href="{{ url('admin/static') }}"><i class="fa fa-newspaper-o"></i> <span>Статистика</span></a></li>
@endrole
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
