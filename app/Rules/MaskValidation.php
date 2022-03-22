<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\EquipmentType;
use Illuminate\Contracts\Validation\Rule;

class MaskValidation implements Rule
{
    private EquipmentType $equipment;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $equipmentTypeId)
    {
        $this->equipment = EquipmentType::find($equipmentTypeId);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {


        return preg_match($this->equipment->getMaskRegex(), $value) === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->equipment->mask;
    }
}
