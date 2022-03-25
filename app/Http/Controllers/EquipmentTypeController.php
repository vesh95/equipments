<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\EquipmentTypeResource;
use App\Models\EquipmentType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;

/**
 * EquipmentTypeController class
 */
class EquipmentTypeController extends Controller
{
    /**
     * GET /api/equipment/type
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return EquipmentTypeResource::collection(EquipmentType::all());
    }
}
