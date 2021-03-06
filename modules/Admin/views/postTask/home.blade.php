
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
                                        <span class="caption-subject font-red sbold uppercase">All Orders</span>
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
                                    <div class="table-toolbar">
                                        <div class="row">
                                            <form action="{{route('postTask')}}" method="get" id="filter_data">
                                             
                                            <div class="col-md-3">
                                                 <select name="search" class="form-control">
                                                     <option>Select Status
                                                     </option>
                                                     <option value="1">
                                                         Pending
                                                     </option>
                                                     <option value="2">
                                                         In Progress
                                                     </option>
                                                     <option value="3">
                                                         Completed
                                                     </option>
                                                     <option value="4">
                                                         Rejected
                                                     </option>
                                                 </select>
                                            </div>
                                             <div class="col-md-3">
                                                {!! Form::text('taskdate',null, ['id'=>'taskdate','class' => 'form-control taskdate','data-required'=>1,"size"=>"16","data-date-format"=>"yyyy-mm-dd","placeholder"=>'Task post date'])  !!} 
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" value="Search" class="btn btn-primary form-control">
                                            </div>
                                           
                                        </form>
                                         <div class="col-md-2">
                                             <a href="{{ route('postTask') }}">   <input type="submit" value="Reset" class="btn btn-default form-control"> </a>
                                        </div>
                                       
                                        </div>
                                    </div>
                                     
                                    <table class="table table-striped table-hover table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th> Sno</th>
                                                <th> Customer</th>
                                                <th> Editor </th>  
                                                <th>Status</th> 
                                                <th>Total Price</th> 
                                                 <th>Order Id</th> 
                                                <th>Original Pic</th> 
                                                <th>Ref Pic</th>
                                                <th>Edited Pic</th>
                                                <th>Last Modified</th>  
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
 
                                        @foreach($postTasks as $key => $result)
                                            @if(!isset($result->editor))
                                             <?php continue; ?>
                                            @endif
                                            <tr>
                                            <td> {{ (($postTasks->currentpage()-1)*15)+(++$key) }}</td>
                                           
                                                <td>{{ $result->user->first_name??null.' '.$result->user->last_name??null}}</td>
                                    					            
                                                <td>{{ $result->editor->first_name??null.' '.$result->editor->last_name??null}}
                                                </td>
                                                <td>
                                                    @if($result->status==1)
                                                    <span class=" btn alert-warning"> Pending
                                                    </span>    
                                                    @elseif($result->status==2)
                                                    <span class="btn  alert-info"> In Progress
                                                    </span> 
                                                    @elseif($result->status==3)
                                                    <span class="  alert-success"> Completed
                                                    </span> 
                                                    @elseif($result->status==4)
                                                    <span class="  alert-danger"> Rejected
                                                    </span> 
                                                    @endif
                                                </td>
                                                

                                                <td>{{ $result->total_price}} INR</td>
                                                <td><a href="{{route('postTask.show',$result->id)}}">
                                                    {{ $result->order_id}} </a></td>
                                                
                                                <td><a href="{{url($result->customer_original_image)}}"> View  </a></td>

                                                <td><a href="{{url($result->customer_reference_image)}}"> View  </a></td>
                                                 <td><a href="{{url($result->editor_after_work_image)}}"> View  </a></td>

                                                <td>{{ $result->updated_at}}</td>
                                                <td> 
                                                    {!! Form::open(array('class' => 'form-inline pull-left deletion-form', 'method' => 'DELETE',  'id'=>'deleteForm_'.$result->id, 'route' => array('postTask.destroy', $result->id))) !!}
                                                        <button class='delbtn btn btn-danger btn-xs' type="submit" name="remove_levels" value="delete" id="{{$result->id}}"><i class="fa fa-fw fa-trash" title="Delete"></i></button>
                                                    {!! Form::close() !!} 
                                                </td> 
                                            </tr>
                                           @endforeach 
                                        </tbody>
                                    </table>
                                    
Showing {{($postTasks->currentpage()-1)*$postTasks->perpage()+1}} to {{$postTasks->currentpage()*$postTasks->perpage()}}
    of  {{$postTasks->total()}} entries
                                     <div  class="center" align="center"> 
                                        
                                       {!! $postTasks->appends(['search' => isset($_GET['search'])?$_GET['search']:''])->render() !!}</div>
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
        
