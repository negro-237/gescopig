<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Enseignant;

class UpdateEnseignantRequest extends FormRequest
{

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //return Enseignant::$rules;
        
        return [
            'titre' => 'bail|required',
            'name' => 'bail|required|max:255',
            'tel' => 'bail|required|max:20',
            'mail' => 'bail|required|max:255|email',
            'date_naissance' => 'bail|required|date',
            'lieu_naissance' => 'bail|required',
            'profession' => 'bail|required',
            'domicile' => 'bail|required',
            'nationalite' => 'bail|required',
            'ville_id' => 'bail',
            'mh_licence' => 'bail',
            'mh_master' => 'bail'
        ];
    }
}
