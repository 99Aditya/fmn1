@extends('admin.layout.index')
@section('title', 'Blogs')
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
                                        <h4>Blogs</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="page-header-breadcrumb">
                                    <ul class="breadcrumb-title">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item active"><a href="#!">Blogs</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- Basic Table card start -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5>Blog List</h5>
                                            <a href="{{ route('admin.blog.create') }}" class="btn btn-success">Add New Blog</a>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        @if ($message = Session::get('success'))
                                            <div class="alert alert-success icons-alert" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <i class="icofont icofont-close-line-circled"></i>
                                                </button>
                                                {{ $message }}
                                            </div>
                                        @endif

                                        @if ($message = Session::get('error'))
                                            <div class="alert alert-danger icons-alert" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <i class="icofont icofont-close-line-circled"></i>
                                                </button>
                                                {{ $message }}
                                            </div>
                                        @endif

                                        <div class="table-responsive">
                                            <table id="dt-basic" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Created At</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($blogs as $blog)
                                                        <tr>
                                                            <td>{{ $blog->id }}</td>
                                                            <td>{{ $blog->title }}</td>
                                                            <td>{{ Str::limit($blog->description, 50) }}</td>
                                                            <td>{{ $blog->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                                
                                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted">No blogs found</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Basic Table card end -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('admin_custom_scripts')
    <script>
        // DataTable initialization
        $(document).ready(function() {
            $('#dt-basic').dataTable({
                "sPaginationType": "full_numbers"
            });
        });
    </script>
    @endpush

@endsection
