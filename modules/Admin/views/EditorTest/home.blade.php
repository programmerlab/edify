
            <!-- END SIDEBAR -->
            <!-- BEGIN CONTENT -->
             <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                   @include('packages::partials.breadcrumb')

                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN EXAMPLE TABLE PORTLET-->
                            <div class="portlet light portlet-fit bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-red"></i>
                                        <span class="caption-subject font-red sbold uppercase">{{ $heading }}</span>
                                    </div>
                                     <div class="col-md-2 pull-right">
                                            <!-- <div style="width: 150px;" class="input-group"> 
                                                <a href="{{ route('editorPortfolio.create')}}">
                                                    <button class="btn btn-success"><i class="fa fa-plus-circle"></i> Add editorPortfolio</button> 
                                                </a>
                                            </div> -->
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
                                                <th> Sno. </th>
                                                <th> Editor </th>
                                                <th> Image 1 </th>
                                                <th> Image 2 </th> 
                                                <th> Image 3 </th> 
                                                <th>Created date</th> 
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1;?>
                                        @foreach($test_result as $key => $result)
                                            <tr>
                                                <td> <?php echo $i; ?> </td>
                                                <td> <?php echo $result->eid; ?> </td>
                                                <td><img src="{{ asset('storage/uploads/editor_test_imgs/'.$result->img1)}}" alt="" width="100px">
                                                    <?php if($result->img1_status == 'pending') {?>
                                                    <a href="changeteststatus?id=<?= $result->eid?>&flag=img1_status" class="btn btn-info">Approve</a> <?php } else { ?> <a class="btn btn-info" style="pointer-events: none;">Done</a>  <?php }  ?> 
                                                </td>
                                               
                                                <td><img src="{{ asset('storage/uploads/editor_test_imgs/'.$result->img2)}}" alt="" width="100px">
                                                <?php if($result->img2_status == 'pending') {?>
                                                <a href="changeteststatus?id=<?= $result->eid?>&flag=img2_status" class="btn btn-info">Approve</a>
                                                 <?php } else { ?> <a class="btn btn-info" style="pointer-events: none;">Done</a>  <?php }  ?> 
                                                </td>
                                                <td><img src="{{ asset('storage/uploads/editor_test_imgs/'.$result->img3)}}" alt="" width="100px">
                                                <?php if($result->img3_status == 'pending') {?>
                                                <a href="changeteststatus?id=<?= $result->eid?>&flag=img3_status" class="btn btn-info">Approve</a>
                                                <?php } else { ?> <a class="btn btn-info" style="pointer-events: none;">Done</a>  <?php }  ?> 
                                                </td>
                                                <td>
                                                        {!! Carbon\Carbon::parse($result->created_at)->format('d-m-Y'); !!}
                                                </td>
                                                    
                                                <!-- <td> 
                                                        <a href="{{ route('editorPortfolio.edit',$result->id)}}">
                                                            <i class="fa fa-edit" title="edit"></i> 
                                                        </a>

                                                        {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('editorPortfolio.destroy', $result->id))) !!}
                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                        
                                                         {!! Form::close() !!}

                                                    </td>
                                                -->
                                            </tr>
                                            <?php $i++; ?>

                                           @endforeach
                                        </tbody>
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
        