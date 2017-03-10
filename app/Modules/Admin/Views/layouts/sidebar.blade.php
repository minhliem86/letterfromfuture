  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <!-- Optionally, you can add icons to the links -->
        <!-- <li class=""><a href=""><i class="fa fa-photo"></i> <span>Thống kê</span></a></li> -->
        <li class="{!!Active::setActive(2,'dashboard')!!}"><a href="{!!url('admin/dashboard')!!}"><i class="fa fa-photo"></i> <span>Dashboard</span></a></li>
        <li class="{!!Active::setActive(2,'student')!!}"><a href="{!!route('admin.student.index')!!}"><i class="fa fa-photo"></i> <span>Student</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
