<div class="mb-3 row">
    <label class="col-lg-4 col-form-label" for="validationCustom07">Deskripsi <span class="text-danger">*</span>
    </label>
    <div class="col-lg-8">
        <textarea rows="8" class="form-control" name="deskripsi" placeholder="Masukan Deskripsi...">{{ $update_pedoman->deskripsi }}</textarea>
    </div>
</div>
<div>
    <div class="input-group mb-3">
        <div class="form-file">
            <input type="file" class="form-file-input form-control" name="file_pedoman">
        </div>
        <span class="input-group-text">Upload</span>
    </div>
    <small>Dokumen sebelumnya <a href="{{ asset('storage/' . $update_pedoman->file_pedoman_ami) }}" target="_blank"
        class="text-primary">liat
        disini</a></small>
    <br> <br>
    <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
    <br>
    <small class="text-danger">Maksimal size file: 3MB</small>
</div>
