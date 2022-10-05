<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google.">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template, eCommerce dashboard, analytic dashboard">
    <meta name="author" content="ThemeSelect">
    <title>@yield('title') | ASIK Universitas Paramadina</title>
    <link rel="apple-touch-icon" href="{{asset('v1//app-assets/images/favicon/apple-touch-icon-152x152.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('v1/app-assets/images/favicon/favicon-32x32.png')}}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   <!-- BEGIN: VENDOR CSS-->
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/vendors.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/flag-icon/css/flag-icon.min.css')}}">
     {{-- calendar --}}

   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/materialize-stepper/materialize-stepper.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/fullcalendar/css/fullcalendar.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/fullcalendar/daygrid/daygrid.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/fullcalendar/timegrid/timegrid.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/vendors/dropify/css/dropify.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/pages/page-blog.css')}}">

   <!-- END: VENDOR CSS-->
   <!-- BEGIN: Page Level CSS-->
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/themes/vertical-modern-menu-template/materialize.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/themes/vertical-modern-menu-template/style.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/pages/data-tables.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/pages/form-wizard.css')}}">
   <!-- END: Page Level CSS-->
   <!-- BEGIN: Custom CSS-->
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/pages/app-calendar.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/custom/custom.css')}}">


    {{-- datatables --}}

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
        integrity="sha256-pODNVtK3uOhL8FUNWWvFQK0QoQoV3YA9wGGng6mbZ0E=" crossorigin="anonymous" />

   </head>
