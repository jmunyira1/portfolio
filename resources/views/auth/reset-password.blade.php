<x-guest-layout>
    @section('title', 'New Password')

    <div class="card">

        <div class="card-header text-center border-0 pt-4 pb-0">
            <h4 class="fw-bold mb-1">Create New Password</h4>
            <p class="text-muted mb-0">Your new password must be different from previous ones.</p>
        </div>

        <div class="card-body p-4">

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $request->email) }}"
                        class="form-control @error('email') is-invalid @enderror"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Min. 8 characters"
                        required
                        autocomplete="new-password"
                    >
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Repeat new password"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Reset Password
                    </button>
                </div>

            </form>

        </div>
    </div>

</x-guest-layout>
