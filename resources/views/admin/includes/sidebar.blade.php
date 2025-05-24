<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/media/admin/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/media/admin/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/media/admin/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/media/admin/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                @foreach ($navList as $itemOne)
                    <li class="menu-title menuTitle">
                        <i class="{{ $itemOne['icon'] }}"></i>
                        <span data-key="{{ $itemOne['uniqueId'] }}">{{ $itemOne['name'] }}</span>
                    </li>
                    @if (sizeof($itemOne[Config::get('constants.typeCheck.manageNav.navMain.type')]) > 0)
                        @foreach ($itemOne[Config::get('constants.typeCheck.manageNav.navMain.type')] as $itemTwo)
                            <li class="nav-item navItem">
                                @if (sizeof($itemTwo[Config::get('constants.typeCheck.manageNav.navSub.type')]) > 0)
                                    <a class="nav-link menu-link" href="#{{ $itemTwo['uniqueId'] }}" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="{{ $itemTwo['uniqueId'] }}">
                                        <i class="{{ $itemTwo['icon'] }}"></i>
                                        <span data-key="{{ $itemTwo['uniqueId'] }}">{{ $itemTwo['name'] }}</span>
                                    </a>
                                    <div class="collapse menu-dropdown" id="{{ $itemTwo['uniqueId'] }}">
                                        <ul class="nav nav-sm flex-column">
                                            @foreach ($itemTwo[Config::get('constants.typeCheck.manageNav.navSub.type')] as $itemThree)
                                                @if (sizeof($itemThree[Config::get('constants.typeCheck.manageNav.navNested.type')]) > 0)
                                                    <li class="nav-item navItem">
                                                        <a href="#{{ $itemThree['uniqueId'] }}" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="{{ $itemThree['uniqueId'] }}" data-key="{{ $itemThree['uniqueId'] }}">{{ $itemThree['name'] }}</a>
                                                        <div class="collapse menu-dropdown" id="{{ $itemThree['uniqueId'] }}">
                                                            <ul class="nav nav-sm flex-column">
                                                                @foreach ($itemThree[Config::get('constants.typeCheck.manageNav.navNested.type')] as $itemFour)
                                                                    <li class="nav-item navItem">
                                                                        <a href="{{ url('admin/' . $itemFour['route']) }}" class="nav-link" data-key="{{ $itemFour['uniqueId'] }}">{{ $itemFour['name'] }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="nav-item navItem">
                                                        <a href="{{ url('admin/' . $itemThree['route']) }}" class="nav-link" data-key="{{ $itemThree['uniqueId'] }}">{{ $itemThree['name'] }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                            <li class="nav-item navItem">
                                <a class="nav-link menu-link" href="{{ url('admin/' . $itemTwo['route']) }}">
                                    <i class="ri-honour-line"></i>
                                    <span data-key="{{ $itemTwo['uniqueId'] }}">{{ $itemTwo['name'] }}</span>
                                </a>
                            </li>
                        @endif
                        </li>
                    @endforeach
                @else
                @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
