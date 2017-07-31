@include('admin._partials.head')

<div id="app">
    <!-- Navigation -->
    @include('admin._partials.nav')
    <div class="container-fluid">

        <div class="row">
            <!-- sidebar, hidden for smaller viewports via hidden-helper -->
            <div class="col-md-2 hidden-sm-down bg-faded sidebar">
                Hi!
            </div>
            <!-- main content -->
            <div class="col-md-10 offset-md-2">
                <div class="row">
                    <div class="col-12">
                        <!-- breadcrumbs -->
                        <ol class="breadcrumb">
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
                </div>
                <!-- alerts -->
                <div class="row">
                    <div class="col-12">
                        @include('admin.alerts')
                    </div>
                </div>
                <!-- validation errors -->
                @if (count($errors) > 0)
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                    </div>
                @endif
                <!-- content -->
                @yield('content')
                <!-- ./content -->
            </div>
        </div><!-- ./navigation -->
    </div>
</div>

@include('admin._partials.footer')
