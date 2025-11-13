<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetTransfer;
use App\Models\AssetTransferItem;
use Illuminate\Support\Facades\DB;
use App\Models\AuditLog;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        $validated = $request->validate([
            'from_user_id' => 'required|exists:users,id|different:to_user_id',
            'to_user_id' => 'required|exists:users,id',
            'from_assets' => 'nullable|array',
            'to_assets' => 'nullable|array',
        ]);

        $fromAssetsInput = $validated['from_assets'] ?? [];
        $toAssetsInput = $validated['to_assets'] ?? [];

        if (empty($fromAssetsInput) && empty($toAssetsInput)) {
            return response()->json(['message' => 'É necessário informar pelo menos um ativo em from_assets ou to_assets'], 422);
        }

        $fromIds = array_map(fn($a) => is_array($a) ? $a['id'] : $a, $fromAssetsInput);
        $toIds   = array_map(fn($a) => is_array($a) ? $a['id'] : $a, $toAssetsInput);
        $allIds  = array_merge($fromIds, $toIds);

        return DB::transaction(function () use ($fromIds, $toIds, $allIds, $validated, $request) {

            $assets = Asset::whereIn('id', $allIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($fromIds as $id) {
                if (!isset($assets[$id])) {
                    return response()->json(['message' => "Ativo {$id} não encontrado"], 422);
                }
                if ($assets[$id]->current_user_id != $validated['from_user_id']) {
                    return response()->json([
                        'message' => "Ativo {$id} não pertence a from_user",
                        'current_user_id' => $assets[$id]->current_user_id
                    ], 422);
                }
                if ($assets[$id]->status !== 'EM_USO') {
                    return response()->json(['message' => "Ativo {$id} com status inválido para transferência"], 422);
                }
            }

            foreach ($toIds as $id) {
                if (!isset($assets[$id])) {
                    return response()->json(['message' => "Ativo {$id} não encontrado"], 422);
                }
                if ($assets[$id]->current_user_id != $validated['to_user_id']) {
                    return response()->json([
                        'message' => "Ativo {$id} não pertence a to_user",
                        'current_user_id' => $assets[$id]->current_user_id
                    ], 422);
                }
                if ($assets[$id]->status !== 'EM_USO') {
                    return response()->json(['message' => "Ativo {$id} com status inválido para transferência"], 422);
                }
            }

            $sumFrom = array_sum(array_map(fn($id) => (int) round(($assets[$id]->valor_contabil ?? 0) * 100), $fromIds));
            $sumTo   = array_sum(array_map(fn($id) => (int) round(($assets[$id]->valor_contabil ?? 0) * 100), $toIds));

            if ($sumFrom !== $sumTo) {
                return response()->json(['message' => 'Soma dos valores dos ativos cedidos não corresponde à soma recebida'], 422);
            }

            $transfer = AssetTransfer::create([
                'from_user_id' => $validated['from_user_id'],
                'to_user_id'   => $validated['to_user_id'],
                'total_from'   => $sumFrom / 100,
                'total_to'     => $sumTo / 100,
            ]);

            foreach ($fromIds as $id) {
                AssetTransferItem::create([
                    'asset_transfer_id' => $transfer->id,
                    'asset_id'          => $id,
                    'side'              => 'from'
                ]);
                $assets[$id]->current_user_id = $validated['to_user_id'];
                $assets[$id]->save();
            }

            foreach ($toIds as $id) {
                AssetTransferItem::create([
                    'asset_transfer_id' => $transfer->id,
                    'asset_id'          => $id,
                    'side'              => 'to'
                ]);
                $assets[$id]->current_user_id = $validated['from_user_id'];
                $assets[$id]->save();
            }

            if (class_exists(AuditLog::class)) {
                AuditLog::create([
                    'user_id' => $request->user()->id ?? null,
                    'endpoint' => 'POST /transferencia',
                    'method' => 'POST',
                    'payload' => json_encode($request->all()),
                    'ip' => $request->ip(),
                ]);
            }

            return response()->json($transfer->load('items'), 200);
        });
    }
}
