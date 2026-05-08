@extends('layouts.app')

@section('content')
<style>
    body.dark-mode {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
    }
    .dark-mode .bg-white {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
        border: 1px solid #333;
    }
    .dark-mode hr {
        border-color: #555 !important;
    }
</style>

<div class="container mt-5">
    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-dark shadow-sm" onclick="toggleTheme()" id="theme-btn">🌙 Dark Mode</button>
    </div>

    <div class="text-center p-5 shadow-sm bg-white rounded">
        <h2 class="fw-bold mb-4">Laravel 12 Toastr Notifications Example</h2>

        <div class="d-flex justify-content-center gap-2 flex-wrap mb-4">
            <a href="/success" class="btn btn-success px-4">Success</a>
            <a href="/error" class="btn btn-danger px-4">Error</a>
            <a href="/info" class="btn btn-info px-4">Info</a>
            <a href="/warning" class="btn btn-warning px-4">Warning</a>
        </div>

        <hr class="my-4">

        <div class="mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-primary btn-lg px-5 shadow">
                Users Dashboard
            </a>
        </div>
    </div>
</div>

<script>
    function toggleTheme() {
        const body = document.body;
        const btn = document.getElementById('theme-btn');
        body.classList.toggle('dark-mode');
        const isDark = body.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        btn.innerHTML = isDark ? '☀️ Light Mode' : '🌙 Dark Mode';
    }

    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        document.getElementById('theme-btn').innerHTML = '☀️ Light Mode';
    }
</script>
@endsection