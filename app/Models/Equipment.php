<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Equipment
 *
 * @property int $id
 * @property int $equipment_type_id
 * @property string $serial_number
 * @property string $note
 * @property EquipmentType $equipmentType
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Equipment newModelQuery()
 * @method static Builder|Equipment newQuery()
 * @method static Builder|Equipment query()
 * @method static Builder|Equipment whereCreatedAt($value)
 * @method static Builder|Equipment whereEquipmentTypeId($value)
 * @method static Builder|Equipment whereId($value)
 * @method static Builder|Equipment whereNote($value)
 * @method static Builder|Equipment whereSerialNumber($value)
 * @method static Builder|Equipment whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Equipment extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'equipment_type_id',
        'serial_number',
        'note'
    ];

    /**
     * @return BelongsTo
     */
    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(
            EquipmentType::class,
            'equipment_type_id',
            'id',
        );
    }
}
