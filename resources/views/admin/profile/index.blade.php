@extends('admin.layout.index')
@section('title', 'Profile')
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
                                        <h4>Profile</h4>
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
                                        <li class="breadcrumb-item"><a href="{{ route('root.profile') }}">Profile</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cover-profile">
                                    <div class="profile-bg-img">
                                        <img class="profile-bg-img img-fluid"
                                            src="{{ asset('template/files\assets\images\user-profile\bg-img1.jpg') }}"
                                            alt="bg-img">
                                        <div class="card-block user-info">
                                            <div class="col-md-12">
                                                <div class="media-left">
                                                    <a href="#" class="profile-image">
                                                        <img class="user-img img-radius"
                                                            src="{{ asset('assets/img/user-avatar.png') }}" alt="user-img"
                                                            style="width: 100px">
                                                    </a>
                                                </div>
                                                <div class="media-body row">
                                                    <div class="col-lg-12">
                                                        <div class="user-title">
                                                            <h2>{{ $user->fullname }}</h2>
                                                            <span class="text-white">Web designer</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tab-header card">
                                    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#personal"
                                                role="tab">Personal Info</a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="personal" role="tabpanel">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="card-header-text">About Me</h5>
                                            </div>
                                            <div class="card-block">
                                                <div class="view-info">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="general-info">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table m-0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Full Name</th>
                                                                                        <td>{{ $user->fullname }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <th scope="row">Mobile Number
                                                                                        </th>
                                                                                        <td>{{ $user->mobile }}</td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-xl-6">
                                                                        <div class="table-responsive">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <th scope="row">Email</th>
                                                                                        <td>{{ $user->email }}
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="edit-info">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="general-info">
                                                                {{-- <form action="{{ route('root.profileUpdate') }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12">

                                                                            <table class="table">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="input-group mb-2">
                                                                                                <span
                                                                                                    class="input-group-addon"><i
                                                                                                        class="icofont icofont-user"></i></span>
                                                                                                <input type="text"
                                                                                                    name="name"
                                                                                                    class="form-control"
                                                                                                    placeholder="Full Name">
                                                                                            </div>
                                                                                            @error('name')
                                                                                                <div class="form-valid-error">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="input-group mb-2">
                                                                                                <span
                                                                                                    class="input-group-addon"><i
                                                                                                        class="icofont icofont-email"></i></span>
                                                                                                <input type="text"
                                                                                                    name="email"
                                                                                                    class="form-control"
                                                                                                    placeholder="Email">
                                                                                            </div>
                                                                                            @error('email')
                                                                                                <div class="form-valid-error">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <div class="input-group mb-2">
                                                                                                <span
                                                                                                    class="input-group-addon"><i
                                                                                                        class="icofont icofont-mobile-phone"></i></span>
                                                                                                <input type="text"
                                                                                                    name="mobile"
                                                                                                    class="form-control"
                                                                                                    placeholder="Mobile Number">
                                                                                            </div>
                                                                                            @error('mobile')
                                                                                                <div class="form-valid-error">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </td>
                                                                                        <td>
                                                                                            <div class="input-group mb-2">
                                                                                                <span
                                                                                                    class="input-group-addon"><i
                                                                                                        class="icofont icofont-key"></i></span>
                                                                                                <input type="text"
                                                                                                    name="password"
                                                                                                    class="form-control"
                                                                                                    placeholder="Password">
                                                                                            </div>
                                                                                            @error('password')
                                                                                                <div class="form-valid-error">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </td>
                                                                                    </tr>

                                                                                </tbody>
                                                                            </table>

                                                                        </div>
                                                                    </div>
                                                                    <div class="text-center">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </form> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
