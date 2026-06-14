<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ActivityLog
{
    public static function record(string $action, ?string $modelType = null, ?int $modelId = null, array $detail = []): void
    {
        $idPetugas = session('id_petugas');
        if (!$idPetugas) return;

        $level = session('id_level') == 1 ? 'administrator' : 'petugas';

        DB::table('activity_logs')->insert([
            'user_id'    => $idPetugas,
            'user_type'  => $level,
            'action'     => $action,
            'model_type' => $modelType,
            'model_id'   => $modelId,
            'detail'     => $detail ? json_encode($detail) : null,
            'created_at' => now(),
        ]);
    }
}
