<!-- Header Start -->
<div class="navbar navbar-default navbar-fixed-top tiny" role="navigation">
    <div class="container nav-content">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ url('img/logo-site.png') }}" alt="Logo" title="Easy Loves"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="navbar navbar-nav navbar-right">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="#">Sobre nós</a></li>
                <li class="active"><a href="{{ url('/') }}" >Doar</a></li>
                @if(Auth::user())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> &nbsp;Painel <i class="fa fa-angle-down small"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ route('home') }}"><i class="fa fa-sign-out"></i> &nbsp;Minha conta</a></li>
                            <li><a href="{{ route('logout') }}"><i class="fa fa-power-off"></i> &nbsp;Sair</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- Header End -->
