<!-- Info Alert -->
@if (Session::has('info'))
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa fa-info"></span> <strong>Info!</strong>
        <hr>
        <p>
            {{ Session::get('info') }}
        </p>
    </div>
@endif
<!-- Success Alert -->
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa fa-check"></span> <strong>Erfolg!</strong>
        <hr>
        <p>
            {{ Session::get('success') }}
        </p>
    </div>
@endif
<!-- Warning Alert -->
@if (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa fa-warning"></span> <strong>Warnung!</strong>
        <hr>
        <p>
            {{ Session::get('warning') }}
        </p>
    </div>
@endif
<!-- Critical Alert -->
@if (Session::has('danger'))
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="fa fa-fire"></span> <strong>Achtung!</strong>
        <hr>
        <p>
            {{ Session::get('danger') }}
        </p>
    </div>
@endif