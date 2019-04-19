<?php

namespace App\Http\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormEntryStore extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|max:25',
            'email' => 'required|email'
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages() {
        return [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required'  => 'Please enter your last name.',
            'phone.required'      => 'Please enter your phone number.',
            'email.required'      => 'Please enter your email address.',
        ];
    }

    public function validateRequestOrFail() {
        $validator = Validator::make($this->all(), $this->rules(), $this->messages());
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['errors' => $validator->errors()->all()], 422));
        }
    }

}