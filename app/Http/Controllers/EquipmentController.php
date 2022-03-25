<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Handlers\EquipmentCreateHandler;
use App\Handlers\EquipmentUpdateHandler;
use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Requests\PutEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

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
        return EquipmentResource::collection(Equipment::all()->load('equipmentType'));
    }

    /**
     * POST /api/equipment
     *
     * @param CreateEquipmentRequest $request
     * @return array
     */
    public function store(CreateEquipmentRequest $request): array
    {
        $models = [];
        $errors = [];
        $equipmentTypeModel = EquipmentType::where([
            'id' => $request->equipmentTypeId
        ])
            ->first();
        foreach ($request->serialNumbers as $key => $serialNumber) {
            $equipmentModel = new Equipment([
                'equipment_type_id' => $request->equipmentTypeId,
                'serial_number' => $serialNumber,
                'note' => $request->note,
            ]);

            $error = (new EquipmentCreateHandler($equipmentTypeModel, $equipmentModel))
                ->handle();
            if ($error !== null) {
                $errors[$key] = $error;

                continue;
            }

            try {
                if ($equipmentModel->save()) {
                    $models[] = EquipmentResource::make($equipmentModel);
                }
            } catch (QueryException) {
                continue;
            }
        }

        return [
            'equipments' => $models,
            'invalidSerials' => $errors,
        ];
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
     * @param PutEquipmentRequest $request
     * @param Equipment $equipment
     * @return Response|EquipmentResource
     */
    public function update(PutEquipmentRequest $request, Equipment $equipment): Response|EquipmentResource
    {
        $lastErrors = (new EquipmentUpdateHandler($equipment, $request))
            ->handle();
        if ($lastErrors !== null && !$lastErrors->errors()->isEmpty()) {
            return response($lastErrors->errors(), 422);
        }

        $equipment->fill([
            'note' => $request->note,
        ]);

        $equipment->update();

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
