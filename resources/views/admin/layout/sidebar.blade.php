@php($route = Route::currentRouteName())
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo ">
        <a href="" class="app-brand-link">
      <span class="app-brand-logo demo">
           <img src="{{asset('assets/images/logo/logo.png')}}" style="width: 30px">
      </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Sch</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>


    <ul class="menu-inner py-1">

        <li class="menu-item {{(strpos($route, 'home') !== false)?'active':''}}">
            <a href="{{route('home')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>


        <!-- Rooms -->
        @can('rooms-list')
        <li class="menu-item {{(strpos($route, 'room') !== false)?'active':''}}">
            <a href="{{route('rooms.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div class="text-truncate" data-i18n="Rooms">Rooms</div>
            </a>
        </li>
        @endcan


        <!-- Timeslots -->
        @can('timeslot-list')
        <li class="menu-item {{(strpos($route, 'timeslot') !== false)?'active':''}}">
            <a href="{{route('timeslots.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div class="text-truncate" data-i18n="Timeslots">Time Slots</div>
            </a>
        </li>
        @endcan

        <!-- Courses -->
        @can('course-list')
        <li class="menu-item {{(strpos($route, 'courses') !== false)?'active':''}}">
            <a href="{{route('courses.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div class="text-truncate" data-i18n="Rooms">Courses</div>
            </a>
        </li>
        @endcan

        <!-- Professors -->
        @can('professor-list')
        <li class="menu-item {{(strpos($route, 'professors') !== false)?'active':''}}">
            <a href="{{route('professors.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div class="text-truncate" data-i18n="Rooms">Professors</div>
            </a>
        </li>
        @endcan

        <!-- Classes -->
        @can('class-list')
        <li class="menu-item {{(strpos($route, 'classes') !== false)?'active':''}}">
            <a href="{{route('classes.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div class="text-truncate" data-i18n="Rooms">Classes</div>
            </a>
        </li>
        @endcan


        <li class="menu-item {{(strpos($route, 'timetables') !== false)?'active':''}}">
            <a href="{{route('timetables.index')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-content"></i>
                <div class="text-truncate" data-i18n="Rooms">TimeTable</div>
            </a>
        </li>





        <!-- Users -->
        @can('user-list')
            <li class="menu-item {{(strpos($route, 'users') !== false)?'active':''}}">
                <a href="{{route('users.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-plus"></i>
                    <div class="text-truncate" data-i18n="Students">Users</div>
                </a>
            </li>
        @endcan
        <!-- Permission -->
        @can('permission-list')
            <li class="menu-item {{(strpos($route, 'permissions') !== false)?'active':''}}">
                <a href="{{route('permissions.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <div class="text-truncate" data-i18n="Dashboard">Permissions</div>
                </a>
            </li>
        @endcan
        <!-- Role -->
        @can('role-list')
            <li class="menu-item {{(strpos($route, 'roles') !== false)?'active':''}}">
                <a href="{{route('roles.index')}}" class="menu-link">
                    <i class="menu-icon fa fa-cog"></i>
                    <div class="text-truncate" data-i18n="Students">Roles</div>
                </a>
            </li>
        @endcan





    </ul>



</aside>
