@push('header')
    <!--**********************************
        Header start
        ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Account
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
    <!--**********************************
        Header end ti-comment-alt
        ***********************************-->
@endpush
@extends('layouts.main')
@section('content')

    <div class="row page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Account</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Password</a></li>
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

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="basic-form">
                    <form class="form-valide-with-icon needs-validation" novalidate="" action="{{ url('/password/edit') }}"
                        method="post">
                        @method('put')
                        @csrf
                        <div class="mb-4">
                            <small class="text-danger">Field dengan tanda (*) wajib diisi!</small>
                        </div>
                        <div class="mb-3">
                            <label class="text-label form-label" for="current_password">Password Sebelumnya <span class="text-danger">*</span></label>
                            <div class="input-group transparent-append">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password Sebelumnya...">
                                <span class="input-group-text show-pass">
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-label form-label" for="password">New Password <span class="text-danger">*</span></label>
                            <div class="input-group transparent-append">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="New Password...">
                                <span class="input-group-text show-pass">
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="text-label form-label" for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <div class="input-group transparent-append">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm Password...">
                                <span class="input-group-text show-pass">
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-lg-3 ms-auto">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="submit" class="btn btn-light">cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection
