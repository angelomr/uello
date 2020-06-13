<nav class="navbar navbar-expand-md bg-menu shadow-sm">
    <div class="container">
        <a href="{{ url('/') }}">
            {{ config('app.name', 'Uello') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Clientes</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>