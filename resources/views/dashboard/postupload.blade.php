<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<link rel="stylesheet" href="assets/plugins_dashboard/bootstrap-select/css/bootstrap-select.min.css">
    <script src="assets/plugins_dashboard/bootstrap-select/js/bootstrap-select.min.js"></script>
    <style>
        .uploadFormWrap{
            position: relative;
            overflow: hidden;
            height: 300px;
            margin: 0 auto;
            max-width: 700px;
        }
        .uploadBox{
            position: absolute;
            width: 50%;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #ededed;
            cursor: pointer;
            background-size: cover;
            background-position: center center;
        }
        .uploadBox.after{
            left: 50%;
            background-color: #eeeeee;
        }
        .uploadBox:not(.filled):before{
            content: 'click to upload BEFORE image';
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            color: #222222;
            width: 85%;
            text-align: center;
        }
        .uploadBox.after:not(.filled):before{
            content: 'click to upload AFTER image';
        }
        .uploadBox.filled:before{
            content: 'BEFORE';
            padding: 15px;
            color: white;
            background-color: rgba(0, 0, 0, 0.4);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 85%;
            text-align: center;
        }
        .uploadBox.filled.after:before{
            content: 'AFTER';
        }
        .fileUploadControl{
            font-size: 0;
            position: absolute;
            z-index: -8;
            opacity: 0;
            width: 0;
            height: 0;
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
                    <h2>Post</h2>
                </div>
                <?php
                    if(Session::has('postuploadmsg'))
                    {
                        ?>
                        <p class="text-success">
                                <?php 
                        echo Session::get('postuploadmsg');
                        Session::pull('postuploadmsg');
                        ?>
                        </p>
                    <?php }?>
                <div class="body">
                    <div class="alert alert-success">
                        <ol>
                            <li>For each post it is mondatory to post 2 photos</li>
                            <li>One should be before and one should be after</li>
                            <li>Be sure to add comments</li>
                        </ol>
                    </div>
                    <div class="uploadFormWrap">
                        <label for="postbefore" class="uploadBox">

                        </label>
                        <label for="postafter" class="uploadBox after">

                        </label>
                    </div>
                    <form action="{{ url('uploadpost') }}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col-xs-6">
                        <input type="file" id="postbefore" name="postbefore" class="fileUploadControl">
                        <input type="file" id="postafter" name="postafter" class="fileUploadControl">
                        <div class="form-group m-t-20">
                            <div class="form-line">
                                <select name="sw" id="sw" class="form-control">
                                    <option >Select Software</option>
                                    <option value="ps">Photoshop</option>
                                    <option value="cd">coreldraw</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <textarea name="comment" id="postComment" class="form-control" placeholder="Comment about your work"></textarea>
                            </div>
                        </div>

                        </div>
                        <div class="clearfix"></div>
                        <button class="btn btn-success btn-lg m-t-20">Submit</button>
                    </form>
                </div>
                
            </div>

        </div>
</section>
@include('dashboard.partials.footer_links')

<script>
        $(".fileUploadControl").on('change', function(){
            var input = this;
            var $preview = $("label[for="+$(input).attr('id')+"]");
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $preview.css('background-image', 'url(' + e.target.result + ')').addClass('filled');
                    console.log($(this).next(), 'ss', $preview)
                }
                reader.readAsDataURL(input.files[0]);
            }
        })
    </script>
</body>

</html>
