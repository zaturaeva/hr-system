{{-- resources/views/employees/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Приём сотрудника')
@section('page-title', 'Приём сотрудника')

@section('header-actions')
    <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Назад
    </a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">Новый сотрудник</div>
                <div class="card-body">
                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-2">
                            <label class="form-label">ФИО <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="full_name" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   placeholder="Иванов Иван Иванович"
                                   value="{{ old('full_name') }}"
                                   required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Дата приёма <span class="text-danger">*</span></label>
                                <input type="date" 
                                       name="hire_date" 
                                       class="form-control @error('hire_date') is-invalid @enderror"
                                       value="{{ old('hire_date', date('Y-m-d')) }}"
                                       required>
                                @error('hire_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Должность</label>
                                <input type="text" 
                                       name="position" 
                                       class="form-control @error('position') is-invalid @enderror"
                                       placeholder="Разработчик"
                                       value="{{ old('position') }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row g-2 mt-1">
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Зарплата</label>
                                <div class="input-group">
                                    <input type="number" 
                                           name="salary" 
                                           class="form-control @error('salary') is-invalid @enderror"
                                           placeholder="50000"
                                           step="1000"
                                           min="0"
                                           value="{{ old('salary') }}">
                                    <span class="input-group-text">₽</span>
                                </div>
                                @error('salary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-12 col-sm-6">
                                <label class="form-label">Доп. дни отпуска</label>
                                <input type="number" 
                                       name="extra_vacation_days" 
                                       class="form-control @error('extra_vacation_days') is-invalid @enderror"
                                       placeholder="0"
                                       min="0"
                                       max="365"
                                       value="{{ old('extra_vacation_days', 0) }}">
                                @error('extra_vacation_days')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary btn-sm">
                                Отмена
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                Принять
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection