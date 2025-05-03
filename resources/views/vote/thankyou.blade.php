@extends('layouts.app')

@push('styles')
<style>
    .thank-you-container {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 20px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        padding: 3rem;
        text-align: center;
        color: white;
        animation: fadeIn 0.5s ease-in;
    }

    .success-icon {
        font-size: 5rem;
        color: #4ade80;
        margin-bottom: 1.5rem;
        animation: bounceIn 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .btn-result {
        background: rgba(67, 97, 238, 0.9);
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
        color: white;
    }

    .btn-result:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        background: rgba(67, 97, 238, 1);
        color: white;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes bounceIn {
        0% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); opacity: 1; }
    }

    body {
        background: linear-gradient(135deg, #4361ee, #7209b7);
        min-height: 100vh;
    }
</style>
@endpush

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="thank-you-container">
                <i class="fas fa-check-circle success-icon"></i>
                <h2 class="mb-4">Terima kasih telah menggunakan hak pilih!</h2>
                <p class="mb-4 text-white-50">Suara Anda telah berhasil tercatat dalam sistem</p>
                <a href="{{ route('results.index') }}" class="btn btn-result">
                    <i class="fas fa-chart-bar me-2"></i>Lihat Hasil Voting
                </a>
            </div>
        </div>
    </div>
</div>
@endsection