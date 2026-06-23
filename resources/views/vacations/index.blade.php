{{-- resources/views/vacations/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Отпуска')
@section('page-title', 'Отпуска')

@section('header-actions')
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-users"></i>
    </a>
    <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-chart-bar"></i>
    </a>
@endsection

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-1 gap-1">
        <a href="{{ route('vacations.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Оформить
        </a>
        <span class="text-muted fs-11">
            Всего: {{ count($vacationData) }}
        </span>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if(count($vacationData) > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width:24%;">Сотрудник</th>
                                <th style="width:20%;">Должность</th>
                                <th style="width:14%;">Стаж</th>
                                <th style="width:18%;">Дней</th>
                                <th style="width:12%;">Статус</th>
                                <th style="width:12%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vacationData as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('employees.show', $item['id']) }}">
                                            {{ $item['name'] }}
                                        </a>
                                    </td>
                                    <td>{{ $item['position'] }}</td>
                                    <td>{{ $item['work_duration'] ?? '0 дн.' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <span class="fw-500">{{ number_format($item['available_days'], 1) }}</span>
                                            <div class="progress" style="width: 30px;">
                                                <div class="progress-bar" 
                                                     style="width: {{ min(($item['available_days'] / 28) * 100, 100) }}%">
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusMap = ['active' => 'Активен', 'on_vacation' => 'В отпуске', 'dismissed' => 'Уволен'];
                                            $status = $item['status'] ?? 'active';
                                        @endphp
                                        <span class="badge badge-secondary">
                                            {{ $statusMap[$status] ?? $status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('vacations.show', $item['id']) }}" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('employees.vacation', $item['id']) }}" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-2 text-muted">
                    <i class="fas fa-calendar-alt fa-2x mb-1 d-block" style="color: #a0aec0;"></i>
                    <p class="fs-11">Нет данных об отпусках</p>
                    <a href="{{ route('vacations.create') }}" class="btn btn-primary btn-sm">
                        + Оформить первый
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection