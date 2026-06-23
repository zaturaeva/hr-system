{{-- resources/views/vacations/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Отпуск сотрудника')
@section('page-title', 'Детали отпуска')

@section('header-actions')
    <a href="{{ route('vacations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-1">{{ $employee->full_name }}</h5>
                    <p class="text-muted fs-14">{{ $employee->position ?? 'Без должности' }}</p>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Стаж:</span>
                        <span class="fw-500">{{ $workDuration ?? '0 дн.' }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Доступно дней:</span>
                        <span class="fw-500">{{ number_format($availableDays, 1) }}</span>
                    </div>
                    
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar" 
                             style="width: {{ min(($availableDays / 28) * 100, 100) }}%">
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-user"></i> Профиль
                        </a>
                        <a href="{{ route('employees.vacation', $employee->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Оформить
                        </a>
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
                                        <th>Дата начала</th>
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
                        <div class="text-center py-5 text-muted">
                            Нет записей об отпусках
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection