@extends('layouts.app')

@push('styles')
    <style>
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

        .dashboard-container {
            padding: 2rem 0;
        }

        .stats-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 1.5rem;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            background: rgba(0, 0, 0, 0.35);
        }

        .stats-card h5 {
            color: var(--text-primary);
            font-size: 1.1rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .stats-card h2 {
            color: var(--text-primary);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .stats-card p {
            color: var(--text-secondary);
            margin: 0;
        }

        .glass-table-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .glass-table-card .card-header {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--glass-border);
            color: var(--text-primary);
            padding: 1rem 1.5rem;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid var(--glass-border);
            color: var(--text-primary);
            font-weight: 500;
            padding: 1rem;
        }

        .table tbody td {
            background: rgba(0, 0, 0, 0.2);
            color: var(--text-primary);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
            vertical-align: middle;
        }

        .btn-manage {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-manage:hover {
            background: #3251d4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
            color: white;
        }

        .candidate-photo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--glass-border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .dashboard-title {
            color: var(--text-primary);
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .pagination-container {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1rem;
            width: 100%;
        }

        .pagination {
            margin: 0;
            gap: 0.25rem;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            color: var(--text-primary);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            min-width: 38px;
            text-align: center;
        }

        .pagination .page-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
            transform: translateY(-2px);
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-secondary);
            pointer-events: none;
        }

        .pagination-info {
            color: var(--text-primary);
            font-size: 0.9rem;
            white-space: nowrap;
            margin-right: 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <h2 class="dashboard-title">Admin Dashboard</h2>

        <div class="row g-4">
            <!-- Total Voters Card -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h5>Total Pemilih</h5>
                    <h2>{{ $totalUsers }}</h2>
                    <p>Pengguna Terdaftar</p>
                </div>
            </div>

            <!-- Total Votes Card -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h5>Total Suara</h5>
                    <h2>{{ $totalVotes }}</h2>
                    <p>Suara Masuk</p>
                </div>
            </div>

            <!-- Latest Vote Card -->
            <div class="col-md-4">
                <div class="stats-card">
                    <h5>Suara Terakhir</h5>
                    <h2>{{ $latestVote ? $latestVote->created_at->diffForHumans() : 'Belum ada suara' }}</h2>
                    <p>Waktu Pemilihan Terakhir</p>
                </div>
            </div>
        </div>

        <!-- Latest Votes Table -->
        <div class="glass-table-card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Aktivitas Pemilihan Terbaru</h5>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Pemilih</th>
                                <th>Kandidat</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentVotes as $vote)
                                <tr>
                                    <td>{{ $vote->user_id }}</td>
                                    <td>{{ $vote->candidate->name }}</td>
                                    <td>{{ $vote->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Candidates Results -->
        <div class="glass-table-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Hasil Pemilihan</h5>
                <a href="{{ route('admin.candidates') }}" class="btn btn-manage">
                    <i class="fas fa-users-cog me-2"></i>Kelola Kandidat
                </a>
            </div>
            <div class="p-4">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Kandidat</th>
                                <th>Total Suara</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($candidates as $candidate)
                                <tr>
                                    <td>
                                        @if($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}"
                                                class="candidate-photo">
                                        @else
                                            <div
                                                class="candidate-photo d-flex align-items-center justify-content-center bg-secondary">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $candidate->name }}</td>
                                    <td>{{ $candidate->votes_count }}</td>
                                    <td>
                                        {{ $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Users List -->
        <div class="glass-table-card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Pengguna</h5>
            <form method="GET" class="d-flex align-items-center">
                <select name="perPage" class="form-select" onchange="this.form.submit()"
                style="background: var(--glass-bg); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); color: var(--text-primary); border: 1px solid var(--glass-border); padding: 0.5rem;">
                <option value="5" {{ request('perPage', 10) == 5 ? 'selected' : '' }}>5 entries</option>
                <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10 entries</option>
                <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25 entries</option>
                <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50 entries</option>
                </select>
            </form>
            </div>
            <div class="p-4">
            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Status Pemilihan</th>
                    <th>Terdaftar Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                        @if($user->has_voted)
                            <span class="badge bg-success">Sudah Memilih</span>
                        @else
                            <span class="badge bg-warning">Belum Memilih</span>
                        @endif
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-white">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
                entries
                </div>
                <nav>
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($users->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">Previous</span>
                    </li>
                    @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}&perPage={{ request('perPage') }}">Previous</a>
                    </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($users->onEachSide(1)->links()->elements[0] as $page => $url)
                    @if ($page == $users->currentPage())
                        <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                        <a class="page-link" href="{{ $url }}&perPage={{ request('perPage') }}">{{ $page }}</a>
                        </li>
                    @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($users->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}&perPage={{ request('perPage') }}">Next</a>
                    </li>
                    @else
                    <li class="page-item disabled">
                        <span class="page-link">Next</span>
                    </li>
                    @endif
                </ul>
                </nav>
            </div>
            </div>
        </div>
    </div>
@endsection
