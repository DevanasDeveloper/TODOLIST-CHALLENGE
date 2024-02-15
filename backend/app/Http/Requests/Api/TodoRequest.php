<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $validation = false;
        if($this->routeIs('todo.store') || $this->routeIs('todo.update')){
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
        if($this->isMethod("post") || $this->isMethod("put")){
            if($this->routeIs('todo.store')){
                $rules = [
                    "title" => "required|unique:todos,title,null,id,user_id,".$this->user()->id,
                ];
            }else{
                $rules = [
                    "title" => "required|unique:todos,title,".$this->id.",id,user_id,".$this->user()->id,
                ];
            }
        }
        return $rules;
    }

    public function messages(){
        $messages = [
            "title.required" => "The title is required",
            "title.unique" => "The title is already exists"
        ];
        return $messages;
    }
}
