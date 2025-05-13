<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'TemplaX') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            :root {
                --primary-color: #3490dc;
                --primary-hover: #2779bd;
                --secondary-color: #f6993f;
                --dark-color: #343a40;
                --light-color: #f8f9fa;
                --danger-color: #e3342f;
                --success-color: #38c172;
                --border-color: #dee2e6;
                --text-color: #333;
                --text-muted: #b7b8b8;
                --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                --transition: all 0.3s ease;
                --border-radius: 0.375rem;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Nunito', sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                background-attachment: fixed;
                color: var(--text-color);
                line-height: 1.6;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 1rem;
            }

            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 15px;
            }

            .welcome-card {
                background-color: white;
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                width: 100%;
                max-width: 800px;
                padding: 2.5rem;
                margin: 2rem auto;
                text-align: center;
                border: 1px solid var(--border-color);
                transition: var(--transition);
            }

            .welcome-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            }

            .logo {
                margin-bottom: 1.5rem;
                transition: var(--transition);
            }

            .logo:hover {
                transform: scale(1.05);
            }

            .logo svg {
                width: 80px;
                height: 80px;
                fill: var(--primary-color);
            }

            h1 {
                font-size: 2.5rem;
                color: var(--primary-color);
                margin-bottom: 0.5rem;
                font-weight: 700;
            }

            .tagline {
                font-size: 1.2rem;
                color: var(--text-muted);
                margin-bottom: 2rem;
                font-weight: 500;
            }

            .features {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 1.5rem;
                margin: 2rem 0;
            }

            .feature {
                flex: 1 1 250px;
                max-width: 300px;
                padding: 1.5rem;
                background-color: rgba(255, 255, 255, 0.7);
                border-radius: var(--border-radius);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                transition: var(--transition);
            }

            .feature:hover {
                transform: translateY(-3px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .feature h3 {
                color: var(--primary-color);
                margin-bottom: 0.75rem;
                font-size: 1.25rem;
            }

            .feature p {
                color: var(--text-muted);
                font-size: 0.95rem;
            }

            .btn-container {
                display: flex;
                justify-content: center;
                gap: 1rem;
                margin-top: 2rem;
                flex-wrap: wrap;
            }

            .btn {
                display: inline-block;
                font-weight: 600;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                user-select: none;
                border: 1px solid transparent;
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
                line-height: 1.5;
                border-radius: var(--border-radius);
                transition: var(--transition);
                cursor: pointer;
                text-decoration: none;
            }

            .btn-primary {
                color: white;
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .btn-primary:hover {
                background-color: var(--primary-hover);
                border-color: var(--primary-hover);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .btn-outline {
                color: var(--primary-color);
                background-color: transparent;
                border-color: var(--primary-color);
            }

            .btn-outline:hover {
                color: white;
                background-color: var(--primary-color);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .auth-links {
                position: absolute;
                top: 1rem;
                right: 1rem;
                display: flex;
                gap: 1rem;
            }

            .auth-link {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 600;
                font-size: 0.9rem;
                transition: var(--transition);
            }

            .auth-link:hover {
                color: var(--primary-hover);
                text-decoration: underline;
            }

            .footer {
                margin-top: 2rem;
                text-align: center;
                color: var(--text-muted);
                font-size: 0.9rem;
            }

            /* Responsive styles */
            @media (max-width: 768px) {
                .welcome-card {
                    padding: 1.5rem;
                }

                h1 {
                    font-size: 2rem;
                }

                .tagline {
                    font-size: 1rem;
                }

                .features {
                    flex-direction: column;
                    align-items: center;
                }

                .feature {
                    max-width: 100%;
                }

                .auth-links {
                    position: relative;
                    top: 0;
                    right: 0;
                    justify-content: center;
                    margin-bottom: 1rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            @if (Route::has('login'))
                <div class="auth-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="auth-link">Dashboard</a>
                   
                    @endauth
                </div>
            @endif

            <div class="welcome-card">
                <div class="logo">
                    <svg viewBox="0 0 316 316" xmlns="http://www.w3.org/2000/svg">
                        <path d="M158 0C70.7 0 0 70.7 0 158s70.7 158 158 158 158-70.7 158-158S245.3 0 158 0zm-35.7 256h-22.1V60h22.1v196zm93.5 0h-22.1v-87.7l-50.2-74.6h27l36.2 58.9 35.4-58.9h26.6l-52.9 74.6V256z"/>
                    </svg>
                </div>
                <h1>Welcome to TemplaX</h1>
                <p class="tagline">Create your digital business card in minutes</p>

                <div class="features">
                    <div class="feature">
                        <h3>Professional Design</h3>
                        <p>Choose from dozens of professionally designed templates to create your perfect business card.</p>
                    </div>
                    <div class="feature">
                        <h3>Easy Customization</h3>
                        <p>Customize colors, fonts, and layouts with our intuitive drag-and-drop editor.</p>
                    </div>
                    <div class="feature">
                        <h3>Digital Sharing</h3>
                        <p>Share your business card digitally via email, social media, or QR code.</p>
                    </div>
                </div>

                <div class="btn-container">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                    @endif
                </div>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} TemplaX. All rights reserved.</p>
            </div>
        </div>