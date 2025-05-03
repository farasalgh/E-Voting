@extends('layouts.app')

@push('styles')
<style>
    .table {
        --bs-table-bg: transparent !important;
        --bs-table-accent-bg: transparent !important;
    }

    :root {
        --primary-color: #4361ee;
        --primary-light: rgba(67, 97, 238, 0.3);
        --glass-bg: rgba(0, 0, 0, 0.25);
        --glass-border: rgba(255, 255, 255, 0.18);
        --text-primary: rgba(255, 255, 255, 0.95);
        --text-secondary: rgba(255, 255, 255, 0.7);
    }

    body {
        background: linear-gradient(135deg, #4361ee, #7209b7);
        min-height: 100vh;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }

    .glass-card .card-header {
        background: rgba(0, 0, 0, 0.2);
        border-bottom: 1px solid var(--glass-border);
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }

    .card-header h3 {
        color: var(--text-primary);
        font-weight: 600;
        margin: 0;
    }

    .table {
        color: var(--text-primary) !important;
        margin: 0;
    }

    .table thead th {
        background: rgba(0, 0, 0, 0.2) !important;
        color: var(--text-primary) !important;
        font-weight: 500;
        border-bottom: 1px solid var(--glass-border);
        padding: 1rem;
    }

    .table tbody tr {
        background: rgba(0, 0, 0, 0.2) !important;
    }

    .table tbody tr:hover {
        background: rgba(0, 0, 0, 0.35) !important;
    }

    .table td {
        color: var(--text-primary) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem;
        vertical-align: middle;
    }

    .btn-add {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-add:hover {
        background: #3251d4;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        color: white;
    }

    .modal-content {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
    }

    .modal-header,
    .modal-footer {
        background: rgba(0, 0, 0, 0.2);
        border-color: var(--glass-border);
    }

    .modal-title {
        color: var(--text-primary);
    }

    .form-label {
        color: var(--text-primary);
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--glass-border);
        color: var(--text-primary);
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--primary-color);
        color: var(--text-primary);
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        color: var(--text-primary);
        transition: all 0.3s ease;
        margin: 0 0.25rem;
        border: none;
    }

    .btn-action.edit {
        background: rgba(67, 97, 238, 0.3);
    }

    .btn-action.delete {
        background: rgba(220, 53, 69, 0.3);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        color: white;
    }

    .btn-action.edit:hover {
        background: rgba(67, 97, 238, 0.5);
    }

    .btn-action.delete:hover {
        background: rgba(220, 53, 69, 0.5);
    }

    .candidate-photo {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 2px solid var(--glass-border);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        object-fit: cover;
    }

    /* Fix modal close button */
    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>
@endpush

@section('content')
<div class="container mt-4">
    <div class="glass-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Manage Candidates</h3>
            <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#addCandidateModal">
                <i class="fas fa-plus me-2"></i>Add Candidate
            </button>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Vision</th>
                            <th>Mission</th>
                            <th>Slogan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidates as $candidate)
                        <tr>
                            <td>
                                <img src="{{ $candidate->photo ? asset('storage/'.$candidate->photo) : asset('images/default-avatar.png') }}" 
                                     alt="{{ $candidate->name }}" 
                                     class="candidate-photo">
                            </td>
                            <td>{{ $candidate->name }}</td>
                            <td>{{ Str::limit($candidate->vision, 30) }}</td>
                            <td>{{ Str::limit($candidate->mission, 30) }}</td>
                            <td>{{ $candidate->slogan }}</td>
                            <td>
                                <button class="btn-action edit" 
                                        data-id="{{ $candidate->id }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCandidateModal">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <button class="btn-action delete"
                                        data-id="{{ $candidate->id }}">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Candidate Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vision</label>
                        <textarea name="vision" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mission</label>
                        <textarea name="mission" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slogan</label>
                        <input type="text" name="slogan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-add">Save Candidate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Candidate Modal -->
<div class="modal fade" id="editCandidateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vision</label>
                        <textarea name="vision" id="edit_vision" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mission</label>
                        <textarea name="mission" id="edit_mission" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slogan</label>
                        <input type="text" name="slogan" id="edit_slogan" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-add">Update Candidate</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit button handling
    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/admin/candidates/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_vision').value = data.vision;
                    document.getElementById('edit_mission').value = data.mission;
                    document.getElementById('edit_slogan').value = data.slogan;
                    document.getElementById('editForm').action = `/admin/candidates/${id}`;
                });
        });
    });

    // Delete button handling
    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this candidate?')) {
                const id = this.dataset.id;
                fetch(`/admin/candidates/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
            }
        });
    });
});
</script>
@endpush

@endsection