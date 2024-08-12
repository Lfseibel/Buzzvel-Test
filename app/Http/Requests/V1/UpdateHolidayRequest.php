<?php

namespace App\Http\Requests\V1;

use App\Rules\Year2024;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHolidayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();
        $id = $this->route('holiday');

        if($method == 'PUT')
        {
            return [
                'title' => ['required'],
                'description' => ['required'],
                'date' => ['required', 'date','date_format:Y-m-d', new Year2024],
                'location' => ['required'],
                'participants' => ['nullable'],
            ];
        }
        else
        {
            return [
                'title' => ['sometimes','required'],
                'description' => ['sometimes','required'],
                'date' => ['sometimes','required','date','date_format:Y-m-d', new Year2024],
                'location' => ['sometimes','required'],
                'participants' => ['sometimes','nullable'],
            ];
        }
        
    }

}
