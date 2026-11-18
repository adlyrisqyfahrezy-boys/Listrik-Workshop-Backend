<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(): JsonResponse
    {
        $lokasi = Lokasi::with(['ruang', 'meteran'])->get();

        return response()->json($lokasi);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $lokasi = Lokasi::create($validated);

        return response()->json($lokasi, 201);
    }

    public function show(Lokasi $lokasi): JsonResponse
    {
        $lokasi->load(['ruang', 'meteran']);

        return response()->json($lokasi);
    }

    public function update(Request $request, Lokasi $lokasi): JsonResponse
    {
        $validated = $request->validate([
            'nama_lokasi' => 'sometimes|required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $lokasi->update($validated);

        return response()->json($lokasi);
    }

    public function destroy(Lokasi $lokasi): JsonResponse
    {
        $lokasi->delete();

        return response()->json(null, 204);
    }
}
