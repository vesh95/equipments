<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Handlers\EquipmentUpdateHandler;
use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Requests\PutEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Rules\MaskValidation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;

class EquipmentController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return EquipmentResource::collection(Equipment::all()->load('equipmentType'));
    }

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

            $error = Validator::make(
                [
                    $equipmentTypeModel->name => $serialNumber
                ],
                [
                    $equipmentTypeModel->name => [
                        new MaskValidation($equipmentModel),
                    ],
                ]
            )->errors();
            if ($error->isNotEmpty()) {
                $errors[$key] = [
                    'typeId' => $equipmentTypeModel->id,
                    'name' => $equipmentTypeModel->name,
                    'mask' => $error->first(),
                    'value' => $serialNumber
                ];

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

    public function show(Equipment $equipment): EquipmentResource
    {
        return EquipmentResource::make($equipment);
    }

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

    public function destroy(Equipment $equipment): Response
    {
        $equipment->delete();

        return response([], 204);
    }
}
