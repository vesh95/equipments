<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Exceptions\EquipmentUpdateException;
use App\Http\Requests\PutEquipmentRequest;
use App\Models\Equipment;
use App\Rules\MaskValidation;
use Validator;

/**
 * EquipmentUpdateHandler
 *
 * Returns validation errors
 *
 * @package App\Handlers
 */
final class EquipmentUpdateHandler
{
    /**
     * @param Equipment $equipment
     * @param PutEquipmentRequest $request
     */
    public function __construct(
        private Equipment           $equipment,
        private PutEquipmentRequest $request,
    )
    {
    }

    /**
     * @return Equipment
     * @throws EquipmentUpdateException
     */
    public function handle(): Equipment
    {
        if ($this->equipment->serial_number !== $this->request->serialNumber) {
            $this->equipment->serial_number = $this->request->serialNumber;
            $validator = Validator::make(
                [
                    'serialNumber' => $this->request->serialNumber,
                ],
                [
                    'serialNumber' => 'unique:equipment,serial_number',
                ],
                [
                    'serialNumber.unique' => 'Данный серийный номер уже занят'
                ]
            );

            if ($validator->errors()->isNotEmpty()) {
                throw new EquipmentUpdateException($validator->errors());
            }
        }
        if ($this->equipment->equipment_type_id !== $this->request->equipmentTypeId) {
            $this->equipment->equipment_type_id = $this->request->equipmentTypeId;
        }

        $validator = Validator::make(
            [
                'serialNumber' => $this->request->serialNumber,
            ],
            [
                'serialNumber' => new MaskValidation($this->equipment)
            ],
            [
                'serialNumber' => 'Не валидная маска оборужования'
            ]
        );

        if ($validator->errors()->isNotEmpty()) {
            throw new EquipmentUpdateException($validator->errors());
        }

        return $this->equipment;
    }
}
