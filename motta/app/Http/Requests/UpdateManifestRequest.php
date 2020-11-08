<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManifestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $Id = $this->get('id') ?? \Request::instance()->segment($routeSegmentWithId);
        return [
            'code' => 'required|unique:App\Models\Manifest,code,'.$Id,
            'create_date' => 'required',
            'file.*' => 'mimes:pdf,rar,zip|nullable',
            'document_type_id' => 'required',
            'customer_id' => 'required',
            'address_id' => 'required',
            //'user_id' => 'required',
            // 'name' => 'required|min:5|max:255'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}