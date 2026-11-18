<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index(): JsonResponse
    {
        $ruang = Ruang::with(['lokasi', 'perangkat'])->get();

        return response()->json($ruang);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_ruang' => 'required|string|max:255',
            'id_lokasi' => 'required|exists:tb_lokasi,id',
        ]);

        $ruang = Ruang::create($validated);

        return response()->json($ruang, 201);
    }

    public function show(Ruang $ruang): JsonResponse
    {
        $ruang->load(['lokasi', 'perangkat']);

        return response()->json($ruang);
    }

    public function update(Request $request, Ruang $ruang): JsonResponse
    {
        $validated = $request->validate([
            'nama_ruang' => 'sometimes|required|string|max:255',
            'id_lokasi' => 'sometimes|required|exists:tb_lokasi,id',
        ]);

        $ruang->update($validated);

        return response()->json($ruang);
    }

    public function destroy(Ruang $ruang): JsonResponse
    {
        $ruang->delete();

        return response()->json(null, 204);
    }
}
