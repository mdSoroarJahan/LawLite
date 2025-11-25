@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">{{ $case->title }}</h1>
                    <div class="btn-group">
                        <a href="{{ route('lawyer.cases.edit', $case->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('lawyer.cases.destroy', $case->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this case?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Case Details</h5>
                            </div>
                            <div class="card-body">
                                @if ($case->case_number)
                                    <div class="mb-3">
                                        <strong>Case Number:</strong>
                                        <span class="ms-2">{{ $case->case_number }}</span>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <strong>Status:</strong>
                                    <span class="ms-2">
                                        @if ($case->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($case->status === 'in_progress')
                                            <span class="badge bg-primary">In Progress</span>
                                        @elseif($case->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </span>
                                </div>

                                @if ($case->outcome)
                                    <div class="mb-3">
                                        <strong>Outcome:</strong>
                                        <span class="ms-2 badge bg-info text-dark">{{ ucfirst($case->outcome) }}</span>
                                    </div>
                                @endif

                                @if ($case->description)
                                    <div class="mb-3">
                                        <strong>Description:</strong>
                                        <p class="mt-2 text-muted">{{ $case->description }}</p>
                                    </div>
                                @endif

                                @if ($case->notes)
                                    <div class="mb-3">
                                        <strong>Notes:</strong>
                                        <p class="mt-2 text-muted">{{ $case->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Client Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>Name:</strong> {{ $case->client_name }}
                                    @if ($case->user_id)
                                        <span class="badge bg-success ms-2" title="Linked to User Account">Linked</span>
                                    @else
                                        <span class="badge bg-secondary ms-2" title="No User Account Linked">Guest</span>
                                    @endif
                                </div>
                                @if ($case->client_email)
                                    <div class="mb-2">
                                        <strong>Email:</strong> <a
                                            href="mailto:{{ $case->client_email }}">{{ $case->client_email }}</a>
                                    </div>
                                @endif
                                @if ($case->client_phone)
                                    <div class="mb-2">
                                        <strong>Phone:</strong> <a
                                            href="tel:{{ $case->client_phone }}">{{ $case->client_phone }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Hearing Information</h5>
                            </div>
                            <div class="card-body">
                                @if ($case->hearing_date)
                                    <div class="mb-3">
                                        <strong>Date:</strong>
                                        <div class="mt-1">{{ $case->hearing_date->format('l, F d, Y') }}</div>
                                    </div>
                                @endif

                                @if ($case->hearing_time)
                                    <div class="mb-3">
                                        <strong>Time:</strong>
                                        <div class="mt-1">
                                            {{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}
                                        </div>
                                    </div>
                                @endif

                                @if ($case->court_location)
                                    <div class="mb-3">
                                        <strong>Location:</strong>
                                        <div class="mt-1">{{ $case->court_location }}</div>
                                    </div>
                                @endif

                                @if (!$case->hearing_date && !$case->hearing_time && !$case->court_location)
                                    <p class="text-muted">No hearing scheduled yet</p>
                                @endif
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="small text-muted">
                                    <div>Created: {{ $case->created_at->format('M d, Y h:i A') }}</div>
                                    <div>Updated: {{ $case->updated_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Case Documents</h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#uploadDocumentModal">
                                    Upload
                                </button>
                            </div>
                            <div class="card-body">
                                @if ($case->documents->count() > 0)
                                    <div class="list-group list-group-flush">
                                        @foreach ($case->documents as $doc)
                                            <div
                                                class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <div class="text-truncate me-2">
                                                    <i class="bi bi-file-earmark-text me-2"></i>
                                                    {{ $doc->file_name }}
                                                </div>
                                                <a href="{{ \Illuminate\Support\Facades\Storage::url($doc->file_path) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-primary">View</a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-muted text-center my-3">No documents uploaded yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Tasks & To-Do</h5>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addTaskModal">
                                    Add Task
                                </button>
                            </div>
                            <div class="card-body">
                                @if ($case->tasks->count() > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach ($case->tasks as $task)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <div class="d-flex align-items-center">
                                                    <form
                                                        action="{{ route('lawyer.cases.tasks.update', [$case->id, $task->id]) }}"
                                                        method="POST" class="me-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="checkbox" class="form-check-input"
                                                            onchange="this.form.submit()"
                                                            {{ $task->is_completed ? 'checked' : '' }} name="is_completed">
                                                    </form>
                                                    <div
                                                        class="{{ $task->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
                                                        {{ $task->title }}
                                                        @if ($task->due_date)
                                                            <small class="d-block text-muted"
                                                                style="font-size: 0.75rem;">Due:
                                                                {{ $task->due_date->format('M d') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <form
                                                    action="{{ route('lawyer.cases.tasks.destroy', [$case->id, $task->id]) }}"
                                                    method="POST" onsubmit="return confirm('Delete task?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-link text-danger p-0"><i
                                                            class="bi bi-trash"></i></button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted text-center my-3">No tasks added yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('lawyer.cases.index') }}" class="btn btn-secondary">Back to Cases</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadDocumentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('lawyer.cases.documents.store', $case->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Upload Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Document Name</label>
                            <input type="text" name="file_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File</label>
                            <input type="file" name="document" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('lawyer.cases.tasks.store', $case->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Task Title</label>
                            <input type="text" name="title" class="form-control" required
                                placeholder="e.g. File motion">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Due Date (Optional)</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
