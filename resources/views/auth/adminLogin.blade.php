@extends('layouts.app')

@section('title', 'Admin Login — ' . config('app.name', 'SAPP Church'))

@section('body-class', 'admin-login-page')

@push('styles')
    <style>
        .admin-login-brand__bg {
            background-image: url("{{ asset('assets/landingPage/BACKGROUND.jpg') }}");
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/auth/adminLogin.css') }}?v={{ filemtime(public_path('css/auth/adminLogin.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/app-typography.css') }}?v={{ filemtime(public_path('css/app-typography.css')) }}">
@endpush

@section('content')
    <header class="admin-login-header">
        <div class="admin-login-header__inner">
            <a href="{{ route('landingPage') }}" class="admin-login-header__brand">
                <img
                    class="admin-login-header__logo"
                    src="{{ asset('assets/landingPage/SAPPC.png') }}"
                    alt=""
                    width="40"
                    height="40"
                    decoding="async"
                >
                <span>Saint Anthony of Padua Parish Church</span>
            </a>
            <a href="{{ route('developers') }}" class="admin-login-header__developers">
                <i class="fa-solid fa-laptop-code" aria-hidden="true"></i>
                Developers
            </a>
        </div>
    </header>

    <main class="admin-login-root">
        <div class="admin-login-layout">
            <section class="admin-login-panel admin-login-panel--form" aria-label="Admin login">
                <div class="admin-login-card">
                    <div class="admin-login-card__head">
                        <div class="admin-login-card__avatar" aria-hidden="true">
                            <img
                                src="{{ asset('assets/auth/PROFILE.PNG') }}"
                                alt=""
                                width="84"
                                height="84"
                                decoding="async"
                            >
                        </div>
                        <h1 class="admin-login-card__role">Church Priest</h1>
                        <p class="admin-login-card__tagline">Enter your username and password to log in your account</p>
                    </div>

                    <div class="admin-login-card__body">
                        @error('login')
                            <p class="admin-login-card__error" role="alert">{{ $message }}</p>
                        @enderror

                        <form class="admin-login-form" method="POST" action="{{ route('admin.login.submit') }}" autocomplete="on">
                            @csrf
                            <div class="admin-login-field">
                                <label for="admin-username">Username:</label>
                                <div class="admin-login-input-wrap">
                                    <span class="admin-login-input-wrap__icon" aria-hidden="true">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input
                                        id="admin-username"
                                        class="admin-login-input @error('userName') admin-login-input--error @enderror"
                                        type="text"
                                        name="userName"
                                        value="{{ old('userName') }}"
                                        autocomplete="username"
                                        required
                                    >
                                </div>
                                @error('userName')
                                    <span class="admin-login-field__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="admin-login-field">
                                <label for="admin-password">Password:</label>
                                <div class="admin-login-input-wrap admin-login-input-wrap--password">
                                    <span class="admin-login-input-wrap__icon" aria-hidden="true">
                                        <i class="fa-solid fa-lock"></i>
                                    </span>
                                    <input
                                        id="admin-password"
                                        class="admin-login-input @error('userPass') admin-login-input--error @enderror"
                                        type="password"
                                        name="userPass"
                                        autocomplete="current-password"
                                        required
                                    >
                                    <button type="button" class="admin-login-toggle-pw" aria-label="Show password">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                @error('userPass')
                                    <span class="admin-login-field__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="admin-login-submit">Login</button>
                        </form>
                    </div>
                </div>
            </section>

            <section class="admin-login-panel admin-login-panel--brand" aria-label="Parish branding">
                <div class="admin-login-brand__bg" aria-hidden="true"></div>
                <div class="admin-login-brand__content">
                    <img
                        class="admin-login-brand__logo"
                        src="{{ asset('assets/landingPage/SAPPC-transparent.png') }}"
                        alt="Parish of St. Anthony of Padua, Barbaza seal"
                        width="600"
                        height="600"
                        decoding="async"
                    >
                    <h2 class="admin-login-brand__title">Saint Anthony of Padua Parish Church</h2>
                    <p class="admin-login-brand__subtitle">Recording Management System</p>
                </div>
            </section>
        </div>
    </main>

    @include('layouts.landingPageFooter')
@endsection

@push('scripts')
    <script>
        (function () {
            var form = document.querySelector('.admin-login-form');
            var userInput = document.getElementById('admin-username');
            var passInput = document.getElementById('admin-password');
            if (!form || !userInput || !passInput) return;

            function trimmed(el) {
                return (el.value || '').trim();
            }

            function bothComplete() {
                return trimmed(userInput) !== '' && trimmed(passInput) !== '';
            }

            form.addEventListener('keydown', function (e) {
                if (e.key !== 'Enter') return;
                if (e.target === userInput) {
                    e.preventDefault();
                    if (!trimmed(userInput)) {
                        userInput.setCustomValidity('Please enter your username.');
                        userInput.reportValidity();
                        userInput.setCustomValidity('');
                        return;
                    }
                    passInput.focus();
                    return;
                }
                if (e.target === passInput) {
                    if (!trimmed(userInput)) {
                        e.preventDefault();
                        userInput.setCustomValidity('Please enter your username.');
                        userInput.reportValidity();
                        userInput.setCustomValidity('');
                        userInput.focus();
                        return;
                    }
                    if (!trimmed(passInput)) {
                        e.preventDefault();
                        passInput.setCustomValidity('Please enter your password.');
                        passInput.reportValidity();
                        passInput.setCustomValidity('');
                        return;
                    }
                }
            });

            form.addEventListener('submit', function (e) {
                if (!bothComplete()) {
                    e.preventDefault();
                    if (!trimmed(userInput)) {
                        userInput.setCustomValidity('Please enter your username.');
                        userInput.reportValidity();
                        userInput.setCustomValidity('');
                        userInput.focus();
                    } else {
                        passInput.setCustomValidity('Please enter your password.');
                        passInput.reportValidity();
                        passInput.setCustomValidity('');
                        passInput.focus();
                    }
                }
            });
        })();

        document.querySelector('.admin-login-toggle-pw')?.addEventListener('click', function () {
            const input = document.getElementById('admin-password');
            const icon = this.querySelector('i');
            if (!input || !icon) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
        });
    </script>
@endpush
