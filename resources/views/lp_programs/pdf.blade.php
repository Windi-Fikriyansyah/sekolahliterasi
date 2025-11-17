@extends('template.app')
@section('title', 'Atur Section')

@section('content')
    <div class="page-content">

        <div class="row">

            <!-- ONLY RIGHT SIDE (TABS) -->
            <div class="col-md-12">
                <div class="card shadow-sm p-4">

                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="fw-bold">Section Tabs</h4>
                        <button id="addTabBtn" class="btn btn-success">+ Tambah Section</button>
                    </div>

                    <ul id="sortableList" class="list-group">

                        {{-- Jika ADA DATA DI DATABASE --}}
                        @if (isset($sections) && count($sections) > 0)

                            @php $tabCounter = 1; @endphp

                            @foreach ($sections as $sec)
                                <li class="list-group-item draggable" draggable="true" data-id="{{ $sec->id }}">


                                    <div class="d-flex justify-content-between align-items-start">

                                        <div style="flex:1">

                                            <label class="fw-bold">Nama Section</label>
                                            <input type="text" class="form-control tab-title"
                                                value="{{ $sec->nama_section ?? 'Section ' . $tabCounter }}">


                                            <div class="mt-3">
                                                <label class="fw-bold">Jenis File</label>
                                                <div class="d-flex gap-4">
                                                    <label>
                                                        <input type="radio" name="fileType_{{ $tabCounter }}"
                                                            value="pdf" {{ $sec->type_file == 'pdf' ? 'checked' : '' }}>
                                                        PDF
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="fileType_{{ $tabCounter }}"
                                                            value="video"
                                                            {{ $sec->type_file == 'video' ? 'checked' : '' }}>
                                                        Video
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <label class="fw-bold">File Saat Ini</label><br>

                                                @if ($sec->file)
                                                    <a target="_blank" href="{{ asset('storage/' . $sec->file) }}"
                                                        class="text-primary">
                                                        {{ basename($sec->file) }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Belum ada file</span>
                                                @endif

                                                <div class="mt-2">
                                                    <label class="fw-bold">Unggah File Baru</label>
                                                    <input type="file" class="form-control file-input">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="ms-3 text-end">
                                            <span class="bi bi-list handle" style="font-size:20px; cursor:grab"></span><br>
                                            <button class="btn btn-danger btn-sm mt-2 deleteTabBtn">&times;</button>
                                        </div>

                                    </div>

                                </li>
                                @php $tabCounter++; @endphp
                            @endforeach


                            {{-- Jika TIDAK ADA DATA --}}
                        @else
                            <li class="list-group-item draggable" draggable="true" data-id="">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div style="flex:1">
                                        <label class="fw-bold">Nama Section</label>
                                        <input type="text" class="form-control tab-title" value="Section 1">

                                        <div class="mt-3">
                                            <label class="fw-bold">Jenis File</label>
                                            <div class="d-flex gap-4">
                                                <label>
                                                    <input type="radio" name="fileType_1" value="pdf" checked> PDF
                                                </label>
                                                <label>
                                                    <input type="radio" name="fileType_1" value="video"> Video
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label class="fw-bold">Upload File *</label>
                                            <input type="file" class="form-control file-input">
                                        </div>
                                    </div>

                                    <div class="ms-3 text-end">
                                        <span class="bi bi-list handle" style="font-size:20px; cursor:grab"></span><br>
                                        <button class="btn btn-danger btn-sm mt-2 deleteTabBtn">&times;</button>
                                    </div>

                                </div>
                            </li>
                        @endif

                    </ul>


                    <button id="saveAllBtn" class="btn btn-primary mt-4 w-100">Simpan Semua</button>

                </div>
            </div>

        </div>
    </div>

    <div id="loadingOverlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
 background:rgba(0,0,0,0.4); z-index:9999; backdrop-filter:blur(2px);
 align-items:center; justify-content:center;">


        <div class="spinner-border text-light" role="status" style="width:4rem; height:4rem;">
        </div>
    </div>

@endsection


@push('style')
    <style>
        .draggable {
            cursor: grab;
        }

        .handle {
            font-size: 20px;
            cursor: grab;
        }

        .tab-title {
            width: 50%;
        }
    </style>
@endpush


@push('js')
    <script>
        let tabCounter = {{ isset($sections) ? count($sections) + 1 : 2 }};


        // ===================== ADD NEW TAB =====================
        document.getElementById("addTabBtn").addEventListener("click", function() {

            let li = document.createElement("li");
            li.className = "list-group-item draggable";
            li.setAttribute("draggable", "true");

            li.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
            <div style="flex:1">

                <label class="fw-bold">Nama Section</label>
                <input type="text" class="form-control tab-title" value="Section ${tabCounter}">

                <div class="mt-3">
                    <label class="fw-bold">Jenis File</label>
                    <div class="d-flex gap-4">
                        <label>
                            <input type="radio" name="fileType_${tabCounter}" value="pdf" checked> PDF
                        </label>
                        <label>
                            <input type="radio" name="fileType_${tabCounter}" value="video"> Video
                        </label>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="fw-bold">Upload File *</label>
                    <input type="file" class="form-control file-input"> <!-- EMPTY (RESET) -->
                </div>

            </div>

            <div class="ms-3 text-end">
                <span class="bi bi-list handle" style="font-size:20px; cursor:grab"></span><br>
                <button class="btn btn-danger btn-sm mt-2 deleteTabBtn">&times;</button>
            </div>
        </div>
    `;

            document.getElementById("sortableList").appendChild(li);
            tabCounter++;

            enableDeleteButtons();
            enableDragDrop();
        });


        // ===================== DELETE TAB =====================
        function enableDeleteButtons() {
            document.querySelectorAll(".deleteTabBtn").forEach(btn => {
                btn.onclick = function() {

                    if (document.querySelectorAll("#sortableList li").length === 1) {
                        alert("Minimal harus ada 1 section!");
                        return;
                    }
                    this.closest("li").remove();
                };
            });
        }
        enableDeleteButtons();


        // ===================== DRAG & DROP =====================
        function enableDragDrop() {
            const list = document.getElementById("sortableList");
            let draggedItem = null;

            list.querySelectorAll(".draggable").forEach(item => {

                item.addEventListener("dragstart", () => {
                    draggedItem = item;
                    item.style.opacity = "0.4";
                });

                item.addEventListener("dragend", () => {
                    draggedItem = null;
                    item.style.opacity = "1";
                });

                item.addEventListener("dragover", e => e.preventDefault());

                item.addEventListener("drop", function() {
                    if (draggedItem && draggedItem !== this) {
                        if ([...list.children].indexOf(draggedItem) < [...list.children].indexOf(this)) {
                            this.after(draggedItem);
                        } else {
                            this.before(draggedItem);
                        }
                    }
                });

            });
        }
        enableDragDrop();


        document.getElementById("saveAllBtn").addEventListener("click", function() {

            let formData = new FormData();
            formData.append("id_program", "{{ $data->id }}");

            let indexTab = 0;

            document.querySelectorAll("#sortableList li").forEach((li, index) => {

                let title = li.querySelector(".tab-title").value;
                let idSection = li.dataset.id || "";

                // === ambil file type yang dipilih
                let fileType = li.querySelector("input[type='radio']:checked")?.value || "pdf";

                // === ambil file yg diupload
                let fileInput = li.querySelector(".file-input");
                let file = fileInput?.files[0] ?? null;

                formData.append(`sections[${indexTab}][id]`, idSection);
                formData.append(`sections[${indexTab}][urutan]`, index + 1);
                formData.append(`sections[${indexTab}][type]`, fileType);
                formData.append(`sections[${indexTab}][title]`, title);

                if (file) {
                    formData.append(`sections[${indexTab}][file]`, file);
                }

                indexTab++;
            });

            document.getElementById("loadingOverlay").style.display = "flex";

            fetch("{{ route('lp_programs.save_pdf') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById("loadingOverlay").style.display = "none";

                    if (data.success) {
                        alert("Berhasil disimpan!");
                        location.reload();
                    } else {
                        alert("Gagal: " + data.message);
                    }
                })
                .catch(err => {
                    document.getElementById("loadingOverlay").style.display = "none";
                    alert("Error: " + err);
                });

        });
    </script>
@endpush
