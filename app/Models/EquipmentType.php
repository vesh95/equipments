<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EquipmentType
 *
 * @property int $id
 * @property string $name
 * @property string $mask
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
}
