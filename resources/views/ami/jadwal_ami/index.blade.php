@php
    use Carbon\Carbon;
@endphp
@push('header')
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Audit Mutu Internal
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        @if (session('message'))
            <div class="d-flex justify-content-center">
                <div class="alert alert-success left-icon-big alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i
                                class="mdi mdi-btn-close"></i></span>
                    </button>
                    <div class="media">
                        <div class="alert-left-icon-big">
                            <span><i class="mdi mdi-check-circle-outline"></i></span>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-1 mb-2">Congratulations!</h5>
                            <p class="mb-0">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endpush
@extends('layouts.main')
@section('content')

    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Audit Mutu Internal</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Jadwal AMI</a></li>
        </ol>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Jadwal</h4>
                <div class="d-flex">
                    <button type="button" class="btn btn-rounded btn-secondary btn-xs" data-bs-toggle="modal"
                        data-bs-target="#basicModal"><span class="btn-icon-start text-secondary"><i
                                class="fa fa-plus color-secondary"></i>
                        </span>Add</button>
                    <button type="button" class="btn btn-rounded btn-danger btn-xs" data-bs-toggle="modal"
                        data-bs-target="#nonAktifJadwal">
                        </span>Non Aktifkan Jadwal</button>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="table table-responsive-md" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Jadwal</th>
                                <th>Pelaksanaan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwal_ami as $index => $jadwal)
                                <tr>
                                    <td>{{ ($jadwal_ami->currentPage() - 1) * $jadwal_ami->perPage() + $index + 1 }}</td>
                                    <td>{{ $jadwal->nama_jadwal }}</td>
                                    <td>{{ Carbon::createFromFormat('Y-m-d H:i:s', $jadwal->jadwal_mulai)->isoFormat('DD/MM/Y') }}
                                        -
                                        {{ Carbon::createFromFormat('Y-m-d H:i:s', $jadwal->jadwal_selesai)->isoFormat('DD/MM/Y') }}
                                    </td>
                                    <td>
                                        <strong>
                                            @php
                                                if (
                                                    Carbon::createFromFormat('Y-m-d H:i:s', $jadwal->jadwal_mulai)
                                                        ->startOfDay()
                                                        ->gte(Carbon::now())
                                                ) {
                                                    echo 'Pending';
                                                } elseif (Carbon::now()->between($jadwal->jadwal_mulai, $jadwal->jadwal_selesai)) {
                                                    echo 'Proses';
                                                } else {
                                                    echo 'Selesai';
                                                }
                                            @endphp
                                        </strong>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" data-url="{{ route('web.ami.jadwal-ami.show', $jadwal->id) }}"
                                                class="btn btn-primary shadow btn-xs sharp me-1 btn-edit"
                                                data-bs-toggle="modal" data-bs-target="#updateJadwal"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <button class="btn btn-danger shadow btn-xs sharp btn-delete"
                                                data-url="{{ route('web.ami.jadwal-ami.show', $jadwal->id) }}"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Data tidak tersedia!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $jadwal_ami->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate="" action="{{ route('web.ami.jadwal-ami.store') }}"
                            method="post">
                            @csrf
                            <div class="row">
                                <div class="mb-4">
                                    <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Nama Jadwal
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="validationCustom07"
                                            name="nama_jadwal" placeholder="Masukan Nama Jadwal...">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Jadwal Mulai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="validationCustom07"
                                            name="jadwal_mulai" placeholder="Masukan Jadwal Mulai...">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Jadwal
                                        Selesai
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="validationCustom07"
                                            name="jadwal_selesai" required>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Pilih
                                        Tahun Pelaksanaan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <select class="default-select wide form-control" id="validationCustom05"
                                            name="histori_ami_id">
                                            <option data-display="Select" disabled selected>Please select
                                            </option>
                                            @foreach ($pelaksanaan_ami as $pelaksanaan)
                                                <option value="{{ $pelaksanaan->id }}">
                                                    {{ $pelaksanaan->tahun_ami }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- update --}}
    <div class="modal fade" id="updateJadwal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate="" action="{{ url('/ami/JadwalAmi/') }}"
                            method="post">
                            @csrf
                            @method('put')
                            <div class="row" id="formBodyEdit">

                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Non Aktif Jadwal --}}
    <div class="modal fade" id="nonAktifJadwal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Non Aktifkan Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate=""
                            action="{{ route('web.ami.pelaksanaan-ami.non-active') }}" method="post">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="mb-4">
                                    <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Pilih
                                        Tahun Pelaksanaan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <select class="default-select wide form-control" id="validationCustom05"
                                            name="id_tahun_ami">
                                            <option data-display="Select" disabled selected>Please select
                                            </option>
                                            @foreach ($pelaksanaan_ami as $pelaksanaan)
                                                <option value="{{ $pelaksanaan->id }}">
                                                    {{ $pelaksanaan->tahun_ami }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger light"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Non Aktifkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('js')
    <script>
        $('body').on('click', '.btn-edit', function() {
            let url = $(this).data('url');
            $('#editModalBody form').attr('action', url)
            $.ajax({
                url: url + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#editModalBody .row').html(data);
                }
            })
        })
    </script>
@endpush
