<!-- Menu start -->
<div id='menu'>
    <ul>
        <li class="{{ isActive('home', 'highlight') }}">
            <a href='{{ getUserRoute('dashboard') }}'>
                <i class="fa fa-desktop"></i>
                <span>Dashboard</span>
                <span class="{{ isActive('home', 'current-page') }}"></span>
            </a>
        </li>
        @if (Auth::user()->level >= 3)
        <li class="{{ isActive('diligencias.index', 'highlight') }}">
            <a href='{{ getUserRoute('diligencias') }}'>
                <i class="fa fa-folder-open-o"></i>
                <span>Diligências</span>
                <span class="{{ isActive('diligencias.index', 'current-page') }}"></span>
            </a>
        </li>
        @endif
        @if (Auth::user()->level >= 6)
            <li class="{{ isActive('pages.financeiro', 'highlight') }}">
                <a href='{{ route('pages.financeiro') }}'>
                    <i class="fa fa-money"></i>
                    <span>Financeiro</span>
                    <span class="{{ isActive('pages.financeiro', 'current-page') }}"></span>
                </a>
            </li>
        @endif
        @if (Auth::user()->level >= 5)
            <li class='has-sub {{ isSubMenuActive('entities') }}'>
                <a href='#'>
                    <i class="fa fa-flask"></i>
                    <span>Gestão</span>
                </a>
                <ul>
                    <li class="{{ isActive('advogados.index', 'highlight') }}">
                        <a href='{{ route('advogados.index') }}'>
                            <i class="fa fa-graduation-cap"></i>
                            <span>Advogados</span>
                            <span class="{{ isActive('advogados.index', 'current-page') }}"></span>
                        </a>
                    </li>
                    <li class="{{ isActive('clientes.index', 'highlight') }}">
                        <a href='{{ route('clientes.index') }}'>
                            <i class="fa fa-institution"></i>
                            <span>Clientes</span>
                            <span class="{{ isActive('clientes.index', 'current-page') }}"></span>
                        </a>
                    </li>
                    <li class="{{ isActive('correspondentes.index', 'highlight') }}">
                        <a href='{{ route('correspondentes.index') }}'>
                            <i class="fa fa-group"></i>
                            <span>Correspondentes</span>
                            <span class="{{ isActive('correspondentes.index', 'current-page') }}"></span>
                        </a>
                    </li>
                    <li class="{{ isActive('users.index', 'highlight') }}">
                        <a href='{{ route('users.index') }}'>
                            <i class="fa fa-user"></i>
                            <span>Usuários</span>
                            <span class="{{ isActive('users.index', 'current-page') }}"></span>
                        </a>
                    </li>
                    <li class="{{ isActive('pages.setup', 'highlight') }}">
                        <a href='{{ route('pages.setup') }}'>
                            <i class="fa fa-cog"></i>
                            <span>Setup</span>
                            <span class="{{ isActive('pages.setup', 'current-page') }}"></span>
                        </a>
                    </li>
                    <li class="{{ isActive('emails.index', 'highlight') }}">
                        <a href='{{ route('emails.index') }}'>
                            <i class="fa fa-envelope-o"></i>
                            <span>Emails</span>
                            <span class="{{ isActive('emails.index', 'current-page') }}"></span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</div>
<!-- Menu End -->


<!-- Freebies Starts -->
<div class="freebies">
    <!-- Sidebar Extras -->
    <div class="sidebar-addons">
        <ul class="views">
            @if (Auth::user()->level >= 3)
                <li>
                    <i class="fa fa-circle-o text-success"></i>
                    <div class="details">
                        <p>Usuários</p>
                    </div>
                    <span class="label label-success">8</span>
                </li>
                <li>
                    <i class="fa fa-circle-o text-info"></i>
                    <div class="details">
                        <p>Correspondentes</p>
                    </div>
                    <span class="label label-info">7</span>
                </li>
                <li>
                    <i class="fa fa-circle-o text-danger"></i>
                    <div class="details">
                        <p>Diligências</p>
                    </div>
                    <span class="label label-danger">4</span>
                </li>
            @endif
            <li>
                <i class="fa fa-circle-o text-warning"></i>
                <div class="details">
                    <p>Perfil:</p>
                </div>
                <span class="label label-warning label-transparent">{{ getUserGroup() }}</span>
            </li>
        </ul>
    </div>
</div>
<!-- Freebies Starts -->
