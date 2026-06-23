<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'full_name' => 'required|string|max:255',
            'hire_date' => 'required|date|before_or_equal:today',
            'position' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric|min:0',
            'extra_vacation_days' => 'nullable|integer|min:0|max:365'
        ];

       if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['full_name'] = 'sometimes|string|max:255';
            $rules['hire_date'] = 'sometimes|date|before_or_equal:today';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'full_name.required' => 'ФИО обязательно для заполнения',
            'full_name.max' => 'ФИО не может превышать 255 символов',
            'hire_date.required' => 'Дата приёма обязательна',
            'hire_date.before_or_equal' => 'Дата приёма не может быть в будущем',
            'salary.min' => 'Зарплата должна быть положительным числом',
            'extra_vacation_days.min' => 'Дополнительные дни не могут быть отрицательными',
            'extra_vacation_days.max' => 'Дополнительные дни не могут превышать 365'
        ];
    }
}