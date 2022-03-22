<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property int $equipmentTypeId
 * @property string $note
 * @property string $serialNumber
 */
class PutEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'equipmentTypeId' => 'exists:equipment_types,id',
            'note' => 'string|nullable'
        ];
    }
}
