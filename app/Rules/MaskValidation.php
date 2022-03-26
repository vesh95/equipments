<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\Rule;

class MaskValidation implements Rule
{
    /**
     * @var EquipmentType
     */
    private EquipmentType $equipmentType;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private Equipment $equipment)
    {
        $this->equipmentType = EquipmentType::find(
            ['id' => $this->equipment->equipment_type_id]
        )->first();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match(
                $this->equipmentType->getMaskRegex(),
                (string)$this->equipment->serial_number
            ) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->equipmentType->mask;
    }
}
