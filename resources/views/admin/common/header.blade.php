<a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{\App\Facades\AdminLogin::getAdminSession()->image_url}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{\App\Facades\AdminLogin::getAdminSession()->first_name .' '.\App\Facades\AdminLogin::getAdminSession()->last_name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{\App\Facades\AdminLogin::getAdminSession()->image_url}}" class="img-circle" alt="User Image">

                <p>
                  {{\App\Facades\AdminLogin::getAdminSession()->first_name .' '.\App\Facades\AdminLogin::getAdminSession()->last_name}}
                  <small>Member since Nov. </small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{\App\Facades\Tools::createdAdminEndUrl('admin/form/'.\App\Facades\AdminLogin::getAdminSession()->id)}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{\App\Facades\Tools::createdAdminEndUrl('logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>