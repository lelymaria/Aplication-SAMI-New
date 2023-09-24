@push('header')
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Manage Akun
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
        @if (session('error'))
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger left-icon-big alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"><span><i
                                class="mdi mdi-btn-close"></i></span>
                    </button>
                    <div class="media">
                        <div class="alert-left-icon-big">
                        </div>
                        <div class="media-body">
                            <h5 class="mt-1 mb-2">Ooops!</h5>
                            <p class="mb-0">{{ session('error') }}</p>
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Manage User</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('web.manage-user.akun-auditee.index') }}">Auditee</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Update Auditee</a></li>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="profile card card-body px-3 pt-3 pb-0">
                <div class="profile-head">
                    <div class="photo-content">
                        <div class="cover-photo rounded"></div>
                    </div>
                    <div class="profile-info">
                        <div class="profile-photo">
                            <img src="{{ asset($update_akun_auditee->foto_profile) }}" class="img-fluid rounded-circle"
                                alt="" style="width: 100px; height: 100px">
                        </div>
                        <div class="profile-details">
                            <div class="profile-name px-3 pt-2">
                                <h4 class="text-primary mb-0">{{ $update_akun_auditee->name }}</h4>
                                <p>{{ $update_akun_auditee->userHasLevelNotActive->level->name }}</p>
                            </div>
                            <div class="profile-email px-2 pt-2">
                                <h4 class="text-muted mb-0">{{ $update_akun_auditee->email }}</h4>
                                <p>Email</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-validation">
                        <form class="needs-validation" novalidate=""
                            action="{{ route('web.manage-user.akun-auditee.update', $update_akun_auditee->id) }}"
                            method="post">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="mb-3">
                                    <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom05">Unit Kerja
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="default-select wide form-control" id="validationCustom05"
                                                name="unit_kerja">
                                                <option data-display="Select">Please select</option>
                                                @foreach ($dataProdi as $dataProdi)
                                                    <option value="{{ $dataProdi->id }}"
                                                        {{ $dataProdi->id == $update_akun_auditee->akunAuditee->id_unit_kerja ? 'selected' : '' }}>
                                                        {{ $dataProdi->nama_prodi }}</option>
                                                @endforeach
                                                @foreach ($layananAkademik as $layananAkademik)
                                                    <option value="{{ $layananAkademik->id }}"
                                                        {{ $layananAkademik->id == $update_akun_auditee->akunAuditee->id_unit_kerja ? 'selected' : '' }}>
                                                        {{ $layananAkademik->nama_layanan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom02">Email
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="validationCustom02"
                                                name="email" value="{{ $update_akun_auditee->email }}"
                                                placeholder="Masukan Email...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom03">NIP
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="validationCustom03"
                                                name="nip" value="{{ $update_akun_auditee->nip }}"
                                                placeholder="Masukan NIP...">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom03">Nama
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="validationCustom03"
                                                name="nama" value="{{ $update_akun_auditee->name }}"
                                                placeholder="Masukan Nama...">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-lg-8 ms-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-validation">
                        <form class="needs-validation" novalidate=""
                            action="{{ route('web.manage-user.update-password', $update_akun_auditee->id) }}"
                            method="post">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom07">Password Baru
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="password" class="form-control" id="validationCustom07"
                                                name="new_password" placeholder="Masukan Password Baru...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom08">Konfirmasi
                                            Password
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="password" class="form-control" id="validationCustom08"
                                                name="new_password_confirmation" placeholder="Konfirmasi Password...">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <div class="col-lg-8 ms-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tugas Standar</h4>
                    <button type="button" class="btn btn-rounded btn-secondary btn-xs" data-bs-toggle="modal"
                        data-bs-target="#basicModal"><span class="btn-icon-start text-secondary"><i
                                class="fa fa-plus color-secondary"></i>
                        </span>Add</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{-- <table id="example3" class="table table-responsive-md" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Standar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($update_akun_auditee->user->tugasStandar as $index => $update_akun_tugas)
                                    <tr>
                                        <td>{{ ($update_akun_auditee->user->tugasStandar()->paginate()->currentPage() -1) *$update_akun_auditee->user->tugasStandar()->paginate()->perPage() +$index +1 }}
                                        </td>
                                        <td>{{ $update_akun_tugas->standar->nama_standar }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#"
                                                    data-url="{{ url('/manage_user/' . $update_akun_tugas->id) }}"
                                                    class="btn btn-primary shadow btn-xs sharp me-1 btn-edit"
                                                    data-bs-toggle="modal" data-bs-target="#updateTugas"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <button class="btn btn-danger shadow btn-xs sharp btn-delete"
                                                    data-url="{{ url('/manage_user/' . $update_akun_tugas->id) }}"><i
                                                        class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Data tidak
                                            tersedia!</td>
                                    </tr>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $update_akun_auditee->user->tugasStandar()->paginate()->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    {{-- Modal --}}
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form class="needs-validation" novalidate="" action="{{ url('/manage_user') }}" method="post">
                    @csrf
                    <input type="hidden" name="user" value="{{ $update_akun_auditee->id }}">
                    <div class="modal-body">
                        <div class="form-validate">
                            <div class="row">
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom05">Standar
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <select class="default-select wide form-control" id="validationCustom05"
                                            name="standar">
                                            <option data-display="Select">Please select</option>
                                            @foreach ($standar as $standar)
                                                <option value="{{ $standar->id }}">
                                                    {{ $standar->nama_standar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <small class="text-danger">Field dengan tanda (*)
                                    wajib diisi!</small>
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
    {{-- update --}}
    <div class="modal fade" id="updateTugas">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate=""
                            action="{{ url('/manage_user' . $update_akun_auditee->id) }}" method="post">
                            @csrf
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
@endpush

@push('js')
    <script>
        $('body').on('click', '.btn-edit', function() {
            let url = $(this).data('url');
            $('#editModalBody form').attr('action', url)
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#editModalBody .row').html(data);
                }
            })
        })
    </script>
@endpush
