<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'category_id' =>'required',  
            'name' => 'required|min:10|max:70|',
            'price' =>'required|integer|gt:0',  
            'stock' =>'required', 
        ];
    }
}
