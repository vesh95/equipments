<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Rules\MaskValidation;
use Validator;

final class EquipmentCreateHandler
{
    public function __construct(
        private EquipmentType $equipmentTypeModel,
        private Equipment     $equipment
    )
    {
    }

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
