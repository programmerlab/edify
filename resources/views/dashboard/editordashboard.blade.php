<!DOCTYPE html>
<html>

@include('dashboard.partials.head')

<body class="theme-edify1">

@include('dashboard.partials.header')

<section>

@include('dashboard.partials.sidebar')

</section>

<section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="header">
                    <h2>Edify Analytics Area</h2>
                </div>
                <div class="body">
                    <div class="alert @if($editor_aproved) alert-success @else alert-danger @endif" >
                     @if($check_status->img1_status==0)
                        Your profile is Waiting for approval
                     @elseif($check_status->img2_status==0)
                        Your profile is Waiting for approval
                     @elseif($check_status->img3_status==0)
                        Your profile is Waiting for approval
                     @else
                         Congratulation! Your profile has been approved.  
                     @endif
                 </div>

                </div>
            </div>

        </div>
</section>

    <script src="assets/plugins_dashboard/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="assets/plugins_dashboard/bootstrap/js/bootstrap.js"></script>

<!-- Select Plugin Js -->
<script src="assets/plugins_dashboard/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="assets/plugins_dashboard/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="assets/plugins_dashboard/node-waves/waves.js"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="assets/plugins_dashboard/jquery-countto/jquery.countTo.js"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="assets/plugins_dashboard/jquery-sparkline/jquery.sparkline.js"></script>

<!-- Custom Js -->
<script src="assets/js_dashboard/admin.js"></script>
<!-- <script src="js/pages/index.js"></script> -->

<!-- Demo Js -->
<script src="assets/js_dashboard/demo.js"></script>
</body>

</html>
