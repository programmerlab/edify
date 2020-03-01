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
                        <h2>The photo editor for every idea</h2>
                    </div>
                </div>
              </div>
              <div class="item">
                <div class="slide">
                    <div class="container">
                        <h2>everything you need for <br> online photo editing <br> we've got it covered</h2>
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    
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
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates sapiente obcaecati non, maxime recusandae officiis, tenetur fugit pariatur temporibus optio illum atque voluptate dolorum? Ad nemo eligendi illo temporibus enim?</p>
                        <h4>John Doe</h4>
                      </div>
                  </div>
              
                  <div class="item">
                    <div class="content">
                      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates sapiente obcaecati non, maxime recusandae officiis, tenetur fugit pariatur temporibus optio illum atque voluptate dolorum? Ad nemo eligendi illo temporibus enim?</p>
                      <h4>John Doe</h4>
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
                    <img src="assets/img/11.jpg" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/12.jpg" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/13.png" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/11.jpg" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/12.jpg" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/13.png" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/11.jpg" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/12.jpg" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/13.png" alt="">
                </div>
                <div class="items">
                    <img src="assets/img/12.jpg" alt="">
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
                    <?php
                        if(isset($msg))
                        { ?>
                        <script>
                        $('#signup .nav-tabs li:nth-child(0) a').tab('show');
                        $('#signup').modal('show');   
                        </script>
                        <?php
                        }
                    ?>
            
                  <div class="tab-content">
                    <div id="signin" class="tab-pane fade in active">
                    <?php
                        if(isset($msg))
                        {
                            echo $msg; 
                        }
                    ?>
                        <form method="POST" action="{{ url('login') }}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username" name="email" id="email">
                        </div>
                        <div class="form-group passField">
                            <span tabindex="0">Show</span>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                        </div>
                        <button class="btn btn-success btn-block" type='submit'>Submit</button>
                    </form>
                    </div>
                    <div id="becomeEditor" class="tab-pane fade">
                       
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

</body>
</html>