<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<style>
        .postUnit{
            height: 200px;
        }
        .postUnit .postimg{
            background-size: cover;
            height: calc(100% - 20px);
            width: calc(100% - 20px);
            background-position: center;
            position: absolute;
            top: 10px;
            left: 10px;
            transition: 0.3s all ease;
            border-radius: 4px;
        }
        .postimgAfter{
            opacity: 0;
        }
        .switchIcon{
            position: absolute;
            top: 5px;
            right: 5px;
            color: white;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 9;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
        }
        .switchIcon:hover + .postimgAfter{
            opacity: 1;
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
                    <h2>Posts</h2>
                    <a href="{{url('postupload')}}" class="btn btn-success pull-right" style="margin-top: -15px" > 
                     Uplaod  </a>
                </div>

                <div class="body">

                    <div class="container-fluid">
                        <div class="postWrap">
                           @if(Session::has('flash_alert_notice'))
                             <div class="alert alert-success alert-dismissable" style="margin:10px">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                              <i class="icon fa fa-check"></i>  
                             {{ Session::get('flash_alert_notice') }} 
                             </div>
                        @endif
                            @foreach($editor_posts as $post) 
                                
                            <div class="col-xs-6 col-sm-4 col-md-4 postUnit" style="
                                border: 2px solid #ccc;
                                padding: 5px;
                            ">
                                <div style="background-image: url(storage/uploads/editor_test_imgs/<?php  echo $post->before_img; ?>)" class="postimg" > </div>
                                <label class="material-icons switchIcon" data-target="#uploadStory_{{$post->id}}"   data-toggle="modal" >switch_camera</label>

                                <div style="background-image: url(storage/uploads/editor_test_imgs/<?php  echo $post->after_img; ?>)"class="postimg postimgAfter"  > </div> 
                            
                                <a href="#post" data-target="#delete_{{$post->id}}"   data-toggle="modal">

                                <button class='btn-danger' type="submit" name="remove_levels" value="delete" style="margin-left: 11px;position: absolute;left: 0px;top: 10px;">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button> 
                            </a> 

                         <div class="modal fade" id="delete_{{$post->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                   
                                        <div class="modal-body">
                                            <b> Are you sure want to delete?</b> 
                                        </div> 
                                        
                                        <div class="modal-footer"> 
                                            <a href="{{url('post/delete/'.$post->id)}}"  class="btn btn-danger waves-effect" >Delete</a> 

                                             <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                        </div> 
                                </div>
                            </div>
                        </div>


                        <div class="modal fade" id="uploadStory_{{$post->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                   
                                        <div class="modal-body">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                <?php 
                                                $path = url('storage/uploads/editor_test_imgs/'.$post->after_img);
                                                ?> 
                                                  <img src="{{$path}}" width="100%">
                                                  AFTER Image
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer"> 
                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                        </div> 
                                </div>
                            </div>
                        </div>

                            </div> 
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>

@include('dashboard.partials.footer_links')
</body>

</html>
