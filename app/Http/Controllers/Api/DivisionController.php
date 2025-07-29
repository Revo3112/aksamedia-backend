<?php
// app/Http/Controllers/Api/DivisionController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DivisionFilterRequest;
use App\Models\Division;
use Illuminate\Http\JsonResponse;

class DivisionController extends Controller
{
    public function index(DivisionFilterRequest $request): JsonResponse
    {
        try {
            $query = Division::query();

            // Filter berdasarkan nama
            if ($request->has('name') && !empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            $divisions = $query->orderBy('name')
                              ->paginate(10);

            return response()->json([
                'status' => 'success',
                'message' => 'Data divisi berhasil diambil',
                'data' => [
                    'divisions' => $divisions->items()
                ],
                'pagination' => [
                    'current_page' => $divisions->currentPage(),
                    'last_page' => $divisions->lastPage(),
                    'per_page' => $divisions->perPage(),
                    'total' => $divisions->total(),
                    'from' => $divisions->firstItem(),
                    'to' => $divisions->lastItem(),
                    'has_more_pages' => $divisions->hasMorePages(),
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server',
                'data' => null
            ], 500);
        }
    }
}
