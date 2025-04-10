<?php

namespace App\Http\Requests;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @method \App\Models\User|null user()
 */

class StoreScheduleRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Schedule::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "professional_id" => 'required|exists:users,id',
            "weekday" => 'required|gte:0|lte:6|integer',
            "start_time" =>  [
                "required",
                Rule::date()->format("H:i:s"),
            ],
            "end_time" => [
                "required",
                Rule::date()->format("H:i:s"),
            ]
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $start_time = Carbon::parse($this->validated('start_time'));
                $end_time = Carbon::parse($this->validated('end_time'));

                if ($start_time->gte($end_time)) {
                    $validator->errors()->add(
                        'end_time',
                        'The end time must be later than the start time.'
                    );
                }
            }
        ];
    }
}
