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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Audit Mutu Internal</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Pedoman AMI</a></li>
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

    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pedoman</h4>
                @if ($pedoman_ami->count() > 0)
                @else
                    @can('operator')
                        <button type="button" class="btn btn-rounded btn-secondary btn-xs" data-bs-toggle="modal"
                            data-bs-target="#basicModal"><span class="btn-icon-start text-secondary"><i
                                    class="fa fa-plus color-secondary"></i>
                            </span>Add</button>
                    @endcan
                @endif
            </div>
            <div class="card-body">
                @foreach ($pedoman_ami as $pedoman)
                    <div class="d-xl-flex d-block align-items-start description-bx">
                        <div>
                            <h4 class="card-title">Deskripsi</h4>
                            <p class="description mt-4">{{ $pedoman->deskripsi }}
                            </p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        @can('operator')
                            <a class="btn btn-dark light me-3 btn-edit" href="javascript:void(0);"
                                data-url="{{ route('web.ami.pedoman-ami.show', $pedoman->id) }}" data-bs-toggle="modal"
                                data-bs-target="#updatePedoman"><i class="fas fa-pencil-alt me-3 scale4"></i>Update Pedoman</a>
                        @endcan
                        <a href="{{ asset('storage/' . $pedoman->file_pedoman_ami) }}" class="btn btn-primary"><i
                                class="las la-download scale5 me-3"></i>Download Pedoman</a>
                    </div>
                @endforeach
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
                    <h5 class="modal-title">Tambah Pedoman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate="" action="{{ route('web.ami.pedoman-ami.store') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 row">
                                    <label class="col-lg-4 col-form-label" for="validationCustom07">Deskripsi
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-8">
                                        <textarea rows="8" class="form-control" name="deskripsi" placeholder="Deskripsi"
                                            placeholder="Masukan Deskripsi..."></textarea>
                                    </div>
                                </div>
                                <div>
                                    <div class="input-group mb-3">
                                        <div class="form-file">
                                            <input type="file" class="form-file-input form-control" name="file_pedoman">
                                        </div>
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                    <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
                                    <br>
                                    <small class="text-danger">Maksimal size file: 3MB</small>
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
    {{-- update --}}
    <div class="modal fade" id="updatePedoman">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Pedoman AMI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body" id="editModalBody">
                    <div class="form-validate">
                        <form class="needs-validation" novalidate="" action="{{ url('/ami/pedomanAmi/') }}"
                            method="post" enctype="multipart/form-data">
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
                    console.log(data);
                    $('#editModalBody .row').html(data);
                }
            })
        })
    </script>
@endpush
