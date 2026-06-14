<?php

namespace App\Http\Controllers;

use App\Services\ActivityLog as ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = \DB::table('activity_logs')
            ->join('tb_petugas', 'activity_logs.user_id', '=', 'tb_petugas.id_petugas')
            ->select('activity_logs.*', 'tb_petugas.nama_petugas as user_name', 'tb_petugas.username as user_username');

        // Filter by action
        if ($action = $request->input('action')) {
            $query->where('activity_logs.action', $action);
        }

        // Filter by date range
        if ($from = $request->input('from')) {
            $query->whereDate('activity_logs.created_at', '>=', $from);
        }
        if ($to = $request->input('to')) {
            $query->whereDate('activity_logs.created_at', '<=', $to);
        }

        $logs = $query->orderByDesc('activity_logs.created_at')->paginate(50);

        // Enrich logs with labels and colors
        $logs->getCollection()->transform(function($log) {
            $log->created_at = \Carbon\Carbon::parse($log->created_at);
            $actionLabels = [
                'create_barang' => ['label' => 'Tambah Barang', 'bg' => 'rgba(40,167,69,.15)', 'color' => '#28a745'],
                'update_barang' => ['label' => 'Update Barang', 'bg' => 'rgba(0,123,255,.15)', 'color' => '#007bff'],
                'delete_barang' => ['label' => 'Hapus Barang', 'bg' => 'rgba(220,53,69,.15)', 'color' => '#dc3545'],
                'buka_lelang' => ['label' => 'Buka Lelang', 'bg' => 'rgba(40,167,69,.15)', 'color' => '#28a745'],
                'tutup_lelang' => ['label' => 'Tutup Lelang', 'bg' => 'rgba(255,193,7,.15)', 'color' => '#ffc107'],
                'upload_bukti_bayar' => ['label' => 'Upload Bukti', 'bg' => 'rgba(23,162,184,.15)', 'color' => '#17a2b8'],
                'verifikasi_bukti_bayar' => ['label' => 'Verifikasi Bukti', 'bg' => 'rgba(111,66,193,.15)', 'color' => '#6f42c1'],
            ];

            $action = $actionLabels[$log->action] ?? ['label' => $log->action, 'bg' => 'rgba(108,117,125,.15)', 'color' => '#6c757d'];
            $log->_action_label = $action['label'];
            $log->_badge_bg = $action['bg'];
            $log->_badge_color = $action['color'];

            // Parse details for summary
            if ($log->detail) {
                $details = json_decode($log->detail, true);
                $summary = [];
                if (isset($details['nama'])) $summary[] = $details['nama'];
                if (isset($details['status'])) $summary[] = 'Status: ' . $details['status'];
                if (isset($details['catatan'])) $summary[] = substr($details['catatan'], 0, 50);
                if (isset($details['status_filter'])) $summary[] = 'Filter: ' . $details['status_filter'];
                $log->_details_summary = implode(' · ', $summary);
            } else {
                $log->_details_summary = '';
            }

            return $log;
        });

        return view('administrator.activity_log', compact('logs'));
    }
}
