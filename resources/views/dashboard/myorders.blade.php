<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
   <script src="assets/plugins_dashboard/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="assets/plugins_dashboard/bootstrap-select/css/bootstrap-select.min.css">
    <script src="assets/plugins_dashboard/bootstrap-select/js/bootstrap-select.min.js"></script>

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
                    <li role="presentation" class="active"><a href="#new" data-toggle="tab" aria-expanded="false">New orders(pending)</a></li>
                    
                    <li role="presentation" class=""><a href="#inprogress" data-toggle="tab" aria-expanded="true">In Progress</a></li>
                    <li role="presentation" class=""><a href="#completed" data-toggle="tab" aria-expanded="true">Completed</a></li>
                    <li role="presentation" class=""><a href="#rejected" data-toggle="tab" aria-expanded="true">Rejected</a></li>
                </ul>
                    <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade  active in" id="new">
                        <div class="orderWrapper">
                            <div class="orderUnit m-b-15">
                                <h3 class="orderDate">New Order</h3>
                                <div class="orderTimeList">             
                                @foreach($order as $result)
                                 @if( $result->editor_status != 1)
                                     <?php continue;  ?>
                                @endif
                                <div class="col-md-6" style="border: 3px solid #ccc;height: 325px;">
                                     
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Post Date : {!! Carbon\Carbon::parse($result->created_at)->format('d-m-Y'); !!}">View Post Date  
                                           </a> | 
                                     <a href="#" data-toggle="tooltip" data-placement="top" title="Last Update : {!! Carbon\Carbon::parse($result->updated_at)->format('d-m-Y'); !!}">View Last updated date  
                                           </a>
                                    <div class="col-xs-6   orderGrid">
                                        <div class="orderbg"> 
                                             <img src="{{$result->customer_original_image}}" onclick="getImgUrl('{{$result->customer_original_image}}')" width="100%" height="300px">  
                                        </div>
                                        <div class="orderDetails">
                                           
                                
                                            <span class="imgId">{{$result->id}}</span>
                                            <span class="ono" >Order ID : {{$result->order_id}}</span>
                                            <span class="ocustomer">Notes : </span>
                                            <span class="odesc">  {{$result->order_details}}</span>
                                            <span class="oimg">{{$result->customer_reference_image}}</span>
                                        </div> 
                                        <div class=" col-md-12">
                                           
                                        </div> 
                                         <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
                                    </div> 
                                    <div class="col-xs-6   orderGrid" style="padding: 5px">
                                       <div class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal" data-img="{{$result->customer_original_image}}"
                                       data-title="Origin Image" 
                                        > <span class="glyphicon glyphicon-ok"></span> View Origin Image </div>

                                       <p class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal"
                                       data-img="{{$result->customer_reference_image}}"
                                       data-title="Reference Image" 
                                        > 
                                        <span class="glyphicon glyphicon-ok"  
                                        ></span> View Reference Image </p> 
                                       <p 
                                        class="btn btn-info col-md-12 showImage" 
                                        data-toggle="modal" data-target="#originModal"
                                        data-img="{{$result->editor_after_work_image}}"
                                        data-title="Edited Image" 
                                       > 
                                       <span class="glyphicon glyphicon-ok" ></span> View Edited  Image </p> 
                                        <div class="form-line" id="editor_status" >
                                            
                                            <input type="hidden" id="imgId2" name="imgId2" value="{{$result->id}}">

                                            <select name="editor_status" id="sw" class="form-control" onchange="changeStatus(this,{{$result->id}})" >
                                                    <option>Update Status</option>
                                                    <option value="1" @if($result->editor_status==1) selected @endif >Pending</option>
                                                    <option value="2" @if($result->editor_status==2) selected @endif>In Progress</option>
                                                    <option value="3" @if($result->editor_status==4) selected @endif>Completed</option>
                                                </select> 
                                        </div>
                                        <p class="btn btn-success col-md-12">
                                            Customer Notes :
                                        </p>
                                        <div class="btn-info" style="padding: 5px"> <span class="glyphicon glyphicon-ok"></span> 
                                         <?php echo substr($result->order_details, 0,60).'...';
                                        ?>   
                                        </div>
                                        <p style="padding: 10px">

                                        To Upload Click on Image<hr></p>
                                    </div>
                                </div>
                                    @endforeach        
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Rejected order -->

                      <div role="tabpanel" class="tab-pane fade" id="rejected">
                        <div class="orderWrapper">
                            <div class="orderUnit m-b-15">
                                <h3 class="orderDate">Rejected</h3>
                                <div class="orderTimeList">             
                                @foreach($order as $result)
                                @if( $result->editor_status != 4)
                                     <?php continue;  ?>
                                @endif
                                <div class="col-md-6" style="border: 3px solid #ccc;height: 325px;">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Post Date : {!! Carbon\Carbon::parse($result->created_at)->format('d-m-Y'); !!}">View Post Date  
                                           </a> | 
                                     <a href="#" data-toggle="tooltip" data-placement="top" title="Last Update : {!! Carbon\Carbon::parse($result->updated_at)->format('d-m-Y'); !!}">View Last update date 
                                           </a>


                                    <div class="col-xs-6   orderGrid">
                                        <div class="orderbg"> 
                                             <img src="{{$result->customer_original_image}}" onclick="getImgUrl('{{$result->customer_original_image}}')" width="100%" height="300px">  
                                        </div>
                                        <div class="orderDetails">
                                            <span class="imgId">{{$result->id}}</span>
                                            <span class="ono" >Order ID : {{$result->order_id}}</span>
                                            <span class="ocustomer">Notes : </span>
                                            <span class="odesc">  {{$result->order_details}}</span>
                                            <span class="oimg">{{$result->customer_reference_image}}</span>
                                        </div> 
                                        <div class=" col-md-12">
                                           
                                        </div> 
                                         <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
                                    </div> 
                                    <div class="col-xs-6   orderGrid" style="padding: 5px">
                                       <div class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal" data-img="{{$result->customer_original_image}}"
                                       data-title="Origin Image" 
                                        > <span class="glyphicon glyphicon-ok"></span> View Origin Image </div>

                                       <p class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal"
                                       data-img="{{$result->customer_reference_image}}"
                                       data-title="Reference Image" 
                                        > 
                                        <span class="glyphicon glyphicon-ok"  
                                        ></span> View Reference Image </p> 
                                       <p 
                                        class="btn btn-info col-md-12 showImage" 
                                        data-toggle="modal" data-target="#originModal"
                                        data-img="{{$result->editor_after_work_image}}"
                                        data-title="Edited Image" 
                                       > 
                                       <span class="glyphicon glyphicon-ok" ></span> View Edited  Image </p> 
                                        <div class="form-line" id="editor_status" >
                                             

                                            <select name="editor_status" id="editor_status_inprogress" class="form-control"
                                            onchange="changeStatus(this,{{$result->id}})"
                                             >
                                                    <option>Update Status</option>
                                                    <option value="1" @if($result->editor_status==1) selected @endif >Pending</option>
                                                    <option value="2" @if($result->editor_status==2) selected @endif>In Progress</option>
                                                    <option value="3" @if($result->editor_status==4) selected @endif>Completed</option>
                                                </select> 
                                        </div>
                                        <p class="btn btn-success col-md-12">
                                            Customer Notes :
                                        </p>
                                        <div class="btn-info" style="padding: 5px"> <span class="glyphicon glyphicon-ok"></span> 
                                         <?php echo substr($result->order_details, 0,60).'...';
                                        ?>   
                                        </div>
                                        <p style="padding: 10px">

                                        To Upload Click on Image<hr></p>
                                    </div>
                                </div>
                                    @endforeach        
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- In progress Order-->

                      <div role="tabpanel" class="tab-pane fade" id="inprogress">
                        <div class="orderWrapper">
                            <div class="orderUnit m-b-15">
                                <h3 class="orderDate">In Progress</h3>
                                <div class="orderTimeList">             
                                @foreach($order as $result)
                                @if( $result->editor_status != 2)
                                     <?php continue;  ?>
                                @endif
                                <div class="col-md-6" style="border: 3px solid #ccc;height: 325px;">
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Post Date : {!! Carbon\Carbon::parse($result->created_at)->format('d-m-Y'); !!}">View Post Date  
                                           </a> | 
                                     <a href="#" data-toggle="tooltip" data-placement="top" title="Last Update : {!! Carbon\Carbon::parse($result->updated_at)->format('d-m-Y'); !!}">View Last update date 
                                           </a>


                                    <div class="col-xs-6   orderGrid">
                                        <div class="orderbg"> 
                                             <img src="{{$result->customer_original_image}}" onclick="getImgUrl('{{$result->customer_original_image}}')" width="100%" height="300px">  
                                        </div>
                                        <div class="orderDetails">
                                            <span class="imgId">{{$result->id}}</span>
                                            <span class="ono" >Order ID : {{$result->order_id}}</span>
                                            <span class="ocustomer">Notes : </span>
                                            <span class="odesc">  {{$result->order_details}}</span>
                                            <span class="oimg">{{$result->customer_reference_image}}</span>
                                        </div> 
                                        <div class=" col-md-12">
                                           
                                        </div> 
                                         <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
                                    </div> 
                                    <div class="col-xs-6   orderGrid" style="padding: 5px">
                                       <div class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal" data-img="{{$result->customer_original_image}}"
                                       data-title="Origin Image" 
                                        > <span class="glyphicon glyphicon-ok"></span> View Origin Image </div>

                                       <p class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal"
                                       data-img="{{$result->customer_reference_image}}"
                                       data-title="Reference Image" 
                                        > 
                                        <span class="glyphicon glyphicon-ok"  
                                        ></span> View Reference Image </p> 
                                       <p 
                                        class="btn btn-info col-md-12 showImage" 
                                        data-toggle="modal" data-target="#originModal"
                                        data-img="{{$result->editor_after_work_image}}"
                                        data-title="Edited Image" 
                                       > 
                                       <span class="glyphicon glyphicon-ok" ></span> View Edited  Image </p> 
                                        <div class="form-line" >
                                                <select name="editor_status" id="sw" class="form-control" onchange="changeStatus(this,{{$result->id}})">
                                                    <option>Update Status</option>
                                                    <option value="1" @if($result->editor_status==1) selected @endif >Pending</option>
                                                    <option value="2" @if($result->editor_status==2) selected @endif>In Progress</option>
                                                    <option value="3" @if($result->editor_status==4) selected @endif>Completed</option>
                                                </select> 
                                            </div>
                                        <p class="btn btn-success col-md-12">
                                            Customer Notes :
                                        </p>
                                        <div class="btn-info" style="padding: 5px"> <span class="glyphicon glyphicon-ok"></span> 
                                         <?php echo substr($result->order_details, 0,60).'...';
                                        ?>   
                                        </div>
                                        <p style="padding: 10px">

                                        To Upload Click on Image<hr></p>
                                    </div>
                                </div>
                                    @endforeach        
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- compled order -->

                    <div role="tabpanel" class="tab-pane fade" id="completed">
                        <div class="orderWrapper">
                            <div class="orderUnit m-b-15">
                                <h3 class="orderDate">Completed</h3>
                                <div class="orderTimeList">             
                                @foreach($order as $result) 
                                 @if( $result->editor_status != 3)
                                     <?php continue;  ?>
                                @endif
                                <div class="col-md-6" style="border: 2px solid #ccc;height: 325px; margin: 1px">

                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Post Date : {!! Carbon\Carbon::parse($result->created_at)->format('d-m-Y'); !!}">View Post Date  
                                           </a> | 
                                     <a href="#" data-toggle="tooltip" data-placement="top" title="Last Update : {!! Carbon\Carbon::parse($result->updated_at)->format('d-m-Y'); !!}">View Last updated date  
                                           </a>
                                   

                                    <div class="col-xs-6   orderGrid">
                                        <div class="orderbg"> 
                                             <img src="{{$result->customer_original_image}}" onclick="getImgUrl('{{$result->customer_original_image}}')" width="100%" height="300px">  
                                        </div>
                                        <div class="orderDetails">
                                            <span class="imgId">{{$result->id}}</span>
                                            <span class="ono" >Order ID : {{$result->order_id}}</span>
                                            <span class="ocustomer">Notes : </span>
                                            <span class="odesc">  {{$result->order_details}}</span>
                                            <span class="oimg">{{$result->customer_reference_image}}</span>
                                        </div> 
                                        <div class=" col-md-12">
                                           
                                        </div> 
                                         <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
                                    </div> 
                                    <div class="col-xs-6   orderGrid" style="padding: 5px">
                                       <div class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal" data-img="{{$result->customer_original_image}}"
                                       data-title="Origin Image" 
                                        > <span class="glyphicon glyphicon-ok"></span> View Origin Image </div>

                                       <p class="btn btn-info col-md-12 showImage" data-toggle="modal" data-target="#originModal"
                                       data-img="{{$result->customer_reference_image}}"
                                       data-title="Reference Image" 
                                        > 
                                        <span class="glyphicon glyphicon-ok"  
                                        ></span> View Reference Image </p> 
                                       <p 
                                        class="btn btn-info col-md-12 showImage" 
                                        data-toggle="modal" data-target="#originModal"
                                        data-img="{{$result->editor_after_work_image}}"
                                        data-title="Edited Image" 
                                       > 
                                       <span class="glyphicon glyphicon-ok" ></span> View Edited  Image </p> 
                                        <div class="form-line" >
                                                <select name="editor_status" id="sw" class="form-control" onchange="changeStatus(this,{{$result->id}})" disabled="">
                                                    <option>Update Status</option>
                                                    <option value="1" @if($result->editor_status==1) selected @endif >Pending</option>
                                                    <option value="2" @if($result->editor_status==2) selected @endif>In Progress</option>
                                                    <option value="3" @if($result->editor_status==3) selected @endif>Completed</option>
                                                    <option value="4" @if($result->editor_status==4) selected @endif>Rejected</option>
                                                </select> 
                                            </div>
                                        <p class="btn btn-success col-md-12">
                                            Customer Notes :
                                        </p>
                                        <div class="btn-info" style="padding: 5px"> <span class="glyphicon glyphicon-ok"></span> 
                                         <?php echo substr($result->order_details, 0,60).'...';
                                        ?>   
                                        </div>
                                        <p style="padding: 10px">

                                        To Upload Click on Image<hr></p>
                                    </div>
                                </div>
                                    @endforeach        
                                </div>
                            </div>

                        </div>
                    </div>
                        
                    </div>
                </div>
        </div>
    </div>
