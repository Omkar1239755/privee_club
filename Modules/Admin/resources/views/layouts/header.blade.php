<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item"> <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> </li>
        <li class="nav-item d-none d-sm-inline-block"> <a class="nav-link" href="javascript:;" role="button">Welcome
            <b>{{ Auth::guard('admin')->user()->name }}</b>
        </a> </li>
    </ul>
</nav>
