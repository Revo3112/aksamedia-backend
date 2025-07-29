<?php
// app/Http/Controllers/Api/EmployeeController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeFilterRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(EmployeeFilterRequest $request): JsonResponse
    {
        try {
            $query = Employee::with('division');

            // Filter berdasarkan nama
            if ($request->has('name') && !empty($request->name)) {
                $query->byName($request->name);
            }

            // Filter berdasarkan divisi
            if ($request->has('division_id') && !empty($request->division_id)) {
                $query->byDivision($request->division_id);
            }

            $employees = $query->orderBy('name')
                              ->paginate(10);

            $employeesData = $employees->getCollection()->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'image' => $employee->image_url,
                    'name' => $employee->name,
                    'phone' => $employee->phone,
                    'division' => [
                        'id' => $employee->division->id,
                        'name' => $employee->division->name,
                    ],
                    'position' => $employee->position,
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Data karyawan berhasil diambil',
                'data' => [
                    'employees' => $employeesData
                ],
                'pagination' => [
                    'current_page' => $employees->currentPage(),
                    'last_page' => $employees->lastPage(),
                    'per_page' => $employees->perPage(),
                    'total' => $employees->total(),
                    'from' => $employees->firstItem(),
                    'to' => $employees->lastItem(),
                    'has_more_pages' => $employees->hasMorePages(),
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

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('employees', 'public');
                $data['image'] = $imagePath;
            }

            // Map division field ke division_id
            $data['division_id'] = $data['division'];
            unset($data['division']);

            Employee::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan berhasil ditambahkan',
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    public function update(UpdateEmployeeRequest $request, string $id): JsonResponse
    {
        try {
            $employee = Employee::findOrFail($id);
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                    Storage::disk('public')->delete($employee->image);
                }

                $imagePath = $request->file('image')->store('employees', 'public');
                $data['image'] = $imagePath;
            }

            // Map division field ke division_id
            $data['division_id'] = $data['division'];
            unset($data['division']);

            $employee->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan berhasil diupdate',
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        try {
            $employee = Employee::findOrFail($id);

            // Hapus gambar jika ada
            if ($employee->image && Storage::disk('public')->exists($employee->image)) {
                Storage::disk('public')->delete($employee->image);
            }

            $employee->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Karyawan berhasil dihapus',
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Karyawan tidak ditemukan',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }
}
