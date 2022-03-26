<?php

namespace App\Interfaces;

interface UpdateEquipmentDataInterface
{
    /**
     * @return string|null
     */
    public function getSerialNumber(): ?string;

    /**
     * @return int|null
     */
    public function getEquipmentTypeId(): ?int;

    /**
     * @return string|null
     */
    public function getNote(): ?string;
}