<!-- END: Head-->

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed">
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow">
                <div class="nav-wrapper">
                    <div class="header-search-wrapper hide-on-med-and-down"
                    {{-- <i class="material-icons">search</i> --}}
                        {{-- <input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Explore Materialize" data-search="template-list"> --}}
                        <ul class="search-list collection display-none"></ul>
                    </div>
                    <ul class="navbar-list right">

                        <li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>
                        <li>halo, <b> {{Auth::user()->name}}</b></li>
                        <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{asset('v1/app-assets/images/avatar/avatar-7.png')}}" alt="avatar"><i></i></span></a></li>

                    </ul>
                    <!-- translation-button-->

                    <!-- notifications-dropdown-->
                    {{-- <ul class="dropdown-content" id="notifications-dropdown">
                        <li>
                            <h6>NOTIFICATIONS<span class="new badge">5</span></h6>
                        </li>
                        <li class="divider"></li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle teal small">settings</span> Settings updated</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle deep-orange small">today</span> Director meeting started</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle amber small">trending_up</span> Generate monthly report</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                        </li>
                    </ul> --}}
                    <!-- profile-dropdown-->
                    @php

                    $role = Auth::user()->getRoleNames()[0];
                    @endphp
                    <ul class="dropdown-content" id="profile-dropdown">
                        @if($role == 'mahasiswa'){
                        <li><a class="grey-text text-darken-1" href="{{ route('profile') }}"><i class="material-icons">person_outline</i> Profile</a></li>
                        @endif
                        {{-- <li><a class="grey-text text-darken-1" href="app-chat.html"><i class="material-icons">lock</i> Password</a></li> --}}
                        {{-- <li><a class="grey-text text-darken-1" href="user/{{Auth::user()->id}}/editprofile"><i class="material-icons">lock</i> Password</a></li> --}}

                        <li class="divider"></li>

                        <form method="POST" action="{{ route('logout') }}">
                        <li>
                              @csrf
                              <a href="{{ route('logout') }}" class="grey-text text-darken-1" onclick="event.preventDefault();
                              this.closest('form').submit();"><i class="material-icons">keyboard_tab</i>Logout</a>
                          </li>
                        </form>
                    </ul>
                </div>
                <nav class="display-none search-sm">
                    <div class="nav-wrapper">
                        <form id="navbarForm">
                            <div class="input-field search-input-sm">
                                <input class="search-box-sm mb-0" type="search" required="" id="search" placeholder="Explore Materialize" data-search="template-list">
                                <label class="label-icon" for="search"><i class="material-icons search-sm-icon">search</i></label><i class="material-icons search-sm-close">close</i>
                                <ul class="search-list collection search-list-sm display-none"></ul>
                            </div>
                        </form>
                    </div>
                </nav>
            </nav>
        </div>
    </header>
    <!-- END: Header-->
    <ul class="display-none" id="default-search-main">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">FILES</h6>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('v1/app-assets/images/icon/pdf-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Two new item submitted</span><small class="grey-text">Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">17kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('v1/app-assets/images/icon/doc-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">52 Doc file Generator</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">550kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('v1/app-assets/images/icon/xls-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">25 Xls File Uploaded</span><small class="grey-text">Digital Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">20kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('v1/app-assets/images/icon/jpg-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">37kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">MEMBERS</h6>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('v1/app-assets/images/avatar/avatar-7.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">John Doe</span><small class="grey-text">UI designer</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('v1/app-assets/images/avatar/avatar-8.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Michal Clark</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('v1/app-assets/images/avatar/avatar-10.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Milena Gibson</span><small class="grey-text">Digital Marketing</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('v1/app-assets/images/avatar/avatar-12.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a></li>
    </ul>
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion"><a class="collection-item display-flex align-items-center" href="#"><span class="material-icons">error_outline</span><span class="member-info">No results found.</span></a></li>
    </ul>

    <!-- BEGIN: SideNav-->
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
       <img src="{{asset('logo-upm-putih.png')}}" class="img-fluid mt-5 " style="margin-left:20px" width="200" alt="">
        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow mt-4" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
            <li class="bold"><a class="waves-effect waves-cyan " href="{{route('dashboard.index')}}" ><i class="material-icons">dashboard</i><span class="menu-title" data-i18n="Documentation">Dashboard</span></a>
            </li>
            <li class="navigation-header"><a class="navigation-header-text">Misc </a><i class="navigation-header-icon material-icons">more_horiz</i>
            </li>
            @if(Auth::user())
            @foreach($menudata as $b => $value)
                @foreach ($value as $a)
                @if($a->menu)
                @if(($a->menu->parent_id  == 0) && ($a->menu->position == 'none') || ($a->menu->position == 'single'))
                <li class="bold"><a class="waves-effect waves-cyan " href="{{route($a->menu->link ?? '')}}"><i class="material-icons">{{$a->menu->icon}}</i><span class="menu-title" data-i18n="Documentation">{{$a->menu->name}}</span></a>
                </li>
                    @elseif(($a->menu->parent_id == 0) && ($a->menu->position == 'parent'))
                        <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="javascript:void(0);"><i class="material-icons">{{$a->menu->icon}}</i><span class="menu-title" data-i18n="Menu levels">{{$a->menu->name}}</span></a>
                            <div class="collapsible-body">
                                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                                    @foreach($menudata as $children => $childs)

                                         @foreach($childs as $child)
                                            {{-- {{ $child->menu ? $child->menu->parent_id : 0 }} --}}
                                            @if($child->menu)
                                            @if( $child->menu->parent_id == $a->menu->id)
                                                <li><a href="{{route($child->menu->link ?? '')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">{{$child->menu->name}}</span></a>
                                                </li>
                                            @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @endif
                    @endif
                @endforeach
           @endforeach
           @endif







        </ul>
        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        @yield('content')
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN: Footer-->

    <footer class="page-footer footer footer-static footer-dark gradient-45deg-indigo-purple gradient-shadow navbar-border navbar-shadow">
        <div class="footer-copyright">
            <div class="container"><span>&copy; <?php echo date('Y');?> <a href="http://themeforest.net/user/pixinvent/portfolio?ref=pixinvent" target="_blank">PIXINVENT</a> All rights reserved.</span><span class="right hide-on-small-only">Design and Developed by <a href="https://pixinvent.com/">PIXINVENT</a></span></div>
        </div>
    </footer>


    <!-- END: Footer-->
    <!-- BEGIN VENDOR JS-->
    <script src="{{asset('v1/app-assets/js/vendors.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/dropify/js/dropify.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/select2/select2.full.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('v1/app-assets/vendors/select2/select2.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('v1/app-assets/vendors/select2/select2-materialize.css')}}" type="text/css">
    <script src="{{asset('v1/app-assets/vendors/materialize-stepper/materialize-stepper.min.js')}}"></script>
    <!-- BEGIN VENDOR JS-->
    <script src="{{asset('v1/app-assets/vendors/fullcalendar/lib/moment.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/fullcalendar/js/fullcalendar.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/fullcalendar/daygrid/daygrid.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/fullcalendar/timegrid/timegrid.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/fullcalendar/interaction/interaction.min.js')}}"></script>
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('v1/app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('v1/app-assets/vendors/data-tables/js/dataTables.select.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->
    <link rel="stylesheet" type="text/css" href="{{asset('v1/app-assets/css/pages/form-select2.css')}}">
    <!-- BEGIN THEME  JS-->
    <script src="{{asset('v1/app-assets/js/plugins.js')}}"></script>
    <script src="{{asset('v1/app-assets/js/search.js')}}"></script>
    <script src="{{asset('v1/app-assets/js/custom/custom-script.js')}}"></script>
    <script src="{{asset('v1/app-assets/js/scripts/customizer.js')}}"></script>
    {{-- <script src="{{asset('v1/app-assets/js/scripts/app-calendar.js')}}"></script> --}}

    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    {{-- <script src="{{asset('v1/app-assets/js/scripts/data-tables.js')}}"></script> --}}
    <!-- END PAGE LEVEL JS-->
    <script src="{{asset('v1/app-assets/js/scripts/form-select2.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{asset('v1/app-assets/js/scripts/form-wizard.js')}}"></script>
    <script src="{{asset('v1/app-assets/js/scripts/advance-ui-modals.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"
        integrity="sha256-siqh9650JHbYFKyZeTEAhq+3jvkFCG8Iz+MHdr9eKrw=" crossorigin="anonymous"></script>
    <script src="{{asset('v1/app-assets/js/scripts/form-file-uploads.js')}}"></script>
    <script>
      //message with toastr
      @if(session()->has('success'))
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.success('{{ session('success') }}');
      @elseif(session()->has('error'))
      toastr.options.positionClass = 'toast-bottom-right';
        toastr.error('{{ session('error') }}');
      @endif
    </script>



@yield('script')

</body>

</html>
