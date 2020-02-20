<aside class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-12">

    <!--My Account-->
    <div class="sidemodule">
        <h2 class="heading5"><span class="maintext"> Minha conta</span></h2>
        <ul class="nav nav-list categories">
            @if (!auth()->user()->is_entity)
                <li> <a href="{{ route('home') }}">Início</a> </li>
                <li> <a href="{{ route('donations.index') }}">Minhas Doações </a></li>
                <li> <a href="{{ route('profile') }}">Meus Dados</a> </li>
            @else
                <li> <a href="{{ route('home') }}">Início</a> </li>
                <li> <a href="{{ route('campaigns.index') }}">Minhas Campanhas </a></li>
                <li> <a href="{{ route('profile') }}">Meus Dados</a> </li>
            @endif
        </ul>
    </div>
</aside>
