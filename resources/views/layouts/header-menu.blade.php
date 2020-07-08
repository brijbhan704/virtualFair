<?php  $session=Session::get('session');
$profileDetail=Session::get('profileDetail');
$evntDetail=Session::get('evntDetail');
$selectedEvent=Session::get('selectedEvent');
$profile_pic="";
/*$profile_pic=$profileDetail->exhim_logo;*/
//dump($selectedEvent);
?>    <div class="main-header">
      <!-- logo -->
            <div class="" style="width: 253px!important;">
                <img src="{{asset('assets/images/logo.png')}}" alt="">
            </div>

            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>

            
           

             <!-- User avatar dropdown -->
             <div class="dropdown">
                    <div  class="user col align-self-end">
                    
                    
                       <a id="eventDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon  i-MaleFemale"></i><br>
                            <span class="nav-text">{{ (isset($selectedEvent->aem_name) ? $selectedEvent->aem_name : '') }}</span>
                        </a>
                        


                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="eventDropdown">
                        @if(isset($evntDetail))
                            @foreach($evntDetail as $key => $evntList)
                                    <a class="dropdown-item" href="changeevent/{{$evntList->aem_id}}/{{Request::path()}}" >{{$evntList->aem_name}}</a>
                            @endforeach
                        @endif
                           
                        </div>
                        
                    </div>
                </div>

           


            <div style="margin: auto"></div>

            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
                <!-- Grid menu Dropdown -->

                <!-- Notificaiton -->
                <div class="dropdown">
                    <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="badge badge-primary">3</span>
                        <i class="i-Bell text-muted header-icon"></i>
                    </div>
                    <!-- Notification dropdown -->
                    <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                        <div class="dropdown-item d-flex">
                            <div class="notification-icon">
                                <i class="i-Speach-Bubble-6 text-primary mr-1"></i>
                            </div>
                            <div class="notification-details flex-grow-1">
                                <p class="m-0 d-flex align-items-center">
                                    <span>New message</span>
                                    <span class="badge badge-pill badge-primary ml-1 mr-1">new</span>
                                    <span class="flex-grow-1"></span>
                                    <span class="text-small text-muted ml-auto">10 sec ago</span>
                                </p>
                                <p class="text-small text-muted m-0">James: Hey! are you busy?</p>
                            </div>
                        </div>
                        <div class="dropdown-item d-flex">
                            <div class="notification-icon">
                                <i class="i-Receipt-3 text-success mr-1"></i>
                            </div>
                            <div class="notification-details flex-grow-1">
                                <p class="m-0 d-flex align-items-center">
                                    <span>New order received</span>
                                    <span class="badge badge-pill badge-success ml-1 mr-1">new</span>
                                    <span class="flex-grow-1"></span>
                                    <span class="text-small text-muted ml-auto">2 hours ago</span>
                                </p>
                                <p class="text-small text-muted m-0">1 Headphone, 3 iPhone x</p>
                            </div>
                        </div>
                        <div class="dropdown-item d-flex">
                            <div class="notification-icon">
                                <i class="i-Empty-Box text-danger mr-1"></i>
                            </div>
                            <div class="notification-details flex-grow-1">
                                <p class="m-0 d-flex align-items-center">
                                    <span>Product out of stock</span>
                                    <span class="badge badge-pill badge-danger ml-1 mr-1">3</span>
                                    <span class="flex-grow-1"></span>
                                    <span class="text-small text-muted ml-auto">10 hours ago</span>
                                </p>
                                <p class="text-small text-muted m-0">Headphone E67, R98, XL90, Q77</p>
                            </div>
                        </div>
                        <div class="dropdown-item d-flex">
                            <div class="notification-icon">
                                <i class="i-Data-Power text-success mr-1"></i>
                            </div>
                            <div class="notification-details flex-grow-1">
                                <p class="m-0 d-flex align-items-center">
                                    <span>Server Up!</span>
                                    <span class="badge badge-pill badge-success ml-1 mr-1">3</span>
                                    <span class="flex-grow-1"></span>
                                    <span class="text-small text-muted ml-auto">14 hours ago</span>
                                </p>
                                <p class="text-small text-muted m-0">Server rebooted successfully</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notificaiton End -->

                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div  class="user col align-self-end">
                      <?php if (!empty($profile_pic)){  ?>
                        <img src="{{asset('assets/images/'.$session[0]->bm_id.'/'.$profileDetail->exhim_id.'/'.$profileDetail->exhim_logo)}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                      <?php } else { ?>
                        <img src="{{asset('assets/images/faces/avatar.jpg')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                      <?php } ?>




                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> {{$session[0]->user_name}}
                            </div>
                            <a class="dropdown-item" href="{{url('/')}}/profile">Account settings</a>
                            <!-- <a class="dropdown-item">Billing history</a> -->
                            <a class="dropdown-item" href="{{url('/')}}/logout">Sign out</a>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <!-- header top menu end -->
