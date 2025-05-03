
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4361ee">
    <title>E-Voting System</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    @stack('styles')
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3498db;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(67, 97, 238, 0.1);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-auth {
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-login {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-login:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-register {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-register:hover {
            background-color: #3251d4;
            transform: translateY(-1px);
        }

        .main-content {
            flex: 1;
            padding: 2rem 0;
        }

        footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 1.5rem 0;
            margin-top: auto;
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: rgba(0,0,0,0.1);
        }
        
        .dropdown-menu .dropdown-item i {
            width: 1.25rem;
            text-align: center;
        }
        
        .dropdown-menu .dropdown-item {
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .dropdown-menu .dropdown-item:hover {
            transform: translateX(5px);
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-vote-yea me-2"></i>E-Voting
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('vote.index') }}">Vote</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('results.index') }}">Result</a>
                    </li>
                    @endauth
                </ul>

                <div class="user-menu">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-auth btn-login dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->is_admin)
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.candidates') }}" class="dropdown-item">
                                        <i class="fas fa-users me-2"></i>Kelola Kandidat
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-auth btn-login me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-auth btn-register">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content">
        <div class="container mt-5 pt-4">
            @yield('content')
        </div>
    </div>

    <footer class="py-4">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-3">
                    <h5 class="text-white mb-3">
                        <i class="fas fa-vote-yea me-2"></i>E-Voting
                    </h5>
                    <p class="text-light mb-0">Platform voting elektronik yang aman, mudah, dan transparan untuk masa depan pemilihan yang lebih baik.</p>
                </div>
                <div class="col-lg-4 mb-3">
                    <h5 class="text-white mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none mb-2 d-block">Home</a></li>
                        <li><a href="{{ route('vote.index') }}" class="text-light text-decoration-none mb-2 d-block">Vote</a></li>
                        <li><a href="{{ route('results.index') }}" class="text-light text-decoration-none mb-2 d-block">Results</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-3">
                    <h5 class="text-white mb-3">Connect With Us</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 mb-3 border-light">
            <div class="text-center text-light">
                <p class="mb-0">&copy; {{ date('Y') }} E-Voting System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>