@extends('admin.adminlayout')

@section('content')
        <div class="row">
            <div class="col-md-12">
                Aktuelle Paarungen ohne Ergebnis
                <br>
                Alle Paarungen der Vergangenheit der aktuellen Saison, die kein Ergebnis, keine Wertung haben und nicht annulliert sind
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                Quick-Links zu aktuellen Saisons, Spielwochen
                <div class="list-group">
                    <a href="#" class="list-group-item">
                        Tiel
                    </a>
                    <a href="#" class="list-group-item list-group-item-action">Dapibus ac facilisis in</a>
                    <a href="#" class="list-group-item list-group-item-action">Morbi leo risus</a>
                    <a href="#" class="list-group-item list-group-item-action">Porta ac consectetur ac</a>
                    <a href="#" class="list-group-item list-group-item-action">Vestibulum at eros</a>
                </div>
            </div>
            <div class="col-md-4">
                Gesperrte Spieler
            </div>
            <div class="col-md-4">
                Spiele ohne Schiedsrichter
            </div>
        </div>

@endsection