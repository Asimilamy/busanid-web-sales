<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class SubmitTransactionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'salesperson_id' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required',
            'grandtotal' => 'required',

            'details.*.product_id' => 'required',
            'details.*.qty' => 'required',
            'details.*.value' => 'required',
            'details.*.subtotal' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'details.*.product_id' => 'Product ID',
            'details.*.qty' => 'Qty',
            'details.*.value' => 'Value',
            'details.*.subtotal' => 'Subtotal',
        ];
    }
}