</section>
<div class="modal fade " id="orderDetails" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
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
                                    <img src="" width="100%"  height="400px" id="orginal_img" alt="Original Image" id="origin_img"  />
                                </div>
                                <div class="item">
                                    <img class="oimg" height="400px" width="100%" src="#" alt="Reference Image" id="ref_img" />
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
                                        <a href="#" target="_blank" class="btn bg-deep-orange download origin_img" download="download" data-toggle="tooltip" title="Download Original Image" 
                                        
                                        >Original Image</a> 
                                         <a href="#" target="_blank" class="btn bg-deep-orange download ref_img" download="download" data-toggle="tooltip" title="Download Reference Image">Reference Image</a> 
                                    </div>
                                    <div class="col-xs-12">
                                        <hr>
                                        <form action="{{url('uploadEditedImage')}}" method="POST" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <input type="hidden" name="image_id" value="" id="img_id"> 
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="orderFile">Edited file</label>
                                                    <input type="file" id="orderFile" class="form-control" placeholder="Choose File" name="editedImage">
                                                </div>
                                            </div>
                                            <div class="form-group m-t-20">
                                                <div class="form-line">
                                                    <select name="editor_status" id="sw" class="form-control" >
                                                        <option >Update Status</option>
                                                        <option value="2">In Progress</option>
                                                        <option value="3">Completed</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <label for="cmt">Editor's Comment</label>
                                                    <textarea  name="editor_remarks" id="cmt" class="form-control" placeholder="remark"></textarea>
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

