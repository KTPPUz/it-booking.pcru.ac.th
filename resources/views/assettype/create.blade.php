<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="assetTypeModalLabel">เพิ่มข้อมูลประเภทอุปกรณ์</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('assettype.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="type_name">ชื่อ</label>
                    <input type="text" name="type_name" id="type_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">คำอธิบาย</label>
                    <textarea name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="status">สถานะ</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="1"><span class="badge  badge text-white bg-success">เปิดใช้งาน</span>
                        </option>
                        <option value="0"><span class="badge  badge text-white bg-success">ปิดใช้งาน</span>
                        </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
            </form>
        </div>
    </div>
</div>
