<div class="mb-3 row">
    <label class="col-lg-4 col-form-label" for="validationCustom07">Pilih Standar
    </label>
    <div class="col-lg-8">
        <select class="default-select wide form-control" id="validationCustom05" name="standar">
            <option data-display="Select">Please select</option>
            @foreach ($standar as $standar)
                <option value="{{ $standar->id }}" {{ $standar->id == $update_akun_auditee->user()->id_standar ? 'selected' : '' }}>
                    {{ $standar->nama_standar }}</option>
            @endforeach
        </select>
    </div>
</div>
