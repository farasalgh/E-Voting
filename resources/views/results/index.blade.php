@extends('layouts.app')

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #4361ee, #7209b7);
            min-height: 100vh;
        }

        :root {
            --primary-color: #4361ee;
            --primary-light: rgba(67, 97, 238, 0.3);
            --glass-bg: rgba(0, 0, 0, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
            --text-primary: rgba(255, 255, 255, 0.95);
            --text-secondary: rgba(255, 255, 255, 0.7);
        }

        /* Reset table background */
        .table {
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
            --bs-table-striped-bg: transparent !important;
            --bs-table-hover-bg: transparent !important;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .stats-card {
            background: rgba(0, 0, 0, 0.2);
            /* Darker background for stats cards */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            background: rgba(0, 0, 0, 0.3);
            /* Darker on hover */
        }

        .chart-container {
            background: rgba(0, 0, 0, 0.2);
            /* Darker background for chart */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }

        .table {
            color: var(--text-primary) !important;
            margin: 0;
        }

        .table thead th {
            background: rgba(0, 0, 0, 0.3) !important;
            /* Darker header background */
            color: var(--text-primary) !important;
            border-bottom: 1px solid var(--glass-border);
            font-weight: 500;
        }

        .table tbody tr {
            background: rgba(0, 0, 0, 0.2) !important;
            /* Darker row background */
        }

        .table tbody tr:hover {
            background: rgba(0, 0, 0, 0.3) !important;
            /* Darker on hover */
        }

        .table td {
            color: var(--text-primary) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: middle;
        }

        .progress {
            background: rgba(255, 255, 255, 0.1);
            /* Slightly visible background */
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            background: var(--primary-color);
            transition: width 0.5s ease;
        }

        .candidate-img {
            border: 2px solid var(--glass-border);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: rgba(0, 0, 0, 0.2);
            /* Dark background for images */
        }

        /* Add text color classes */
        .text-white-50 {
            color: var(--text-secondary) !important;
        }

        .text-white {
            color: var(--text-primary) !important;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="glass-card p-4">
                    <h2 class="text-center text-white mb-4">Hasil Pemilihan</h2>

                    <!-- Stats Cards -->
                    <div class="row mb-4 g-4">
                        <div class="col-md-4">
                            <div class="stats-card p-4">
                                <h5 class="text-white mb-3">Total Suara</h5>
                                <h3 class="text-white mb-0" id="totalVotes">0</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card p-4">
                                <h5 class="text-white mb-3">Total Pemilih</h5>
                                <h3 class="text-white mb-0">{{ $totalVoters ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card p-4">
                                <h5 class="text-white mb-3">Partisipasi</h5>
                                <h3 class="text-white mb-0" id="participationRate">0%</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Chart Container -->
                    <div class="chart-container">
                        <canvas id="voteChart"></canvas>
                    </div>

                    <!-- Results Table -->
                    <div class="table-responsive mt-4">
                        <table class="table" id="resultsTable">
                            <thead>
                                <tr>
                                    <th>Kandidat</th>
                                    <th>Jumlah Suara</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('voteChart').getContext('2d');
        let chart;
        const colors = [
            'rgba(67, 97, 238, 0.6)',
            'rgba(114, 9, 183, 0.6)',
            'rgba(72, 149, 239, 0.6)',
            'rgba(76, 201, 240, 0.6)',
        ];

        // Update Chart.js options for better visibility
        Chart.defaults.color = '#fff';
        Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.1)';

        function updateTable(data, totalVotes) {
            const tbody = document.getElementById('resultsTable').getElementsByTagName('tbody')[0];
            tbody.innerHTML = '';

            data.forEach(candidate => {
                const percentage = totalVotes > 0 ? ((candidate.votes_count / totalVotes) * 100).toFixed(2) : 0;
                const row = tbody.insertRow();
                row.innerHTML = `
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="${candidate.photo ? '/storage/' + candidate.photo : '/images/default-avatar.png'}" 
                                 class="rounded-circle me-3 candidate-img" 
                                 style="width: 50px; height: 50px; object-fit: cover">
                            <div>
                                <strong class="text-white">${candidate.name}</strong><br>
                                <small class="text-white-50">${candidate.slogan || ''}</small>
                            </div>
                        </div>
                    </td>
                    <td class="text-white align-middle">${candidate.votes_count}</td>
                    <td class="align-middle" style="width: 40%">
                        <div class="progress" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: ${percentage}%;" 
                                 aria-valuenow="${percentage}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                                ${percentage}%
                            </div>
                        </div>
                    </td>
                `;
            });
        }

        async function fetchData() {
            try {
                const response = await fetch('/api/vote-results');
                const data = await response.json();

                const totalVotes = data.reduce((sum, candidate) => sum + candidate.votes_count, 0);
                const totalVoters = {{ $totalVoters ?? 0 }};
                const participationRate = totalVoters > 0
                    ? ((totalVotes / totalVoters) * 100).toFixed(2)
                    : 0;

                // Update stats cards
                document.getElementById('totalVotes').textContent = totalVotes;
                document.getElementById('participationRate').textContent = `${participationRate}%`;

                // Update chart
                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: data.map(candidate => candidate.name),
                        datasets: [{
                            data: data.map(candidate => candidate.votes_count),
                            backgroundColor: colors,
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: 'white',
                                    padding: 20,
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        }
                    }
                });

                // Update table
                updateTable(data, totalVotes);

            } catch (error) {
                console.error('Error fetching vote results:', error);
            }
        }

        // Initial fetch and interval
        fetchData();
        setInterval(fetchData, 5000); // refresh every 5 seconds
    </script>
@endpush