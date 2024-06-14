<!-- resources/views/livewire/user-master.blade.php -->
<div>
    <div class="row">
        <div style="padding-left:30px;" class="col-md-8 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header">
                    <div class="row" style="padding-top: 20px; padding-left:20px;">
                        <div class="col-md-8">
                            <h2>User Master</h2>
                        </div>
                        <div class="col-md-4 text-right">
                            <input wire:model.debounce.300ms="search" id="search-box" type="text" class="form-control" placeholder="Search Users...">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div style="padding-top: 10px">
                        <table class="table table-bordered mt-5">
                            @if ($users->count() > 0)
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <button wire:click="edit({{ $user->id }})" class="btn btn-primary btn-sm">Edit</button>
                                        <button x-data="{ unitId: {{ $user->id }} }" @click="confirmDeletion(unitId)" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @else
                            <tr>
                                <td colspan="5">
                                    <h5>No users found</h5>
                                </td>
                            </tr>
                            @endif
                        </table>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>{{ $users->links() }}</div>
                            <div class="text-right">Total: {{ $users->total() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                    <h5>{{ $user_id ? 'Edit User' : 'Create User' }}</h5>
                </div>
                <div class="card-body" style="padding-top: 10px">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" autofocus placeholder="Enter user name" wire:model="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email*</label>
                            <input type="email" class="form-control" placeholder="Enter email" wire:model="email">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role*</label>
                            <select class="form-control" wire:model="role">
                                <option value="">Select Role</option>
                                <option value="Admin">Admin</option>
                                <option value="Sales">Sales</option>
                                <option value="Support">Support</option>
                            </select>
                            @error('role')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password*</label>
                            <input type="password" class="form-control" placeholder="Enter password" wire:model="password">
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password*</label>
                            <input type="password" class="form-control" placeholder="Confirm password" wire:model="password_confirmation">
                            @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" wire:click="create" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDeletion(unitId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', unitId);
                    Swal.fire('Deleted!', 'User Deleted Successfully.', 'success');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('show-toastr', event => {
                toastr.options = {
                    closeButton: true,
                    positionClass: "toast-top-right",
                };
                toastr.success(event.detail.message);
            });
        });
    </script>
    @endpush
</div>