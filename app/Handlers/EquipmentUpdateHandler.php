<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Interfaces\UpdateEquipmentDataInterface;
use App\Models\Equipment;
use App\Rules\MaskValidation;
use Illuminate\Validation\ValidationException;
use Validator;

/**
 * EquipmentUpdateHandler
 *
 * Returns validation errors and saves updated equipment
 *
 * @package App\Handlers
 */
final class EquipmentUpdateHandler
{
    /**
     * @param Equipment $equipment
     * @param UpdateEquipmentDataInterface $updateEquipmentData
     */
    public function __construct(
        private Equipment                    $equipment,
        private UpdateEquipmentDataInterface $updateEquipmentData,
    )
    {
    }

    /**
     * @return Equipment
     * @throws ValidationException
     */
    public function handle(): Equipment
    {
        if ($this->equipment->serial_number !== $this->updateEquipmentData->getSerialNumber()) {
            $this->equipment->serial_number = $this->updateEquipmentData->getSerialNumber();
            Validator::validate([
                'serialNumber' => $this->updateEquipmentData->getSerialNumber(),
            ], [
                'serialNumber' => 'unique:equipment,serial_number',
            ], [
                'serialNumber.unique' => 'Данный серийный номер уже занят'
            ]);
        }

        if ($this->equipment->equipment_type_id !== $this->updateEquipmentData->getEquipmentTypeId()) {
            $this->equipment->equipment_type_id = $this->updateEquipmentData->getEquipmentTypeId();

            Validator::validate([
                'equipmentTypeId' => $this->updateEquipmentData->getEquipmentTypeId(),
            ], [
                'equipmentTypeId' => 'exists:equipment_types,id',
            ], [
                'equipmentTypeId.exists' => 'Тип оборудования не существует'
            ]);
        }

        Validator::validate(
            [
                'serialNumber' => $this->updateEquipmentData->getSerialNumber(),
            ],
            [
                'serialNumber' => new MaskValidation($this->equipment)
            ],
            [
                'serialNumber' => 'Не валидная маска оборужования'
            ]
        );

        return $this->equipment;
    }
}
