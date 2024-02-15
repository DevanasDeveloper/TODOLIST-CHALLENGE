<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validation = false;
        if($this->routeIs('auth.register') || $this->routeIs('auth.login')){
            $validation = true;
        }
        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if($this->isMethod("post")){
            if($this->routeIs("auth.login")){
                $rules['email'] = "required|email";
                $rules['password'] = "required";
            }else{
                $rules['fullname'] = "required";
                $rules['email'] = "required|email|unique:users,email";
                $rules['password'] = "required";
                $rules['confirm_password'] = "required|same:password";
            }
            
        }
        return $rules;
    }

    public function messages(){
        $messages = [
            "email.required" => "The email is required !",
            "email.email" => "The email is incorrect !", 
            "fullname.required" => "The fullname is required !",
            "password.required" => "The password is required !",
            "confirm_password.required" => "The confirm password is required !",
            "conform_password.same" => "The confirm password must be like the first password !",
        ];
        return $messages;
    }
}
