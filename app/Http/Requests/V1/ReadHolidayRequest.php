<?php

namespace App\Http\Requests\V1;

use App\Rules\Year2024;
use Illuminate\Foundation\Http\FormRequest;

class ReadHolidayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();

        return $user != null && $user->tokenCan('read');
    }


}
