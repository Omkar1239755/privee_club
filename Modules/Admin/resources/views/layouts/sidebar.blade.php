<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="d-flex">
            <a href="{{ url('admin/dashboard') }}" class="brand-link left_sidebar_img">
            <img src="{{ url('public/assets/images/Frame.png') }}"  alt="AdminLTE Logo" style="width:75 px;" class="brand-image ">
            &nbsp;<span class="brand-text font-weight-bold"><b>Privee</b></span>
            </a>
    </div>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin.user')}}" class="nav-link {{ Request::is('admin/get-user') ? 'active' : '' }}"> <i class="fa-solid fa-users"></i>
                        &nbsp;<p> Users </p>
                    </a>
                </li> 
                
                <li class="nav-item">
                    <a href="{{route('admin.privacy')}}" class="nav-link"> <i class="fa-solid fa-users"></i>
                        &nbsp;<p> Privacy </p>
                    </a>
                </li>
                
                <!--<li class="nav-item">-->
                <!--    <a href="{{route('admin.term')}}" class="nav-link"> <i class="fa-solid fa-users"></i>-->
                <!--        &nbsp;<p> Terms & Condition </p>-->
                <!--    </a>-->
                <!--</li>-->
               
                <li class="nav-item">
                <a href="{{route('admin.logout')}}" class="nav-link {{ Request::is('admin/logout') ? 'active' : '' }}"><i class="fas fa-sign-out-alt"></i>
                     &nbsp;<p> Logout </p>
                </a>
                </li> 
                
                <!-- <li class="nav-item">-->
                <!--    <a href="{{route('admin.catgeories')}}" class="nav-link {{ Request::is('admin/category') ? 'active' : '' }}"> <i class="fa-solid fa-users"></i>-->
                <!--        &nbsp;<p> Category </p>-->
                <!--    </a>-->
                <!--</li> -->
        

            </ul>
        </nav>
    </div>
</aside>

