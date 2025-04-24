@extends('layouts.guest')

@section('content')
    <h2 class="mb-4 text-center">Iniciar Sesión</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input id="email" type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </div>

        <div class="text-center">
            <p class="mb-0">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
        </div>
    </form>
@endsection
