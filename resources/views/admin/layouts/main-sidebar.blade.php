<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ route('admin.dashboard') }}">
                        <img src="{{URL::asset('assets/img/brand/logo_black.png')}}" class="main-logo" alt="logo">
        </a>
        <a class="desktop-logo logo-dark active" href="{{ route('admin.dashboard') }}">
                        <img src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo dark-theme" alt="logo">
        </a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ route('admin.dashboard') }}">
                        <img src="{{URL::asset('assets/img/brand/logo_black.png')}}" class="logo-icon" alt="logo">
        </a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ route('admin.dashboard') }}">
                        <img src="{{URL::asset('assets/img/brand/logo.png')}}" class="logo-icon dark-theme" alt="logo">
        </a>
    </div>

    <div class="main-sidemenu">
        <ul class="side-menu mt-3">
            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-tachometer-alt side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.dashboard') }}</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.user.index') }}">
                    <i class="fa fa-user side-menu__icon"></i>
                    <span class="side-menu__label">Passengers</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.drivers.index') }}">
                    <i class="fa fa-user side-menu__icon"></i>
                    <span class="side-menu__label">Drivers</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.stations.index') }}">
                    <i class="fa fa-charging-station side-menu__icon"></i>
                    <span class="side-menu__label">Locations</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.buses.index') }}">
                    <i class="fa fa-bus side-menu__icon"></i>
                    <span class="side-menu__label">Buses</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.drivers_notifications.index') }}">
                    <i class="fa fa-bell side-menu__icon"></i>
                    <span class="side-menu__label">Drivers Notifications</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.locations_notifications.index') }}">
                    <i class="fa fa-bell side-menu__icon"></i>
                    <span class="side-menu__label">Locations Notifications</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.buses_notifications.index') }}">
                    <i class="fa fa-bell side-menu__icon"></i>
                    <span class="side-menu__label">Buses Notifications</span>
                </a>
            </li>

            {{--<li class="slide">
                <a class="side-menu__item" href="{{ route('admin.contact-us') }}">
                    <i class="fas fa-address-book side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.contact_us') }}</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.report-problem') }}">
                    <i class="fa fa-file side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.report_problem') }}</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.notification.index') }}">
                    <i class="fa fa-bell side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.send_notification') }}</span>
                </a>
            </li>--}}



{{--            <li class="side-item side-item-category">{{config('languageString.app_setting')}}</li>--}}

{{--            <li class="slide">--}}
{{--                <a class="side-menu__item" href="{{ route('admin.page.index') }}">--}}
{{--                    <i class="fa fa-file side-menu__icon"></i>--}}
{{--                    <span class="side-menu__label">{{config('languageString.text_page')}}</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="slide">--}}
{{--                <a class="side-menu__item" href="{{ route('admin.social-link.index') }}">--}}
{{--                    <i class="fa fa-globe-europe side-menu__icon"></i>--}}
{{--                    <span class="side-menu__label">{{config('languageString.social_link')}}</span>--}}
{{--                </a>--}}
{{--            </li>--}}

            {{--<li class="slide">
                <a class="side-menu__item" href="{{ route('admin.app-control.index') }}">
                    <i class="fa fa-file-word side-menu__icon"></i>
                    <span class="side-menu__label">{{config('languageString.app_control')}}</span>
                </a>
            </li>--}}

{{--            <li class="slide">--}}
{{--                <a class="side-menu__item" href="{{ route('admin.app-menu.index') }}">--}}
{{--                    <i class="fa fa-bars side-menu__icon"></i>--}}
{{--                    <span class="side-menu__label">App Menu</span>--}}
{{--                </a>--}}
{{--            </li>--}}

{{--            <li class="slide">--}}
{{--                <a class="side-menu__item" href="{{ route('admin.setting') }}">--}}
{{--                    <i class="fa fa-cog side-menu__icon"></i>--}}
{{--                    <span class="side-menu__label">{{config('languageString.setting')}}</span>--}}
{{--                </a>--}}
{{--            </li>--}}
        </ul>
    </div>
</aside>
<!-- main-sidebar -->
