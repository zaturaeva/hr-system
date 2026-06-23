{{-- resources/views/vacations/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Оформление отпуска')
@section('page-title', 'Оформление отпуска')

@section('header-actions')
    <a href="{{ route('vacations.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">Новая заявка на отпуск</div>
                <div class="card-body">
                    <form action="{{ route('vacations.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Сотрудник <span class="text-danger">*</span></label>
                            <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                                <option value="">Выберите сотрудника...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" 
                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->full_name }} 
                                        (стаж: {{ $employee->getWorkDuration() }}, доступно: {{ number_format($employee->calculateVacationDays(), 1) }} дн.)
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Дата начала <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="start_date" 
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date', date('Y-m-d', strtotime('+1 day'))) }}"
                                       required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Количество дней <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="days" 
                                       class="form-control @error('days') is-invalid @enderror"
                                       placeholder="14"
                                       min="1"
                                       max="365"
                                       value="{{ old('days', 14) }}"
                                       required>
                                @error('days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a href="{{ route('vacations.index') }}" class="btn btn-outline-secondary">
                                Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Оформить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection