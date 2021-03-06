 <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
<div class="page-container">

 <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar navbar-collapse collapse">

                    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start active open">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="selected"></span>
                                <span class="arrow open"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item start active open">
                                    <a href="{{ url('admin')}}" class="nav-link ">
                                        <i class="icon-bar-chart"></i>
                                        <span class="title">Dashboard</span>
                                        <span class="selected"></span>
                                    </a>
                                </li>
                                </ul>
                        </li>

                         <li class="nav-item start active {{ (isset($page_title) && $page_title=='Role')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Roles</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Blog')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='View Role')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Role')?'active':'' }}">
                                            <a href="{{ route('role') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Roles
                                                </span>
                                            </a>
                                        </li>

                                         <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Role')?'active':'' }}">
                                            <a href="{{ route('role.create') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    Create Role
                                                </span>
                                            </a>
                                        </li>
										 <li class="nav-item  {{ (isset($page_title) && $page_action=='Update Permission')?'active':'' }}">
                                            <a href="{{ url('admin/permission') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    Set Permission
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>


                        <li class="nav-item  start active  {{ (isset($page_title) && ($page_title=='Admin User' || $page_title=='Client User') )?'open':'' }}">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                 <i class="glyphicon glyphicon-user"></i>
                                <span class="title">Manage User</span>
                                <span class="arrow {{ (isset($page_title) && $page_title=='Admin User')?'open':'' }}"></span>
                            </a>

                           <ul class="sub-menu" style="display: {{ (isset($page_title) && ($page_title=='Admin User' OR $page_title=='Client User' ))?'block':'none' }}">

                               <li class="nav-item  {{ (isset($page_title) && $page_title=='Admin User')?'open':'' }}">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-user"></i>
                                    <span class="title">Admin User</span>
                                    <span class="arrow {{ (isset($page_title) && $page_title=='Admin User')?'open':'' }}"></span>
                                </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Admin User')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Admin User')?'active':'' }}">
                                            <a href="{{ route('user.create') }}" class="nav-link ">
                                                <i class="glyphicon glyphicon-plus-sign"></i>
                                                <span class="title">
                                                    Create User
                                                </span>
                                            </a>
                                        </li>

                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Admin User')?'active':'' }}">
                                            <a href="{{ route('user') }}" class="nav-link ">
                                                 <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Users
                                                </span>
                                            </a>
                                        </li>


                                    </ul>
                                </li>
                               <li class="nav-item  {{ (isset($page_title) && $page_title=='Client User')?'open':'' }}">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-user"></i>
                                    <span class="title">Client User</span>
                                    <span class="arrow {{ (isset($page_title) && $page_title=='Client User')?'open':'' }}"></span>
                                </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Client User')?'block':'none' }}">
                                        <!-- <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Client User')?'active':'' }}">
                                            <a href="{{ route('clientuser.create') }}" class="nav-link ">
                                                <i class="glyphicon glyphicon-plus-sign"></i>
                                                <span class="title">
                                                    Create User
                                                </span>
                                            </a>
                                        </li> -->

                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Client User')?'active':'' }}">
                                            <a href="{{ route('clientuser') }}" class="nav-link ">
                                                 <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Users
                                                </span>
                                            </a>
                                        </li>


                                    </ul>
                                </li>

                            </ul>
                        </li>

    <li class="nav-item  start active {{ (isset($page_title) && $page_title=='Category')?'open':'' }}">
    <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-folder-open-o"></i>
        <span class="title">Manage Category</span>
        <span class="arrow {{ (isset($page_title) && $page_title=='Category')?'open':'' }}"></span>
    </a>
    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Category')?'block':'none' }}">
       
        <li class="nav-item  {{ (isset($sub_page_title) && $sub_page_title=='Sub Category')?'open':'' }}">

            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-folder-o"></i>
                <span class="title">Category</span>
                <span class="arrow {{ (isset($sub_page_title) && $sub_page_title=='Sub Category')?'open':'' }}"></span>
            </a>
            <ul class="sub-menu"  style="display: {{ (isset($sub_page_title) && $sub_page_title=='Category')?'block':'' }}">
                <li class="nav-item {{ (isset($page_action) && $page_action=='Create  Category')?'open':'' }}">
                    <a href="{{ route('category.create') }}" class="nav-link " > Create Category</a>
                </li>
                <li class="nav-item {{ (isset($page_action) && $page_action=='View  Category')?'open':'' }}">
                    <a href="{{ route('category') }}" class="nav-link "  >View Category</a>
                </li>

            </ul>
        </li>
    </ul>
    </li>

    <li class="nav-item  start active {{ (isset($page_title) && $page_title=='Software Editor')?'open':'' }}">
         
        <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-folder-open-o"></i>
        <span class="title">Software Editor</span>
        <span class="arrow {{ (isset($page_title) && $page_title=='Software Editor')?'open':'' }}"></span>
    </a>
        <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Software Editor')?'block':'none' }}">
           
            <li class="nav-item  {{ (isset($sub_page_title) && $sub_page_title=='Sub Software Editor')?'open':'' }}">

                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-folder-o"></i>
                    <span class="title">Software Editor</span>
                    <span class="arrow {{ (isset($sub_page_title) && $sub_page_title=='Software Editor')?'open':'' }}"></span>
                </a>
                <ul class="sub-menu"  style="display: {{ (isset($sub_page_title) && $sub_page_title=='Software Editor')?'block':'' }}">
                    <li class="nav-item {{ (isset($page_action) && $page_action=='Create  Software Editor')?'open':'' }}">
                        <a href="{{ route('softwareEditor.create') }}" class="nav-link " > Create Software Editor</a>
                    </li>
                    <li class="nav-item {{ (isset($page_action) && $page_action=='View  Software Editor')?'open':'' }}">
                        <a href="{{ route('softwareEditor') }}" class="nav-link "  >View Software Editor</a>
                    </li>

                </ul>
            </li>
        </ul>
    </li>


    <li class="nav-item  start active {{ (isset($page_title) && $page_title=='Software Editor')?'open':'' }}">
         
        <a href="javascript:;" class="nav-link nav-toggle">
        <i class="fa fa-folder-open-o"></i>
        <span class="title">  Editor </span>
        <span class="arrow {{ (isset($page_title) && $page_title=='Editor Portfolio')?'open':'' }}"></span>
    </a>
        <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Editor Portfolio')?'block':'none' }}">
           
            <li class="nav-item  {{ (isset($sub_page_title) && $sub_page_title=='Editor Portfolio')?'open':'' }}">

                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-folder-o"></i>
                    <span class="title">Editor Portfolio</span>
                    <span class="arrow {{ (isset($sub_page_title) && $sub_page_title=='Editor Portfolio')?'open':'' }}"></span>
                </a>
                <ul class="sub-menu"  style="display: {{ (isset($sub_page_title) && $sub_page_title=='Editor Portfolio')?'block':'' }}">
                    <li class="nav-item {{ (isset($page_action) && $page_action=='Create  Editor Portfolio')?'open':'' }}">
                        <a href="{{ route('editorPortfolio.create') }}" class="nav-link " > Create Editor Portfolio </a>
                    </li>
                    <li class="nav-item {{ (isset($page_action) && $page_action=='View  Software Editor')?'open':'' }}">
                        <a href="{{ route('editorPortfolio') }}" class="nav-link "  >View Editor Portfolio</a>
                    </li>

                </ul>
            </li>
        </ul>
    </li>


                        
                         <li class="nav-item  start active  {{ (isset($viewPage) && $viewPage=='Post Task')?'open':'' }}">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                     <i class="glyphicon glyphicon-user"></i>
                                    <span class="title">Manage Orders</span>
                                    <span class="arrow {{ (isset($viewPage) && $viewPage=='Post Task')?'open':'' }}"></span>
                                </a>

                            <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Post Task')?'block':'none' }}">

                                <li class="nav-item  {{ (isset($page_title) && $page_title=='Post Task')?'open':'' }}">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-user"></i>
                                    <span class="title">Orders</span>
                                    <span class="arrow {{ (isset($page_title) && $page_title=='Post Task')?'open':'' }}"></span>
                                </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Post Task')?'block':'none' }}">
                                         <li class="nav-item  {{ (isset($page_title) && $page_action=='Post Task')?'active':'' }}">
                                            <a href="{{ route('postTask') }}" class="nav-link ">
                                                 <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Orders
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item  {{ (isset($page_title) && $page_title=='comment')?'open':'' }}">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-user"></i>
                                    <span class="title">Comment</span>
                                    <span class="arrow {{ (isset($page_title) && $page_title=='comment')?'open':'' }}"></span>
                                </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='comment')?'block':'none' }}">
                                         <li class="nav-item  {{ (isset($page_title) && $page_action=='comment')?'active':'' }}">
                                            <a href="{{ route('comment') }}" class="nav-link ">
                                                 <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Comment
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>



                            <!-- Post task -->


                          <!---Resolution Center-->
                     


                  <!--    <li class="nav-item start active {{ (isset($page_title) && $page_title=='Program')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Promotions</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Program')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Program')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Program')?'active':'' }}">
                                            <a href="{{ route('program') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Promotion
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Program')?'active':'' }}">
                                            <a href="{{ route('program.create') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-plus-sign"></i>
                                                <span class="title">
                                                    Create Promotion
                                                </span>
                                            </a>
                                        </li>

                                    </ul>

                            </li> -->



                           <!--  <li class="nav-item start active {{ (isset($page_title) && $page_title=='Blog')?'open':'' }}">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="glyphicon glyphicon-th"></i>
                                    <span class="title">Blogs</span>
                                    <span class="arrow {{ (isset($page_title) && $page_title=='Blog')?'open':'' }}"></span>
                                </a>
                                <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Blog')?'block':'none' }}">
                                    <li class="nav-item  {{ (isset($page_title) && $page_action=='View Blog')?'active':'' }}">
                                        <a href="{{ route('blog') }}" class="nav-link ">
                                           <i class="glyphicon glyphicon-eye-open"></i>
                                            <span class="title">
                                                View Blogs
                                            </span>
                                        </a>
                                    </li>

                                     <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Blog')?'active':'' }}">
                                        <a href="{{ route('blog.create') }}" class="nav-link ">
                                           <i class="glyphicon glyphicon-plus-sign"></i>
                                            <span class="title">
                                                Create Blog
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item start active {{ (isset($page_title) && $page_title=='Article Type')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Article Category</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Article Type')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Article Type')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Article Type')?'active':'' }}">
                                            <a href="{{ route('articleType') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Article Type
                                                </span>
                                            </a>
                                        </li>

                                         <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Article Type')?'active':'' }}">
                                            <a href="{{ route('articleType.create') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-plus-sign"></i>
                                                <span class="title">
                                                    Create Article Type
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                            </li>
 -->


                            <!-- <li class="nav-item start active {{ (isset($page_title) && $page_title=='Article')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Article</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Article')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Article')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Article')?'active':'' }}">
                                            <a href="{{ route('article') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Article
                                                </span>
                                            </a>
                                        </li>

                                         <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Article')?'active':'' }}">
                                            <a href="{{ route('article.create') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-plus-sign"></i>
                                                <span class="title">
                                                    Create Article
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                            </li> -->

                                <!-- <li class="nav-item start active {{ (isset($page_title) && $page_title=='Support Ticket')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Support Ticket</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Article')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Support Ticket')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Article')?'active':'' }}">
                                            <a href="{{ route('supportTicket') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    Support Ticket
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>  -->

                               <!--  <li class="nav-item start active {{ (isset($page_title) && $page_title=='Reason')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Reason</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Reason')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Reason')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Reason')?'active':'' }}">
                                            <a href="{{ route('reason') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    View Reason
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Reason')?'active':'' }}">
                                            <a href="{{ route('reason.create') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    Create Reason
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>  -->
                            

                                <li class="nav-item start active {{ (isset($page_title) && $page_title=='Payment')?'open':'' }}">
                                   <a href="javascript:;" class="nav-link nav-toggle">
                                       <i class="glyphicon glyphicon-th"></i>
                                       <span class="title">Payment Management</span>
                                       <span class="arrow {{ (isset($page_title) && $page_title=='Payment')?'open':'' }}"></span>
                                   </a>
                               </li>

                               <li class="nav-item start active {{ (isset($page_title) && $page_title=='setting')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Website Setting </span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='setting')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='setting')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View setting')?'active':'' }}">
                                        <a href="{{ route('setting') }}" class="nav-link ">
                                           <i class="glyphicon glyphicon-eye-open"></i> 
                                            <span class="title">
                                                View Settings
                                            </span>
                                        </a>
                                        </li> 
                                            
                                    </ul>
                            </li>

                            <!-- <li class="nav-item start active {{ (isset($page_title) && $page_title=='Editor Test')?'open':'' }}">
                                   <a href="{{ url('admin/editor-test') }}" class="nav-link nav-toggle">
                                       <i class="glyphicon glyphicon-th"></i>
                                       <span class="title">Editor test</span>
                                   
                                   </a>
                             </li> -->
                               <li class="nav-item start active {{ (isset($page_title) && $page_title=='Reason')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Editor Test</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Reason')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Reason')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Reason')?'active':'' }}">
                                            <a href="{{ url('admin/test-images') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    Add test Images
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Reason')?'active':'' }}">
                                            <a href="{{ url('admin/editor-test') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    Test Results
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> 


                                <li class="nav-item start active {{ (isset($page_title) && $page_title=='Page')?'open':'' }}">
                                    <a href="javascript:;" class="nav-link nav-toggle">
                                        <i class="glyphicon glyphicon-th"></i>
                                        <span class="title">Manage Page</span>
                                        <span class="arrow {{ (isset($page_title) && $page_title=='Page')?'open':'' }}"></span>
                                    </a>
                                    <ul class="sub-menu" style="display: {{ (isset($page_title) && $page_title=='Page')?'block':'none' }}">
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='View Page')?'active':'' }}">
                                            <a href="{{ route('content.create') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                    Add New Page
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item  {{ (isset($page_title) && $page_action=='Create Page')?'active':'' }}">
                                            <a href="{{ route('content') }}" class="nav-link ">
                                               <i class="glyphicon glyphicon-eye-open"></i>
                                                <span class="title">
                                                   Show Content
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> 
                        
                        </ul>
                    </li> 


                        <!-- posttask end-->
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
