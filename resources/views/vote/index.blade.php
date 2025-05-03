@extends('layouts.app')

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #4361ee, #7209b7) !important;
            min-height: 100vh;
        }

        .candidate-container {
            padding: 2rem 0;
        }

        .candidate-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .candidate-photo-wrapper {
            position: relative;
            height: 300px;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        }

        .candidate-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .name-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, transparent 100%);
            padding: 2rem 1.5rem 1rem;
        }

        .name-overlay h4 {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .name-overlay p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .card-content {
            padding: 1.5rem;
        }

        .accordion-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.75rem;
            border-radius: 12px;
            overflow: hidden;
        }

        .accordion-button {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 500;
        }

        .accordion-button:not(.collapsed) {
            background: rgba(67, 97, 238, 0.3);
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.2);
        }

        .accordion-button::after {
            filter: brightness(0) invert(1);
        }

        .accordion-body {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            padding: 1.5rem;
            line-height: 1.6;
        }

        .vote-button {
            background: #4361ee;
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .vote-button:hover {
            background: #3251d4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }

        .page-title {
            color: white;
            text-align: center;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .candidate-photo-wrapper {
                height: 250px;
            }

            .page-title {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container candidate-container">
        <h2 class="page-title">Pilih Kandidat</h2>

        @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 justify-content-center">
            @foreach($candidates as $candidate)
                <div class="col-md-6 col-lg-4">
                    <div class="candidate-card">
                        <div class="candidate-photo-wrapper">
                            @if($candidate->photo)
                                <img src="{{ asset('storage/' . $candidate->photo) }}" class="candidate-photo"
                                    alt="{{ $candidate->name }}">
                            @endif
                            <div class="name-overlay">
                                <h4>{{ $candidate->name }}</h4>
                                @if($candidate->slogan)
                                    <p>{{ $candidate->slogan }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="accordion accordion-flush" id="accordion{{ $candidate->id }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#visi{{ $candidate->id }}">
                                            <i class="fas fa-eye me-2"></i> Visi
                                        </button>
                                    </h2>
                                    <div id="visi{{ $candidate->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion{{ $candidate->id }}">
                                        <div class="accordion-body">
                                            {{ $candidate->vision }}
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#misi{{ $candidate->id }}">
                                            <i class="fas fa-bullseye me-2"></i> Misi
                                        </button>
                                    </h2>
                                    <div id="misi{{ $candidate->id }}" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion{{ $candidate->id }}">
                                        <div class="accordion-body">
                                            {!! nl2br(e($candidate->mission)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="/vote" class="vote-form">
                                @csrf
                                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                <button type="submit" class="vote-button">
                                    <i class="fas fa-vote-yea me-2"></i> Pilih Kandidat
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection