<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Handlers\CreateEquipmentsHandler;
use App\Handlers\EquipmentUpdateHandler;
use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Requests\PatchEquipmentRequest;
use App\Http\Resources\CreatedEquipmentResource;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

/**
 * EquipmentController class
 */
class EquipmentController extends Controller
{
    /**
     * GET /api/equipment
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return EquipmentResource::collection(Equipment::paginate(
            $request->query('perPage', 5)
        ));
    }

    /**
     * POST /api/equipment
     *
     * @param CreateEquipmentRequest $request
     * @return CreatedEquipmentResource
     * @throws ValidationException
     */
    public function store(CreateEquipmentRequest $request): CreatedEquipmentResource
    {
        $creationResults = (new CreateEquipmentsHandler($request))->handle();

        return CreatedEquipmentResource::make($creationResults);
    }

    /**
     * GET /api/equipment/:id
     *
     * @param Equipment $equipment
     * @return EquipmentResource
     */
    public function show(Equipment $equipment): EquipmentResource
    {
        return EquipmentResource::make($equipment);
    }

    /**
     * PATH /api/equipment/:id
     *
     * @param PatchEquipmentRequest $request
     * @param Equipment $equipment
     * @return Response|EquipmentResource
     * @throws ValidationException
     */
    public function update(PatchEquipmentRequest $request, Equipment $equipment): Response|EquipmentResource
    {
        $equipment = (new EquipmentUpdateHandler($equipment, $request))->handle();

        return EquipmentResource::make($equipment);
    }

    /**
     * DELETE /api/equipment/:id
     *
     * @param Equipment $equipment
     * @return Response
     */
    public function destroy(Equipment $equipment): Response
    {
        $equipment->delete();

        return response([], 204);
    }
}
