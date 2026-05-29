@extends('admin.layout.index')
@section('title', 'Users')
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
                                        <h4>Users</h4>
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
                                        <li class="breadcrumb-item"><a href="{{ route('root.allUsers') }}">Users</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="table-responsive dt-responsive">
                                            <table class="table table-striped table-bordered nowrap simple-data-table">
                                                <thead>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Password</th>
                                                        <th>Avatar</th>
                                                        <th>Mobile</th>
                                                        <th>Post</th>
                                                        <th>Follower</th>
                                                        <th>Following</th>
                                                        <th>Verify</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($all_info as $single_info)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $single_info->fullname }}</td>
                                                            <td>{{ $single_info->email }}</td>
                                                            <td>{{ $single_info->dec_password }}</td>
                                                            <td><img src="{{ get_avatar($single_info->avatar) }}"
                                                                    class="show-img-icon"></td>
                                                            <td>{{ $single_info->mobile }}</td>
                                                            <td>{{count($single_info->postCount) }}</td>
                                                            <td>{{ 1 }}</td>
                                                            <td>{{ 2 }}</td>
                                                            <td class="text-center">
                                                                <div
                                                                    class="border-checkbox-group border-checkbox-group-info">
                                                                    <input class="border-checkbox mark-user-verify"
                                                                        @if ($single_info->verified) checked @endif
                                                                        type="checkbox" data-id="{{ $single_info->id }}">
                                                                    <label class="border-checkbox-label"
                                                                        for="checkbox3"></label>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                <div class="btn-group dropdown-split-primary">
                                                                    <button type="button"
                                                                        class="btn btn-info dropdown-toggle dropdown-toggle-split waves-effect waves-light"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        More
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item waves-effect waves-light"
                                                                            href="{{route('root.user-block', $single_info->id)}}">{{$single_info->is_blocked ? "Unblock" : "Block"}}</a>
                                                                        <a class="dropdown-item waves-effect waves-light"
                                                                            href="">Delete</a>

                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>S.No.</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Password</th>
                                                        <th>Avatar</th>
                                                        <th>Mobile</th>
                                                        <th>Post</th>
                                                        <th>Follower</th>
                                                        <th>Following</th>
                                                        <th>Verify</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
