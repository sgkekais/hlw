@include('admin._includes.head')

<div id="app">
    <!-- Navigation -->
    @include('admin._includes.nav')
    <!-- alerts -->
    <div class="container">
        @include('admin.alerts')
    </div>
    <!-- validation errors -->
    @if (count($errors) > 0)
        <div class="container">
            <div class="alert alert-danger alert-dismissible fade show mt-4 " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="fa fa-fire"></span> <strong>Achtung, es sind Fehler aufgetreten!</strong>
                <p>
                    Bitte korrigiere die folgenden Eingaben (achte bspw. auf die Feldnamen).
                </p>
                <p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </p>
            </div>
        </div>
    @endif
    <!-- ./Navigation -->
    @yield('content')
</div>

@include('admin._includes.footer')
