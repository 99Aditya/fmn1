@extends('admin.layout.index')
@section('title', 'Edit Blog')
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
                                        <h4>Edit Blog</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="page-header-breadcrumb">
                                    <ul class="breadcrumb-title">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="{{ route('admin.blog') }}">Blogs</a></li>
                                        <li class="breadcrumb-item active"><a href="#!">Edit</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Update Blog Post</h5>
                                    </div>                                    
                                    <div class="card-block">
                                        <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST">
                                            @csrf

                                            <div class="form-group mb-3">
                                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                                <input 
                                                    type="text" 
                                                    class="form-control @error('title') is-invalid @enderror" 
                                                    id="title" 
                                                    name="title" 
                                                    placeholder="Enter blog title"
                                                    value="{{ old('title', $blog->title) }}"
                                                    required>
                                                @error('title')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                                <textarea 
                                                    class="form-control @error('description') is-invalid @enderror" 
                                                    id="description" 
                                                    name="description" 
                                                    rows="6" 
                                                    placeholder="Enter blog description"
                                                    required>{{ old('description', $blog->description) }}</textarea>
                                                @error('description')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Update Blog</button>
                                                <a href="{{ route('admin.blog') }}" class="btn btn-secondary">Cancel</a>
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
