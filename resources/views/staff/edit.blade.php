<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editstaffModalLabel">แก้ไขข้อมูลเจ้าหน้าที่</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('staff.update', $user->staff_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">ชื่อ</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">อีเมล</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}"
                        required>
                </div>
                <div class="md-3">
                    <label for="type_id" class="form-label">ประเภทเจ้าหน้าที่</label>
                    <select name="type_id" class="form-select" id="type_id" required>
                        @foreach ($stafftypes as $type)
                            <option value="{{ $type->staff_type_id }}"
                                {{ $type->staff_type_id == $user->type_id ? 'selected' : '' }}>
                                {{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">รหัสผ่าน (ปล่อยว่างถ้าไม่ต้องการเปลี่ยน)</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-success">บันทึก</button>
            </form>
        </div>
    </div>
</div>
