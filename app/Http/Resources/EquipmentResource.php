<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property int $equipment_type_id
 * @property string $serial_number
 * @property string $note
 * @property EquipmentType $equipmentType
 */
class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'equipmentTypeId' => $this->equipment_type_id,
            'serialNumber' => $this->serial_number,
            'note' => $this->note,
            'equipmentType' => [
                'id' => $this->equipmentType->id,
                'name' => $this->equipmentType->name,
                'mask' => $this->equipmentType->mask,
            ]
        ];
    }
}
