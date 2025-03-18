<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createRoomModalLabel">เพิ่มข้อมูลห้อง</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="room_name" class="form-label">ชื่อห้อง</label>
                    <input type="text" class="form-control" id="room_name" name="room_name" required>
                </div>

                <div class="mb-3">
                    <label for="room_type" class="form-label">ประเภทห้อง</label>
                    <select class="form-control" name="room_type" id="room_type" required>
                        <option value="" selected>เลือกประเภทห้อง</option>
                        @foreach ($roomtypes as $room)
                            <option value="{{ $room->type_id }}">{{ $room->name }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3">
                    <label for="capacity" class="form-label">ความจุ</label>
                    <input type="text" class="form-control" id="capacity" name="capacity" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">คำอธิบาย</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>


                <div class="mb-3">
                    <label for="room_pic" class="form-label">รูปภาพ</label>
                    <input type="file" name="room_pic[]" id="roompic" class="form-control" multiple
                        onchange="previewImages(event)">
                </div>

                <img id="image-preview" alt="Image Preview" width="150px" style="display: none;">
                <div id="previewContainer" class="mt-3"></div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>

            <script>
                function previewImages(event) {
                    const files = event.target.files;
                    const previewContainer = document.getElementById('previewContainer');
                    previewContainer.innerHTML = '';

                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '100px';
                            img.style.marginRight = '10px';
                            previewContainer.appendChild(img);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            </script>
        </div>
    </div>
</div>
