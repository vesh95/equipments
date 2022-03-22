<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Requests\PutEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
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
        return EquipmentResource::collection(Equipment::all());
    }

    public function store(CreateEquipmentRequest $request): array
    {
        $models = [];
        $errors = [];
        foreach ($request->serialNumbers as $serialNumber) {
            $equipmentModel = new Equipment([
                'equipment_type_id' => $request->equipmentTypeId,
                'serial_number' => $serialNumber,
                'note' => $request->note,
            ]);


            $error = Validator::make(
                [
                    'serialNumber' => $serialNumber
                ],
                [
                    'serialNumber' => [
                        new MaskValidation($equipmentModel),
                    ],
                ]
            )->errors();
            if ($error->isNotEmpty()) {
                $errors[$serialNumber] = $error;

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
            'models' => $models,
            'errors' => $errors,
        ];
    }

    public function show(Equipment $equipment): EquipmentResource
    {
        return EquipmentResource::make($equipment);
    }

    public function update(PutEquipmentRequest $request, Equipment $equipment): Response|EquipmentResource
    {
        $equipment->fill([
            'equipment_type_id' => $request->equipmentTypeId,
            'serial_number' => $request->serialNumber,
            'note' => $request->note,
        ]);
        $e = Validator::make([
            'serialNumber' => $request->serialNumber,
        ], [
            'serialNumber' => [
                'unique:equipment,serial_number',
                new MaskValidation($equipment),
            ]
        ]);

        if (!$e->errors()->isEmpty()) {
            return response($e->errors(), 422);
        }

        $equipment->update();

        return EquipmentResource::make($equipment);
    }
}
