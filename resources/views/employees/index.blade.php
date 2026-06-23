{{-- resources/views/employees/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Сотрудники')
@section('page-title', 'Сотрудники')

@section('header-actions')
    <a href="{{ route('vacations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-calendar-alt"></i>
    </a>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-chart-bar"></i>
    </a>
@endsection

@section('content')
    @php
        $stats = [
            'total' => $employees->count(),
            'active' => $employees->where('status', 'active')->count(),
            'on_vacation' => $employees->where('status', 'on_vacation')->count(),
            'dismissed' => $employees->where('status', 'dismissed')->count(),
            'avg_vacation_days' => $employees->count() > 0 ? round($employees->sum(function($e) { return $e->calculateVacationDays(); }) / $employees->count(), 1) : 0
        ];
    @endphp

    <!-- Statistics -->
    <div class="row g-1 mb-2">
        <div class="col-3">
            <div class="stat-card">
                <div class="stat-label">Всего</div>
                <div class="stat-number blue">{{ $stats['total'] }}</div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-card">
                <div class="stat-label">Активные</div>
                <div class="stat-number">{{ $stats['active'] }}</div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-card">
                <div class="stat-label">В отпуске</div>
                <div class="stat-number">{{ $stats['on_vacation'] }}</div>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-card">
                <div class="stat-label">Уволенные</div>
                <div class="stat-number">{{ $stats['dismissed'] }}</div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-1 gap-1">
        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Принять
        </a>
        <span class="text-muted fs-11">
            Ø {{ number_format($stats['avg_vacation_days'], 1) }} дн.
        </span>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:4%;">#</th>
                            <th style="width:20%;">ФИО</th>
                            <th style="width:16%;">Должность</th>
                            <th style="width:14%;">Дата приёма</th>
                            <th style="width:12%;">Стаж</th>
                            <th style="width:14%;">Отпуск</th>
                            <th style="width:10%;">Статус</th>
                            <th style="width:10%;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('employees.show', $employee->id) }}" class="fw-500">
                                        {{ $employee->full_name }}
                                    </a>
                                </td>
                                <td>{{ $employee->position ?? '—' }}</td>
                                <td>
                                    @if($employee->hire_date instanceof \DateTime)
                                        {{ $employee->hire_date->format('d.m.Y') }}
                                    @else
                                        {{ date('d.m.Y', strtotime($employee->hire_date)) }}
                                    @endif
                                </td>
                                <td>{{ $employee->getWorkDuration() }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <span class="fw-500">{{ number_format($employee->calculateVacationDays(), 1) }}</span>
                                        <div class="progress" style="width: 30px;">
                                            <div class="progress-bar" 
                                                 style="width: {{ min(($employee->calculateVacationDays() / 28) * 100, 100) }}%">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusMap = ['active' => 'Активен', 'on_vacation' => 'В отпуске', 'dismissed' => 'Уволен'];
                                        $status = $employee->status ?? 'active';
                                    @endphp
                                    <span class="badge badge-secondary">
                                        {{ $statusMap[$status] ?? $status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('employees.show', $employee->id) }}" 
                                           class="btn btn-outline-secondary btn-sm" title="Просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('employees.edit', $employee->id) }}" 
                                           class="btn btn-outline-secondary btn-sm" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-secondary btn-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#dismissModal{{ $employee->id }}"
                                                title="Уволить">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Dismiss Modal -->
                            <div class="modal fade" id="dismissModal{{ $employee->id }}" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <form action="{{ route('employees.dismiss', $employee->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title fs-11">Увольнение</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-1 fs-11">
                                                    Уволить <strong>{{ $employee->full_name }}</strong>?
                                                </p>
                                                <div class="mb-1">
                                                    <label class="form-label">Причина</label>
                                                    <select name="reason" class="form-select" required>
                                                        <option value="">Выберите...</option>
                                                        <option value="По собственному желанию">По собственному желанию</option>
                                                        <option value="Сокращение штата">Сокращение штата</option>
                                                        <option value="Нарушение дисциплины">Нарушение дисциплины</option>
                                                        <option value="По соглашению сторон">По соглашению сторон</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Отмена</button>
                                                <button type="submit" class="btn btn-danger btn-sm">Уволить</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-2 text-muted">
                                    Нет сотрудников
                                    <div class="mt-1">
                                        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm">
                                            + Добавить
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection