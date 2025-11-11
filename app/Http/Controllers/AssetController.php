<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\AuditLog;

class AssetController extends Controller
{
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'valor_contabil' => 'required|numeric|min:0',
        'latitude_distribuicao' => 'nullable|numeric',
        'longitude_distribuicao' => 'nullable|numeric',
        'current_user_id' => 'required|exists:users,id',
        'status' => 'nullable|in:NOVO,EM_USO,MANUTENCAO',
    ]);

    $asset = Asset::create($validated);

    if (class_exists(\App\Models\AuditLog::class)) {
        AuditLog::create([
            'user_id' => $request->user()->id ?? null,
            'endpoint' => 'POST /ativos',
            'method' => 'POST',
            'payload' => json_encode($request->all()),
            'ip' => $request->ip(),
        ]);
    }

    return response()->json($asset, 201);
}

}

