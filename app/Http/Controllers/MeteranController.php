<?php

namespace App\Http\Controllers;

use App\Models\Meteran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeteranController extends Controller
{
    public function index(): JsonResponse
    {
        $meteran = Meteran::with('lokasi')->get();

        return response()->json($meteran);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_lokasi' => 'required|exists:tb_lokasi,id',
            'nama_meteran' => 'required|string|max:255',
            'maks_watt' => 'required|numeric|min:0',
        ]);

        $meteran = Meteran::create($validated);

        return response()->json($meteran, 201);
    }

    public function show(Meteran $meteran): JsonResponse
    {
        $meteran->load('lokasi');

        return response()->json($meteran);
    }

    public function update(Request $request, Meteran $meteran): JsonResponse
    {
        $validated = $request->validate([
            'id_lokasi' => 'sometimes|required|exists:tb_lokasi,id',
            'nama_meteran' => 'sometimes|required|string|max:255',
            'maks_watt' => 'sometimes|required|numeric|min:0',
        ]);

        $meteran->update($validated);

        return response()->json($meteran);
    }

    public function destroy(Meteran $meteran): JsonResponse
    {
        $meteran->delete();

        return response()->json(null, 204);
    }
}
