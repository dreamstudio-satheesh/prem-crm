<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <input wire:model.debounce.300ms="search" type="text" class="form-control w-50" placeholder="Search Issue...">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#issueModal" wire:click="create">Add New Issue</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($issues as $issue)
                        <tr>
                            <td>{{ $issue->id }}</td>
                            <td>{{ $issue->name }}</td>
                            <td>{{ $issue->description }}</td>
                            <td>
                                <button wire:click="edit({{ $issue->id }})" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#issueModal">Edit</button>
                                <button wire:click="delete({{ $issue->id }})" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $issues->links() }}
        </div>
    </div>

    <!-- Modal for Add/Edit Issue -->
    <div wire:ignore.self class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="issueModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="issueModalLabel">{{ $issue_id ? 'Edit Issue' : 'Create Issue' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" wire:model="name" class="form-control" placeholder="Enter Name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea wire:model="description" class="form-control" placeholder="Enter Description"></textarea>
                            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for modal and alerts -->
    @push('scripts')
        <script>
            window.addEventListener('show-form', event => {
                $('#issueModal').modal('show');
            });
            window.addEventListener('hide-form', event => {
                $('#issueModal').modal('hide');
            });
        </script>
    @endpush
</div>
