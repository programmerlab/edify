<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <link href="https://fonts.googleapis.com/css?family=Hind+Siliguri:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css ">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script>

</head>

<body>

    <section class="testsWrapper">
        <header>
            
            <div class="container-fluid "  >
                <div class="col-sm-6 col-md-6">
                    <img src="assets/img/logo.png" alt="">
                </div>
                <div class="col-sm-6 col-md-6 pull-right" style="  text-align: right;">
                    <span style="color: #fff">Welcome :) <a style="color: #fff;display: inline-block" href="{{url('logout')}}">Logout </a> </span>
                    
                </div>
            </div> 
        </header>
        <form method="POST" action="{{ url('uploadtestimage') }}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="welcomeSection">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <h2>Welcome editor,</h2>
                        <p>Edify is unique digital platform for editors and creatives. To continue using Edify you need
                            to go through some tests which are mentioned below.</p>
                        <ul>
                            <li>These tests will go through 3 stages.</li>
                            <li>Download refrence images and based on the instructions edit the image</li>
                            <li>After Editing upload the high quality image in respective sections</li>
                            <li>When you are done with all tests click submit.</li>
                            <li>After verification you will be notified and you may then continue to get work for your
                                services through Edify</li>
                        </ul>
                    </div>
                    <div class="col-sm-5">
                        <img src="assets/img/welcome.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="section test1">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h2 class="testTitle">Online Portfolio</h2>
                        @if($errors->all())
                        {{ $errors->all() }}
                        @endif
                        <p>Do you keep your work online ? we'd like to take a peek into your soceial media for your
                            skils. you can provide link to your profiles in the fields. </p>
                        <ul class="list">
                            <li>Your Facebook profile link. <br> eg. http://www.facebook.com/ededitor</li>
                            <li>Your Instagram profile link. <br> eg. http://www.instagram.com/ededitor</li>
                            <li>You can provide any other profile viz deviantart, artstation, behance etc. as long as it
                                showcases your editing skills</li>
                        </ul>
                            
                    </div>
                    <div class="col-sm-6">
                    <div class="testOp">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder='Instagram ID' name="fb_id" id="fb_id"  value="{{old('fb_id')}}">
                        </div>
                        <div class="form-group">
                            <input type="text" value="{{old('insta_id')}}" class="form-control" name="insta_id" id="insta_id" placeholder='Facebook ID' >
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="other_id" id="other_id" placeholder='Other ID'   value="{{old('other_id')}}">
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section test2">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 pull-right">
                        <h2 class="testTitle">Editing Skills #1</h2>
                        <p>This section tests skin retouching, fixing skin tones, beautify face, white balance correction.</p>
                        <ul>
                            <li>Download the reference image by clicking on 'download refrence' button</li>
                            <li>Edit image based on given instructions.</li>
                            <li>Upload image in 'upload' field.</li>
                            <li>Please upload high quality image.</li>
                        </ul>
                            <div class="testOp">
                                <div class="form-group">
                                    <label for="t1" class="uploadBtn"><i class="fa fa-upload"></i> Upload</label>
                                </div>
                                
                                <a href="{{  url($path.'/'.$test_imgs[0]->images) }}" class="dloadRefBtn btn" download>Download Reference #1</a>
                            </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="previewBox">
                            <input type="file" name="img1" class="form-upload" id='t1'>
                            <div class="preview">
                                <?php $path1 = url($path.'/'.$test_imgs[0]->images); ?>
                            </div>
                            <div class="previewBefore" style="background-image: url('<?php echo $path1; ?>')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section test3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <h2 class="testTitle">Editing Skill #2</h2>
                        <p>This section tests image manipulations</p>
                        <ul>
                            <li>Download the reference image by clicking on 'download refrence' button</li>
                            <li>Edit image based on given instructions.</li>
                            <li>Upload image in 'upload' field.</li>
                            <li>Please upload high quality image.</li>
                        </ul>
                            <div class="testOp">
                                <div class="form-group">
                                    <label for="t2" class="uploadBtn"><i class="fa fa-upload"></i> Upload</label>
                                </div>
                                 <?php $path2 = url($path.'/'.$test_imgs[1]->images); ?>
                                <a href="{{ $path2 }}" class="dloadRefBtn btn" download>Download Reference #2</a>
                            </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="previewBox">
                            <input type="file" name="img2" class="form-upload" id='t2'>
                            <div class="preview"></div>
                            <div class="previewBefore" style="background-image: url('{{$path2}}')"></div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section test4">
            <div class="container">
                <div class="row">
                    <div class="col-sm-5 pull-right">
                        <h2 class="testTitle">Editing Skil #3</h2>
                        <p>For this section take your creative freedom and blow us with your skill you can edit however you want.</p>
                        <ul>
                            <li>Download the reference image by clicking on 'download refrence' button</li>
                            <li>Edit image based on given instructions.</li>
                            <li>Upload image in 'upload' field.</li>
                            <li>Please upload high quality image.</li>
                        </ul>
                            <div class="testOp">
                                <div class="form-group">
                                    <label for="t3" class="uploadBtn"><i class="fa fa-upload"></i> Upload</label>
                                </div>
                              <?php $path3 = url($path.'/'.$test_imgs[2]->images); ?>
                                <a href="{{ $path3  }}" class="dloadRefBtn btn" download>Download Reference #3</a>
                            </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="previewBox">
                            <input type="file" name="img3" class="form-upload" id='t3'>
                            <div class="preview"></div>
                            <div class="previewBefore" style="background-image: url('{{$path3}}');"></div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center alert alert-warning">
                        <h2 class="testTitle">Submit Test</h2>
                        <p>Please Make sure you have filled all the fields. </p>
                        <br>
                            <button type="submit" class="btn btn-success submitTest">Submit Tests</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <img src="assets/img/logo.png" alt="">
                </div>
                <div class="col-sm-4">
                    <h3>Social</h3>
                    <ul class="list-inline">
                        <li>
                            <a href="#"><i class="fa fa-facebook"></i> <span>Facebook</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i> <span>Instagram</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-linkedin"></i> <span>linkedin</span></a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-4 text-right">
                    <h3>Contact</h3>
                    <ul class="text-left list-inline">
                        <li>
                            <a href="#"> <i class="fa fa-phone"></i> <span>+91 9999 9999 99</span></a>
                        </li>
                        <li>
                            <a href="#"> <i class="fa fa-envelope"></i> <span>info@edify.in</span> </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="text-center bg-default">copyright &copy; edify 2020.</p>
    </footer>

</body>

</html>