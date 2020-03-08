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
                    <div class="storiesWrap">
                        <div class="story addBtn" data-toggle="modal" data-target="#uploadStory">
                            <i class="material-icons">library_add</i>
                        </div>
                        <div class="story" style="background-image: url(https://images.unsplash.com/photo-1503023345310-bd7c1de61c7d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&w=1000&q=80);">
                        </div>
                        <div class="story">
                        </div>
                   
                    </div>
                </div>
            </div>

        </div>
</section>


<div class="modal fade" id="uploadStory" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-body">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label for="storyUpload">Upload</label>
                                <input type="file" id="storyUpload" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-link waves-effect">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@include('dashboard.partials.footer_links')
</body>

</html>
