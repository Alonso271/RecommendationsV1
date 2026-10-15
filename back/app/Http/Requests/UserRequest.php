<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $userId = $this->route('user');

        return [
            'name' => [$isUpdate ? 'sometimes' : 'required', 'string', 'max:255'],

            'nickname' => [
                $isUpdate ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('users', 'nickname')->ignore($userId),
            ],

            'email' => [
                $isUpdate ? 'sometimes' : 'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],

            'password' => [
                $isUpdate ? 'sometimes' : 'required',
                'confirmed',
                Password::min(8),
            ],

            'photo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'birthdate' => ['nullable', 'date', 'before:today'],
            'genres'    => ['nullable', 'array'],
            'genres.*' => ['integer', 'distinct', 'exists:genres,id'],
        ];
    }
}
