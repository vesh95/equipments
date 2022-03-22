<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string[] $serialNumbers
 * @property int $equipmentTypeId
 * @property string $note
 */
class CreateEquipmentRequest extends FormRequest
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
            'equipmentTypeId' => 'required|exists:equipment_types,id',
            'serialNumbers' => 'required',
            'note' => 'string',
        ];
    }
}
