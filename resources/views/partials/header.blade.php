<header>
    <div class="container-fluid">
        <div class="col-sm-6">
            <a href="{{url('/')}}" class='logo'>
                <img src="{{url('assets/img/logo.png')}}" alt="">
            </a>
        </div>
        <div class="col-sm-6 text-right">
            <a class="home" href="{{url('/')}}">Home</a> 
            <a class="signinbtn" href="#signup">Become an editor</a>
            @if(Auth::check())
                <a class="logoutbtn" href="{{url('logout')}}">Logout</a>
            @else
                <a class="signinbtn" href="#signin">sign in</a>
            @endif 
            
        </div>
    </div>
</header>