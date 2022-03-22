<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use App\Rules\MaskValidation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
}
