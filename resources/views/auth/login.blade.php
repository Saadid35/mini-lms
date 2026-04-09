<x-guest-layout>

    @if(session('status'))
        <div class="alert alert-success mb-3" role="alert">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="prenom.nom@cfm.fr" required autofocus autocomplete="username">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="••••••••" required autocomplete="current-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                <label for="remember_me" class="form-check-label small text-muted">Se souvenir de moi</label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small" style="color:#003f87;">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-cfm-primary btn">
            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
        </button>
    </form>

</x-guest-layout>
