@extends('packages::layouts.master')
  @section('title', 'Test Images')
    @section('header')
    <h1>Test Images</h1>
    @stop
    @section('content') 
      @include('packages::partials.navigation')
      <!-- Left side column. contains the logo and sidebar -->
      @include('packages::partials.sidebar')
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
        
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">{{ $heading }}</span>
                                    </div>
                                     
                                </div>
                                  
                                    @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif
                                <div class="portlet-body">
                                    
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th> Sno </th>
                                                <th> Image </th>
                                                <th>Action</th> 
                                            </tr>

                                            <tbody>
                                            <?php $i = 1; ?>
                                            @foreach( $test_images as $images )
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><img src="{{ asset('storage/uploads/editor_test_imgs/'.$images->images)}}" alt="" width="100px"></td>
                                                <td> <i class="fa fa-edit" title="edit" data-toggle="modal" data-target="#myModal{{$images->id}}"></i>
                                                <div id="myModal{{$images->id}}" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Update Test Image</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                        <form action="{{ url('admin/test-images') }}" method="POST" role="form" enctype="multipart/form-data">
                                                        <input type="hidden" name="hidden_id" value="{{$images->id}}">
                                                            <div class="form-group">
                                                            <label for="myfile">Select a file:</label>
                                                            <input type="file" class="form-control" id="myfile" name="myfile">
                                                            </div>
                                                            
                                                            <input type="submit" value="submit" class="btn btn-primary">    
                                                        </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </div>

                                                    </div>
                                                    </div>
                                                </td>
                                                </tr>
                                                <?php $i++; ?>
                                                @endforeach
                                            </tbody>
                                        </thead>
                                        
                                    </table>
                                    
                                </div>
                            </div>
                            <!-- END EXAMPLE TABLE PORTLET-->
                        </div>
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            
            
            <!-- END QUICK SIDEBAR -->
        </div>
        @stop