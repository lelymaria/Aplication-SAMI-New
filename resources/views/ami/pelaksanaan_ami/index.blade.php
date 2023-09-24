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
    </div>
@endpush
@extends('layouts.main')
@section('content')
    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Audit Mutu Internal</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Pelaksanaan AMI</a></li>
        </ol>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pelaksanaan AMI</h4>
                <button type="button" class="btn btn-rounded btn-secondary btn-xs" data-bs-toggle="modal"
                    data-bs-target="#addPelaksanaan"><span class="btn-icon-start text-secondary"><i
                            class="fa fa-plus color-secondary"></i>
                    </span>Add</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example3" class="table table-responsive-md" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Pelaksanaan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pelaksanaan_ami as $index => $pelaksanaan)
                                <tr>
                                    <td>{{ ($pelaksanaan_ami->currentPage() - 1) * $pelaksanaan_ami->perPage() + $index + 1 }}
                                    </td>
                                    <td>{{ $pelaksanaan->tahun_ami }}</td>
                                    <td>{{ $pelaksanaan->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="#"
                                                data-url="{{ route('web.ami.pelaksanaan-ami.show', $pelaksanaan->id) }}"
                                                class="btn btn-primary shadow btn-xs sharp me-1 btn-edit"
                                                data-bs-toggle="modal" data-bs-target="#updatePelaksanaan"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <button class="btn btn-danger shadow btn-xs sharp btn-delete"
                                                data-url="{{ route('web.ami.pelaksanaan-ami.show', $pelaksanaan->id) }}"><i
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
                    {{ $pelaksanaan_ami->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal fade" id="addPelaksanaan">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pelaksanaan AMI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate="" action="{{ route('web.ami.pelaksanaan-ami.store') }}"
                            method="post">
                            @csrf
                            <div class="row">
                                <div class="mb-4">
                                    <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Tahun
                                        Pelaksanaan AMI
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="validationCustom07" name="tahun_ami"
                                            placeholder="Contoh: Tahun 2022/2023(Ganjil)">
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

    <div class="modal fade" id="updatePelaksanaan">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Pelaksanaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate="" action="{{ url('/ami/jadwal_pelaksanaan') }}"
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
