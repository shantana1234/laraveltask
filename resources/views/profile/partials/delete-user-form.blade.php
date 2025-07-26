<section>
    <header class="mb-3">
        <p class="text-muted">
            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirm-user-deletion">
        <i class="fas fa-trash me-1"></i>Delete Account
    </button>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="confirm-user-deletion" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Are you sure you want to delete your account?
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    <div class="modal-body">
                        @csrf
                        @method('delete')

                        <p class="text-muted mb-3">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" name="password" type="password" 
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   placeholder="Password" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i>Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
