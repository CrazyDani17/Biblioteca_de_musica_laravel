<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        /*$customerModel = config('models.customer');
        //dd($customerModel);
        $customerModel = new $customerModel();*/
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $customerId = $this->get('id') ?? \Request::instance()->segment($routeSegmentWithId);

        /*if (!$customerModel->find($customerId)) {
            abort(400, 'Could not find that entry in the database.');
        }*/

        return [
            'name'=> 'required|unique:customers,name,'.$customerId,
            'ruc' => 'required|min:11|max:11|unique:customers,ruc,'.$customerId,
            //'user_id' => 'required',
            'sector_id' => 'required',
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
