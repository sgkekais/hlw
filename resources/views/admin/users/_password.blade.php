<div class="form-group row">
    <label for="password" class="form-control-label col-md-2">{{ $required ? 'Passwort' : 'Neues Passwort' }}</label>
    <div class="col-md-4">
        <input type="password" class="form-control" name="password" id="password" autocomplete="new-password" aria-describedby="passwordHelp" {{ $required ? 'required' : null }}>
        <small id="passwordHelp" class="form-text text-muted">
            Mindestens 12 Zeichen.{{ $required ? null : ' Leer lassen, um das Passwort nicht zu ändern.' }}
        </small>
        @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
    </div>
</div>
<div class="form-group row">
    <label for="password_confirmation" class="form-control-label col-md-2">Passwort wiederholen</label>
    <div class="col-md-4">
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" autocomplete="new-password" {{ $required ? 'required' : null }}>
    </div>
</div>
