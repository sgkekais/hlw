Klicke hier, um deine Registrierung zu bestätigen:
<a href="{{ $link = route('email-verification.check', $user->verification_token) . '?email=' . urlencode($user->email) }}">{{ $link }}</a>
