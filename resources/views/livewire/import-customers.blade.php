<div>
    <form wire:submit.prevent="uploadAndPrepareImport">
        <div class="form-group">
            <label for="file">Upload File</label>
            <input type="file" class="form-control" id="file" wire:model="upload_file">
            @error('upload_file')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Prepare Import</button>
    </form>

    @if ($previewData)
        <table class="table mt-5">
            <thead>
                <tr>
                    @foreach($headers as $header)
                        <th>
                            {{ $header }}
                            <select wire:model.lazy="selectedMappings.{{ $header }}">
                                <option value="">Select Field</option>
                                @foreach($columnOptions as $field => $label)
                                    <option value="{{ $field }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($previewData as $row)
                    <tr>
                        @foreach($row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button wire:click="setUserMappings" class="btn btn-success">Confirm Mappings</button>
        <button wire:click="importData" class="btn btn-info">Import Data</button>
        <button wire:click="resetPreview" class="btn btn-secondary">Reset</button>
    @endif
</div>
