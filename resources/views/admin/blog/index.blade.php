@extends('admin.layout.index')
@section('title', 'Blog Posts')
@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8"><h4>Blog Posts</h4></div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active">Blogs</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5>All Posts ({{ $blogs->count() }})</h5>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-success">
                      <i class="feather icon-plus mr-1"></i> New Post
                    </a>
                  </div>
                </div>
                <div class="card-block">
                  @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                  @endif

                  <div class="table-responsive">
                    <table id="dt-basic" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Status</th>
                          <th>Views</th>
                          <th>Read</th>
                          <th>Published</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($blogs as $blog)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                              <strong>{{ Str::limit($blog->title, 55) }}</strong>
                              @if($blog->featured_image)
                                <i class="feather icon-image text-muted ml-1" title="Has image"></i>
                              @endif
                            </td>
                            <td>{{ $blog->category?->name ?? '<span class="text-muted">—</span>' }}</td>
                            <td>
                              @if($blog->status === 'published')
                                <span class="badge badge-success">Published</span>
                              @else
                                <span class="badge badge-secondary">Draft</span>
                              @endif
                            </td>
                            <td>{{ number_format($blog->views) }}</td>
                            <td>{{ $blog->read_time }} min</td>
                            <td>{{ $blog->published_at?->format('d M Y') ?? '—' }}</td>
                            <td>
                              @if($blog->status === 'published')
                                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-sm btn-outline-info" title="View on site">
                                  <i class="feather icon-eye"></i>
                                </a>
                              @endif
                              <a href="{{ route('admin.blog.edit', $blog) }}" class="btn btn-sm btn-primary">Edit</a>
                              <form action="{{ route('admin.blog.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                              </form>
                            </td>
                          </tr>
                        @empty
                          <tr><td colspan="8" class="text-center text-muted">No blog posts yet</td></tr>
                        @endforelse
                      </tbody>
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

@push('admin_custom_scripts')
<script>
  $(document).ready(function() {
    $('#dt-basic').dataTable({ "sPaginationType": "full_numbers", "order": [] });
  });
</script>
@endpush
@endsection
