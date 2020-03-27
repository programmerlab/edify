<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<style>
        .storiesWrap{
            overflow: auto;
            white-space: nowrap;
        }
        .story{
            display: inline-block;
            position: relative;
            height: 300px;
            width: 180px;
            margin: 10px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            cursor: pointer;
            box-shadow: 0px 0px 0px 0px #ddd;
            transition: 0.3s all ease;
        }
        .story:hover{
            box-shadow: 0px 2px 14px -1px #eeddee;
        }
        .story.addBtn{
            background-color: #dcdcdc;
            box-shadow: none;
        }
        .story.addBtn .material-icons{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            font-size: 60px;
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
                    <h2>Stories</h2>
                   
                </div>
                <div class="body">
                    @if(Session::has('flash_alert_notice'))
                    {{ Session::get('flash_alert_notice')}}
                    @endif
                    <div class="storiesWrap">
                        <div class="story addBtn" data-toggle="modal" data-target="#uploadStory">
                            <i class="material-icons">library_add</i>
                        </div>
                        <!-- <div class="story" style="background-image: url(https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80);">
                        </div> -->
                         
                        @foreach($stories as $story)
                        
                            
                        <div   class="story" style="background-image: url(storage/uploads/editor_stories_imgs/<?php echo $story->story_img; ?>);">
                        
                            <a href="#story" data-target="#delete_{{$story->id}}"   data-toggle="modal">
                                <button class='btn-danger' type="submit" name="remove_levels" value="delete" style="margin-left: 11px;position: absolute;right: 0px; ">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </button> 
                            </a>
                            <i class="material-icons" data-target="#uploadStory_{{$story->id}}"   data-toggle="modal" style="
                        position: absolute;
                        bottom: 0;
                        left: 45%;
                    ">library_add</i>
                        </div>

                        <div class="modal fade" id="delete_{{$story->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                   
                                        <div class="modal-body">
                                            <b> Are you sure want to delete?</b> 
                                        </div> 
                                        
                                        <div class="modal-footer"> 
                                            <a href="{{url('story/delete/'.$story->id)}}"  class="btn btn-danger waves-effect" >Delete</a> 

                                             <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                        </div> 
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="uploadStory_{{$story->id}}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                   
                                        <div class="modal-body">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                <?php 
                                                $path = url('storage/uploads/editor_stories_imgs/'.$story->story_img);
                                                ?> 
                                                  <img src="{{$path}}" width="100%">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer"> 
                                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                        </div> 
                                </div>
                            </div>
                        </div>

                        
                        
                        @endforeach
                    </div>
                    <?php
                    if(Session::has('storyuploadmsg'))
                    {
                        ?>
                        <p class="text-success">
                                <?php 
                        echo Session::get('storyuploadmsg');
                        Session::pull('storyuploadmsg');
                        ?>
                        </p>
                    <?php }?>
                </div>
            </div>

        </div>
</section>


<div class="modal fade" id="uploadStory" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('uploadstories') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label for="storyUpload">Upload</label>
                                <input type="file" id="storyUpload" name="storyUpload" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-link waves-effect">Submit</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@include('dashboard.partials.footer_links')
</body>

</html>
