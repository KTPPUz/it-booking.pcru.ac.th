<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="assetGroupCModalLabel">เพิ่มข้อมูลกลุ่มอุปกรณ์</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('assetgroup.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="group_name">ชื่อ</label>
                    <input type="text" name="group_name" id="group_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="asset_type_id">ประเภทอุปกรณ์</label>
                    <select name="asset_type_id" id="asset_type_id" class="form-control" required>
                        @foreach ($assettypes as $assetType)
                            <option value="{{ $assetType->asset_type_id }}">{{ $assetType->type_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="group_status">สถานะ</label>
                    <select name="group_status" id="group_status" class="form-control" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="specifications">ข้อมูล</label>
                    <textarea name="specifications" id="specifications" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
