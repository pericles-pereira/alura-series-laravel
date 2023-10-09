<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }} - Controle de Séries</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="/storage/logo/logo.png" type="image/png">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="{{ route('series.index') }}" class="btn mb-2 mt-2 btn-dark">Home</a>

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn mb-2 mt-2 btn-danger">Sair</button>
                </form>
            @endauth
            
            @if (!Route::is('login') && Auth::guest())
                <a href="{{ route('login') }}" class="btn mb-2 mt-2 btn-success">Entrar</a>
            @endif
        </div>
    </nav>
    <div class="container">
        <h1 class="mt-3">{{ $title }}</h1>

        @isset($mensagemSucesso)
            <div class="alert alert-success">
                {{ $mensagemSucesso }}
            </div>
        @endisset

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        {{ $slot }}
    </div>
</body>
</html>