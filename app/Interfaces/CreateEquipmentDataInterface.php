<?php

namespace App\Interfaces;

interface CreateEquipmentDataInterface
{
    /**
     * @return string[]
     */
    public function getSerialNumbers(): array;

    /**
     * @return int
     */
    public function getEquipmentTypeId(): int;

    /**
     * @return string|null
     */
    public function getNote(): ?string;
}
