<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MstOrganizationRequest extends FormRequest
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
        $id_check = $this->request->get('id') ? "," . $this->request->get('id') : "";
        return [
            'name_en' => 'required|max:100|unique:mst_organizations,name_en' . $id_check,
            'name_lc' => 'required|max:100|unique:mst_organizations,name_lc' . $id_check,
            'country_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'phone' => 'required',
            'email' => 'required',

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
            'name_en' => 'Name En',
            'name_lc' => 'Name Lc',
            'district_id' => 'District',
            'province_id' => 'Province',
            'country_id' => 'Country',
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
            'required' => 'The :attribute field is required.',
            'unique' => 'The :attribute has already been taken.',
            'max' => 'The :attribute must not be greater than :max.',
        ];
    }
}
