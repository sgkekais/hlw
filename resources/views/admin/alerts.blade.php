<!-- Info Alert -->
@if (Session::has('info'))
    <div class="alert alert-info alert-dismissible fade show mt-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-info"></span> <strong>Info!</strong>
        <p>
            {{ Session::get('info') }}
        </p>
    </div>
@endif
<!-- Success Alert -->
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-check"></span> <strong>Erfolg!</strong>
        <p>
            {{ Session::get('success') }}
        </p>
    </div>
@endif
<!-- Warning Alert -->
@if (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-warning"></span> <strong>Warnung!</strong>
        <p>
            {{ Session::get('warning') }}
        </p>
    </div>
@endif
<!-- Critical Alert -->
@if (Session::has('danger'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <span class="fa fa-fire"></span> <strong>Achtung!</strong>
        <p>
            {{ Session::get('danger') }}
        </p>
    </div>
@endif