<div class="topbar">
                        <div class="topbar-left	d-none d-lg-block bg-black">
                            <div class="text-center">
                                <a href="home" class="logo"><img src="<?php echo base_url()?>assets/images/logo_dark.png" height="50" alt="logo"> &nbsp;</a>
                            </div>
                        </div>

                        <nav class="navbar-custom bg-black">

                             <!-- Search input -->
                             <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="list-inline float-right mb-0">    

                                <li class="list-inline-item dropdown notification-list nav-user">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                       <img src="<?php echo base_url()?>upload/<?php echo $this->session->userdata('foto');?>" alt="user" class="rounded-circle">
                                        <span class="d-none d-md-inline-block ml-1"><?php echo $this->session->userdata('level');?> <i class="mdi mdi-chevron-down"></i> </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                        <a class="dropdown-item" href="<?php echo base_url('profil')?>"><i class="dripicons-user text-muted"></i> Profile</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo base_url('C_login/logout')?>"><i class="dripicons-exit text-muted"></i> Logout</a>
                                    </div>
                                </li>

                            </ul>

                            <ul class="list-inline menu-left mb-0 ">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect bg-black">
                                        <i class="mdi mdi-menu"></i>
                                    </button>
                                </li>
                            </ul>


                        </nav>

                    </div>