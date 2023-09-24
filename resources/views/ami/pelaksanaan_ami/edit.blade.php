<div class="mb-3 row">
    <label class="col-lg-4 col-form-label" for="validationCustom07">Tahun
        Pelaksanaan AMI
    </label>
    <div class="col-lg-8">
        <input type="text" class="form-control" id="validationCustom07" name="tahun_ami"
            placeholder="Contoh: Tahun 2022/2023(Ganjil)" required value="{{ $update_pelaksanaan->tahun_ami }}">
    </div>
</div>
<div class="mb-3 row">
    <label class="col-lg-4 col-form-label" for="validationCustom07">Status
    </label>
    <div class="col-lg-8">
        <select class="form-select" name="status">
            <option value="1" {{ $update_pelaksanaan->status ? 'selected' : '' }}>Aktif</option>
            <option value="0" {{ $update_pelaksanaan->status ? '' : 'selected' }}>Tidak Aktif</option>
        </select>
    </div>
</div>
