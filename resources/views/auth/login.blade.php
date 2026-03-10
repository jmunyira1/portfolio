<x-guest-layout>
    @section('title', 'Sign In')

    <div class="card">

        <div class="card-header text-center border-0 pt-4 pb-0">
            <h4 class="fw-bold mb-1">Sign In</h4>
            <p class="text-muted mb-0">Enter your credentials to access the admin panel.</p>
        </div>

        <div class="card-body p-4">

            {{-- Session status (e.g. password reset link sent) --}}
            @if (session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="admin@example.com"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label for="password" class="form-label">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-muted fs-12">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Sign In
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-guest-layout>
