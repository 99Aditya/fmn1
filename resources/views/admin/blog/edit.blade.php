@extends('admin.layout.index')
@section('title', 'Edit Blog Post')

@push('admin_custom_style')
<style>
.ck-editor__editable { min-height: 400px; }
</style>
@endpush

@section('content')
<div class="pcoded-content">
  <div class="pcoded-inner-content"><div class="main-body"><div class="page-wrapper">

    <div class="page-header">
      <div class="row align-items-end">
        <div class="col-lg-8"><h4>Edit Post</h4></div>
        <div class="col-lg-4">
          <ul class="breadcrumb-title">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.blog') }}">Blogs</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="page-body">
      <form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @if($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <div class="row">
          <div class="col-lg-8">
            <div class="card"><div class="card-block">
              <div class="form-group">
                <label class="font-weight-bold">Post Title *</label>
                <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $blog->title) }}" required>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Excerpt</label>
                <textarea name="excerpt" class="form-control" rows="2" maxlength="400">{{ old('excerpt', $blog->excerpt) }}</textarea>
              </div>
              <div class="form-group">
                <label class="font-weight-bold">Content *</label>
                <textarea name="content" id="contentEditor">{{ old('content', $blog->content) }}</textarea>
              </div>
            </div></div>

            <div class="card">
              <div class="card-header"><h5 class="mb-0">SEO Settings</h5></div>
              <div class="card-block">
                <div class="form-group">
                  <label>SEO Title <small class="text-muted">(50–60 chars)</small></label>
                  <input type="text" name="meta_title" class="form-control" maxlength="70" value="{{ old('meta_title', $blog->meta_title) }}">
                </div>
                <div class="form-group">
                  <label>Meta Description <small class="text-muted">(120–160 chars)</small></label>
                  <textarea name="meta_description" class="form-control" rows="2" maxlength="160">{{ old('meta_description', $blog->meta_description) }}</textarea>
                </div>
                <div class="form-group">
                  <label>URL Slug (read-only)</label>
                  <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text">/blog/</span></div>
                    <input type="text" class="form-control" value="{{ $blog->slug }}" disabled>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card"><div class="card-header"><h5 class="mb-0">Publish</h5></div><div class="card-block">
              @if($blog->status === 'published')
                <div class="alert alert-success py-2 mb-3"><i class="feather icon-check-circle mr-1"></i> Published {{ $blog->published_at?->diffForHumans() }}</div>
              @endif
              <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                  <option value="draft" {{ $blog->status==='draft' ? 'selected':'' }}>Draft</option>
                  <option value="published" {{ $blog->status==='published' ? 'selected':'' }}>Published</option>
                </select>
              </div>
              <div class="mb-3 text-muted" style="font-size:.8rem">
                <i class="feather icon-eye mr-1"></i> {{ number_format($blog->views) }} views &nbsp;
                <i class="feather icon-clock mr-1"></i> {{ $blog->read_time }} min read
              </div>
              <button type="submit" class="btn btn-primary btn-block">Update Post</button>
              @if($blog->status === 'published')
                <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="btn btn-outline-info btn-block mt-2">View on site</a>
              @endif
              <a href="{{ route('admin.blog') }}" class="btn btn-secondary btn-block mt-2">Cancel</a>
            </div></div>

            <div class="card"><div class="card-header"><h5 class="mb-0">Category & Tags</h5></div><div class="card-block">
              <div class="form-group">
                <label>Category</label>
                <select name="category_id" class="form-control select2">
                  <option value="">— None —</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $blog->category_id==$cat->id ? 'selected':'' }}>{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Hashtags <small class="text-muted">(comma separated)</small></label>
                <input type="text" name="hashtags" class="form-control" value="{{ old('hashtags', $blog->hashtags) }}">
              </div>
            </div></div>

            <div class="card"><div class="card-header"><h5 class="mb-0">Featured Image</h5></div><div class="card-block">
              @if($blog->featured_image)
                <img src="{{ $blog->featured_image_url }}" style="width:100%;border-radius:8px;margin-bottom:10px;max-height:160px;object-fit:cover">
              @endif
              <input type="file" name="featured_image" class="form-control-file" accept="image/*">
              <small class="text-muted">Upload to replace current image.</small>
            </div></div>
          </div>
        </div>
      </form>
    </div>

  </div></div></div>
</div>

@push('admin_custom_scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
<script>
CKEDITOR.ClassicEditor.create(document.getElementById('contentEditor'), {
  toolbar: { items: ['heading','|','bold','italic','underline','|','bulletedList','numberedList','|','blockQuote','|','link','imageUpload','|','code','codeBlock','|','insertTable','|','undo','redo','|','sourceEditing'] },
  codeBlock: { languages: [
    {language:'php',label:'PHP'},{language:'javascript',label:'JavaScript'},
    {language:'html',label:'HTML'},{language:'css',label:'CSS'},
    {language:'python',label:'Python'},{language:'sql',label:'SQL'},
    {language:'bash',label:'Bash'},{language:'json',label:'JSON'},
    {language:'plaintext',label:'Plain text'}
  ]},
  heading: { options: [
    {model:'paragraph',title:'Paragraph',class:'ck-heading_paragraph'},
    {model:'heading1',view:'h1',title:'Heading 1',class:'ck-heading_heading1'},
    {model:'heading2',view:'h2',title:'Heading 2',class:'ck-heading_heading2'},
    {model:'heading3',view:'h3',title:'Heading 3',class:'ck-heading_heading3'},
  ]},
});
</script>
@endpush
@endsection