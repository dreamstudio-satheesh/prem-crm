<div>
    <div class="row">
        <div style="padding-left:30px;" class="col-md-8 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header">
                    <div class="row d-flex align-items-center" style="padding-top: 20px; padding-left:20px;">
                        <div class="col-md-4">
                            <h2>Industry Master</h2>
                        </div>

                        <div class="col-md-4 d-flex justify-content-end">
                            <button wire:click="export" class="btn btn-sm btn-success ml-2"><i class="ri-file-upload-line align-bottom me-1"></i> Export</button>
                        </div>

                        <div class="col-md-4 d-flex justify-content-end">
                            <input wire:model.debounce.300ms="search" id="search-box" type="text" class="form-control" placeholder="Search Industry..">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div style="padding-top: 10px">
                        <table class="table table-bordered mt-5">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($industries->count() > 0)
                                @foreach ($industries as $industry)
                                <tr>
                                    <td>{{ ($industries->currentPage() - 1) * $industries->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $industry->name }}</td>
                                    <td>{{ $industry->description }}</td>
                                    <td>
                                        <button wire:click="edit({{ $industry->id }})" class="btn btn-primary btn-sm">Edit</button>
                                        <button x-data="{ unitId: {{ $industry->id }} }" @click="confirmDeletion(unitId)" class="btn btn-danger btn-sm">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">
                                        <h5>No Industry found</h5>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>{{ $industries->links() }}</div>
                            <div class="text-right">Total: {{ $industries->total() }}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="card" style="height: 80vh; overflow-y: auto;">
                <div class="card-header card-header-border-bottom d-flex justify-content-between">
                    <h5>{{ $industry_id ? 'Edit Industry' : 'Create Industry' }}</h5>
                    <button type="button" class="btn btn-sm btn-info ml-2" data-bs-toggle="modal" data-bs-target="#importModal"><i class="ri-file-download-line align-bottom me-1"></i> Import</button>
                </div>
                <div class="card-body" style="padding-top: 10px">
                    <form wire:submit.prevent="store">
                        <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" class="form-control" id="name" autofocus placeholder="Enter Industry name" wire:model="name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" placeholder="Enter description" wire:model="description"></textarea>
                            @error('description')
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

    <!-- Import Modal -->
    <div class="modal fade" wire:ignore.self id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Industries</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="importForm" wire:submit.prevent="import">
                        <div class="form-group">
                            <label for="file">Upload CSV File</label>
                            <input type="file" class="form-control" id="file" wire:model="upload_file">
                            @error('upload_file')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Import</button>
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
                    Swal.fire('Deleted!', 'Industry Deleted Successfully.', 'success');
                }
            });
        }

        document.addEventListener('close-modal', event => {
            var modal = $('#importModal');
            modal.modal('hide');
        });

        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('show-toastr', event => {
                toastr.options = {
                    closeButton: true,
                    positionClass: "toast-top-right",
                };
                const detail = event.detail[0];
                if (detail && detail.message) {
                    toastr.success(detail.message);
                }
            });
        });
    </script>
    @endpush
</div>