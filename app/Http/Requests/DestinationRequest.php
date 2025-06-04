<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Pastikan middleware sudah atur otorisasi admin
    }

    public function rules()
    {
        return [
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'price'          => 'required|integer|min:0',
            'open_time'      => 'required|date_format:H:i',
            'close_time'     => 'required|date_format:H:i|after:open',
            'subcategory_id' => 'required|exists:subcategories,id',
            'category'       => 'required|in:Destinasi Populer,Paket Wisata',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_popular'     => 'nullable|boolean',
        ];
    }
}
