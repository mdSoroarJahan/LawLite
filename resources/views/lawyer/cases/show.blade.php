@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="{{ route('lawyer.dashboard') }}"
                                    class="text-decoration-none text-muted">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('lawyer.cases.index') }}"
                                    class="text-decoration-none text-muted">Cases</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Case
                                #{{ $case->case_number ?? $case->id }}</li>
                        </ol>
                    </nav>
                    <h1 class="h3 fw-bold text-dark mb-0">{{ $case->title }}</h1>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('lawyer.cases.edit', $case->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil me-1"></i> Edit Case
                    </a>
                    <form action="{{ route('lawyer.cases.destroy', $case->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this case? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="row g-4">
                <!-- Left Column: Main Info -->
                <div class="col-lg-8">
                    <!-- Case Overview -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                            <h5 class="card-title fw-bold mb-0"><i class="bi bi-info-circle me-2 text-primary"></i>Case
                                Overview</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1">Case Number</label>
                                    <div class="fs-5 fw-semibold text-dark">{{ $case->case_number ?? 'N/A' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small text-uppercase fw-bold mb-1">Current Status</label>
                                    <div>
                                        @if ($case->status === 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                                        @elseif($case->status === 'in_progress')
                                            <span class="badge bg-primary px-3 py-2 rounded-pill">In Progress</span>
                                        @elseif($case->status === 'completed')
                                            <span class="badge bg-success px-3 py-2 rounded-pill">Completed</span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">Closed</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($case->description)
                                <div class="mb-4">
                                    <label class="text-muted small text-uppercase fw-bold mb-1">Description</label>
                                    <p class="text-dark">{{ $case->description }}</p>
                                </div>
                            @endif

                            @if ($case->notes)
                                <div class="p-3 bg-light rounded border-start border-4 border-info">
                                    <label class="text-info small text-uppercase fw-bold mb-1">Internal Notes</label>
                                    <p class="mb-0 text-muted fst-italic">{{ $case->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Documents & Tasks Row -->
                    <div class="row g-4">
                        <!-- Documents -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div
                                    class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-folder2-open me-2 text-primary"></i>Documents
                                    </h6>
                                    <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal"
                                        data-bs-target="#uploadDocumentModal">
                                        <i class="bi bi-upload me-1"></i> Upload
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    @if ($case->documents->count() > 0)
                                        <div class="list-group list-group-flush">
                                            @foreach ($case->documents as $doc)
                                                <div
                                                    class="list-group-item px-3 py-3 border-bottom-0 border-top-0 d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center text-truncate">
                                                        <div
                                                            class="avatar-sm bg-light rounded me-3 d-flex align-items-center justify-content-center text-primary">
                                                            <i class="bi bi-file-earmark-text fs-5"></i>
                                                        </div>
                                                        <div class="text-truncate">
                                                            <div class="fw-semibold text-dark text-truncate"
                                                                style="max-width: 150px;">{{ $doc->file_name }}</div>
                                                            <small
                                                                class="text-muted">{{ $doc->created_at->format('M d') }}</small>
                                                        </div>
                                                    </div>
                                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($doc->file_path) }}"
                                                        target="_blank" class="btn btn-sm btn-light text-primary">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-folder-x display-6 text-muted mb-2"></i>
                                            <p class="text-muted small mb-0">No documents yet</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Tasks -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div
                                    class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-check2-square me-2 text-primary"></i>Tasks</h6>
                                    <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal"
                                        data-bs-target="#addTaskModal">
                                        <i class="bi bi-plus-lg me-1"></i> Add
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    @if ($case->tasks->count() > 0)
                                        <ul class="list-group list-group-flush">
                                            @foreach ($case->tasks as $task)
                                                <li
                                                    class="list-group-item px-3 py-3 border-bottom d-flex justify-content-between align-items-center {{ $task->is_completed ? 'bg-light' : 'bg-white' }}">
                                                    <div class="d-flex align-items-center">
                                                        <form
                                                            action="{{ route('lawyer.cases.tasks.update', [$case->id, $task->id]) }}"
                                                            method="POST" class="me-3">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-check mb-0">
                                                                <input type="checkbox"
                                                                    class="form-check-input rounded-circle border-2 p-2"
                                                                    style="width: 1.5em; height: 1.5em; cursor: pointer;"
                                                                    onchange="this.form.submit()"
                                                                    {{ $task->is_completed ? 'checked' : '' }}
                                                                    name="is_completed">
                                                            </div>
                                                        </form>
                                                        <div>
                                                            <div class="mb-0 {{ $task->is_completed ? 'text-decoration-line-through text-muted fst-italic' : 'fw-bold text-dark' }}"
                                                                style="font-size: 1rem;">
                                                                {{ $task->title }}
                                                            </div>
                                                            @if ($task->due_date)
                                                                <small
                                                                    class="{{ $task->is_completed ? 'text-muted' : 'text-danger fw-semibold' }}">
                                                                    <i class="bi bi-calendar-event me-1"></i> Due
                                                                    {{ $task->due_date->format('M d') }}
                                                                </small>
                                                            @else
                                                                <small class="text-muted opacity-75">
                                                                    <i class="bi bi-clock me-1"></i> No due date
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <form
                                                        action="{{ route('lawyer.cases.tasks.destroy', [$case->id, $task->id]) }}"
                                                        method="POST" onsubmit="return confirm('Delete task?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            class="btn btn-sm btn-link text-secondary p-0 opacity-50 hover-opacity-100"
                                                            title="Delete Task">
                                                            <i class="bi bi-trash fs-6"></i>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="text-center py-5">
                                            <i class="bi bi-clipboard-check display-6 text-muted mb-2"></i>
                                            <p class="text-muted small mb-0">No tasks pending</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar -->
                <div class="col-lg-4">
                    <!-- Client Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="fw-bold mb-0">Client Information</h6>
                        </div>
                        <div class="card-body text-center pt-4 pb-4">
                            <div class="avatar-lg bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fs-3 fw-bold"
                                style="width: 64px; height: 64px;">
                                {{ substr($case->client_name, 0, 1) }}
                            </div>
                            <h5 class="fw-bold mb-1">{{ $case->client_name }}</h5>
                            <div class="mb-3">
                                @if ($case->user_id)
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Registered
                                        User</span>
                                @else
                                    <span
                                        class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3">Guest
                                        Client</span>
                                @endif
                            </div>

                            <div class="d-grid gap-2">
                                @if ($case->client_email)
                                    <a href="mailto:{{ $case->client_email }}" class="btn btn-light text-start">
                                        <i class="bi bi-envelope me-2 text-muted"></i> {{ $case->client_email }}
                                    </a>
                                @endif
                                @if ($case->client_phone)
                                    <a href="tel:{{ $case->client_phone }}" class="btn btn-light text-start">
                                        <i class="bi bi-telephone me-2 text-muted"></i> {{ $case->client_phone }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Hearing Info -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="fw-bold mb-0">Next Hearing</h6>
                        </div>
                        <div class="card-body">
                            @if ($case->hearing_date)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3 text-primary"><i class="bi bi-calendar-date fs-4"></i></div>
                                    <div>
                                        <label class="text-muted small text-uppercase fw-bold">Date</label>
                                        <div class="fw-semibold">{{ $case->hearing_date->format('l, F d, Y') }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($case->hearing_time)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3 text-primary"><i class="bi bi-clock fs-4"></i></div>
                                    <div>
                                        <label class="text-muted small text-uppercase fw-bold">Time</label>
                                        <div class="fw-semibold">
                                            {{ \Carbon\Carbon::parse($case->hearing_time)->format('h:i A') }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($case->court_location)
                                <div class="d-flex align-items-start">
                                    <div class="me-3 text-primary"><i class="bi bi-geo-alt fs-4"></i></div>
                                    <div>
                                        <label class="text-muted small text-uppercase fw-bold">Location</label>
                                        <div class="fw-semibold">{{ $case->court_location }}</div>
                                    </div>
                                </div>
                            @endif

                            @if (!$case->hearing_date && !$case->hearing_time && !$case->court_location)
                                <div class="text-center py-3 text-muted">
                                    <i class="bi bi-calendar-x mb-2 fs-4"></i>
                                    <p class="small mb-0">No hearing scheduled</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Meta Info -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body small text-muted">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Created</span>
                                <span>{{ $case->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Last Updated</span>
                                <span>{{ $case->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadDocumentModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('lawyer.cases.documents.store', $case->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">Upload Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Document Name</label>
                            <input type="text" name="file_name" class="form-control" required
                                placeholder="e.g. Court Order #123">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">File</label>
                            <input type="file" name="document" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('lawyer.cases.tasks.store', $case->id) }}" method="POST">
                    @csrf
                    <div class="modal-header border-bottom-0 pb-0">
                        <h5 class="modal-title fw-bold">Add New Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Task Title</label>
                            <input type="text" name="title" class="form-control" required
                                placeholder="e.g. File motion for dismissal">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Due Date (Optional)</label>
                            <input type="date" name="due_date" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0 pb-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Add Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
