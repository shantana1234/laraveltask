<x-app-layout>
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-user-edit me-2"></i>Profile Settings
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Update Profile Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user me-2"></i>Profile Information
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-lock me-2"></i>Update Password
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 text-danger">
                            <i class="fas fa-trash me-2"></i>Delete Account
                        </h5>
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
