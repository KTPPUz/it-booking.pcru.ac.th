<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editassetGroupModalLabel">แก้ไขข้อมูลประเภทอุปกรณ์</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('assetgroup.update', $assetGroup->group_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="group_name">Group Name:</label>
                    <input type="text" name="group_name" id="group_name" class="form-control"
                        value="{{ $assetGroup->group_name }}" required>
                </div>
                <div class="form-group">
                    <label for="asset_type_id">Asset Type ID:</label>
                    {{-- <input type="number" name="asset_type_id" id="asset_type_id" class="form-control"
                        value="{{ $assetGroup->asset_type_id }}" required> --}}
                    <select name="asset_type_id" id="asset_type_id" class="form-control" required>
                        @foreach ($assettypes as $assetType)
                            <option value="{{ $assetType->type_id }}"
                                {{ $assetType->type_id == $assetGroup->asset_type_id ? 'selected' : '' }}>
                                {{ $assetType->type_name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group">
                    <label for="group_status">Status:</label>
                    <select name="group_status" id="group_status" class="form-control" required>
                        <option value="1" {{ $assetGroup->group_status == 1 ? 'selected' : '' }}>เปิดใช้งาน
                        </option>
                        <option value="0" {{ $assetGroup->group_status == 0 ? 'selected' : '' }}>ปิดใช้งาน</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="specifications">Specifications:</label>
                    <textarea name="specifications" id="specifications" class="form-control">{{ $assetGroup->specifications }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
