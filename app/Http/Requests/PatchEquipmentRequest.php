<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Interfaces\UpdateEquipmentDataInterface;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @property int|null $equipmentTypeId
 * @property string|null $note
 * @property string|null $serialNumber
 */
class PatchEquipmentRequest extends FormRequest implements UpdateEquipmentDataInterface
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

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function getEquipmentTypeId(): ?int
    {
        return $this->equipmentTypeId;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }
}
