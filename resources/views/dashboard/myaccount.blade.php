<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<style>
        #certificate{
            overflow: auto;
        }
        .certificate{
            background: url(assets/images_dashboard/certificate.jpg) no-repeat 0 0 / 100%;
    width: 650px;
    height: 465px;
    padding: 215px 80px 60px;
    margin: 0 auto;
    box-shadow: 0px 0px 35px -15px #551515;
    position: relative;
    text-align: center;
        }
        .certiName{
            display: block;
            position: relative;
            font-size: 42px;
            color: #551515;
            font-weight: bold;
            font-family: monospace;
            text-transform: uppercase;
        }
        .certificate img{

            position: absolute;
    max-width: 70px;
    bottom: 80px;
    right: 85px;
        }
    </style>
<body class="theme-edify1">

@include('dashboard.partials.header')

<section>

@include('dashboard.partials.sidebar')

</section>

<section class="content">
        <div class="container-fluid">

        <div class="card">
                <div class="header">
                    <h2>Account Details</h2>
                </div>
                <div class="body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active"><a href="#edit" data-toggle="tab" aria-expanded="false">Edit Account Details</a></li>
                        <li role="presentation" class=""><a href="#certificate" data-toggle="tab" aria-expanded="true">Certificate</a></li>
                        <li role="presentation" class=""><a href="#followers" data-toggle="tab" aria-expanded="true">Followers</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="edit">
                            <div class="container-fluid m-t-15 p-l-20 p-r-20">
                                <form action="#">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="name" class="form-control">
                                            <label class="form-label">Name</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="email_address" class="form-control">
                                            <label class="form-label">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="aadhar" class="form-control">
                                            <label class="form-label">Aadhar</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="pan" class="form-control">
                                            <label class="form-label">PAN</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="mob" class="form-control">
                                            <label class="form-label">Mobile</label>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary m-t-15 waves-effect">Save</button>
                                </form>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="certificate">
                            <div class="certificate">
                                <span class="certiName">Mr Editor</span> after verification of his works under our review team. <img src="assets/images_dashbaord/logo.png" />
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="followers">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box-3 bg-indigo">
                                        <div class="icon">
                                            <i class="material-icons">face</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">Followers</div>
                                            <div class="number">257</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box-3 bg-deep-purple">
                                        <div class="icon">
                                            <i class="material-icons">favorite</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">LIKES</div>
                                            <div class="number">125</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
</section>

@include('dashboard.partials.footer_links')
</body>

</html>
