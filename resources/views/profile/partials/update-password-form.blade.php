<section>
    <header class="mb-3">
        <p class="text-muted">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="row g-3">
            <div class="col-12">
                <label for="update_password_current_password" class="form-label">Current Password</label>
                <input id="update_password_current_password" name="current_password" type="password" 
                       class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                       autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="update_password_password" class="form-label">New Password</label>
                <input id="update_password_password" name="password" type="password" 
                       class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                       autocomplete="new-password">
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                       class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                       autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Save
                </button>

                @if (session('status') === 'password-updated')
                    <span class="text-success ms-2">
                        <i class="fas fa-check me-1"></i>Saved.
                    </span>
                @endif
            </div>
        </div>
    </form>
</section>
