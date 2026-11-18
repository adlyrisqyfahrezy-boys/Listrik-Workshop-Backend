<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PerangkatController extends Controller
{
    public function index(): JsonResponse
    {
        $perangkat = Perangkat::with('ruang')->get();

        return response()->json($perangkat);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id_ruang' => 'required|exists:tb_ruang,id',
            'nama_perangkat' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:0',
            'uom' => 'required|string|max:50',
            'daya' => 'required|numeric|min:0',
        ]);

        $perangkat = Perangkat::create($validated);

        return response()->json($perangkat, 201);
    }

    public function show(Perangkat $perangkat): JsonResponse
    {
        $perangkat->load('ruang');

        return response()->json($perangkat);
    }

    public function update(Request $request, Perangkat $perangkat): JsonResponse
    {
        $validated = $request->validate([
            'id_ruang' => 'sometimes|required|exists:tb_ruang,id',
            'nama_perangkat' => 'sometimes|required|string|max:255',
            'jumlah' => 'sometimes|required|integer|min:0',
            'uom' => 'sometimes|required|string|max:50',
            'daya' => 'sometimes|required|numeric|min:0',
        ]);

        $perangkat->update($validated);

        return response()->json($perangkat);
    }

    public function destroy(Perangkat $perangkat): JsonResponse
    {
        $perangkat->delete();

        return response()->json(null, 204);
    }
}
