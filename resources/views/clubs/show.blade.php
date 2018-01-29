@extends('layouts.app')

@section('subnav')

    {{--@include('_partials.subnav_divisions')--}}

@endsection

@section('content')

{{-- primrary color when club color is white --}}
@php
    if ($club->colours_club_primary == "#FFFFFF" || $club->colours_club_primary == "#ffffff") {
        $primary_color = "#111";
    } else {
        $primary_color = $club->colours_club_primary;
    }
@endphp
<!-- cover -->
<div class="position-relative border border-top-0 border-left-0 border-right-0" style="background-color: {{ $club->colours_club_primary }}">
    <div class="container">
        {{-- TODO: cover! {{ $club->cover_url ? "background-image: url('".asset('storage/'.$club->cover_url)."'); background-size: cover; background-position: center right" :  --}}
        <div class="position-absolute h-100" style="width: 100%; right: 0; background: url(' {{ asset('storage/club_bg.jpg') }} ') no-repeat top center; background-size: cover">
            {{-- inner --}}
            <div class="position-relative h-100" style="width: 40%; background: repeating-linear-gradient(
                    135deg,
                    transparent,
                    transparent 20px,
                    {{ $club->colours_club_primary }} 20px,
                    {{ $club->colours_club_primary }} 40px
                );">

            </div>
        </div>
        <div class="row pt-3">
            <div class="col-3 text-center">
                @if($club->logo_url)
                    <img src="{{ asset('storage/'.$club->logo_url) }}" class="img-fluid" title="{{ $club->name }}" alt="Vereinswappen">
                @else
                    <span class="fa fa-ban text-muted fa-5x"></span>
                @endif
            </div>
            <div class="col-9 text-white">
                <h1 class="font-weight-bold"><span class="p-1 bg-black-transparent">{{ $club->name }}</span></h1>
                <ul class="list-unstyled">
                    {{-- league championships --}}
                    @php
                        $league_championships = $club->championships->where('division.competition.type', 'league')->sortByDesc('end');
                    @endphp
                    @if (!$league_championships->isEmpty())
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            @foreach ($league_championships as $league_championship)
                                <i class="fa fa-fw fa-star" style="color: orange" title="{{ $league_championship->name }}"></i>
                            @endforeach
                        </span>
                        </li>
                    @endif
                    {{-- cup trophys --}}
                    @php
                        $cup_championships = $club->championships->where('division.competition.type', 'knockout')->sortByDesc('end');
                    @endphp
                    @if (!$cup_championships->isEmpty())
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            @foreach ($cup_championships as $cup_championship)
                                <i class="fa fa-fw fa-trophy" style="color: orange" title="{{ $cup_championship->name }}"></i>
                            @endforeach
                        </span>
                        </li>
                    @endif
                    {{-- stadium --}}
                    @php
                        $regular_stadium = $club->regularStadium->first();
                    @endphp
                    @isset ($regular_stadium)
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            @svg('arena', ['class' => 'align-middle pr-1', 'style' => 'fill: #FFF', 'width' => '30', 'height' => '30'])
                            {{ $regular_stadium->name }}
                        </span>
                        </li>
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            <i class="fa fa-fw fa-calendar"></i> {{ $regular_stadium->pivot->regular_home_day }}
                            <i class="fa fa-fw fa-clock-o"></i> {{ $regular_stadium->pivot->regular_home_time }}
                        </span>
                        </li>
                    @endif
                    {{-- website --}}
                    @if($club->website)
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            <i class="fa fa-fw fa-home"></i> <a href="{{ $club->website }}" target="_blank">Offizielle Website</a>
                        </span>
                        </li>
                    @endif
                    {{-- facebook --}}
                    @if($club->facebook)
                        <li class="my-1">
                        <span class="p-1 bg-black-transparent">
                            <i class="fa fa-fw fa-facebook"></i> <a href="{{ $club->facebook }}" target="_blank">Facebook</a>
                        </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <!-- tabs -->
                <nav class="nav nav-tabs border-0" id="tab" role="tablist">
                    <a class="nav-item nav-link px-2 active border border-white" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-expanded="true" style="background-color: rgba(0, 0, 0, 0.5);">
                        Übersicht
                    </a>
                    <a class="ml-1 nav-item nav-link px-2 border-white" id="results-tab" data-toggle="tab" href="#results" role="tab" aria-controls="results" style="background-color: rgba(0, 0, 0, 0.5);" >
                        Resultate
                    </a>
                    <a class="ml-1 nav-item nav-link px-2 border-white" id="players-tab" data-toggle="tab" href="#players" role="tab" aria-controls="players" style="background-color: rgba(0, 0, 0, 0.5);">
                        Kader
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- content -->
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="tab-content col-12" id="tabcontent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <h1 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Übersicht</h1>
                <div class="row">
                    <div class="col">
                        <div class="p-4 bg-light rounded text-muted">
                            <ul class="list-inline d-flex justify-content-around mb-0">
                                @if ($club->founded)
                                    <li class="list-inline-item" title="Gegründet">
                                        <span class="fa fa-birthday-cake fa-3x pr-1 align-middle"></span>
                                        <span class="h3 align-middle">{{ $club->founded->format('d.m.Y') }}</span>
                                    </li>
                                @endif
                                @if ($club->league_entry)
                                    <li class="list-inline-item" title="Eingetreten">
                                        <span class="fa fa-sign-in fa-3x pr-1 align-middle"></span>
                                        <span class="h3 align-middle">{{ $club->league_entry->format('d.m.Y') }}</span>
                                    </li>
                                @endif
                                @if ($club->league_exit)
                                    <li class="list-inline-item" title="Ausgetreten">
                                        <span class="fa fa-sign-out fa-3x pr-1 align-middle"></span>
                                        <span class="h3 align-middle">{{ $club->league_exit->format('d.m.Y') }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Spielverlegungen</h2>
                        <div class="row">
                            @if ($reschedulings && !$reschedulings->isEmpty())
                                @php
                                    $total_reschedulings      = $reschedulings->count();
                                    $counting_reschedulings   = $reschedulings->where('reschedule_count', true)->count();
                                @endphp
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <div class="h1 font-weight-bold font-italic align-middle text-center {{ $counting_reschedulings >= $season->max_rescheduling ? "text-danger" : null }}" title="Anzahl Verlegungen">
                                        <span class="fa fa-fw fa-calendar-plus-o"></span>
                                        {{ $counting_reschedulings }}
                                    </div>
                                </div>
                                <div class="col">
                                    <ul class="list-group">
                                        @if ($total_reschedulings > 0)
                                            @foreach ($reschedulings as $rescheduled_fixture)
                                                <li class="list-group-item">
                                                    {{ $rescheduled_fixture->clubHome ? $rescheduled_fixture->clubHome->name_short : "-" }}
                                                    :
                                                    {{ $rescheduled_fixture->clubAway ? $rescheduled_fixture->clubAway->name_short : "-" }}
                                                    aus SW {{ $rescheduled_fixture->matchweek->number_consecutive }}
                                                    verlegt vom {{ $rescheduled_fixture->rescheduledFrom && $rescheduled_fixture->rescheduledFrom->datetime ? $rescheduled_fixture->rescheduledFrom->datetime->format('d.m.Y H:i') : "o.D." }}
                                                    auf den {{ $rescheduled_fixture->datetime ? $rescheduled_fixture->datetime->format('d.m.Y H:i') : "o.D." }}
                                                    <span class="pull-right">
                                                        <a href="{{ route('frontend.fixtures.show', $rescheduled_fixture) }}" title="Match betrachten">
                                                            <i class="fa fa-fw fa-arrow-right"></i>
                                                        </a>
                                                    </span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item">
                                                <span class="fa fa-fw fa-thumbs-o-up"></span> Team hat bisher kein Spiel verlegt.
                                            </li>
                                        @endif
                                    </ul>
                                    @if ($total_reschedulings > $counting_reschedulings)
                                        <small class="text-muted">
                                            {{ $total_reschedulings - $counting_reschedulings }} Verlegung wird nicht gezählt.
                                        </small>
                                    @endif
                                </div>
                            @else
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <div class="h1 font-weight-bold font-italic align-middle text-center" title="Anzahl Verlegungen">
                                        <span class="fa fa-fw fa-calendar-plus-o"></span>
                                        0
                                    </div>
                                </div>
                                <div class="col">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span class="fa fa-fw fa-thumbs-o-up"></span> Team hat bisher kein Spiel verlegt.
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- club colors --}}
                    <div class="col-md-6">
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Farben</h2>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex d-flex-block border border-secondary rounded" style="width: 45%">
                                <!-- club colors -->
                                <div class="rounded-left" style="background-color: {{ $club->colours_club_primary }}; width: 50%">
                                    &nbsp;
                                </div>
                                <div class="rounded-right" style="background-color: {{ $club->colours_club_secondary }}; width: 50%">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="d-flex flex-row w-50 pl-1 justify-content-around align-items-center">
                                <!-- home -->
                                <span class="align-middle h1 mb-0 font-weight-bold font-italic">H</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="278.463 44.799 403.078 362.881">
                                    <path fill="{{ $club->colours_kit_home_primary }}" d="M480 103.04c-28.192 0-51.341-21.45-53.545-48.608-7.011.855-15.143 2.473-23.197 4.69a124.2 124.2 0 0 0-30.971 13.274l-64.292 43.994 33.904 67.813 23.95-13.063c.067-.036.144-.031.21-.063.269-.13.56-.188.856-.264.291-.072.573-.161.869-.175.071-.004.134-.045.21-.045.21 0 .385.09.587.117.313.041.618.076.914.184.269.099.502.242.744.385.25.148.493.282.712.479.229.206.403.448.587.699.121.166.292.282.39.466.041.067.036.144.067.211.125.264.184.551.26.842.076.295.166.582.179.882.004.072.045.134.045.21v223.65H480.5v-295.69c-.167.002-.333.012-.5.012z"/>
                                    <path fill="{{ $club->colours_kit_home_secondary }}" d="M587.484 72.253c-9.453-5.672-19.874-10.138-30.751-13.131-8.051-2.218-16.182-3.835-23.193-4.686-2.187 26.992-25.071 48.339-53.04 48.592V398.72h107.021V175.065c0-.076.04-.134.044-.21.014-.296.104-.583.18-.878.071-.292.13-.583.26-.847.031-.072.026-.144.063-.211.099-.179.26-.291.381-.452.188-.255.363-.506.601-.717.215-.188.452-.323.694-.466.251-.147.488-.295.766-.394.296-.107.597-.144.905-.184.201-.027.381-.117.587-.117.071 0 .135.041.211.045.3.013.582.099.878.175.295.076.582.134.851.264.067.031.14.027.206.063l22.754 12.419 33.963-67.935-63.381-43.367z"/>
                                    <path d="M479.5 407.68H592a4.474 4.474 0 0 0 4.479-4.479V182.618l20.349 11.102H616.837l21.469 11.711c.026.018.063.018.089.036.019.009.032.031.05.04.201.099.407.157.613.224.112.036.22.094.336.121.35.085.699.13 1.049.13.403 0 .807-.058 1.191-.161.13-.036.246-.107.372-.152.251-.094.502-.179.73-.313.143-.085.26-.207.394-.305.188-.144.386-.273.552-.448.125-.13.219-.296.331-.443.125-.166.269-.313.372-.502.009-.022.009-.045.018-.063.014-.031.04-.049.054-.081l36.674-73.346c.094-.184.089-.381.156-.574.095-.295.188-.569.229-.86.041-.292.027-.574.005-.865-.019-.282-.036-.551-.107-.824-.072-.287-.192-.542-.318-.807-.121-.251-.237-.493-.407-.721-.18-.247-.403-.448-.637-.654-.144-.13-.237-.3-.398-.413l-87.329-59.736a132.832 132.832 0 0 0-33.21-14.233c-12.615-3.467-25.102-5.537-34.245-5.681H435.2c-.014 0-.022.005-.031.005-.014 0-.022-.009-.036-.005-9.152.139-21.639 2.213-34.25 5.686-11.657 3.208-22.83 7.997-33.43 14.376l-87.1 59.593c-.166.112-.255.282-.403.412-.233.206-.453.403-.632.649-.17.229-.291.475-.412.726a4.713 4.713 0 0 0-.318.797 4.31 4.31 0 0 0-.108.833 7.557 7.557 0 0 0-.018.423v.005c-.001.141.004.283.022.428.036.291.134.564.233.851.063.188.063.39.157.573l36.673 73.347c.013.031.04.049.054.081.009.022.009.045.018.063.103.188.247.336.372.501.112.148.206.313.332.448.161.17.354.295.538.435.139.107.264.233.412.318.215.13.453.206.686.296.139.054.269.134.417.175.385.107.784.161 1.188.161.349 0 .699-.045 1.048-.13.117-.027.224-.085.336-.121.206-.067.417-.121.614-.219.018-.009.031-.027.049-.036.032-.018.063-.022.094-.036l41.816-22.817V403.2a4.478 4.478 0 0 0 4.48 4.479H479.5m191.863-278.041l-32.848 65.704-13.74-7.495 33.556-67.124 13.032 8.915zM524.616 53.76C522.762 76.29 503.479 94.08 480 94.08s-42.762-17.79-44.616-40.32h89.232zm-235.984 75.882l11.899-8.145 33.501 66.999-12.548 6.845m272.455-24.268c-.269-.13-.556-.188-.851-.264-.296-.076-.578-.162-.878-.175-.076-.004-.14-.045-.211-.045-.206 0-.386.09-.587.117-.309.04-.609.076-.905.184-.277.099-.515.247-.766.394-.242.144-.479.278-.694.466-.237.21-.412.461-.601.717-.121.161-.282.273-.381.452-.036.067-.031.139-.063.211-.13.264-.188.555-.26.847-.076.295-.166.582-.18.878-.004.076-.044.134-.044.21V398.72H372.48V175.07c0-.076-.041-.139-.045-.21-.013-.3-.103-.587-.179-.882-.076-.292-.134-.578-.26-.842-.031-.067-.027-.144-.067-.211-.098-.184-.269-.3-.39-.466-.184-.251-.358-.493-.587-.699-.219-.197-.461-.332-.712-.479-.242-.144-.475-.287-.744-.385-.295-.107-.6-.143-.914-.184-.202-.027-.376-.117-.587-.117-.076 0-.139.041-.21.045-.296.014-.578.103-.869.175-.296.076-.587.134-.856.264-.067.032-.143.027-.21.063l-23.95 13.063-33.904-67.813 64.292-43.994a124.162 124.162 0 0 1 30.971-13.274c8.055-2.218 16.186-3.835 23.197-4.69C428.659 81.59 451.808 103.04 480 103.04c28.197 0 51.341-21.45 53.54-48.604 7.012.851 15.143 2.468 23.193 4.686 10.877 2.993 21.298 7.459 30.751 13.131l63.378 43.366-33.963 67.935-22.754-12.419c-.066-.035-.138-.031-.206-.062z"/>
                                    <path d="M565.12 116.48h-35.84a4.478 4.478 0 0 0-4.48 4.48v22.4c0 16.943 13.942 24.904 21.316 26.746a4.416 4.416 0 0 0 2.168 0c7.374-1.841 21.315-9.802 21.315-26.746v-22.4a4.477 4.477 0 0 0-4.479-4.48zm-4.48 26.88c0 11.957-10.021 16.509-13.439 17.709-3.418-1.205-13.44-5.752-13.44-17.709v-17.92h26.88v17.92z"/>
                                </svg>
                                <!-- away -->
                                <span class="align-middle h1 mb-0 font-weight-bold font-italic">A</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" viewBox="278.463 44.799 403.078 362.881">
                                    <path fill="{{ $club->colours_kit_away_primary }}" d="M480 103.04c-28.192 0-51.341-21.45-53.545-48.608-7.011.855-15.143 2.473-23.197 4.69a124.2 124.2 0 0 0-30.971 13.274l-64.292 43.994 33.904 67.813 23.95-13.063c.067-.036.144-.031.21-.063.269-.13.56-.188.856-.264.291-.072.573-.161.869-.175.071-.004.134-.045.21-.045.21 0 .385.09.587.117.313.041.618.076.914.184.269.099.502.242.744.385.25.148.493.282.712.479.229.206.403.448.587.699.121.166.292.282.39.466.041.067.036.144.067.211.125.264.184.551.26.842.076.295.166.582.179.882.004.072.045.134.045.21v223.65H480.5v-295.69c-.167.002-.333.012-.5.012z"/>
                                    <path fill="{{ $club->colours_kit_away_secondary }}" d="M587.484 72.253c-9.453-5.672-19.874-10.138-30.751-13.131-8.051-2.218-16.182-3.835-23.193-4.686-2.187 26.992-25.071 48.339-53.04 48.592V398.72h107.021V175.065c0-.076.04-.134.044-.21.014-.296.104-.583.18-.878.071-.292.13-.583.26-.847.031-.072.026-.144.063-.211.099-.179.26-.291.381-.452.188-.255.363-.506.601-.717.215-.188.452-.323.694-.466.251-.147.488-.295.766-.394.296-.107.597-.144.905-.184.201-.027.381-.117.587-.117.071 0 .135.041.211.045.3.013.582.099.878.175.295.076.582.134.851.264.067.031.14.027.206.063l22.754 12.419 33.963-67.935-63.381-43.367z"/>
                                    <path d="M479.5 407.68H592a4.474 4.474 0 0 0 4.479-4.479V182.618l20.349 11.102H616.837l21.469 11.711c.026.018.063.018.089.036.019.009.032.031.05.04.201.099.407.157.613.224.112.036.22.094.336.121.35.085.699.13 1.049.13.403 0 .807-.058 1.191-.161.13-.036.246-.107.372-.152.251-.094.502-.179.73-.313.143-.085.26-.207.394-.305.188-.144.386-.273.552-.448.125-.13.219-.296.331-.443.125-.166.269-.313.372-.502.009-.022.009-.045.018-.063.014-.031.04-.049.054-.081l36.674-73.346c.094-.184.089-.381.156-.574.095-.295.188-.569.229-.86.041-.292.027-.574.005-.865-.019-.282-.036-.551-.107-.824-.072-.287-.192-.542-.318-.807-.121-.251-.237-.493-.407-.721-.18-.247-.403-.448-.637-.654-.144-.13-.237-.3-.398-.413l-87.329-59.736a132.832 132.832 0 0 0-33.21-14.233c-12.615-3.467-25.102-5.537-34.245-5.681H435.2c-.014 0-.022.005-.031.005-.014 0-.022-.009-.036-.005-9.152.139-21.639 2.213-34.25 5.686-11.657 3.208-22.83 7.997-33.43 14.376l-87.1 59.593c-.166.112-.255.282-.403.412-.233.206-.453.403-.632.649-.17.229-.291.475-.412.726a4.713 4.713 0 0 0-.318.797 4.31 4.31 0 0 0-.108.833 7.557 7.557 0 0 0-.018.423v.005c-.001.141.004.283.022.428.036.291.134.564.233.851.063.188.063.39.157.573l36.673 73.347c.013.031.04.049.054.081.009.022.009.045.018.063.103.188.247.336.372.501.112.148.206.313.332.448.161.17.354.295.538.435.139.107.264.233.412.318.215.13.453.206.686.296.139.054.269.134.417.175.385.107.784.161 1.188.161.349 0 .699-.045 1.048-.13.117-.027.224-.085.336-.121.206-.067.417-.121.614-.219.018-.009.031-.027.049-.036.032-.018.063-.022.094-.036l41.816-22.817V403.2a4.478 4.478 0 0 0 4.48 4.479H479.5m191.863-278.041l-32.848 65.704-13.74-7.495 33.556-67.124 13.032 8.915zM524.616 53.76C522.762 76.29 503.479 94.08 480 94.08s-42.762-17.79-44.616-40.32h89.232zm-235.984 75.882l11.899-8.145 33.501 66.999-12.548 6.845m272.455-24.268c-.269-.13-.556-.188-.851-.264-.296-.076-.578-.162-.878-.175-.076-.004-.14-.045-.211-.045-.206 0-.386.09-.587.117-.309.04-.609.076-.905.184-.277.099-.515.247-.766.394-.242.144-.479.278-.694.466-.237.21-.412.461-.601.717-.121.161-.282.273-.381.452-.036.067-.031.139-.063.211-.13.264-.188.555-.26.847-.076.295-.166.582-.18.878-.004.076-.044.134-.044.21V398.72H372.48V175.07c0-.076-.041-.139-.045-.21-.013-.3-.103-.587-.179-.882-.076-.292-.134-.578-.26-.842-.031-.067-.027-.144-.067-.211-.098-.184-.269-.3-.39-.466-.184-.251-.358-.493-.587-.699-.219-.197-.461-.332-.712-.479-.242-.144-.475-.287-.744-.385-.295-.107-.6-.143-.914-.184-.202-.027-.376-.117-.587-.117-.076 0-.139.041-.21.045-.296.014-.578.103-.869.175-.296.076-.587.134-.856.264-.067.032-.143.027-.21.063l-23.95 13.063-33.904-67.813 64.292-43.994a124.162 124.162 0 0 1 30.971-13.274c8.055-2.218 16.186-3.835 23.197-4.69C428.659 81.59 451.808 103.04 480 103.04c28.197 0 51.341-21.45 53.54-48.604 7.012.851 15.143 2.468 23.193 4.686 10.877 2.993 21.298 7.459 30.751 13.131l63.378 43.366-33.963 67.935-22.754-12.419c-.066-.035-.138-.031-.206-.062z"/>
                                    <path d="M565.12 116.48h-35.84a4.478 4.478 0 0 0-4.48 4.48v22.4c0 16.943 13.942 24.904 21.316 26.746a4.416 4.416 0 0 0 2.168 0c7.374-1.841 21.315-9.802 21.315-26.746v-22.4a4.477 4.477 0 0 0-4.479-4.48zm-4.48 26.88c0 11.957-10.021 16.509-13.439 17.709-3.418-1.205-13.44-5.752-13.44-17.709v-17.92h26.88v17.92z"/>
                                </svg>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Zuletzt</h2>
                        @php
                            $lastGames = $club->getLastGamesPlayedOrRated(5)->load('clubHome', 'clubAway');
                        @endphp
                        @if (!$lastGames->isEmpty())
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th class="d-none d-sm-table-cell"></th>
                                        <th class="align-middle"><span class="fa fa-calendar" title="Datum"></span></th>
                                        <th colspan="3" class="text-center"><span class="fa fa-handshake-o" title="Paarung"></span></th>
                                        <th class="align-middle text-center"><span class="fa fa-search-plus" title="Spieldetails"></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lastGames as $fixture)
                                        <tr>
                                            <td class="d-none d-sm-table-cell align-middle">
                                                <span class="fa-stack">
                                                    @if ($fixture->isPlayed() && !$fixture->isRated())
                                                        @if ($club->hasWon($fixture))
                                                            <i class="fa fa-circle fa-stack-2x text-success"></i>
                                                            <strong class="fa-stack-1x text-white">S</strong>
                                                        @elseif ($club->hasLost($fixture))
                                                            <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                            <strong class="fa-stack-1x text-white">N</strong>
                                                        @elseif ($club->hasDrawn($fixture))
                                                            <i class="fa fa-circle fa-stack-2x text-dark"></i>
                                                            <strong class="fa-stack-1x text-white">U</strong>
                                                        @endif
                                                    @elseif ($fixture->isRated())
                                                        <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                                        <strong class="fa-stack-1x text-white">R</strong>
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="align-middle text-left">
                                                @if ($fixture->datetime)
                                                    {{-- date --}}
                                                    <span class="d-inline d-md-none pr-1">{{ $fixture->datetime->format('d.m.') }}</span>
                                                    <span class="d-none d-md-inline px-1">{{ $fixture->datetime->format('d.m.y') }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-right">
                                                @if($fixture->clubHome)
                                                    <span class="pr-1">{{ $fixture->clubHome->name_short }}</span>
                                                    @if($fixture->clubHome->logo_url)
                                                        <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" width="30" class="d-none d-sm-inline-block">
                                                    @else
                                                        <span class="fa fa-ban text-muted d-none d-sm-inline-block" title="Kein Vereinswappen vorhanden"></span>
                                                    @endif
                                                @else
                                                    <span class="pr-1">{{ $fixture->club_home }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="rounded {{ $fixture->rescheduledTo || $fixture->isCancelled() ? "bg-light text-muted" : "bg-dark text-white" }} d-inline-block p-1" style="word-break: keep-all; width: 60px">
                                                    {{-- cancelled? --}}
                                                    @if($fixture->isCancelled())
                                                        <span class="text-danger">
                                                            @if ($fixture->isPlayed() && !$fixture->isRated())
                                                                {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                                            @elseif ($fixture->isRated())
                                                                {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                                            @else
                                                                Ann.
                                                            @endif
                                                         </span>
                                                    {{-- played and *not* rated? --}}
                                                    @elseif($fixture->isPlayed() && !$fixture->isRated())
                                                        {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                                    {{-- rated? --}}
                                                    @elseif($fixture->isRated())
                                                        <span class="text-warning">{{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}</span>
                                                    @else
                                                        -&nbsp;:&nbsp;-
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="align-middle text-left">
                                                @if($fixture->clubAway)
                                                    @if($fixture->clubAway->logo_url)
                                                        <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" width="30" class="d-none d-sm-inline-block">
                                                    @else
                                                        <span class="fa fa-ban text-muted d-none d-sm-inline-block" title="Kein Vereinswappen vorhanden"></span>
                                                    @endif
                                                    <span class="pl-1">{{ $fixture->clubAway->name_short }}</span>
                                                    @else
                                                    <span class="pl-1">{{ $fixture->club_away }}</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Spieldetails">
                                                    <span class="fa fa-fw fa-arrow-right"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            Keine zurückliegenden Spiele.
                        @endif
                    </div>
                    <div class="col-lg-6">
                        @php
                            $nextGames = $club->getNextGames(5)->load('clubHome','clubAway');
                        @endphp
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Demnächst</h2>
                        @if (!$nextGames->isEmpty())
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Datum</th>
                                        <th colspan="3" class="text-center">Paarung</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($nextGames as $fixture)
                                    <tr>
                                        <td class="align-middle text-left">
                                            @if ($fixture->datetime)
                                                {{-- date --}}
                                                <span class="d-inline d-md-none pr-1">{{ $fixture->datetime->format('d.m.') }}</span>
                                                <span class="d-none d-md-inline px-1">{{ $fixture->datetime->format('d.m.y') }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-right">
                                            @if($fixture->clubHome)
                                                {{ $fixture->clubHome->name_short }}
                                                @if($fixture->clubHome->logo_url)
                                                    <img src="{{ asset('storage/'.$fixture->clubHome->logo_url) }}" width="30" class="d-none d-sm-inline-block">
                                                @else
                                                    <span class="d-none d-sm-inline-block fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                            @else
                                                {{ $fixture->club_home }}
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($fixture->isPlayed())
                                                {{ $fixture->goals_home }} : {{ $fixture->goals_away }}
                                            @elseif($fixture->isRated())
                                                {{ $fixture->goals_home_rated }} : {{ $fixture->goals_away_rated }}
                                            @else
                                                - : -
                                            @endif
                                        </td>
                                        <td class="align-middle text-left">
                                            @if($fixture->clubAway)
                                                @if($fixture->clubAway->logo_url)
                                                    <img src="{{ asset('storage/'.$fixture->clubAway->logo_url) }}" width="30" class="d-none d-sm-inline-block">
                                                @else
                                                    <span class="d-none d-sm-inline-block fa fa-ban text-muted" title="Kein Vereinswappen vorhanden"></span>
                                                @endif
                                                {{ $fixture->clubAway->name_short }}
                                            @else
                                                {{ $fixture->club_away }}
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('frontend.fixtures.show', $fixture) }}" title="Spieldetails">
                                                <span class="fa fa-fw fa-arrow-right"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            Keine anstehenden Spiele.
                        @endif
                    </div>
                </div>
                @if ($club->note)
                    <div class="row mt-4">
                        <div class="col">
                            <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Notizen zum Club</h2>
                            <p>{{ $club->note }}</p>
                            {{-- TODO: stadiums --}}
                        </div>
                    </div>
                @endif
                @php
                    $players = $club->players()->active()->public()->get();
                @endphp
                @if (!$players->isEmpty())
                    <div class="row mt-2">
                        <div class="col">
                            <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $club->colours_club_primary }}">Gesperrte Spieler</h2>
                            <ul class="list-group border-danger">
                            @php
                                $suspended_players = false;
                            @endphp
                                @foreach ($players as $player)
                                    @if ($card = $player->isSuspended())
                                        <div class="alert alert-danger">
                                            {{ $player->person->first_name }} {{ $player->person->last_name }}
                                            wurde am <b>{{ $card->fixture->datetime ? $card->fixture->datetime->format('d.m.Y') : null }}</b>
                                            im Spiel <a href="{{ route('frontend.fixtures.show', $card->fixture) }}" class="text-danger" title="Spieldetails">{{ $card->fixture->clubHome ? $card->fixture->clubHome->name : null }} : {{ $card->fixture->clubAway ? $card->fixture->clubAway->name : null }}</a>
                                            für <b>{{ $card->ban_matches - $card->ban_reduced_by }}</b> Spiele gesperrt. Die Sperre gilt noch für <b>{{ $card->ban_remaining }}</b> weitere Spiele.
                                            @if ($card->ban_reason)
                                                Grund der Sperre: {{ $card->ban_reason }}
                                            @endif
                                        </div>
                                        @php
                                            $suspended_players = true;
                                        @endphp
                                    @endif
                                @endforeach
                                @unless ($suspended_players)
                                    <div class="alert alert-success">
                                        <span class="fa fa-check-circle-o"></span> Alle Spieler sind spielberechtigt.
                                    </div>
                                @endunless
                            </ul>
                        </div>
                    </div>
                @endif
                @auth
                    @php
                        $contacts = $club->contacts;
                    @endphp
                    <div class="row mt-2">
                        <div class="col">
                            <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $club->colours_club_primary }}">Ansprechpartner</h2>
                            <p class="text-muted">Nur für angemeldete Mitglieder sichtbar.</p>
                            @if (!$contacts->isEmpty())
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div class="col-1 font-weight-bold">
                                            <span class="font-weight-bold">#</span>
                                        </div>
                                        <div class="col-4">
                                            <span class="fa fa-user"></span>
                                        </div>
                                        <div class="col-4">
                                            <span class="fa fa-envelope"></span>
                                        </div>
                                        <div class="col-3 ">
                                            <span class="fa fa-phone"></span>
                                        </div>
                                    </li>
                                    @foreach ($club->contacts()->orderBy('hierarchy_level')->with('person')->get() as $contact)
                                        <li class="list-group-item d-flex justify-content-between">
                                            <div class="col-1 font-weight-bold">
                                                {{ $contact->hierarchy_level }}
                                            </div>
                                            <div class="col-4">
                                                {{ $contact->person->first_name }} {{ $contact->person->last_name }}
                                            </div>
                                            <div class="col-4">
                                                {{ $contact->mail }}
                                            </div>
                                            <div class="col-3 ">
                                                {{ $contact->mobile }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="alert alert-info">
                                    <span class="fa fa-info-circle"></span> Es wurden keine Ansprechpartner angegeben.
                                </div>
                            @endif
                        </div>
                    </div>
                @endauth
                {{--
                TODO: Stadion anzeigen?
                @if($club->regularStadium()->first())
                    <div class="row">
                        <div class="col-12">
                            <h4 class="font-weight-bold font-italic text-uppercase" style="color: {{ $club->colours_club_primary }}">Spielstätte</h4>
                                @if($club->regularStadium()->first()->lat && $club->regularStadium()->first()->long)
                                    <div id="map" style="width: 100%; height: 450px;"></div>
                                    <script>
                                        function initMap() {
                                            var uluru = {lat: {{ $club->regularStadium()->first()->lat }}, lng: {{ $club->regularStadium()->first()->long }}};
                                            var map = new google.maps.Map(document.getElementById('map'), {
                                                zoom: 18,
                                                center: uluru
                                            });
                                            var marker = new google.maps.Marker({
                                                position: uluru,
                                                map: map
                                            });
                                        }
                                    </script>
                                    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBKAZ6Ay4GdEqmP3gG6Zpp3kOyBSSa-Lc&callback=initMap">
                                    </script>
                                @endif
                        </div>
                    </div>
                @endif--}}
            </div>
            <!-- end home tab -->
            <!-- results tab -->
            <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="">
                <div class="row">
                    <div class="col-12">
                        <h2 class="font-weight-bold font-italic text-uppercase" style="color: {{ $primary_color }}">Resultate</h2>
                        <form class="form-inline pb-2">
                            <label class="pr-4" for="season-selection"><b>Saison</b></label>
                            <select id="season-selection" name="season-selection" class="form-control" aria-labelledby="">
                                @foreach($club->seasons()->published()->orderBy('end','desc')->get() as $club_season)
                                    <option {{ $club_season->id == $season->id ? "selected" : null }} value="{{ $club_season->id }}">{{ $club_season->name }} {{ $club_season->division ? "- ".$club_season->division->name : null }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="response">
                        @include('loader')
                    </div>
                </div>
            </div>
            <!-- end results tab -->
            <!-- players tab -->
            <div class="tab-pane fade" id="players" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-12">
                        @php
                            $active_players = $club->players()->active()->public()->with('person', 'goals.fixture.matchweek.season', 'cards.fixture.matchweek.season')->get()->sortBy('person.last_name');
                        @endphp
                        <h2 class="font-weight-bold" style="color: {{ $club->colours_club_primary }}">Aktive <span class="badge badge-secondary">{{ $active_players->count() }}</span></h2>
                        <div class="row my-1">
                            <div class="col text-muted">
                                Es sind nur Spieler mit einem gültigen Spielerpass der HLW spielberechtigt.
                            </div>
                        </div>
                        <div class="row mt-4 d-flex justify-content-center">
                            <div class="col">
                                <div class="card-deck">
                                    @foreach($active_players as $player)
                                        <div class="card {{ $player->isSuspended() ? "border-danger text-danger" : null }} text-center">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <h4 class="card-title font-weight-bold mb-0">
                                                        {{ $player->person->full_name_shortened }}
                                                        <span class="pull-right" style="color: {{ $club->colours_club_primary }}">{{ $player->number ? "#".$player->number : null }}</span>
                                                    </h4>
                                                    @if ($player->isSuspended())
                                                        <h6 class="card-subtitle my-1">
                                                            Spieler ist gesperrt
                                                        </h6>
                                                    @endif
                                                </li>
                                                <li class="list-group-item">
                                                    <p class="card-text">
                                                        <span class="fa fa-pencil-square-o"></span>
                                                        @if($player->sign_on)
                                                            {{ $player->sign_on->format('d.m.Y') }}
                                                            @if( Carbon::now()->diffInYears($player->sign_on) > 0 )
                                                                <br><small class="text-muted">{{ Carbon::now()->diffInYears($player->sign_on) == 1 ? Carbon::now()->diffInYears($player->sign_on)." Jahr" : Carbon::now()->diffInYears($player->sign_on)." Jahre" }} dabei</small>
                                                            @else
                                                                <br><small class="text-muted">{{ Carbon::now()->diffInDays($player->sign_on)}} Tage dabei</small>
                                                            @endif
                                                        @endif
                                                    </p>
                                                </li>
                                                <li class="list-group-item">
                                                    <ul class="list-unstyled">
                                                        @php
                                                            $goals_season = $player->goals->where('fixture.matchweek.season.id', $season->id )->count();
                                                            $cards_yr = $player->cards()->yellowReds()->with('fixture.matchweek.season')->get()->where('fixture.matchweek.season.id', $season->id)->count();
                                                            $cards_r = $player->cards()->reds()->with('fixture.matchweek.season')->get()->where('fixture.matchweek.season.id', $season->id)->count();
                                                        @endphp
                                                        <li>
                                                            Saison <b>{{ $season->name }}</b>
                                                            <ul class="list-inline">
                                                                <li class="list-inline-item"><span class="fa fa-soccer-ball-o fa-fw"></span> {{ $goals_season }}</li>
                                                                <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: orange;"></span> <b> {{ $cards_yr }}</b></li>
                                                                <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: red"></span> <b> {{ $cards_r }}</b></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="list-group-item">
                                                    Insgesamt
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item"><span class="fa fa-soccer-ball-o fa-fw"></span> <b>{{ $player->goals->count() }}</b></li>
                                                        <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: orange;"></span> <b>{{ $player->cards()->yellowReds()->count() }}</b></li>
                                                        <li class="list-inline-item"><span class="fa fa-clone fa-fw" style="color: red"></span> <b>{{ $player->cards()->reds()->count() }}</b></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                        @if ($loop->iteration % 2 == 0)
                                            <div class="w-100 my-2 d-block d-md-none"><!-- wrap every 2 below md --></div>
                                        @endif
                                        @if ($loop->iteration % 3 == 0)
                                            <div class="w-100 my-2 d-none d-md-block d-lg-none"><!-- wrap every 3 at md --></div>
                                        @endif
                                        @if ($loop->iteration % 4 == 0)
                                            <div class="w-100 my-2 d-none d-lg-block"><!-- wrap every 4 above md --></div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--@php
                    $inactive_players = $club->players()->inactive()->with('person', 'goals', 'cards')->get()->sortBy('person.last_name');
                @endphp
                @if(!$inactive_players->isEmpty())
                    <div class="row pt-4">
                        <div class="col-12">
                            <h2 style="color: {{ $club->colours_club_primary }}"><b>Ehemalige</b></h2>
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th class=""></th>
                                    <th class="">Eintritt</th>
                                    <th class="">Austritt</th>
                                    <th class="text-center"><span class="fa fa-soccer-ball-o fa-fw"></span></th>
                                    <th class="text-center"><span class="fa fa-clone fa-fw" style="color: orange"></span></th>
                                    <th class="text-center"><span class="fa fa-clone fa-fw" style="color: red"></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($inactive_players as $inactive_player)
                                    <tr>
                                        <td class="align-middle">{{ $inactive_player->person->full_name_shortened }}</td>
                                        <td class="align-middle">{{ $inactive_player->sign_on ? $inactive_player->sign_on->format('d.m.Y') : null }}</td>
                                        <td class="align-middle">{{ $inactive_player->sign_off ? $inactive_player->sign_off->format('d.m.Y') : null}}</td>
                                        <td class="align-middle text-center">{{ $inactive_player->goals->count() }}</td>
                                        <td class="align-middle text-center">{{ $inactive_player->cards()->yellowReds()->count() }}</td>
                                        <td class="align-middle text-center">{{ $inactive_player->cards()->reds()->count() }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif--}}
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-footer')

    <script>

        // get the results of a club for the specified season
        function getResults(season){
            $.ajax({
                method:     'GET',
                url:        '/clubs/{{ $club->id }}/ajax-club-results',
                data:       {'season_id' : season},

                success: function(response){
                    $('#response').html(response);
                },
                error: function(jqXHR, textStatus, errorThrown){
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }

        //
        $(function() {
            // get the results for the current season
            getResults();

            $('#season-selection').change(function () {
                // add loading indicator back
                $('#response').html(@include('loader'));
                // get results of selected season
                getResults($(this).val());

            });
        });

    </script>

@endsection
