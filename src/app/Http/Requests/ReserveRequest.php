<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|after_or_equal:tomorrow',
            'time' => 'required|after_or_equal:11:00|before_or_equal:22:00',
            'hc' => 'required|integer|min:1|max:' . $this->input('remaining'),
        ];
    }

    public function messages()
    {
    return [
    'date.after_or_equal' => '予約日は翌日以降を指定してください',
    'hc.required' => '人数は必ず指定してください',
    'hc.max' => '予約可能人数を超えています',
    'time.after_or_equal' => '予約時間は11：00以降を指定してください',
    'time.before_or_equal' => '予約時間は22：00以前を指定してください',
    ];
}
}
