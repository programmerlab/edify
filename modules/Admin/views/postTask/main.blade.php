@extends('packages::layouts.master')
  @section('title', 'Dashboard')
    @section('header')
    <h1>Dashboard</h1>
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
<!-- BEGIN PAGE BREADCRUMB -->
    @include('packages::partials.breadcrumb') 
    <!-- END PAGE BREADCRUMB -->
    <!-- BEGIN PAGE BASE CONTENT -->
    <div class="row">
      <div class="col-md-12">  
        <div class="todo-content">
          <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
              <div class="col-md-6">
                 <div class="todo-taskbody-user">
                      <div class="col-md-3"> @if(!empty($postTasks->editor->profile_image))
                       <img src="{{$postTasks->editor->profile_image}}" width="80%" alt="">
                      @else
                       <img src="{{url('storage/image/poster-big.png')}}" alt="">
                      @endif
                      <h4>{!! $postTasks->editor->first_name  !!} {!! $postTasks->editor->last_name  !!}

                    </div>
                      
                      <div class="col-md-8">
                       
                      <p>Email : {{$postTasks->editor->email}} <br>
                        Post Date : <b>{{$taskPostDate}}</b> <br> 
                      
                         Status  <a href="javascript:;">
                     <span class="badge badge-info"> 
                    @if($postTasks->status==1)
                     Pending
                    @elseif($postTasks->status==2)
                    In progress
                    @elseif($postTasks->status==3)
                    Completed
                    @elseif($postTasks->status==4)
                    Rejected
                    @endif

                      </span> </a>
                      <a href="{{URL::previous() }}" class="btn">Go back</a>
                    </p>
                    </div>

                      
                  </div>
              </div>

              <ul class="nav nav-tabs" style="margin-top: 50px">
                 
                <li class="active">
                    <a href="#tab_1_1" data-toggle="tab" aria-expanded="true">Order Details</a>
                </li>
                <li class="">
                    <a href="#tab_1_2" data-toggle="tab" aria-expanded="false">Customer Details</a>
                </li>
                <li class="">
                    <a href="#tab_1_3" data-toggle="tab" aria-expanded="false">Editors Details</a>
                </li>
                 
                <li>
                    <a href="#comment" data-toggle="tab"> Comments</a>
                </li>
                <li>
                    <a href="#remarks" data-toggle="tab"> Remarks</a>
                </li>
              </ul>
            </div>
            
            <div class="portlet-body">
              <div class="tab-content"> 
                <div class="tab-pane active" id="tab_1_1"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Orders Details
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                      @if(isset($postTasks) and ($postTasks->count())>0)
                      <table class="table table-striped table-hover table-bordered" id="">
                           
                          <thead>
                             @foreach($table_cname as $key => $result)
                             <tr>
                             @if($result=="id" || $result=='updated_at')
                             <?php continue; ?>
                              @elseif($result == 'customer_original_image') 
                              <th>{{ ucfirst(str_replace('_',' ',Str::snake($result))) }}</th>
                              <th>
                              <a href="{{$postTasks->customer_original_image}}" target="_blank"> View Original Image </a>
                              </th>

                              @elseif($result == 'customer_reference_image') 
                              <th>{{ ucfirst(str_replace('_',' ',Str::snake($result))) }}</th>
                              <th>
                              <a href="{{$postTasks->customer_reference_image}}" target="_blank"> View Reference Image </a>
                              </th>

                              @elseif($result == 'editor_after_work_image') 
                              <th>{{ ucfirst(str_replace('_',' ',Str::snake($result))) }}</th>
                              <th>
                              <a href="{{$postTasks->editor_after_work_image}}" target="_blank"> 
                                @if($postTasks->editor_after_work_image)
                                   View Edited Image 
                                @else
                                  Image not uploaded by Editor
                                @endif
                             </a>
                              </th>


                              @elseif($result=='user_id')
                                  <th>Customer Name </th>
                                  <th> {{ $postTasks->user->first_name}}  {{ $postTasks->user->last_name}} </th>
                              @elseif($result=='editor_id')
                                  <th>Editor Name </th>
                                  <th> {{ $postTasks->editor->first_name}} 
                                      {{ $postTasks->editor->last_name}}
                                  </th>
                              @elseif($result=='editor_status' && $postTasks->editor_status==1)
                                <th >Status From Editor </th>
                                <th class="alert alert-warning">Pending</th>
                              @elseif($result=='editor_status' && $postTasks->editor_status==2)
                                <th>Status From Editor </th>
                                <th class="alert alert-info">In Progress</th>
                              @elseif($result=='editor_status' && $postTasks->editor_status==3)
                                <th>Status From Editor </th>
                                <th class="alert alert-success">Completed</th>
                              @elseif($result=='editor_status' && $postTasks->editor_status==4)
                                <th>Status From Editor </th>
                                <th class="alert alert-danger">Rejected</th>
                              @elseif($result=='status')
                                <th>Actual Work Status </th>
                                @if($postTasks->status==1)
                                <th class="alert alert-danger"> 
                                  Pending
                                </th>
                                @elseif($postTasks->status==2)
                                <th class="alert alert-warning"> 
                                  Rejected
                                </th>
                                @elseif($postTasks->status==3)
                                <th class="alert alert-success"> 
                                  Completed
                                </th>
                                @endif
                              @else 
                                  <th>{{ ucfirst(str_replace('_',' ',Str::snake($result))) }}</th>
                                  <th>{{ $postTasks->$result}}
                                    @if($result=='total_price' ||
                                        $result=='discount_price')
                                      {!! $currency->field_value ?? 'INR' !!}
                                    @endif  
                                   </th>
                              @endif  
                              </tr>
                            @endforeach
                          </thead>  
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div> 
                <div class="tab-pane " id="tab_1_2"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Customer details
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                            @if(isset($posterUser))
                      <table class="table table-striped table-hover table-bordered" id="">
                          <thead> 
                             @foreach($posterUser as $key => $result)
                             <tr>
                             @if($key=="id" || $key=='updated_at')
                             <?php continue; ?>
                             @elseif($key == 'profile_image') 
                              <th>{{ ucfirst(str_replace('_',' ',Str::snake($key))) }}</th>
                              <th>
                              <a href="{{$result}}" target="_blank"> view Profile Image </a>
                              </th>
                             @else 
                               <th>{{ ucfirst(str_replace('_',' ',Str::snake($key))) }}</th>
                                  <th>{{ $result}} </th>
                              </tr>
                             @endif
                              @endforeach
                          </thead> 
                         
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div>
                <div class="tab-pane " id="tab_1_3"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Editors Details
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                            @if(isset($doer))
                      <table class="table table-striped table-hover table-bordered" id="">
                           <thead> 
                             @foreach($doer as $key => $result)
                             <tr>
                             @if($key=="id" || $key=='updated_at')
                             <?php continue; ?>
                              @elseif($key == 'profile_image') 
                              <th>{{ ucfirst(str_replace('_',' ',Str::snake($key))) }}</th>
                              <th>
                              <a href="{{$result}}" target="_blank"> view Profile Image </a>
                              </th>
                             @else 
                               <th>{{ ucfirst(str_replace('_',' ',Str::snake($key))) }}</th>
                                  <th>{{ $result}} </th>
                              </tr>
                             @endif
                              
                              @endforeach
                          </thead> 
                         
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div>  
                <div class="tab-pane " id="comment"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Comments
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                            @if(isset($comments) and ($comments->count())>0)
                      <table class="table table-striped table-hover table-bordered" id="">
                          <thead>
                              <tr>
                                  <th>Sno</th>
                                  <th>Customer Name</th>
                                  <th>Editor Name</th>    
                                  <th>Comments</th> 
                                  <th> Date</th>    
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($comments as $key => $result)
                              <tr>
                                  <td>{{ ++$key}}</td>
                                   
                                  <td> {{$result->userDetail->first_name}} {{$result->userDetail->last_name}} </td>  
                                  <td> {{$result->editor->first_name}} {{$result->editor->last_name}} </td>

                                  <td> {{$result->commentDescription}}  </td>  
                                  <td> {{$result->created_at}} </td> 
                              </tr>
                              @endforeach
                          </tbody>
                         
                      </table>
                      @else
                      No Record Found!
                       @endif
                    </div> 
                  </div>
                </div>  


                <div class="tab-pane " id="remarks"> 
                  <div class="portlet light bordered">
                    <div class="portlet-title">
                      <div class="caption">
                          <i class="icon-social-dribbble font-green"></i>
                          <span class="caption-subject font-green bold uppercase">Remarks
                          </span>
                      </div> 
                    </div> 

                    <div class="form-group ">
                        @if(Session::has('flash_alert_notice'))
                                         <div class="alert alert-success alert-dismissable" style="margin:10px">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                          <i class="icon fa fa-check"></i>  
                                         {{ Session::get('flash_alert_notice') }} 
                                         </div>
                                    @endif 
                      <table class="table table-striped table-hover table-bordered" id="">
                          <form action="{{url('admin/postTask/addRemarks')}}" method="POST">
                          <thead>
                              <tr>  
                                  <th>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Add Status <span class="required"> </span></label>
                                    <div class="col-md-4"> 
                                        <input type="hidden" name="order_id" value="{{$postTasks->id}}">
                                         {{ Form::select('status',[
                                         '1'=>'Pending',
                                         '2'=>'In progress',
                                         '3'=>'Completed',
                                         '4'=>'Rejected'
                                         ], $postTasks->status , ['class' => 'form-control']) }}
                                    </div>
                                </div> 
                              </th>
                            </tr>
                            <tr>
                              <th>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Add Remarks<span class="required"> </span></label>
                                    <div class="col-md-4"> 
                                        {!! Form::textarea('admin_remarks',null, ['class' => 'form-control','data-required'=>1,'rows'=>3,'cols'=>5])  !!} 
                                    </div>
                                </div>
                                  </th>    
                              </tr>

                              <tr>
                              <th>
                                <div class="form-group">
                                    <label class="control-label col-md-3"> <span class="required"> </span></label>
                                    <div class="col-md-4"> 
                                        {!! Form::submit('Add Remarks', ['class' => 'form-control btn btn-success'])  !!} 
                                    </div>
                                </div>
                                  </th>    
                              </tr>
                          </thead>
                           </form>
                         
                      </table>
                       
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
</div>

@stop