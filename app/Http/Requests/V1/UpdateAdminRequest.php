<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $id = $this->route('admin');
        if($method == 'PUT')
        {
            return [
                'senha' => ['required'],
                'email' => ['required','email', Rule::unique('admins', 'email')->ignore($id)],
            ];
        }
        else
        {
            return [
                'senha' => ['sometimes','required'],
                'email' => ['sometimes','required','email',Rule::unique('admin', 'email')->ignore($id)],
            ];
        }
    }
}
