@extends('admin.layout.index')
@section('title', 'user')
@section('content')
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-header">
                        <div class="row align-items-end">
                            <div class="col-lg-8">
                                <div class="page-header-title">
                                    <div class="d-inline">
                                        <h4>user</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="page-header-breadcrumb">
                                    <ul class="breadcrumb-title">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('root.dashboard') }}"> <i class="feather icon-home"></i> </a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('root.dashboard') }}">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('root.dashboard') }}">user</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Enquiries</h5>
                                        <div class="card-header-right">
                                            <ul class="list-unstyled card-option">
                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                <li><i class="feather icon-minus minimize-card"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <form method="post" action="">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-form-label">Name</label>
                                                        <div class="col-sm-12">
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $single_info->name }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-form-label">Email</label>
                                                        <div class="col-sm-12">
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $single_info->email_address }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-form-label">Mobile</label>
                                                        <div class="col-sm-12">
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $single_info->call }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-form-label">Subject</label>
                                                        <div class="col-sm-12">
                                                            <input disabled type="text" class="form-control"
                                                                value="{{ $single_info->question }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Msg</label>
                                                <div class="col-sm-12">
                                                    <textarea disabled rows="3" class="form-control">{{ $single_info->note }}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-sm-12 col-form-label">Reply</label>
                                                <div class="col-sm-12">
                                                    <textarea rows="3" class="form-control" name="reply" placeholder="Enter reply">{{ $single_info->reply }}</textarea>
                                                    @error('reply')
                                                        <div class="form-valid-error">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-primary ">Submit</button>
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
        </div>
    </div>
@endsection
