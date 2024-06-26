        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="{{ url('home') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ assets('') }}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ assets('') }}/assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{ url('home') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ assets('') }}/assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ assets('') }}/assets/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="mdi mdi-speedometer"></i> <span data-key="t-dashboards">Dashboards</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ url('home') }}" class="nav-link" data-key="t-dashboards">
                                            Home </a>
                                    </li>

                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->
  
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Master" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Master">
                                <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-master">Master</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Master">
                                <ul class="nav nav-sm flex-column">

                                <li class="nav-item">
                            <a class="nav-link menu-link" href="{{ url('/master/customers') }}" >
                                <i class="mdi mdi-sticker-text-outline"></i> <span>Customer List</span>
                            </a> 
                            </li> 
                            <li class="nav-item">
                                        <a href="{{ url('addresstype') }}" class="nav-link" data-key="t-master">
                                           Customer Type
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('products') }}" class="nav-link" data-key="t-master">
                                           Tally Product
                                        </a>
                                    </li> 
                                    <li class="nav-item">
                                        <a href="{{ url('role') }}" class="nav-link" data-key="t-master">
                                        Desigination
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ url('user') }}" class="nav-link" data-key="t-master">
                                         Exceutive
                                        </a>
                                    </li> 
                                </ul>
                            </div>
                        </li>
                       

                        
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#PreSales" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="PreSales">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-presales">Pre Sales</span>
                            </a>
                            <div class="collapse menu-dropdown" id="PreSales">
                                <ul class="nav nav-sm flex-column">
                                  <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-presales"> Leads
                                        </a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-presales"> Opportunities
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-presales"> Email Campaign
                                        </a>
                                    </li>
 

                                    <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-presales"> Quote
                                        </a>
                                    </li> 

                                    <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-presales"> Multiple Quote
                                        </a>
                                    </li> 

                                    <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-presales"> Price Discount & Approval
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-presales"> Terms & Conditions
                                        </a>
                                    </li>
 


                                </ul>
                            </div>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Sales" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Sales">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-apps">Sales</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Sales">
                                <ul class="nav nav-sm flex-column"> 
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Contracts" >
                                <i class="mdi mdi-sticker-text-outline"></i> <span>Service Contracts</span>
                            </a>
                           
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Services" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Services">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-services">Services</span>
                            </a> 

                            <div class="collapse menu-dropdown" id="Services">
                                <ul class="nav nav-sm flex-column">  
                                <li class="nav-item">
                                        <a href="{{ url('transactions/onsiteentry') }}" class="nav-link" data-key="t-services"> On-Site Visit  </a>
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-services"> AMC  </a>
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-services"> TDL  </a>
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-services"> Renewal  </a>
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-services"> Online Calls  </a> 
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-services"> Calls Closing  </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                         
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Traning" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Traning">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-apps">Training</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Traning">
                                <ul class="nav nav-sm flex-column"> 
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#UserPermission" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="UserPermission">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-apps">User Permissions  </span>
                            </a>
                            <div class="collapse menu-dropdown" id="UserPermission">
                                <ul class="nav nav-sm flex-column"> 
                                </ul>
                            </div>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Messages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Messages">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-apps">Messages</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Messages">
                                <ul class="nav nav-sm flex-column"> 
                                </ul>
                            </div>
                        </li>
                        
                         
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-apps">Products</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarApps">
                                <ul class="nav nav-sm flex-column"> 
                                </ul>
                            </div>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Tickets" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Tickets">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-apps">Tickets</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Tickets">
                                <ul class="nav nav-sm flex-column"> 
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#Reports" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Reports">
                                <i class="mdi mdi-sticker-text-outline"></i> <span data-key="t-apps">Reports</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Reports">
                                <ul class="nav nav-sm flex-column">

                                    <li class="nav-item">
                                        <a href="{{ url('reports/hourly') }}" class="nav-link" data-key="t-calendar"> Hourly
                                        </a>
                                    </li> 
                                </ul>
                            </div>
                        </li>
                        <!-- end  Menu -->


                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>