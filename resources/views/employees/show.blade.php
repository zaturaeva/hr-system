{{-- resources/views/employees/show.blade.php --}}
@extends('layouts.app')

@section('title', $employee->full_name)
@section('page-title', $employee->full_name)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Сотрудники</a></li>
    <li class="breadcrumb-item active">{{ $employee->full_name }}</li>
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-light rounded-circle mx-auto mb-2 d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 32px; color: #4a5568;">
                            {{ mb_substr($employee->full_name, 0, 1) }}
                        </div>
                        <h5 class="mb-1">{{ $employee->full_name }}</h5>
                        <span class="text-muted fs-14">{{ $employee->position ?? 'Без должности' }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="row g-2 fs-14">
                        <div class="col-6">
                            <div class="text-muted">Дата приёма</div>
                            <div class="fw-500">
                                {{ $employee->hire_date instanceof \DateTime ? $employee->hire_date->format('d.m.Y') : date('d.m.Y', strtotime($employee->hire_date)) }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Стаж</div>
                            <div class="fw-500">{{ $employee->getWorkDuration() }}</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Зарплата</div>
                            <div class="fw-500">{{ number_format($employee->salary ?? 0, 0, '.', ' ') }} ₽</div>
                        </div>
                        <div class="col-6">
                            <div class="text-muted">Статус</div>
                            <div>
                                @php
                                    $statusMap = [
                                        'active' => 'Активен',
                                        'on_vacation' => 'В отпуске',
                                        'dismissed' => 'Уволен'
                                    ];
                                    $badgeMap = [
                                        'active' => 'badge-success',
                                        'on_vacation' => 'badge-warning',
                                        'dismissed' => 'badge-danger'
                                    ];
                                    $status = $employee->status ?? 'active';
                                @endphp
                                <span class="badge {{ $badgeMap[$status] ?? 'badge-secondary' }}">
                                    {{ $statusMap[$status] ?? $status }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div>
                        <div class="text-muted fs-14">Доступно дней отпуска</div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="fs-3 fw-600">{{ number_format($vacationDays, 1) }}</span>
                            <span class="text-muted">из 28</span>
                        </div>
                        <div class="progress mt-2" style="height: 4px;">
                            <div class="progress-bar" 
                                 style="width: {{ min(($vacationDays / 28) * 100, 100) }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">История отпусков</div>
                <div class="card-body p-0">
                    @if(!empty($vacationHistory))
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Начало</th>
                                        <th>Дней</th>
                                        <th>Остаток</th>
                                        <th>Дата заявки</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vacationHistory as $vacation)
                                        <tr>
                                            <td>{{ date('d.m.Y', strtotime($vacation['start_date'])) }}</td>
                                            <td>{{ $vacation['days'] }}</td>
                                            <td>{{ $vacation['remaining_days'] }}</td>
                                            <td>{{ date('d.m.Y', strtotime($vacation['applied_at'])) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted fs-14">
                            Нет записей об отпусках
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="d-flex flex-wrap gap-2 mt-3">
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-outline-secondary btn-sm">
                    Редактировать
                </a>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#dismissModal">
                    Уволить
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm ms-auto">
                    ← Назад
                </a>
            </div>
        </div>
    </div>
    
    <!-- Dismiss Modal -->
    <div class="modal fade" id="dismissModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('employees.dismiss', $employee->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title fs-14">Увольнение</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3 fs-14">
                            Уволить <strong>{{ $employee->full_name }}</strong>?
                        </p>
                        <div class="mb-3">
                            <label class="form-label">Причина</label>
                            <select name="reason" class="form-select" required>
                                <option value="">Выберите...</option>
                                <option value="По собственному желанию">По собственному желанию</option>
                                <option value="Сокращение штата">Сокращение штата</option>
                                <option value="Нарушение дисциплины">Нарушение дисциплины</option>
                                <option value="По соглашению сторон">По соглашению сторон</option>
                            </select>
                        </div>
                        <div class="text-muted fs-14">
                            Неиспользовано: <strong>{{ number_format($vacationDays, 1) }}</strong> дней
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
@endsection