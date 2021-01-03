<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     title="Store User Request",
 *     description="Store User Request body data",
 * )
 */
class UserRequest extends FormRequest
{
    /**
     * @OA\Property(
     *     title="first_name"
     * )
     *
     * @var string
     */
    public $first_name;
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
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
        ];
    }
}
