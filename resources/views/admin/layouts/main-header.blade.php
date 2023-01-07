<!-- main-header -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
{{--            <div class="responsive-logo">--}}
{{--                <a href="{{ url('/' . $page='index') }}">--}}
{{--                    <img src="{{URL::asset('assets/img/brand/logo-white.png')}}"--}}
{{--                         class="logo-1" alt="logo">--}}
{{--                </a>--}}
{{--                <a href="{{ url('/' . $page='index') }}">--}}
{{--                    <img src="{{URL::asset('assets/img/brand/logo-white.png')}}"--}}
{{--                         class="dark-logo-1" alt="logo">--}}
{{--                </a>--}}
{{--                <a href="{{ url('/' . $page='index') }}">--}}
{{--                    <img src="{{URL::asset('assets/img/brand/favicon.png')}}"--}}
{{--                         class="logo-2" alt="logo">--}}
{{--                </a>--}}
{{--                <a href="{{ url('/' . $page='index') }}">--}}
{{--                    <img src="{{URL::asset('assets/img/brand/favicon.png')}}"--}}
{{--                         class="dark-logo-2" alt="logo">--}}
{{--                </a>--}}
{{--            </div>--}}
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>

        </div>
        <div class="main-header-right">
            <div class="nav nav-item  navbar-nav-right ml-auto">

                @php /*
                <div class="dropdown nav-item main-header-message ">
                    <a class="new nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-mail">
                            <path
                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span class=" pulse-danger"></span></a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-left">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Messages</h6>
                                <span
                                    class="badge badge-pill badge-warning ml-auto my-auto float-right">Mark All Read</span>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread
                                messages</p>
                        </div>
                        <div class="main-message-list chat-scroll">
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="  drop-img  cover-image  "
                                     data-image-src="{{URL::asset('assets/img/faces/3.jpg')}}">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Petey Cruiser</h5>
                                    </div>
                                    <p class="mb-0 desc">I'm sorry but i'm not sure how to help you with that......</p>
                                    <p class="time mb-0 text-left float-left ml-2 mt-2">Mar 15 3:55 PM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                     data-image-src="{{URL::asset('assets/img/faces/2.jpg')}}">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Jimmy Changa</h5>
                                    </div>
                                    <p class="mb-0 desc">All set ! Now, time to get to you now......</p>
                                    <p class="time mb-0 text-left float-left ml-2 mt-2">Mar 06 01:12 AM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                     data-image-src="{{URL::asset('assets/img/faces/9.jpg')}}">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Graham Cracker</h5>
                                    </div>
                                    <p class="mb-0 desc">Are you ready to pickup your Delivery...</p>
                                    <p class="time mb-0 text-left float-left ml-2 mt-2">Feb 25 10:35 AM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                     data-image-src="{{URL::asset('assets/img/faces/12.jpg')}}">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Donatella Nobatti</h5>
                                    </div>
                                    <p class="mb-0 desc">Here are some products ...</p>
                                    <p class="time mb-0 text-left float-left ml-2 mt-2">Feb 12 05:12 PM</p>
                                </div>
                            </a>
                            <a href="#" class="p-3 d-flex border-bottom">
                                <div class="drop-img cover-image"
                                     data-image-src="{{URL::asset('assets/img/faces/5.jpg')}}">
                                    <span class="avatar-status bg-teal"></span>
                                </div>
                                <div class="wd-90p">
                                    <div class="d-flex">
                                        <h5 class="mb-1 name">Anne Fibbiyon</h5>
                                    </div>
                                    <p class="mb-0 desc">I'm sorry but i'm not sure how...</p>
                                    <p class="time mb-0 text-left float-left ml-2 mt-2">Jan 29 03:16 PM</p>
                                </div>
                            </a>
                        </div>
                        <div class="text-center dropdown-footer">
                            <a href="text-center">VIEW ALL</a>
                        </div>
                    </div>
                </div>*/ @endphp

                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs feather feather-maximize" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                        </svg>
                    </a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="">
                        <img alt="" src="{{URL::asset(Auth::user()->image)}}">
                    </a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user">
                                    <img alt="" src="{{URL::asset(Auth::user()->image)}}" class="">
                                </div>
                                <div class="ml-3 my-auto">
                                    <h6>{{ Auth::user()->name }}</h6>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('admin.profile',[1]) }}"><i
                                class="bx bx-slider-alt"></i> Profile</a>
                        @if(Auth::user()->panel_mode==2)
                                <a class="dropdown-item" href="{{ route('admin.changeThemes',[1]) }}"><i
                                        class="bx bx-slider-alt"></i> Dark Themes</a>
                        @else
                                <a class="dropdown-item" href="{{ route('admin.changeThemes',[2]) }}"><i
                                        class="bx bx-slider-alt"></i> Light Themes</a>
                        @endif

                        {{--@if(Auth::user()->locale=='en')
                                <a class="dropdown-item" href="{{ route('admin.changeThemesMode',['ar']) }}"><i
                                        class="bx bx-slider-alt"></i> العربية</a>
                        @else
                                <a class="dropdown-item" href="{{ route('admin.changeThemesMode',['en']) }}"><i
                                        class="bx bx-slider-alt"></i> English</a>
                        @endif--}}
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="bx bx-log-out"></i>
                                Sign Out
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
