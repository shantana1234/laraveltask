<section>
    <header class="mb-3">
        <p class="text-muted">
            Update your account's profile information and email address.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="row g-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Name</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning mt-2">
                        <small>
                            Your email address is unverified.
                            <button form="send-verification" class="btn btn-link p-0 text-decoration-underline">
                                Click here to re-send the verification email.
                            </button>
                        </small>

                        @if (session('status') === 'verification-link-sent')
                            <div class="text-success mt-1">
                                <small>A new verification link has been sent to your email address.</small>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">Phone Number</label>
                <input id="phone" name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
                       value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" 
                          rows="3" autocomplete="street-address">{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Save
                </button>

                @if (session('status') === 'profile-updated')
                    <span class="text-success ms-2">
                        <i class="fas fa-check me-1"></i>Saved.
                    </span>
                @endif
            </div>
        </div>
    </form>
</section>
