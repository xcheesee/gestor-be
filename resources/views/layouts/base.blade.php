<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    {{-- <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/bootstrap.ndtic.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ndtic.css') }}" rel="stylesheet">
    <link href="{{ asset('css/multi-select.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.quicksearch.js') }}"></script>
    <script src="{{ asset('js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('js/xlsx.core.min.js') }}"></script>
    <script src="{{ asset('js/FileSaver.js') }}"></script>
    <script src="{{ asset('js/tableexport.js') }}"></script>
    <script src="{{ asset('js/tools.js') }}"></script>
    <script src="{{ asset('js/echarts.js') }}"></script>
    <title>{{ config('app.name', 'NDTIC WEB App') }}</title>
</head>
<body class="d-flex flex-column bg-body-secondary">
    <header class="py-3 bg-primary text-white">
    <nav class="navbar navbar-expand-xl navbar-dark bg-primary mb-5 fixed-top">
        <div class="container-fluid">
            <a class="ndtic-brand navbar-brand mb-0" href="{{ route('home') }}">
                <!--<img src="{{ asset('img/horizontal_branco.png') }}" width="180px" height="auto">-->
                {{ config('app.name', 'NDTIC WEB App') }} <!-- Caso tenha uma imagem de logo, descomentar a linha acima e remover esta aqui -->
            </a>
            <div class="collapse navbar-collapse" id="navbarText">
            </div>
            <div class="d-flex">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item navbar-text fs-5 me-3" style="color: white;">
                        @auth
                        Olá, {{ Auth::user()->name }}
                        @endauth

                        @guest
                        Entrar
                        @endguest
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('trocasenha') }}" title="Alterar Senha"><i class="fas fa-user-shield fa-2x" style="color: white;"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sair') }}" title="Sair do Sistema"><i class="fas fa-sign-out-alt fa-2x" style="color: white;"></i></a>
                    </li>
                    @endauth
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('entrar') }}" title="Entrar do Sistema"><i class="fas fa-sign-in-alt fa-2x" style="color: white;"></i></a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    </header>

    <div id="spinner-div" class="pt-5">
        <div class="spinner-border text-success align-middle" role="status">
        </div>
    </div>
    <div>
        <div class="d-flex">
            <main class="col-sm p-3" style="min-height: 92.6vh">
                <div class="p-5">
                    <h2 class="mb-4">@yield('cabecalho')</h2>
                    @yield('conteudo')
                </div>
            </main>
        </div>

        <footer class="footer d-flex flex-shrink-0 justify-content-center align-items-center pt-2" style="height: 20px; left: 0; bottom: 0; width: 100%;">
            <div class="ms-2"><p class="mb-0" style="font-size: 12px;">Desenvolvido pela NDTIC - SVMA</p></div>
        </footer>
    </div>
</body>
</html>
