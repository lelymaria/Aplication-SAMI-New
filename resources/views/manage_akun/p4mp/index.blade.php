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
            <li class="breadcrumb-item"><a href="javascript:void(0)">Kepala P4MP</a></li>
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
                <h4 class="card-title">Data Akun</h4>
                <button type="button" class="btn btn-rounded btn-secondary btn-xs" data-bs-toggle="modal"
                    data-bs-target="#basicModal"><span class="btn-icon-start text-secondary"><i
                            class="fa fa-plus color-secondary"></i>
                    </span>Add</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="table table-responsive-md" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Periode Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kepala_p4mp as $index => $akun_p4mp)
                                <tr>
                                    <td>{{ ($kepala_p4mp->currentPage() - 1) * $kepala_p4mp->perPage() + $index + 1 }}</td>
                                    <td>{{ $akun_p4mp->name }}</td>
                                    <td>{{ $akun_p4mp->nip }}</td>
                                    <td>{{ $akun_p4mp->email }}</td>
                                    <td><strong>{{ $akun_p4mp->userHasLevelNotActive->level->name }}</strong></td>
                                    <td><strong>{{ $akun_p4mp->kepalaP4mp->periode_jabatan }}</strong></td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('web.manage-user.kepala-p4mp.edit', $akun_p4mp->id) }}"
                                                class="btn btn-primary shadow btn-xs sharp me-1 btn-edit"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <button class="btn btn-danger shadow btn-xs sharp btn-delete"
                                                data-url="{{ route('web.manage-user.kepala-p4mp.destroy', $akun_p4mp->id) }}"><i
                                                    class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $kepala_p4mp->links() }}
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
                    <h5 class="modal-title">Tambah Akun Kepala P4MP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form class="needs-validation" novalidate="" action="{{ route('web.manage-user.kepala-p4mp.store') }}"
                    method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-validate">
                            <div class="row">
                                <div class="mb-4">
                                    <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom06">Periode
                                        Jabatan
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="validationCustom06"
                                            name="periode_jabatan" placeholder="Masukan Periode Jabatan...">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="validationCustom07" name="email"
                                            placeholder="Masukan Email...">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom08">NIP
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="validationCustom08"
                                            name="nip" placeholder="Masukan NIP...">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom09">Nama <span
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="validationCustom09"
                                            name="nama" placeholder="Masukan Nama...">
                                    </div>
                                </div>
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
