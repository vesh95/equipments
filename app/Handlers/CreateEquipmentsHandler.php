<?php

namespace App\Handlers;

use App\Interfaces\CreateEquipmentDataInterface;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Rules\MaskValidation;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Validator;

/**
 * CreateEquipmentsHandler class
 *
 * Handle equipment creation from CreateEquipmentData
 */
final class CreateEquipmentsHandler
{
    /**
     * @param CreateEquipmentDataInterface $equipmentListData
     */
    public function __construct(
        private CreateEquipmentDataInterface $equipmentListData
    )
    {
    }

    /**
     * @return array
     * @throws ValidationException
     */
    public function handle(): array
    {
        $result = [
            'equipments' => [],
            'invalidSerials' => [],
        ];

        Validator::validate([
            'equipmentTypeId' => $this->equipmentListData->getEquipmentTypeId()
        ], [
            'equipmentTypeId' => 'required|exists:equipment_types,id',
        ], [
            'equipmentTypeId.required' => 'Выберите тип оборудования',
            'equipmentTypeId.exists' => 'Выберете тип оборорудования из списка',
        ]);

        $equipmentTypeModel = EquipmentType::where([
            'id' => $this->equipmentListData->getEquipmentTypeId()
        ])
            ->first();

        foreach ($this->equipmentListData->getSerialNumbers() as $key => $serialNumber) {
            $equipmentModel = new Equipment([
                'equipment_type_id' => $this->equipmentListData->getEquipmentTypeId(),
                'serial_number' => $serialNumber,
                'note' => $this->equipmentListData->getNote(),
            ]);

            $error = Validator::make([
                $equipmentTypeModel->name => $serialNumber
            ], [
                $equipmentTypeModel->name => [
                    new MaskValidation($equipmentModel),
                ],
            ])->errors();
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
