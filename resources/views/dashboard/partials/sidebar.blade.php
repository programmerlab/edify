<aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="assets/images_dashboard/user.png" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo Session::get('name'); ?></div>
                    <div class="email"><?php echo Session::get('email'); ?></div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">Menu</li>
                    
                    <li class="active">
                        <a href="{{url('myaccount')}}">
                            <i class="material-icons">home</i>
                            <span>My account</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('mystories')}}">
                            <i class="material-icons">pages</i>
                            <span>My Stories</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-toggle" href="#">
                            <i class="material-icons">dashboard</i>
                            <span>My Posts</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{url('postupload')}}">
                                    <span>Upload</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('posts')}}">
                                    <span>My Posts</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{url('myorders')}}">
                            <i class="material-icons">receipt</i>
                            <span>My Orders</span>
                        </a>
                    </li>
                    <li>
                        <a class="menu-toggle" href="#">
                            <i class="material-icons">report</i>
                            <span>Help</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="{{url('howitworks')}}">
                                    <span>How it works</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('faq')}}">
                                    <span>FAQ</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{url('termscondition')}}">
                            <i class="material-icons">image</i>
                            <span>Terms and Conditions</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2020 <a href="javascript:void(0);">Edify</a>. All rights reserved.
                </div>
            </div>
            <!-- #Footer -->
        </aside>