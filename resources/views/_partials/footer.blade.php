
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row pt-4 pb-4">
            <div class="col-md-2">
                <h5 class="font-weight-bold">HLW</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" title="zur Startseite">Home</a></li>
                    @foreach (\HLW\Division::published()->orderBy('name')->get() as $division)
                        <li><a href="{{ route('frontend.divisions.show', $division) }}" title="zur Spielklasse">{{ $division->name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('chatter.home') }}" title="zur Schänke">Schänke</a></li>
                    <li><a href="{{ route('infos') }}" title="Satzung, Vorstand, Infos">Infos</a></li>
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
                    Schaut auf der <a href="{{ route('infos') }}#join" title="zur Info-Seite"> Info-Seite nach!</a>
                </p>
            </div>
            <div class="col-md-4">
                <h5 class="font-weight-bold">Social Media</h5>
                <ul class="list-unstyled">
                    <li><span class="fa fa-fw fa-facebook"></span> <a href="https://www.facebook.com/HobbyligaWest/" title="Facebook" target="_blank">HLW auf Facebook</a> <span class="fa fa-external-link"></span> </li>
                    <li><span class="fa fa-fw fa-twitter"></span> <a href="https://twitter.com/HobbyligaWest" title="Twitter" target="_blank">HLW auf Twitter</a> <span class="fa fa-external-link"></span></li>
                    <li><span class="fa fa-fw fa-envelope"></span> vorstand [AT] hobbyligawest [DOT] de</li>
                </ul>
                <a href="{{ route('login') }}" title="Anmelden">Login</a> |
                <a href="{{ route('register') }}" title="Registrieren">Registrieren</a>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12 text-right">
                <a href="{{ route('imprint') }}" title="Impressum">Impressum</a> | &copy; {{ date('Y') }} &ndash; Hobbyliga-West Düsseldorf
            </div>
        </div>
    </div>
</footer>



