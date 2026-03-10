<x-guest-layout>
    @section('title', 'Reset Password')

    <div class="card">

        <div class="card-header text-center border-0 pt-4 pb-0">
            <h4 class="fw-bold mb-1">Reset Password</h4>
            <p class="text-muted mb-0">Enter your email and we'll send you a reset link.</p>
        </div>

        <div class="card-body p-4">

            @if (session('status'))
                <div class="alert alert-success mb-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

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
                    >
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        Send Reset Link
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-muted fs-13">
                        <i class="ti ti-arrow-left me-1"></i> Back to Sign In
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-guest-layout>
