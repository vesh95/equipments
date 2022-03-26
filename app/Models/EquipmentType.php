<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\EquipmentType
 *
 * @property int $id
 * @property string $name
 * @property string $mask
 * @property Equipment[] $equipments
 *
 * @method static Builder|EquipmentType newModelQuery()
 * @method static Builder|EquipmentType newQuery()
 * @method static Builder|EquipmentType query()
 * @method static Builder|EquipmentType whereId($value)
 * @method static Builder|EquipmentType whereMask($value)
 * @method static Builder|EquipmentType whereName($value)
 * @mixin Eloquent
 */
class EquipmentType extends Model
{
    use HasFactory;

    /**
     * Mask items equals regex
     */
    private const MASK_REGEX_ITEMS = [
        'N' => '[0-9]',
        'A' => '[A-Z]',
        'a' => '[a-z]',
        'X' => '[A-Z0-9]',
        'Z' => '[\-\_\@]'
    ];

    /**
     * Returns mask items translated to regex
     *
     * @return string
     */
    public function getMaskRegex(): string
    {
        $regex = '';
        foreach (str_split($this->mask) as $char) {
            $regex .= self::MASK_REGEX_ITEMS[$char];
        }

        return '/^' . $regex . '$/';
    }

    /**
     * @return HasMany
     */
    public function equipments(): HasMany
    {
        return $this->hasMany(
            Equipment::class,
            'equipment_type_id',
            'id');
    }
}
