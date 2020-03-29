<!DOCTYPE html>
<html>

@include('dashboard.partials.head')
<style>
        #certificate{
            overflow: auto;
        }
        .certificate{
            background: url(assets/images_dashboard/certificate.jpg) no-repeat 0 0 / 100%;
    width: 650px;
    height: 465px;
    padding: 215px 80px 60px;
    margin: 0 auto;
    box-shadow: 0px 0px 35px -15px #551515;
    position: relative;
    text-align: center;
        } 
        .certiName{
            display: block;
            position: relative;
            font-size: 35px;
            color: #551515;
            font-weight: bold;
            font-family: monospace;
            text-transform: uppercase;
        }
        .certificate img{

            position: absolute;
    max-width: 70px;
    bottom: 80px;
    right: 85px;
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
                    <h2>Account Details</h2>
                    <!-- {{print_r($acc_details)}} -->
                </div>
                <div class="body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs tab-nav-right" role="tablist">
                        <li role="presentation" class="active "><a href="#edit" data-toggle="tab" aria-expanded="false">Edit Account Details</a></li>
                        <li role="presentation" class=""><a href="#certificate" data-toggle="tab" aria-expanded="true">Certificate</a></li>
                        <li role="presentation" class=""><a href="#followers" data-toggle="tab" aria-expanded="true">Followers</a></li>
                        <li role="presentation" class=""><a href="#bank_account" data-toggle="tab" aria-expanded="true">Bank Account</a></li>
                        

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="edit">
                            <div class="container-fluid m-t-15 p-l-20 p-r-20">
                                <form action="{{ url('update_editor_info')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ isset($acc_details['first_name']) ? $acc_details['first_name'] : '' }}">
                                            <label class="form-label">First Name</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ isset($acc_details['last_name']) ? $acc_details['last_name'] : '' }}">
                                            <label class="form-label">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="email_address" name="email_address" class="form-control" value="{{ isset($acc_details['email']) ? $acc_details['email'] : '' }}">
                                            <label class="form-label">Email Address</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" id="mob" name="mob" class="form-control" value="{{ isset($acc_details['phone']) ? $acc_details['phone'] : '' }}">
                                            <label class="form-label">Mobile</label>
                                        </div>
                                    </div>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="file" id="profile_image" name="profile_image"  class="form-control" value="{{ isset($acc_details['phone']) ? $acc_details['phone'] : '' }}">
                                            <label class="form-label"> </label>
                                        </div>
                                         <label class="form-label">Upload/Change Profile Pic <br>
					                   <img src="{{ $profile_image ?? ' ' }}" width="200" height="200" alt="User" />
                                       </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary waves-effect">Save</button>
                                </form>
                            </div></br>
                            <?php
                                if(Session::has('update_msg'))
                                {
                                    ?>
                                    <p class="text-danger">
                                        <?php 
                                        echo Session::get('update_msg');
                                        Session::pull('update_msg');
                                        ?>
                                    </p>
                                <?php }?>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="certificate">
                            <div class="certificate">
                                <span class="certiName">Mr {{ $acc_details['first_name'] . ' '.$acc_details['last_name']}}</span> after verification of his works under our team. <img src="{{ url('assets/images_dashboard/logo.png')}}" /> 
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="followers">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box-3 bg-indigo">
                                        <div class="icon">
                                            <i class="material-icons">face</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">Followers</div>
                                            <div class="number">257</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="info-box-3 bg-deep-purple">
                                        <div class="icon">
                                            <i class="material-icons">favorite</i>
                                        </div>
                                        <div class="content">
                                            <div class="text">LIKES</div>
                                            <div class="number">125</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div role="tabpanel" class="tab-pane fade" id="bank_account">
                            <div class="container-fluid m-t-15 p-l-20 p-r-20">
                                <form action="{{ url('bankAccount')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}
                                     
                               <div class="form-group form-float {{ $errors->first('account_name', 'has-error') }}">
                                    <div class="form-line"> 
                                       {!! Form::text('account_name',$bankAccount->account_name??null, ['class' => 'form-control'])  !!} 
                                        <span class="help-block">{{ $errors->first('account_name', ':message') }}</span>
                                        <label class="form-label">Account Holder Name</label>
                                    </div>
                                </div>    


                                <div class="form-group form-float {{ $errors->first('bank_name', 'has-error') }}">
                                    <div class="form-line"> 
                                       {!! Form::text('bank_name',$bankAccount->bank_name??null, ['class' => 'form-control'])  !!} 
                                        <span class="help-block">{{ $errors->first('bank_name', ':message') }}</span>
                                        <label class="form-label">Bank Name</label>
                                    </div>
                                </div> 

                                 <div class="form-group form-float {{ $errors->first('account_number', 'has-error') }}">
                                    <div class="form-line"> 
                                       {!! Form::number('account_number',$bankAccount->account_number??null, ['class' => 'form-control'])  !!} 
                                        <span class="help-block">{{ $errors->first('account_number', ':message') }}</span>
                                        <label class="form-label">Acount Number</label>
                                    </div>
                                </div> 
                                <div class="form-group form-float {{ $errors->first('ifsc_code', 'has-error') }}">
                                    <div class="form-line"> 
                                       {!! Form::text('ifsc_code',$bankAccount->ifsc_code??null, ['class' => 'form-control'])  !!} 
                                        <span class="help-block">{{ $errors->first('ifsc_code', ':message') }}</span>
                                        <label class="form-label">IFSC Code</label>
                                    </div>
                                </div> 

                                <div class="form-group form-float {{ $errors->first('bank_branch', 'has-error') }}">
                                    <div class="form-line"> 
                                       {!! Form::text('bank_branch',$bankAccount->bank_branch??null, ['class' => 'form-control'])  !!} 
                                        <span class="help-block">{{ $errors->first('bank_branch', ':message') }}</span>
                                        <label class="form-label">Branch name</label>
                                    </div>
                                </div> 

                               

                                  <div class="form-group form-float ">
                                        <div class="row">  
                                              {!! Form::submit('Save', ['class'=>'btn save btn-primary text-white','id'=>'saveBtn']) !!} 

                                               <a href="{{route('content')}}">
                                    {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
                                            </div>
                                </div> 

                                </form>
                            </div></br>
                            <?php
                                if(Session::has('update_msg'))
                                {
                                    ?>
                                    <p class="text-danger">
                                        <?php 
                                        echo Session::get('update_msg');
                                        Session::pull('update_msg');
                                        ?>
                                    </p>
                                <?php }?>
                        </div>
 

                    </div>
                </div>
            </div>
            

        </div>
</section>

@include('dashboard.partials.footer_links')
</body>

</html>
