@extends('template.app')
@section('title', isset($formulir) ? 'Edit Formulir' : 'Tambah Formulir')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ isset($formulir) ? 'Edit' : 'Tambah' }} Formulir</h5>
                        <small class="text-muted">Form Builder</small>
                    </div>

                    <div class="card-body">
                        <form id="mainForm"
                            action="{{ isset($formulir) ? route('buat_form.update', $formulir->id) : route('buat_form.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($formulir))
                                @method('PUT')
                            @endif

                            <!-- Title -->
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Formulir</label>
                                <div class="col-sm-10">
                                    <input type="text" id="title" name="title" class="form-control"
                                        value="{{ old('title', $formulir->title ?? '') }}" required />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                                <div class="col-sm-10">
                                    <div id="quillEditor" style="height: 250px;">
                                        {!! old('description', $formulir->description ?? '') !!}
                                    </div>
                                    <textarea name="description" id="description" class="d-none"></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>




                            <!-- Button Tambah Field -->
                            <div class="mb-3 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#fieldModal">
                                    <i class="bi bi-plus-circle"></i> Tambah Field
                                </button>
                            </div>

                            <!-- LIST FIELD -->
                            <h6 class="mt-4">Daftar Field</h6>
                            <table class="table table-bordered mt-2" id="fieldsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Label</th>
                                        <th>Tipe</th>
                                        <th>Required</th>
                                        <th>Options</th>
                                        <th>Urutan</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($formFields))
                                        @foreach ($formFields as $i => $field)
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    $("#fieldsTable tbody").append(`
                    <tr>
                        <td>{{ $field->label }}</td>
                        <td>{{ $field->type }}</td>
                        <td>{{ $field->is_required ? 'Ya' : 'Tidak' }}</td>
                        <td>{{ $field->options ? implode(',', json_decode($field->options)) : '-' }}</td>
                       <td>
    <input type="number" class="form-control"
           name="fields[{{ $i }}][order]"
           value="{{ $field->order }}" min="0">
</td>


                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-field">Hapus</button>
                        </td>

                        <input type="hidden" name="fields[{{ $i }}][label]" value="{{ $field->label }}">
                        <input type="hidden" name="fields[{{ $i }}][type]" value="{{ $field->type }}">
                        <input type="hidden" name="fields[{{ $i }}][is_required]" value="{{ $field->is_required }}">
                        <input type="hidden" name="fields[{{ $i }}][options]" value="{{ $field->options ? implode(',', json_decode($field->options)) : '' }}">
                    </tr>
                `);
                                                });
                                            </script>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>

                            <hr>

                            <!-- Submit -->
                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-success">Simpan Formulir</button>
                                    <a href="{{ route('buat_form.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH FIELD -->
    <div class="modal fade" id="fieldModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="addFieldForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Field Formulir</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label>Label Field</label>
                            <input type="text" class="form-control" id="fieldLabel" required>
                        </div>

                        <div class="mb-3">
                            <label>Tipe Field</label>
                            <select id="fieldType" class="form-control" required>
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="textarea">Textarea</option>
                                <option value="select">Select</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="file">File Upload</option>

                            </select>
                        </div>

                        <div class="mb-3" id="optionsBox" style="display:none;">
                            <label>Options (Pisahkan dengan koma)</label>
                            <input type="text" id="fieldOptions" class="form-control"
                                placeholder="contoh: laki-laki,perempuan">
                        </div>

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="fieldRequired">
                            <label class="form-check-label">Wajib diisi</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Field</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
@push('style')
    <link href="{{ asset('template/dist/assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/dist/assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template/dist/assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('template/dist/assets/libs/quill/quill.min.js') }}"></script>
    <script>
        let fieldIndex = {{ isset($formFields) ? count($formFields) : 0 }};
        let quill;

        document.addEventListener("DOMContentLoaded", function() {

            // ============================
            //  INIT QUILL
            // ============================
            quill = new Quill("#quillEditor", {
                theme: "snow",
                modules: {
                    toolbar: [
                        [{
                            'font': []
                        }, {
                            'size': []
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'script': 'super'
                        }, {
                            'script': 'sub'
                        }],
                        [{
                            'header': [1, 2, 3, 4, 5, 6, false]
                        }, 'blockquote', 'code-block'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }, {
                            'indent': '-1'
                        }, {
                            'indent': '+1'
                        }],
                        ['direction', {
                            'align': []
                        }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            document.querySelector("#mainForm").addEventListener("submit", function() {
                document.querySelector("#description").value = quill.root.innerHTML;
            });

        });

        // Show options input only for select/checkbox
        $("#fieldType").on("change", function() {
            const val = $(this).val();
            if (val === "select" || val === "checkbox") {
                $("#optionsBox").show();
            } else {
                $("#optionsBox").hide();
            }
        });

        // Submit modal form
        $("#addFieldForm").on("submit", function(e) {
            e.preventDefault();

            let label = $("#fieldLabel").val();
            let type = $("#fieldType").val();
            let required = $("#fieldRequired").is(":checked") ? 1 : 0;
            let options = $("#fieldOptions").val();

            let order = fieldIndex + 1;


            // add dynamic row to table
            $("#fieldsTable tbody").append(`
            <tr>
                <td>${label}</td>
                <td>${type}</td>
                <td>${required ? 'Ya' : 'Tidak'}</td>
                <td>${options || '-'}</td>
<td>
                <input type="number" name="fields[${fieldIndex}][order]"
                       value="${order}" class="form-control" min="0">
            </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-field">Hapus</button>
                </td>

                <!-- hidden inputs -->
                <input type="hidden" name="fields[${fieldIndex}][label]" value="${label}">
                <input type="hidden" name="fields[${fieldIndex}][type]" value="${type}">
                <input type="hidden" name="fields[${fieldIndex}][is_required]" value="${required}">
                <input type="hidden" name="fields[${fieldIndex}][options]" value="${options}">
            </tr>
        `);

            fieldIndex++;

            // Reset modal
            $('#addFieldForm')[0].reset();
            $("#optionsBox").hide();

            // Close modal
            $("#fieldModal").modal("hide");
        });

        // Remove field row
        $(document).on("click", ".remove-field", function() {
            $(this).closest("tr").remove();
        });
    </script>
@endpush
