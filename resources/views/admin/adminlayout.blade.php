@include('admin._partials.head')

<div id="app">
    <!-- Navigation -->
    @include('admin._partials.nav')
    <div class="container">
        <!-- breadcrumbs -->
        <div class="row no-gutters">
            <ol class="breadcrumb mt-4">
                @foreach(Request::segments() as $segment)
                    <li class="breadcrumb-item {{ $loop->last ? "active" : null }}">
                        @if($loop->first)
                            <span class="fa fa-home"></span>
                        @endif
                        {{ $segment }}
                    </li>
                @endforeach
            </ol>
        </div>
        <!-- alerts -->
        <div class="row">
            @include('admin.alerts')
        </div>
        <!-- validation errors -->
        @if (count($errors) > 0)
            <div class="row">
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
    </div>

    <!-- ./Navigation -->
    @yield('content')
</div>

@include('admin._partials.footer')
