<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editassetGroupModalLabel">แก้ไขข้อมูลประเภทอุปกรณ์</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('assets.update', $asset->asset_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="group_id">Group ID:</label>
                    {{-- <input type="number" name="group_id" id="group_id" class="form-control"
                        value="{{ $asset->group_id }}" required> --}}
                    <select name="group_id" id="group_id" class="form-control" required>
                        <option value="">-- Select Group --</option>
                        @foreach ($assetgroups as $assetGroup)
                            <option value="{{ $assetGroup->group_id }}"
                                {{ $asset->group_id == $assetGroup->group_id ? 'selected' : '' }}>
                                {{ $assetGroup->group_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="asset_ac_id">Academic Equipment ID:</label>
                    <input type="text" name="asset_ac_id" id="asset_ac_id" class="form-control"
                        value="{{ $asset->asset_ac_id }}" required>
                </div>
                <div class="form-group">
                    <label for="asset_status">Status:</label>
                    <select name="asset_status" id="asset_status" class="form-control" required>
                        <option value="1" {{ $asset->asset_status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $asset->asset_status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="asset_note">Note:</label>
                    <textarea name="asset_note" id="asset_note" class="form-control">{{ $asset->asset_note }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
