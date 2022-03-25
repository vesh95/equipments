<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Rules\MaskValidation;
use Validator;

/**
 * EquipmentCreateHandler
 *
 * Returns validation errors
 *
 * @package App\Handlers
 */
final class EquipmentCreateHandler
{
    /**
     * @param EquipmentType $equipmentTypeModel
     * @param Equipment $equipment
     */
    public function __construct(
        private EquipmentType $equipmentTypeModel,
        private Equipment     $equipment
    )
    {
    }

    /**
     * @return array|null
     */
    public function handle(): ?array
    {
        $error = Validator::make(
            [
                $this->equipmentTypeModel->name => $this->equipment->serial_number
            ],
            [
                $this->equipmentTypeModel->name => [
                    new MaskValidation($this->equipment),
                ],
            ]
        )->errors();
        if ($error->isNotEmpty()) {
            return [
                'typeId' => $this->equipmentTypeModel->id,
                'name' => $this->equipmentTypeModel->name,
                'mask' => $error->first(),
                'value' => $this->equipment->serial_number
            ];
        }

        return null;
    }
}
