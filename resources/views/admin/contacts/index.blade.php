@extends('admin.layout.index')
@section('title', 'Contact Messages')
@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8"><h4>Contact Messages</h4></div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active">Contacts</li>
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
                    <h5>All Messages ({{ $contacts->count() }})</h5>
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
                          <th>Name</th>
                          <th>Email</th>
                          <th>Phone</th>
                          <th>Subject</th>
                          <th>Message Snippet</th>
                          <th>Date</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($contacts as $contact)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $contact->full_name }}</strong></td>
                            <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                            <td>{{ $contact->phone ?? '—' }}</td>
                            <td><span class="badge badge-info">{{ $contact->subject }}</span></td>
                            <td>
                              {{ Str::limit($contact->message, 50) }}
                              @if(strlen($contact->message) > 50)
                                <button type="button" class="btn btn-link p-0 text-primary small" data-toggle="modal" data-target="#msgModal{{ $contact->id }}">
                                  Read more
                                </button>
                              @endif
                            </td>
                            <td>{{ $contact->created_at?->format('d M Y H:i') ?? '—' }}</td>
                            <td>
                              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#msgModal{{ $contact->id }}">
                                View
                              </button>
                              <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                              </form>
                            </td>
                          </tr>

                          <!-- Message Modal -->
                          <div class="modal fade" id="msgModal{{ $contact->id }}" tabindex="-1" role="dialog" aria-labelledby="msgModalLabel{{ $contact->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="msgModalLabel{{ $contact->id }}">Message from {{ $contact->full_name }}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body text-wrap">
                                  <p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                                  <p><strong>Phone:</strong> {{ $contact->phone ?? '—' }}</p>
                                  <p><strong>Subject:</strong> {{ $contact->subject }}</p>
                                  <p><strong>Date:</strong> {{ $contact->created_at?->format('d M Y, H:i') ?? '—' }}</p>
                                  <hr>
                                  <p><strong>Message:</strong></p>
                                  <div class="p-3 bg-light rounded text-dark" style="white-space: pre-wrap; word-break: break-word;">{{ $contact->message }}</div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger">Delete Message</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        @empty
                          <tr><td colspan="8" class="text-center text-muted">No contact messages received yet</td></tr>
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
