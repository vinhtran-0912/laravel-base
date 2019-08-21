<?php

namespace App\Http\Requests;

use Log;
use App\Exceptions\HousecomApiException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * {@inheritDoc}
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $message = reset($errors) ?? [config('api_exception.fail_validation.message')];

        if (config('app.env') == 'local') {
            Log::error($message[0]);
        }

        throw new HousecomApiException('fail_validation', $message[0]);
    }
}
