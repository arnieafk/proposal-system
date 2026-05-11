<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lost & Found') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-color: #f5f7ff;
            --bg-gradient: radial-gradient(circle at 8% 8%, #eef2ff 0%, #f7f9ff 45%, #fcfdff 100%);
            --text-color: #182230;
            --text-muted: #667085;
            --card-color: rgba(255, 255, 255, 0.88);
            --card-border: rgba(15, 23, 42, 0.08);
            --navbar-bg: rgba(16, 24, 40, 0.82);
            --navbar-border: rgba(255, 255, 255, 0.12);
            --primary-color: #6366f1;
            --primary-alt: #8b5cf6;
            --primary-soft: rgba(99, 102, 241, 0.12);
            --success-bg: #e8fff3;
            --success-text: #067647;
            --danger-bg: #ffeef0;
            --danger-text: #b42318;
            --input-bg: #ffffff;
            --input-border: #d0d8e8;
            --table-head-bg: #f5f7ff;
            --table-head-color: #344054;
        }

        body[data-theme='dark'] {
            --bg-color: #0b1220;
            --bg-gradient: radial-gradient(circle at 10% 8%, #1c2340 0%, #0f172a 45%, #0b1220 100%);
            --text-color: #e6edf7;
            --text-muted: #9eaac0;
            --card-color: rgba(20, 30, 52, 0.86);
            --card-border: rgba(147, 197, 253, 0.15);
            --navbar-bg: rgba(6, 11, 24, 0.82);
            --navbar-border: rgba(148, 163, 184, 0.2);
            --primary-color: #7c8cff;
            --primary-alt: #9f67ff;
            --primary-soft: rgba(124, 140, 255, 0.22);
            --success-bg: rgba(22, 101, 52, 0.25);
            --success-text: #86efac;
            --danger-bg: rgba(153, 27, 27, 0.24);
            --danger-text: #fda4af;
            --input-bg: #111b31;
            --input-border: #30415f;
            --table-head-bg: rgba(28, 41, 67, 0.7);
            --table-head-color: #d4def1;
        }

        body {
            background: var(--bg-gradient);
            color: var(--text-color);
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            transition: background 0.35s ease, color 0.35s ease;
        }

        .navbar-modern {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: var(--navbar-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--navbar-border);
            transition: background 0.35s ease, border-color 0.35s ease;
        }

        .navbar-brand {
            letter-spacing: 0.3px;
        }

        .theme-toggle {
            background: var(--primary-soft);
            color: var(--text-color);
            border: 1px solid var(--card-border);
            border-radius: 999px;
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
        }

        .theme-toggle:hover {
            transform: translateY(-1px) scale(1.03);
            box-shadow: 0 10px 20px rgba(2, 6, 23, 0.15);
        }

        .page-shell {
            padding-top: 1.5rem;
            padding-bottom: 2.2rem;
        }

        .card-modern {
            border: 1px solid var(--card-border);
            border-radius: 1.1rem;
            background: var(--card-color);
            box-shadow: 0 12px 28px rgba(2, 6, 23, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            overflow: hidden;
            backdrop-filter: blur(8px);
        }

        .card-modern:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 36px rgba(2, 6, 23, 0.16);
        }

        .card-modern .card-header {
            background: linear-gradient(135deg, var(--primary-soft), rgba(139, 92, 246, 0.08));
            border-bottom: 1px solid var(--card-border);
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 0.8rem;
            border: 1px solid var(--input-border);
            background: var(--input-bg);
            color: var(--text-color);
            padding: 0.65rem 0.85rem;
            transition: all 0.22s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.18);
            background: var(--input-bg);
            color: var(--text-color);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .btn {
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-alt));
            border: none;
            box-shadow: 0 8px 18px rgba(99, 102, 241, 0.32);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 28px rgba(99, 102, 241, 0.42);
        }

        .btn-outline-primary,
        .btn-outline-secondary {
            border-width: 1.5px;
        }

        .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-soft);
            color: var(--text-color);
            border-color: var(--primary-color);
        }

        .btn-outline-secondary {
            border-color: var(--input-border);
            color: var(--text-muted);
        }

        .table-modern thead th {
            background: var(--table-head-bg);
            color: var(--table-head-color);
            border-bottom-width: 1px;
            font-weight: 600;
        }

        .table-modern td,
        .table-modern th {
            vertical-align: middle;
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
        }

        .text-subtle {
            color: var(--text-muted);
        }

        .badge-soft-lost {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid rgba(252, 165, 165, 0.55);
        }

        .badge-soft-found {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid rgba(110, 231, 183, 0.55);
        }

        .item-card {
            border-radius: 1rem;
            border: 1px solid var(--card-border);
            background: var(--card-color);
            box-shadow: 0 10px 22px rgba(2, 6, 23, 0.08);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(2, 6, 23, 0.15);
        }

        .item-location {
            background: var(--primary-soft);
            border-radius: 999px;
            display: inline-block;
            padding: 0.3rem 0.65rem;
            font-size: 0.8rem;
            color: var(--text-color);
        }

        .item-description {
            color: var(--text-muted);
            font-size: 0.92rem;
            line-height: 1.45;
        }

        .flash-message {
            border-radius: 0.9rem;
            border: none;
            box-shadow: 0 10px 25px rgba(2, 6, 23, 0.12);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .flash-message.fade-out {
            opacity: 0;
            transform: translateY(-10px);
        }
    </style>
</head>
<body data-theme="light">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-modern shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('items.index') }}">Lost & Found Web Application</a>
            <div class="d-flex align-items-center gap-2">
                <span class="navbar-text text-white-50 d-none d-sm-inline">Public Access</span>
                <button class="theme-toggle" id="themeToggle" type="button" aria-label="Toggle theme">
                    <span id="themeIcon">🌙</span>
                </button>
            </div>
        </div>
    </nav>

    <main class="page-shell">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success flash-message" data-auto-dismiss="true">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger mb-3 flash-message">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.body;
            const toggleButton = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const savedTheme = localStorage.getItem('lf-theme') || 'light';

            const applyTheme = function (theme) {
                body.setAttribute('data-theme', theme);
                themeIcon.textContent = theme === 'dark' ? '☀️' : '🌙';
                localStorage.setItem('lf-theme', theme);
            };

            applyTheme(savedTheme);

            if (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    const currentTheme = body.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                    applyTheme(currentTheme === 'dark' ? 'light' : 'dark');
                });
            }

            const flash = document.querySelector('[data-auto-dismiss="true"]');
            if (!flash) {
                return;
            }

            const dismissAfterMs = 4000;
            setTimeout(function () {
                flash.classList.add('fade-out');
                setTimeout(function () {
                    flash.remove();
                }, 650);
            }, dismissAfterMs);
        });
    </script>
</body>
</html>
