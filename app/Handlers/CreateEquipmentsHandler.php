<?php

namespace App\Handlers;

use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Rules\MaskValidation;
use Illuminate\Database\QueryException;
use Validator;

final class CreateEquipmentsHandler
{
    public function __construct(
        private CreateEquipmentRequest $equipmentRequest
    )
    {
    }

    public function handle(): array
    {
        $result = [
            'equipments' => [],
            'invalidSerials' => [],
        ];
        $equipmentTypeModel = EquipmentType::where([
            'id' => $this->equipmentRequest->equipmentTypeId
        ])
            ->first();

        foreach ($this->equipmentRequest->serialNumbers as $key => $serialNumber) {
            $equipmentModel = new Equipment([
                'equipment_type_id' => $this->equipmentRequest->equipmentTypeId,
                'serial_number' => $serialNumber,
                'note' => $this->equipmentRequest->note,
            ]);

            $error = Validator::make(
                [
                    $equipmentTypeModel->name => $serialNumber
                ],
                [
                    $equipmentTypeModel->name => [
                        new MaskValidation($equipmentModel),
                    ],
                ]
            )->errors();
            if ($error->isNotEmpty()) {
                $result['invalidSerials'][$key] = [
                    'typeId' => $equipmentTypeModel->id,
                    'name' => $equipmentTypeModel->name,
                    'mask' => $error->first(),
                    'value' => $equipmentModel->serial_number
                ];;

                continue;
            }

            try {
                if ($equipmentModel->save()) {
                    $result['models'][] = $equipmentModel;
                }
            } catch (QueryException) {
                continue;
            }
        }

        return $result;
    }
}
