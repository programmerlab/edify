<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<style>
        .orderUnit{
            overflow: hidden;
        }
        .orderDate{
            text-transform: capitalize;
        }
        .orderGrid{
            cursor: pointer;
            position: relative;
            min-height: 180px;
        }
        .orderbg{
            position: absolute;
            top: 10px;
            left: 10px;
            width: calc(100% - 20px);
            height: calc(100% - 20px);
            background-position: center;
            background-size: cover;
            border-radius: 4px;
            box-shadow: 0px 2px 8px -1px #bcbcbc;
        }
        .orderDetails{
            display: none;
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
                    <h2>My Orders</h2>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class=""><a href="#new" data-toggle="tab" aria-expanded="false">New orders(pending)</a></li>
                        <li role="presentation" class="active"><a href="#completed" data-toggle="tab" aria-expanded="true">Completed</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="new">
                            <div class="orderWrapper">
                                <div class="orderUnit m-b-15">
                                    <h3 class="orderDate">today</h3>
                                    <div class="orderTimeList">
                                        <div class="col-xs-6 col-sm-3 col-lg-2 orderGrid">
                                            <div class="orderbg" style="background-image: url(https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg);"></div>
                                            <div class="orderDetails">
                                                <span class="ono">123456</span>
                                                <span class="ocustomer">John doe</span>
                                                <span class="odesc">retouch image</span>
                                                <span class="oimg">https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-lg-2 orderGrid">
                                            <div class="orderbg" style="background-image: url(https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg);"></div>
                                            <div class="orderDetails">
                                                <span class="ono">123456</span>
                                                <span class="ocustomer">John doe</span>
                                                <span class="odesc">retouch image</span>
                                                <span class="oimg">https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="orderUnit m-b-15">
                                    <h3 class="orderDate">today</h3>
                                    <div class="orderTimeList">
                                        <div class="col-xs-6 col-sm-3 col-lg-2 orderGrid">
                                            <div class="orderbg" style="background-image: url(https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg);"></div>
                                            <div class="orderDetails">
                                                <span class="ono">123456</span>
                                                <span class="ocustomer">John doe</span>
                                                <span class="odesc">retouch image</span>
                                                <span class="oimg">https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-lg-2 orderGrid">
                                            <div class="orderbg" style="background-image: url(https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg);"></div>
                                            <div class="orderDetails">
                                                <span class="ono">123456</span>
                                                <span class="ocustomer">John doe</span>
                                                <span class="odesc">retouch image</span>
                                                <span class="oimg">https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade active in" id="completed">
                            <div class="orderWrapper">
                                <div class="orderUnit m-b-15">
                                    <h3 class="orderDate">today</h3>
                                    <div class="orderTimeList">
                                        <div class="col-xs-6 col-sm-3 col-lg-2 orderGrid">
                                            <div class="orderbg completed" style="background-image: url(https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg);"></div>
                                            <div class="orderDetails">
                                                <span class="ono">123456</span>
                                                <span class="ocustomer">John doe</span>
                                                <span class="odesc">retouch image</span>
                                                <span class="oimg">https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg</span>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-lg-2 orderGrid">
                                            <div class="orderbg completed" style="background-image: url(https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg);"></div>
                                            <div class="orderDetails">
                                                <span class="ono">123456</span>
                                                <span class="ocustomer">John doe</span>
                                                <span class="odesc">retouch image</span>
                                                <span class="oimg">https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg</span>
                                            </div>
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
<div class="modal fade" id="orderDetails" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                    <h4 class="p-t-15 p-l-15 p-r-15 p-b-15 bg-deep-orange">ORDER <label class="label oNo pull-right"></label></h4>
                    <div class="modal-body p-l-5 p-r-5 p-t-5">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <img src="https://miro.medium.com/max/1200/1*mk1-6aYaf_Bes1E3Imhc0A.jpeg" />
                                </div>
                                <div class="item">
                                    <img class="oimg" src="#" />
                                </div>
                            </div>

                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <div class="m-t-5">
                            <div class="p-t-5 p-l-5 p-r-5 p-b-5">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6">
                                        <h4 class="m-t-0 m-b-0">Order Details</h4>
                                        <hr class="m-t-5 m-b-10">
                                        <h4><label class="label bg-deep-purple">User - <span class="oCustomer" ></span></label>
                                        </h4>
                                    <p class="oDesc"></p></div>
                                    <div class="col-xs-12 col-sm-6 text-right">
                                        <h4 class="m-t-0 m-b-0">Downloads</h4>
                                        <hr class="m-t-5 m-b-10">
                                        <a href="#" class="btn bg-deep-orange">download</a>
                                    </div>
                                    <div class="col-xs-12">
                                        <hr>
                                        <form action="#">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="orderFile">Edited file</label>
                                                    <input type="file" id="orderFile" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="cmt">Editor's Comment</label>
                                                    <textarea id="cmt" class="form-control" placeholder="remark"></textarea>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-block bg-deep-orange">Update Order</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@include('dashboard.partials.footer_links')
    
<script>
    $(document).ready(function(){
        $(".orderbg").on('click',function(){
            var orderNo = $(this).parent().find('.ono').text();
            var customer = $(this).parent().find('.ocustomer').text();
            var desc = $(this).parent().find('.odesc').text();
            var editmg = $(this).parent().find('.oimg').text();
            $("#orderDetails .oNo").text(orderNo);
            $("#orderDetails .oCustomer").text(customer);
            $("#orderDetails .oDesc").text(desc);
            $("#orderDetails .oimg").attr('src',editmg);
            if($(this).hasClass('completed')){
                $("#orderDetails form").hide()
            }
            else{
                
                $("#orderDetails form").show()
            }
            $("#orderDetails").modal('show');
        })
    })
</script>
</body>

</html>
