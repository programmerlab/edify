<!doctype html>
<html lang="en">
@include('partials.head')

<body>
@include('partials.header')

<section class="slider">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <div class="item active">
                  <div class="slide">
                    <div class="container">
                        <h2>The Creative artist join Edify</h2>
                    </div>
                </div>
              </div>
              <div class="item">
                <div class="slide">
                    <div class="container">
                        <h2>We provide Job for photo editor, if you make a Money quickly</h2>
                    </div>
                </div>
              </div>
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
              <span class="glyphicon glyphicon-chevron-left"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
              <span class="glyphicon glyphicon-chevron-right"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
    </section>
    
    <section class="about">
        <div class="aboutbox">
            <div class="">
                <div class="abouttxt">
                    <h2 class="sectiontitle">About Edify</h2>
                    <p>The edifyartist.com is India's biggest photo editing website, for mobile editor and Photoshop editor.PHOTOSHOP EDITING SERVICES | IMAGE RETOUCHING COMPANY ,We have provide a Photo editing services for Professional editor. And we provide you take bulk orders of photo editing, Or Upload a your creative design on website and view on my Mobile application *edify* Or customer need for reference photo based edify there photo.</p>
                   
                </div>
                <div class="mobi">
                    <img src="assets/img/6.jpg" alt="">
                </div>
                <div class="clearfix"></div>
            </div>

        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <h2 class="sectiontitle">Testimonials</h2>
            <div id="tms" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <div class="item active">
                      <div class="content">
                        <p>Edifyartist.com  is wonderful!!! They do an AMAZING job with all the photos I send & all the quirky requests I have for the photos. The photos are always edify just the way I wanted. Thank you, thank you, thank you!!</p>
                        <h4>Ravi Kumar</h4>
                      </div>
                  </div>
              
                  <div class="item">
                    <div class="content">
                      <p>I am happy work with edify, they have provide 24 hours payout on my bank accounts.And i have completed daily 30 photos editing orders.</p>
                      <h4>Cesur</h4>
                    </div>
                  </div>

                  <div class="item">
                    <div class="content">
                      <p>edify take orders by using reference photo based editing are easily understanding for every editor what to want customer.</p>
                      <h4>Tejas</h4>
                    </div>
                  </div>
                </div>
              
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#tms" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#tms" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <section class="grids">
        <div class="container">
            <h2 class="sectiontitle">Sample works</h2>
            <div class="flexi">
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/1.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/2.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/3.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/4.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/5.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/6.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/7.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/8.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/9.jpg" alt="">
                </div>
                <div class="items">
                    <img width="220" height="250" border="0" align="center" src="assets/img/sample_work/final_10.jpg" alt="">
                </div>
            </div>
        </div>
    </section>

    <div id="signup" class="modal fade" role="dialog">
        <div class="modal-dialog ">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-body">
                <ul class="nav nav-tabs nav-justified">
                    <li><a data-toggle="tab" href="#becomeEditor">Sign Up</a></li>
                    <li class="active"><a data-toggle="tab" href="#signin">Login</a></li>
                  </ul>
                    
                       
                  <div class="tab-content">
                    <div id="signin" class="tab-pane fade in active">
                    <?php
                        if(Session::has('message'))
                        {
                            ?>
                            <p class="text-danger">
                                  <?php 
                           echo Session::get('message');
                           Session::pull('message');
                           ?>
                            </p>
                          
                        <script>
                        $('#signup .nav-tabs li:nth-child(0) a').tab('show');
                        $('#signup').modal('show');   
                        </script>
                        <?php
                         }
                         ?>
                        <form method="POST" action="{{ url('login') }}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="email" id="login-email">
                        </div>
                        <div class="form-group passField">
                            <span tabindex="0">Show</span>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="login-password">
                        </div>
                        
                        <button class="btn btn-success btn-block" type='submit'>Submit</button>
                    </form>
                    <form method="POST" action="{{ url('forgotpassword') }}">
                    {{csrf_field()}}

                        <div class="form-group">
                            <a href="#" class="pointer forgot-password" id="forgotpassword"> forgot Password ? </a>
                            </div>
                            <div class="form-group forgot-password-div" id="forgot_password_div" style="display:none;">
                                <input type="text" class="form-control" placeholder="Email" name="forgot-email" id="forgot-email">
                                <input type="submit" value="submit" class="btn btn-success btn-block">
                            </div>
                        </div>
                    </form>
                    <div id="becomeEditor" class="tab-pane fade">
                       
                    <?php
                        if(Session::has('signup_msg'))
                        {   ?>
                            <p class="text-success">
                                  <?php 
                           echo Session::get('signup_msg');
                           Session::pull('signup_msg');
                           ?>
                           </p>
                        <script>
                        $('#signup .nav-tabs li:nth-child(1) a').tab('show');
                        $('#signup').modal('show');   
                        </script>
                        <?php
                         }
                         ?>
                        <form method="POST" action="{{ route('custom.register') }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Id" required>
                            </div>
                            <!-- <div class="form-group">
                                <input type="text" class="form-control" name="fb_id" placeholder="Facebook ID">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="insta_id" id="" placeholder="Instagram ID">
                            </div> -->
                            <div class="form-group passField">
                                <span tabindex="0">Show</span>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                            </div>
                            <button class="btn btn-success btn-block" type='submit'>Submit</button>
                        </form>
                    </div>
                  </div>
            </div>
          </div>
      
        </div>
      </div>


@include('partials.footer')

<div class="modal fade" id="msg_modal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header alert-success">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Note</h4>
        </div>
        <div class="modal-body">
        <?php
            if(Session::has('test_status_msg'))
            {
                ?>
                <h4 class="text-success">
                        <?php 
                echo Session::get('test_status_msg');
                Session::pull('test_status_msg');
                ?>
                </h4>
                
            <script>
            $('#msg_modal').modal('show');   
            </script>
            <?php
                }
                ?>
        </div>
        
      </div>
    </div>
  </div>

</body>
</html>