@extends('layouts.app')

@push('styles')
    <style>
        .hero-section {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            padding: 4rem 2rem;
            color: white;
            text-align: center;
            animation: fadeIn 0.5s ease-in;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #4ade80;
            margin-bottom: 1rem;
        }

        .cta-button {
            background: rgba(67, 97, 238, 0.9);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 1rem;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
            background: rgba(67, 97, 238, 1);
            color: white;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            background: linear-gradient(135deg, #4361ee, #7209b7);
            min-height: 100vh;
        }

        .step-container {
            position: relative;
            z-index: 1;
            padding: 2rem 3rem;
        }

        .step-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 15px;
            padding: 2rem;
            height: 100%;
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 280px;
        }

        .step-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.2);
        }

        .step-number {
            background: linear-gradient(135deg, #4361ee, #7209b7);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .step-icon {
            font-size: 2rem;
            color: #4ade80;
            margin-top: auto;
        }

        .step-arrow {
            position: absolute;
            top: 50%;
            right: -10%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 2.5rem;
            z-index: 2;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .step-arrow {
                transform: rotate(90deg);
                right: 45%;
                top: auto;
                bottom: -3rem;
            }

            .step-container {
                padding: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <!-- Hero Section -->
        <div class="hero-section mb-5">
            <h1 class="display-4 mb-4">Suarakan Pilihanmu</h1>
            <p class="lead mb-4">Bersama kita wujudkan pemilihan yang jujur, adil, dan transparan melalui sistem E-Voting
                yang aman dan modern.</p>
            @auth
                <a href="{{ route('vote.index') }}" class="cta-button">
                    <i class="fas fa-vote-yea me-2"></i>Mulai Voting
                </a>
            @else
                <a href="{{ route('login') }}" class="cta-button">
                    <i class="fas fa-sign-in-alt me-2"></i>Login untuk Memilih
                </a>
            @endauth
        </div>

        <!-- Features Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="feature-card text-center text-white">
                    <i class="fas fa-shield-alt feature-icon"></i>
                    <h3>Aman & Terpercaya</h3>
                    <p>Sistem voting yang dilengkapi dengan enkripsi data dan verifikasi ganda untuk menjamin keamanan suara
                        Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center text-white">
                    <i class="fas fa-clock feature-icon"></i>
                    <h3>Cepat & Efisien</h3>
                    <p>Proses pemilihan yang simpel dan cepat, dapat dilakukan dimana saja dan kapan saja.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center text-white">
                    <i class="fas fa-chart-bar feature-icon"></i>
                    <h3>Transparan & Real-time</h3>
                    <p>Pantau hasil pemilihan secara langsung dengan visualisasi data yang mudah dipahami.</p>
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="glass-card p-5 mb-5">
            <h2 class="text-center text-white mb-5">Cara Berpartisipasi</h2>
            <div class="row g-5 step-container">
                <div class="col-md-3 position-relative">
                    <div class="step-item text-center text-white">
                        <div class="step-number">1</div>
                        <h4 class="mb-3">Registrasi</h4>
                        <p class="mb-0">Daftar dengan data diri yang valid</p>
                        <i class="fas fa-user-plus step-icon"></i>
                    </div>
                    <div class="step-arrow d-none d-md-block">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>

                <div class="col-md-3 position-relative">
                    <div class="step-item text-center text-white">
                        <div class="step-number">2</div>
                        <h4 class="mb-3">Login</h4>
                        <p class="mb-0">Masuk ke sistem dengan akun Anda</p>
                        <i class="fas fa-sign-in-alt step-icon"></i>
                    </div>
                    <div class="step-arrow d-none d-md-block">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>

                <div class="col-md-3 position-relative">
                    <div class="step-item text-center text-white">
                        <div class="step-number">3</div>
                        <h4 class="mb-3">Pilih</h4>
                        <p class="mb-0">Tentukan pilihan Anda dengan bijak</p>
                        <i class="fas fa-vote-yea step-icon"></i>
                    </div>
                    <div class="step-arrow d-none d-md-block">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="step-item text-center text-white">
                        <div class="step-number">4</div>
                        <h4 class="mb-3">Selesai</h4>
                        <p class="mb-0">Suara Anda langsung tercatat</p>
                        <i class="fas fa-check-circle step-icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection