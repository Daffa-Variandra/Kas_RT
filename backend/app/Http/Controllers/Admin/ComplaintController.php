<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('user.family')->latest()->get();
        return view('admin.complaints.index', compact('complaints'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'admin_response' => 'nullable|string',
        ]);

        $complaint->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
        ]);

        $complaint->user->notify(new \App\Notifications\ComplaintStatusUpdated($complaint));

        // Kirim Email Notifikasi
        $subject = "Pembaruan Status Pengaduan Anda";
        $msg = "Pengaduan Anda dengan judul **{$complaint->title}** kini berstatus **" . strtoupper($request->status) . "**.\n\n";
        if ($request->admin_response) {
            $msg .= "Tanggapan Pengurus:\n\"{$request->admin_response}\"\n\n";
        }
        $msg .= "Terima kasih atas laporan Anda.";
        
        $emailSent = \App\Services\EmailNotificationService::send($complaint->user, $subject, $msg);

        $notifMsg = 'Status pengaduan berhasil diperbarui.';
        if ($complaint->user->client->is_email_notification_active ?? false) {
            $notifMsg .= $emailSent ? ' (Email notifikasi berhasil dikirim).' : ' (Gagal mengirim email, periksa konfigurasi SMTP).';
        }

        return redirect()->back()->with('success', $notifMsg);
    }
}
