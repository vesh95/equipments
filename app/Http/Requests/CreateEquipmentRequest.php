<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Interfaces\CreateEquipmentDataInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string[] $serialNumbers
 * @property int $equipmentTypeId
 * @property null|string $note
 */
class CreateEquipmentRequest extends FormRequest implements CreateEquipmentDataInterface
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
            'serialNumbers' => 'array|min:1',
            'note' => 'string|nullable',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'equipmentTypeId.required' => 'Выберите тип оборудования',
            'equipmentTypeId.exists' => 'Выберете тип оборорудования из списка',
            'serialNumbers.min' => 'Введите хотя бы один серийный номер',
        ];
    }

    /**
     * @return string[]
     */
    public function getSerialNumbers(): array
    {
        return $this->serialNumbers;
    }

    /**
     * @return int
     */
    public function getEquipmentTypeId(): int
    {
        return $this->equipmentTypeId;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }
}
