<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editRoomModalLabel">แก้ไขข้อมูลห้อง</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <form action="{{ route('rooms.update', $room->room_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="room_name" class="form-label">ชื่อห้อง</label>
                    <input type="text" class="form-control" id="room_name" name="room_name"
                        value="{{ old('room_name', $room->room_name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="room_type" class="form-label">ประเภทห้อง</label>
                    <select class="form-control" name="room_type" id="room_type" required>
                        <option value="" disabled>เลือกประเภทห้อง</option>
                        @foreach ($roomtypes as $type)
                            <option value="{{ $type->type_id }}"
                                {{ $type->type_id == $room->room_type ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="capacity" class="form-label">ความจุ</label>
                    <input type="number" class="form-control" id="capacity" name="capacity"
                        value="{{ old('capacity', $room->capacity) }}" min="1" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">คำอธิบาย</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $room->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">สถานะ</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="0" {{ $room->status == 0 ? 'selected' : '' }}>พร้อมใช้งาน</option>
                        <option value="1" {{ $room->status == 1 ? 'selected' : '' }}>ไม่พร้อมใช้งาน</option>
                    </select>
                </div>

                <!-- Image upload field -->
                <div class="mb-3">
                    <label for="room_pic" class="form-label">รูปภาพ</label>
                    <input type="file" name="room_pic[]" id="room_pic" class="form-control" multiple
                        onchange="previewImages(event)">
                </div>

                <!-- Image Gallery -->
                <div id="image-gallery" style="display: flex; flex-wrap: wrap; gap: 10px;">
                    @if ($room->room_pic)
                        @php
                            $images = json_decode($room->room_pic, true);
                        @endphp
                        @if (is_array($images) && !empty($images))
                            @foreach ($images as $image)
                                <img class="image-preview" src="{{ asset('images/' . $image) }}" alt="Room Image"
                                    width="150px" style="margin: 5px;">
                            @endforeach
                        @endif
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>

            <script>
                function previewImages(event) {
                    const imageGallery = document.getElementById('image-gallery');
                    const files = event.target.files;

                    imageGallery.innerHTML = '';

                    const existingImages = @json($images);
                    if (existingImages.length > 0) {
                        existingImages.forEach(image => {
                            const imgElement = document.createElement('img');
                            imgElement.src = `{{ asset('images/') }}/${image}`;
                            imgElement.alt = 'Existing Room Image';
                            imgElement.width = 150;
                            imgElement.style.margin = '5px';
                            imgElement.classList.add('image-preview');

                            imageGallery.appendChild(imgElement);
                        });
                    }

                    if (files.length > 0) {
                        for (let i = 0; i < files.length; i++) {
                            const file = files[i];
                            const reader = new FileReader();

                            reader.onload = function(e) {
                                const imgElement = document.createElement('img');
                                imgElement.src = e.target.result;
                                imgElement.alt = 'New Image Preview';
                                imgElement.width = 150;
                                imgElement.style.margin = '5px';
                                imgElement.classList.add('image-preview');

                                imageGallery.appendChild(imgElement);
                            };

                            reader.readAsDataURL(file);
                        }
                    }
                }
            </script>

        </div>
    </div>
</div>
