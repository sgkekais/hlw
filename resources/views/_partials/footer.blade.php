
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row pt-4 pb-4">
            <div class="col-md-2">
                <h5 class="font-weight-bold">HLW</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" title="zur Startseite">Home</a></li>
                    @foreach (\HLW\Division::published()->orderBy('name')->get() as $division)
                        <li><a href="{{ route('frontend.divisions.show', $division) }}" title="zur Spielklasse">{{ $division->competition->name_short }} {{ $division->name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('chatter.home') }}" title="zum Clubhaus">Clubhaus</a></li>
                    <li><a href="{{ route('frontend.static.infos') }}" title="Satzung, Vorstand, Infos">Infos</a></li>
                    <li><a href="{{ route('frontend.static.halloffame') }}" title="Ruhmeshalle">Ruhmeshalle</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5 class="font-weight-bold">Hobbyliga-West Düsseldorf </h5>
                <p class="">
                    &ndash; Die Fußballliga für Hobby- und Freizeitmannschaften aus Düsseldorf und Umgebung.
                </p>
                <h5 class="font-weight-bold">
                    Ihr wollt mitmachen?
                </h5>
                <p class="">
                    Schaut auf der <a href="{{ route('frontend.static.infos') }}#join" title="zur Info-Seite"> Info-Seite nach!</a>
                </p>
                <h5 class="font-weight-bold">
                    Ihr sucht einen Verein?
                </h5>
                <p>
                    Registriert euch und postet unter 'Börse' im Clubhaus!
                </p>
            </div>
            <div class="col-md-4">
                <h5 class="font-weight-bold">Social Media</h5>
                <ul class="list-unstyled">
                    <li><span class="fa fa-fw fa-facebook"></span> <a href="https://www.facebook.com/HobbyligaWest/" title="Facebook" target="_blank">HLW auf Facebook</a> <span class="fa fa-external-link"></span> </li>
                    <li><span class="fa fa-fw fa-twitter"></span> <a href="https://twitter.com/HobbyligaWest" title="Twitter" target="_blank">HLW auf Twitter</a> <span class="fa fa-external-link"></span></li>
                    <li><span class="fa fa-fw fa-envelope"></span> vorstand [AT] hobbyligawest [DOT] de</li>
                </ul>
                <h5 class="font-weight-bold">Freunde</h5>
                <ul class="list-unstyled">
                    <li><img src="{{ asset('storage/bsgligalogooriginal.png') }}" class="bg-white rounded" height="50"> <a href="http://www.bsgdbuv-cup.de/" target="_blank" class="pl-2" title="zur Kleinfeld-Liga Düsseldorf">Kleinfeld-Liga Düsseldorf</a> <span class="fa fa-fw fa-external-link"></span></li>
                </ul>
                <span class="pull-right">
                    @guest
                        <a href="{{ route('login') }}" title="Anmelden">Login</a> |
                        {{--<a href="{{ route('register') }}" title="Registrieren">Registrieren</a>--}}
                    @endguest
                    @auth
                        <a href="{{ route('frontend.user.profile.show') }}" title="Profil">Profil</a> |
                        <a href="{{ route('logout') }}" title="Abmelden">Logout</a>
                    @endauth
                </span>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12 text-right">
                <a href="{{ route('frontend.static.datenschutz') }}" title="Datenschutzerklärung">Datenschutz</a> |
                <a href="{{ route('frontend.static.imprint') }}" title="Impressum">Impressum</a> | &copy; {{ date('Y') }} &ndash; Hobbyliga-West Düsseldorf
            </div>
        </div>
    </div>
</footer>



