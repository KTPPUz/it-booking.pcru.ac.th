<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staffCModalLabel">เพิ่มข้อมูลเจ้าหน้าที่</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('staff.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">ชื่อ</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">อีเมล</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="type_id" class="form-label">ประเภทเจ้าหน้าที่</label>
                    <select name="type_id" class="form-select" id="type_id" required>
                        @foreach ($stafftypes as $type)
                            <option value="{{ $type->staff_type_id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <!-- <div class="mb-3">
                        <label for="department_id" class="form-label">แผนก</label>
                        <input type="text" name="department_id" class="form-control" id="department_id">
                    </div>
                    <div class="mb-3">
                        <label for="sect_id" class="form-label">สาขา</label>
                        <input type="text" name="sect_id" class="form-control" id="sect_id">
                    </div> -->
                <button type="submit" class="btn btn-success">บันทึก</button>
            </form>
        </div>
    </div>
</div>
