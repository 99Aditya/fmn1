@extends('admin.layout.index')
@section('title', 'New Blog Post')

@push('admin_custom_style')
<style>
/* SEO meter */
.seo-meter { height:5px; border-radius:99px; margin-top:5px; transition:width .4s; }
.seo-label { font-size:.72rem; color:#6c757d; margin-top:3px; }
.char-count { font-size:.72rem; color:#6c757d; }
/* CKEditor code block colours */
.ck-editor__editable { min-height: 400px; }
</style>
@endpush

@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8"><h4>New Blog Post</h4></div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.blog') }}">Blogs</a></li>
                <li class="breadcrumb-item active">Create</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="page-body">
          <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
            @csrf
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
              </div>
            @endif

            <div class="row">

              {{-- Main column --}}
              <div class="col-lg-8">

                <div class="card">
                  <div class="card-block">

                    <div class="form-group">
                      <label class="font-weight-bold">Post Title <span class="text-danger">*</span></label>
                      <input type="text" name="title" id="titleInput" class="form-control form-control-lg" placeholder="Write your post title here…" value="{{ old('title') }}" required>
                    </div>

                    <div class="form-group">
                      <label class="font-weight-bold">Excerpt <small class="text-muted">(short description shown in listings)</small></label>
                      <textarea name="excerpt" id="excerptInput" class="form-control" rows="2" maxlength="400" placeholder="A compelling 1-2 sentence summary…">{{ old('excerpt') }}</textarea>
                      <div class="char-count"><span id="excerptCount">0</span>/400 characters</div>
                    </div>

                    <div class="form-group">
                      <label class="font-weight-bold">Content <span class="text-danger">*</span></label>
                      <textarea name="content" id="contentEditor">{{ old('content') }}</textarea>
                    </div>

                  </div>
                </div>

                {{-- SEO Panel --}}
                <div class="card">
                  <div class="card-header"><h5 class="mb-0"><i class="feather icon-search mr-2"></i>SEO Settings</h5></div>
                  <div class="card-block">
                    <div class="form-group">
                      <label>SEO Title <small class="text-muted">(recommended: 50–60 chars)</small></label>
                      <input type="text" name="meta_title" id="metaTitle" class="form-control" maxlength="70" value="{{ old('meta_title') }}" placeholder="Leave blank to use post title">
                      <div class="d-flex align-items-center mt-1 gap-2">
                        <div class="seo-meter bg-light flex-grow-1" style="height:5px">
                          <div id="metaTitleBar" class="seo-meter" style="width:0%;background:#dc3545"></div>
                        </div>
                        <span class="char-count"><span id="metaTitleCount">0</span>/70</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Meta Description <small class="text-muted">(recommended: 120–160 chars)</small></label>
                      <textarea name="meta_description" id="metaDesc" class="form-control" rows="2" maxlength="160" placeholder="Leave blank to auto-generate from content">{{ old('meta_description') }}</textarea>
                      <div class="d-flex align-items-center mt-1 gap-2">
                        <div class="seo-meter bg-light flex-grow-1" style="height:5px">
                          <div id="metaDescBar" class="seo-meter" style="width:0%;background:#dc3545"></div>
                        </div>
                        <span class="char-count"><span id="metaDescCount">0</span>/160</span>
                      </div>
                    </div>

                    {{-- Google preview --}}
                    <div style="background:#f8f9fa;border-radius:8px;padding:14px;border:1px solid #e9ecef">
                      <div style="font-size:.72rem;color:#6c757d;margin-bottom:8px;font-weight:600">GOOGLE PREVIEW</div>
                      <div id="gpUrl" style="font-size:.78rem;color:#006621">{{ url('/blog') }}/your-post-slug</div>
                      <div id="gpTitle" style="font-size:1.1rem;color:#1a0dab;margin:3px 0;font-weight:400">Post title will appear here</div>
                      <div id="gpDesc" style="font-size:.82rem;color:#545454;line-height:1.45">Meta description will appear here…</div>
                    </div>
                  </div>
                </div>

              </div>

              {{-- Sidebar --}}
              <div class="col-lg-4">

                <div class="card">
                  <div class="card-header"><h5 class="mb-0">Publish</h5></div>
                  <div class="card-block">
                    <div class="form-group">
                      <label>Status</label>
                      <select name="status" class="form-control" id="statusSelect">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-block" id="publishBtn">Save Post</button>
                    <a href="{{ route('admin.blog') }}" class="btn btn-secondary btn-block mt-2">Cancel</a>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header"><h5 class="mb-0">Category & Tags</h5></div>
                  <div class="card-block">
                    <div class="form-group">
                      <label>Category</label>
                      <select name="category_id" class="form-control select2">
                        <option value="">— None —</option>
                        @foreach($categories as $cat)
                          <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                      </select>
                      @if($categories->isEmpty())
                        <small class="text-warning">No blog categories found. <a href="{{ route('admin.categories.create') }}">Create one</a> with type = blog.</small>
                      @endif
                    </div>
                    <div class="form-group">
                      <label>Hashtags <small class="text-muted">(comma separated)</small></label>
                      <input type="text" name="hashtags" class="form-control" placeholder="php, laravel, tutorial" value="{{ old('hashtags') }}">
                    </div>
                  </div>
                </div>

                <div class="card">
                  <div class="card-header"><h5 class="mb-0">Featured Image</h5></div>
                  <div class="card-block">
                    <div id="imagePreviewWrap" style="display:none;margin-bottom:12px">
                      <img id="imagePreview" src="" style="width:100%;border-radius:8px;object-fit:cover;max-height:180px">
                    </div>
                    <input type="file" name="featured_image" id="featuredImage" class="form-control-file" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">JPG, PNG or WEBP — max 3MB. Recommended: 1200×630px</small>
                  </div>
                </div>

              </div>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>

@push('admin_custom_scripts')
{{-- CKEditor 5 with code block --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
<script>
CKEDITOR.ClassicEditor.create(document.getElementById('contentEditor'), {
  toolbar: {
    items: [
      'heading','|','bold','italic','underline','strikethrough','|',
      'bulletedList','numberedList','|','blockQuote','|',
      'link','imageUpload','|',
      'code','codeBlock','|',
      'insertTable','|',
      'undo','redo','|','sourceEditing'
    ]
  },
  codeBlock: {
    languages: [
      { language: 'php',        label: 'PHP' },
      { language: 'javascript', label: 'JavaScript' },
      { language: 'html',       label: 'HTML' },
      { language: 'css',        label: 'CSS' },
      { language: 'python',     label: 'Python' },
      { language: 'sql',        label: 'SQL' },
      { language: 'bash',       label: 'Bash / Shell' },
      { language: 'json',       label: 'JSON' },
      { language: 'plaintext',  label: 'Plain text' },
    ]
  },
  heading: {
    options: [
      { model: 'paragraph',  title: 'Paragraph',  class: 'ck-heading_paragraph' },
      { model: 'heading1',   view: 'h1', title: 'Heading 1',  class: 'ck-heading_heading1' },
      { model: 'heading2',   view: 'h2', title: 'Heading 2',  class: 'ck-heading_heading2' },
      { model: 'heading3',   view: 'h3', title: 'Heading 3',  class: 'ck-heading_heading3' },
    ]
  },
});

// SEO character counters + Google preview
function updateSeoMeter(inputId, barId, countId, ideal, max) {
  const el = document.getElementById(inputId);
  const bar = document.getElementById(barId);
  const cnt = document.getElementById(countId);
  const len = el.value.length;
  cnt.textContent = len;
  const pct = Math.min(100, (len / max) * 100);
  bar.style.width = pct + '%';
  bar.style.background = len >= ideal && len <= max ? '#28a745' : (len < ideal ? '#ffc107' : '#dc3545');
}
document.getElementById('metaTitle').addEventListener('input', function() {
  updateSeoMeter('metaTitle','metaTitleBar','metaTitleCount',50,70);
  document.getElementById('gpTitle').textContent = this.value || document.getElementById('titleInput').value || 'Post title';
});
document.getElementById('metaDesc').addEventListener('input', function() {
  updateSeoMeter('metaDesc','metaDescBar','metaDescCount',120,160);
  document.getElementById('gpDesc').textContent = this.value || 'Meta description…';
});
document.getElementById('titleInput').addEventListener('input', function() {
  const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
  document.getElementById('gpUrl').textContent = '{{ url("/blog") }}/' + slug;
  if (!document.getElementById('metaTitle').value) document.getElementById('gpTitle').textContent = this.value;
});

// Excerpt counter
document.getElementById('excerptInput').addEventListener('input', function() {
  document.getElementById('excerptCount').textContent = this.value.length;
});

// Status label
document.getElementById('statusSelect').addEventListener('change', function() {
  document.getElementById('publishBtn').textContent = this.value === 'published' ? 'Publish Now' : 'Save Draft';
});

function previewImage(e) {
  const file = e.target.files[0];
  if (file) {
    document.getElementById('imagePreview').src = URL.createObjectURL(file);
    document.getElementById('imagePreviewWrap').style.display = 'block';
  }
}
</script>
@endpush
@endsection
