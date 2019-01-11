<ul class="nav navbar-top-links navbar-right">


    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            {{ Auth::user()->last_name }}<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="{{url('/home')}}"><i class="fa fa-user fa-fw"></i> Panel</a>
            </li>
            @if( Auth::user()->role->name == 'Administrator' )
                <li><a href="{{url('/admin')}}"><i class="fa fa-gear fa-fw"></i> Admin panel</a>
                </li>
            @endif
            @if( Auth::user()->role->name == 'Administrator' OR Auth::user()->role->name == 'Manager')
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Manager panel</a>
                </li>
            @endif

            <li class="divider"></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->


</ul>