<!-- Modal -->
<div id="originModal" class="modal fade bd-example-modal-xl" role="dialog">
  <div class="modal-dialog modal-lg"> 
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modal-title">Image</h4>
      </div>
      <div class="modal-body">
         <img src="" width="100%" id="showImage">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 
 
@include('dashboard.partials.footer_links')
    
<script>
    var url = "<?php echo url('/'); ?>";
    function getImgUrl(imgUrl){
            $('#orginal_img').attr('src',imgUrl);
            $('.origin_img').attr('href',imgUrl);

          
    }

    function changeStatus(status,imgId){
     
       window.location.replace(url+'/changeOrderStatus?image_id='+imgId+'&status='+status.value ); 
    }
    

    $(document).ready(function(){ 

        $('[data-toggle="popover"]').popover();   
        $('[data-toggle="tooltip"]').tooltip();

        $('.showImage').on('click',function(){ 

          var img =  $(this).attr('data-img'); 
          var title =  $(this).attr('data-title'); 
          $('#showImage').attr('src',img); 
          

          if(img.length==0){
            title = '<p class="btn-warning">Edited Image not Available!.Kindly Upload.</p>';
          }
          $('#modal-title').html(title);
        });
        
        $(".orderbg").on('click',function(){ 
            var orderNo = $(this).parent().find('.ono').text();
            var customer = $(this).parent().find('.ocustomer').text();
            var desc = $(this).parent().find('.odesc').text();
            var editmg = $(this).parent().find('.oimg').text();
            var imgId =  $(this).parent().find('.imgId').text();
            $("input#img_id").val(imgId);
            $("#orderDetails .oNo").text(orderNo);
            $("#orderDetails .oCustomer").text(customer);
            $("#orderDetails .oDesc").text(desc);
            $("#orderDetails .oimg").attr('src',editmg);
        

              $('.ref_img').attr('href',$('#ref_img').attr('src'));


            if($(this).hasClass('completed')){
                $("#orderDetails form").hide()
            }
            else{
                
                $("#orderDetails form").show()
            }
            $("#orderDetails").modal('show');
        })
    })

    forceDownload();
    function forceDownload( ){
         url = "https://edifyartist.com/storage/uploads/1585401153images%20(1).jpeg";
         fileName = "kroy.jpg";
        var xhr = new XMLHttpRequest();
        xhr.open("GET", url, true);
        xhr.responseType = "blob";
        xhr.onload = function(){
            var urlCreator = window.URL || window.webkitURL;
            var imageUrl = urlCreator.createObjectURL(this.response);
            var tag = document.createElement('a');
            tag.href = imageUrl;
            tag.download = fileName;
            document.body.appendChild(tag);
            tag.click();
            document.body.removeChild(tag);
        }
        xhr.send();
}
</script>
</body>

</html>
