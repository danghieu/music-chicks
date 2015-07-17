<!DOCTYPE HTML>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{Asset('../resources/assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{Asset('../resources/assets/css/bootstrap.css')}}"/>

    <link rel="stylesheet" href="{{Asset('../resources/assets/css/style.css')}}"/>
    <link rel="stylesheet" href="{{Asset('../resources/assets/css/bootstrap-social.css')}}"/>
    <link rel="stylesheet" href="{{Asset('../resources/assets/css/font-awesome.css')}}"/>
    <link rel="stylesheet" href="{{Asset('../resources/assets/css/font-awesome.min.css')}}"/>
    <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript" src="{{Asset('../resources/assets/js/jquery-validate/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{Asset('../resources/assets/js/vote.js')}}"></script>
    <script type="text/javascript" src="{{Asset('../resources/assets/js/bootstrap.min.js')}}"></script>

    <link rel="stylesheet" href="{{Asset('../resources/assets/css/search.css')}}"/>
    <script type="text/javascript" src="{{Asset('../resources/assets/js/search.js')}}"></script>

    
</head>
<body>

  <!-- Search Navbar - START -->

    <nav class="navbar my-navbar-default navbar-default navbar-fixed-top" role="navigation">
        
        <div class=" navbar-header  col-md-offset-1 col-sm-2 col-md-2">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a  href="{{Asset('home')}}"><img class="logo" src="{{Asset('../resources/assets/img/code-engine-studio-logo.png')}}"></a>
        </div>
         
        <div class="col-sm-5 col-md-5 nav navbar-nav search">

                @if(Session::has("logined"))
                @if(Session::get("userlevel")!=3)
                <form class="form-search" role="search"  method="get" action="{{Asset('search')}}"  name="form-search" autocomplete="off">
                    
                        <div class="input-group col-sm-10 col-md-10">

                            <input type="text " class="form-control" name="q" id="q" type="text" placeholder="Search the song">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                            
                        </div>                  
                        <div id="search-result"></div>

                                   
                </form>  
                @endif
                @endif
        </div>

    
        <div class="collapse navbar-collapse action col-sm-5 col-md-5" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @if(Session::has("logined"))
                    @if(isset($avatar) && isset($name) )
                        <li>
                        <div class=" avatar  floatleft">
                                 <a href="{{ url('') }}">
                                    <div class="dropdown  ">
                                    <a href="{{ url('information') }}"><img src="{{$avatar}}" class="avatar-img"></a>
                                        @if(Session::get('userlevel')==2||Session::get('userlevel')==3)
                                        <a href="{{ url('information') }}">{{$name}}
                                        @else 
                                            <button class="btn my-btn-default btn-xs  dropdown-toggle btn-menu" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                             <a href="">{{$name}}
                                             <span class="caret"></span></a>
                                        @endif

                                        
                                      </button>
                                      @if(Session::get('userlevel')==1||Session::get('userlevel')==0)
                                      <ul class="dropdown-menu menu_control" aria-labelledby="dropdownMenu1">
                                        <li><a href="{{ url('information') }}">Setting</a></li>
                                        <li><a href="{{'usersmanager'}}">Control Manager</a></li>
                                      </ul>
                                      @endif
                                    </div>
                                </a>
                        </div>
                            @if(Session::get("userlevel")!=3)
                            <div class="icon">
                                <div class="rest-vote"></div>
                            </div>
                            @endif
                        </li>
                    @endif
                                                    
                        <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>    
                @else
                        
                        <li><a href="{{ url('/register') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="{{ url('/login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>   
                @endif  
                    
            </ul>
              
        </div>  
        
    </nav>

    <!-- Search Navbar - END -->
    <div class="container">
        <div class="content col-sm-12 ">
            @yield("content")
        </div>

    </div><!-- container -->




</body>

</html>