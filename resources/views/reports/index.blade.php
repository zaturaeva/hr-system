{{-- resources/views/reports/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Аналитика')
@section('page-title', 'Аналитика')

@section('header-actions')
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-users"></i>
    </a>
    <a href="{{ route('vacations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-calendar-alt"></i>
    </a>
@endsection

@section('content')
    <!-- Статистика -->
    <div class="row g-1 mb-2">
        <div class="col-6 col-sm-4 col-lg-3">
            <div class="stat-card">
                <div class="stat-label">Всего</div>
                <div class="stat-number blue">{{ $stats['total'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-3">
            <div class="stat-card">
                <div class="stat-label">Активные</div>
                <div class="stat-number">{{ $stats['active'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-3">
            <div class="stat-card">
                <div class="stat-label">В отпуске</div>
                <div class="stat-number">{{ $stats['on_vacation'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-3">
            <div class="stat-card">
                <div class="stat-label">Уволенные</div>
                <div class="stat-number">{{ $stats['dismissed'] ?? 0 }}</div>
            </div>
        </div>
    </div>
    
    <div class="row g-1">
        <!-- Общая информация -->
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">Общая информация</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted fs-12">Средний отпуск</span>
                        <span class="fw-500 fs-12">{{ number_format($stats['avg_vacation'] ?? 0, 1) }} дн.</span>
                    </div>
                    <div class="d-flex justify-content-between py-1 border-bottom">
                        <span class="text-muted fs-12">Фонд зарплаты</span>
                        <span class="fw-500 fs-12">{{ number_format($stats['total_salary'] ?? 0, 0, '.', ' ') }} ₽</span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span class="text-muted fs-12">Средняя зарплата</span>
                        <span class="fw-500 fs-12">
                            {{ $stats['total'] > 0 ? number_format(($stats['total_salary'] ?? 0) / $stats['total'], 0, '.', ' ') : '0' }} ₽
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Быстрые действия -->
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">Быстрые действия</div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-1">
                        <a href="{{ route('employees.create') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-user-plus"></i> Принять
                        </a>
                        <a href="{{ route('vacations.create') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-calendar-plus"></i> Отпуск
                        </a>
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-list"></i> Список
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection