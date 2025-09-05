<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="d-flex">
            <a href="{{ url('admin/dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/images/Frame.png') }}"  alt="AdminLTE Logo" style="width:75 px;" class="brand-image img-circle ">
            &nbsp;<span class="brand-text font-weight-bold"><b>Privee</b></span>
            </a>
    </div>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}"> <i class="fa-solid fa-users"></i>
                        &nbsp;<p> Users </p>
                    </a>
                </li> 
               
                 <li class="nav-item">
                    <a href="{{route('admin.catgeories')}}" class="nav-link {{ Request::is('admin/catgeory') ? 'active' : '' }}"> <i class="fa-solid fa-users"></i>
                        &nbsp;<p> Category </p>
                    </a>
                </li> 

            

            </ul>
        </nav>
    </div>
</aside>

