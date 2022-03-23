<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * App\Models\Equipment
 *
 * @property int $id
 * @property int $equipment_type_id
 * @property string $serial_number
 * @property string $note
 * @method static Builder|Equipment newModelQuery()
 * @method static Builder|Equipment newQuery()
 * @method static Builder|Equipment query()
 * @mixin Eloquent
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Equipment whereCreatedAt($value)
 * @method static Builder|Equipment whereEquipmentTypeId($value)
 * @method static Builder|Equipment whereId($value)
 * @method static Builder|Equipment whereNote($value)
 * @method static Builder|Equipment whereSerialNumber($value)
 * @method static Builder|Equipment whereUpdatedAt($value)
 */
class Equipment extends Model
{
    protected $fillable = [
        'equipment_type_id',
        'serial_number'
    ];

    public function equipmentType(): HasOne
    {
        return $this->hasOne(
            EquipmentType::class,
            'id',
            'equipment_type_id'
        );
    }
}
